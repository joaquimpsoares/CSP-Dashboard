<?php

namespace App\Services\Pricing\Catalog;

use App\Models\Pricing\PriceListItem;
use App\Models\Pricing\PricingProductFamilyMap;
use App\PriceList;
use App\Product;
use Illuminate\Support\Facades\DB;

class PricingCatalogNormalizer
{
    public const CATEGORY_LICENSES = 'licenses';
    public const CATEGORY_AZURE = 'azure';
    public const CATEGORY_PERPETUAL = 'perpetual';

    public function normalizeLatestPriceListForProvider(int $providerId, ?string $market = null, ?string $currency = null, bool $force = false): NormalizationResult
    {
        $q = PriceList::query()
            ->where('provider_id', $providerId)
            ->orderByDesc('effective_from')
            ->orderByDesc('id');

        if ($market !== null) {
            $q->where('market', $market);
        }
        if ($currency !== null) {
            $q->where('currency', $currency);
        }

        $pl = $q->first();
        if (!$pl) {
            return new NormalizationResult();
        }

        return $this->normalizePriceList((int)$pl->id, $force);
    }

    public function normalizePriceList(int $priceListId, bool $force = false): NormalizationResult
    {
        $result = new NormalizationResult();

        $pl = PriceList::findOrFail($priceListId);
        $providerId = (int) $pl->provider_id;

        $maps = PricingProductFamilyMap::query()
            ->where('provider_id', $providerId)
            ->where('enabled', true)
            ->orderByDesc('priority')
            ->orderBy('id')
            ->get()
            ->map(fn($m) => [
                'id' => (int)$m->id,
                'match_type' => (string)$m->match_type,
                'match_value' => (string)$m->match_value,
                'product_family' => (string)$m->product_family,
                'priority' => (int)$m->priority,
                'enabled' => (bool)$m->enabled,
            ])
            ->all();

        $items = PriceListItem::query()->where('price_list_id', $priceListId)->get();

        DB::beginTransaction();
        try {
            foreach ($items as $it) {
                $result->scanned++;

                $dirty = false;

                // A) category auto-fill (only if null unless force)
                if ($force || $it->category === null) {
                    $cat = match ($it->product_type) {
                        'license' => self::CATEGORY_LICENSES,
                        'azure' => self::CATEGORY_AZURE,
                        'perpetual' => self::CATEGORY_PERPETUAL,
                        default => null,
                    };

                    if ($cat !== null && $it->category !== $cat) {
                        $it->category = $cat;
                        $dirty = true;
                    }
                }

                // B) product_family auto-fill
                if ($force || $it->product_family === null) {
                    $family = null;

                    // 1) Try products table mapping (sku first; offer id isn't present in Product table currently)
                    if ($it->sku_id) {
                        $p = Product::query()->where('sku', $it->sku_id)->first();
                        if ($p && !empty($p->category)) {
                            // Use Product.category as a stand-in family label (best available in existing schema)
                            $family = (string) $p->category;
                        }
                    }

                    // 2) Fallback to provider mapping table
                    if ($family === null) {
                        $family = ProductFamilyMapper::resolve([
                            'offer_id' => $it->offer_id,
                            'sku_id' => $it->sku_id,
                            'meter_id' => $it->meter_id,
                            'title' => $it->title,
                        ], $maps);
                    }

                    if ($family === null) {
                        $result->unmapped++;
                        $result->unmappedItems[] = [
                            'price_list_item_id' => $it->id,
                            'offer_id' => $it->offer_id,
                            'sku_id' => $it->sku_id,
                            'meter_id' => $it->meter_id,
                            'title' => $it->title,
                        ];
                    } else {
                        if ($it->product_family !== $family) {
                            $it->product_family = $family;
                            $dirty = true;
                        }
                    }
                }

                if ($dirty) {
                    $it->save();
                    $result->updated++;
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return $result;
    }
}
