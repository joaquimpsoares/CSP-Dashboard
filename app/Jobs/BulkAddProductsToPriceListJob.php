<?php

namespace App\Jobs;

use App\PriceList;
use App\Product;
use App\Models\Pricing\PriceListItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BulkAddProductsToPriceListJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param array<int,int> $productIds
     */
    public function __construct(
        public int $priceListId,
        public array $productIds,
        public string $pricingRule = 'copy_msrp',
        public ?float $marginPercent = null,
        public ?string $fixedPrice = null,
        public bool $availability = true,
    ) {
    }

    /**
     * @return array{added:int,updated:int,skipped:int,errors:array<int,string>}
     */
    public function handle(): array
    {
        $pl = PriceList::withTrashed()->findOrFail($this->priceListId);

        $added = 0;
        $updated = 0;
        $skipped = 0;
        $errors = [];

        $products = Product::withTrashed()->whereIn('id', $this->productIds)->get();

        foreach ($products as $p) {
            try {
                // Basic mapping
                $vendor = $p->vendor;
                $sku = $p->sku;
                $offerId = $p->offer_id;
                $skuId = $p->sku_id;
                $meterId = $p->meter_id;
                $term = $p->default_term_duration ?: ($p->term ?: null);
                $billing = $p->default_billing_cycle ?: ($p->billing ?: null);
                $currency = $p->default_currency ?: ($pl->currency ?: 'EUR');

                // Validation: Microsoft must have offer mapping
                if (strtolower((string)$vendor) === 'microsoft' && empty($offerId)) {
                    $errors[] = "Product {$p->id} missing Microsoft offer_id";
                    $skipped++;
                    continue;
                }

                $msrp = $p->msrp;

                $sell = null;
                if ($this->pricingRule === 'copy_msrp') {
                    $sell = $msrp;
                } elseif ($this->pricingRule === 'margin_percent') {
                    if ($msrp === null || $this->marginPercent === null) {
                        $errors[] = "Product {$p->id} missing MSRP or margin";
                        $skipped++;
                        continue;
                    }
                    $sell = (float)$msrp * (1 + ((float)$this->marginPercent / 100.0));
                } elseif ($this->pricingRule === 'fixed') {
                    $sell = $this->fixedPrice !== null ? (float)$this->fixedPrice : null;
                }

                if ($sell === null) {
                    $errors[] = "Product {$p->id} could not compute sell price";
                    $skipped++;
                    continue;
                }

                $attrs = [
                    'price_list_id' => $pl->id,
                    'product_id' => $p->id,
                    'vendor' => $vendor,
                    'sku' => $sku,
                    'offer_id' => $offerId,
                    'sku_id' => $skuId,
                    'meter_id' => $meterId,
                    'title' => $p->name ?: $sku,
                    'billing_cycle' => $billing,
                    'term_duration' => $term,
                    'term' => $term,
                    'currency' => $currency,
                    'price' => $sell,
                    'msrp' => $msrp,
                    'available_for_purchase' => $this->availability,
                    'cost_unit' => null,
                    'erp_unit' => null,
                ];

                $existing = PriceListItem::query()
                    ->where('price_list_id', $pl->id)
                    ->where('product_id', $p->id)
                    ->where(function ($q) use ($billing) {
                        $q->whereNull('billing_cycle')->orWhere('billing_cycle', $billing);
                    })
                    ->where(function ($q) use ($term) {
                        $q->whereNull('term_duration')->orWhere('term_duration', $term)->orWhere('term', $term);
                    })
                    ->first();

                if ($existing) {
                    $existing->fill($attrs);
                    $existing->save();
                    $updated++;
                } else {
                    PriceListItem::create($attrs);
                    $added++;
                }
            } catch (\Throwable $e) {
                $errors[] = "Product {$p->id} error: {$e->getMessage()}";
            }
        }

        return [
            'added' => $added,
            'updated' => $updated,
            'skipped' => $skipped,
            'errors' => $errors,
        ];
    }
}
