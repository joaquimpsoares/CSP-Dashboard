<?php

namespace App\Services\Pricing;

use App\Models\Pricing\PriceListItem;
use App\Product;

class PriceListItemMatcher
{
    /**
     * Match the exact product variant for a price list.
     *
     * Unique key semantics: (price_list_id, product_id, billing_cycle, term_duration)
     */
    public function match(int $priceListId, Product $product, ?string $billingCycle = null, ?string $termDuration = null): ?PriceListItem
    {
        $billingCycle = $billingCycle ?: ($product->default_billing_cycle ?? $product->billing ?? null);
        $termDuration = $termDuration ?: ($product->default_term_duration ?? $product->term ?? null);

        $q = PriceListItem::query()
            ->where('price_list_id', $priceListId)
            ->where('product_id', $product->id);

        if ($billingCycle !== null) {
            $q->where(function ($qq) use ($billingCycle) {
                $qq->whereNull('billing_cycle')->orWhere('billing_cycle', $billingCycle);
            });
        }

        if ($termDuration !== null) {
            $q->where(function ($qq) use ($termDuration) {
                $qq->whereNull('term_duration')->orWhere('term_duration', $termDuration)->orWhere('term', $termDuration);
            });
        }

        // Prefer the most specific row
        return $q->orderByRaw('case when term_duration is null then 1 else 0 end')
            ->orderByRaw('case when billing_cycle is null then 1 else 0 end')
            ->first();
    }
}
