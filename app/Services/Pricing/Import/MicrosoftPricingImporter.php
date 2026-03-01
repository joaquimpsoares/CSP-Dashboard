<?php

namespace App\Services\Pricing\Import;

use App\Models\Pricing\PriceListItem;
use App\PriceList;
use App\Price;
use App\Services\Pricing\Catalog\PricingCatalogNormalizer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * Integrates the existing Microsoft price import flow into the Pricing Engine tables.
 *
 * NOTE: This implementation reuses the repo's existing persisted pricing data (Price / PriceList)
 * as the source of truth. The actual Microsoft API plumbing is not present in this repository,
 * so this importer focuses on migrating/upserting into the new pricing tables.
 */
class MicrosoftPricingImporter
{
    public function __construct(
        protected PricingCatalogNormalizer $normalizer,
    ) {
    }

    public function importForProvider(int $providerId, string $market, string $currency, array $options = []): ImportResult
    {
        $at = $options['at'] ?? now();
        $monthStart = Carbon::parse($at)->startOfMonth();
        $monthEnd = (clone $monthStart)->addMonth();

        // Choose the provider's existing price list as source (legacy model)
        $sourcePriceList = PriceList::query()
            ->where('provider_id', $providerId)
            ->orderByDesc('id')
            ->first();

        if (!$sourcePriceList) {
            $r = new ImportResult($providerId, $market, $currency, $monthStart->format('Y-m'), 0);
            $r->error = 'NO_SOURCE_PRICE_LIST';
            return $r;
        }

        // Upsert destination price list record (same table, new fields)
        $dest = PriceList::query()
            ->where('provider_id', $providerId)
            ->where('source', 'microsoft_partnercenter')
            ->where('market', $market)
            ->where('currency', $currency)
            ->where('effective_from', $monthStart)
            ->where('effective_to', $monthEnd)
            ->first();

        if (!$dest) {
            $dest = new PriceList();
            $dest->provider_id = $providerId;
            $dest->name = $sourcePriceList->name ?: ('Microsoft Price List ' . $monthStart->format('Y-m'));
            $dest->description = 'Imported from Microsoft (legacy source)';
            $dest->instance_id = $sourcePriceList->instance_id;
            $dest->source = 'microsoft_partnercenter';
            $dest->market = $market;
            $dest->currency = $currency;
            $dest->effective_from = $monthStart;
            $dest->effective_to = $monthEnd;
            $dest->imported_at = now();
            $dest->save();
        } else {
            $dest->imported_at = now();
            $dest->save();
        }

        $result = new ImportResult($providerId, $market, $currency, $monthStart->format('Y-m'), (int)$dest->id);

        $prices = Price::query()
            ->where('price_list_id', $sourcePriceList->id)
            ->where('currency', $currency)
            ->get();

        Log::info('MicrosoftPricingImporter: starting', [
            'provider_id' => $providerId,
            'market' => $market,
            'currency' => $currency,
            'month' => $monthStart->format('Y-m'),
            'source_price_list_id' => $sourcePriceList->id,
            'dest_price_list_id' => $dest->id,
            'prices_count' => $prices->count(),
        ]);

        foreach ($prices as $p) {
            $result->itemsScanned++;

            $payload = [
                'price_list_id' => $dest->id,
                'product_type' => 'license', // best-effort default for legacy prices
                'offer_id' => null,
                'sku_id' => $p->product_sku,
                'meter_id' => null,
                'title' => $p->name,
                'billing_cycle' => null,
                'term' => null,
                'cost_unit' => $p->price,
                'erp_unit' => $p->msrp,
                'uom' => null,
            ];

            // Upsert by unique license key (price_list_id + offer_id + sku_id + billing_cycle + term)
            $existing = PriceListItem::query()
                ->where('price_list_id', $dest->id)
                ->whereNull('offer_id')
                ->where('sku_id', $p->product_sku)
                ->whereNull('billing_cycle')
                ->whereNull('term')
                ->first();

            if (!$existing) {
                PriceListItem::create($payload);
                $result->itemsUpserted++;
            } else {
                $changed = false;
                foreach (['title','cost_unit','erp_unit'] as $k) {
                    if ((string)$existing->{$k} !== (string)$payload[$k]) {
                        $existing->{$k} = $payload[$k];
                        $changed = true;
                    }
                }
                if ($changed) {
                    $existing->save();
                    $result->itemsUpdated++;
                }
            }
        }

        // Normalize immediately
        $norm = $this->normalizer->normalizePriceList((int)$dest->id);
        $result->normalization = $norm;

        Log::info('MicrosoftPricingImporter: done', [
            'provider_id' => $providerId,
            'dest_price_list_id' => $dest->id,
            'items_scanned' => $result->itemsScanned,
            'items_upserted' => $result->itemsUpserted,
            'items_updated' => $result->itemsUpdated,
            'normalization' => $norm->toArray(),
        ]);

        return $result;
    }

    public function importLatestMonthly(int $providerId, string $market, string $currency): ImportResult
    {
        return $this->importForProvider($providerId, $market, $currency, ['at' => now()]);
    }
}
