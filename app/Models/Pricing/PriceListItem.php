<?php

namespace App\Models\Pricing;

use Illuminate\Database\Eloquent\Model;

use App\Product;

class PriceListItem extends Model
{
    protected $table = 'price_list_items';

    protected $fillable = [
        'price_list_id',
        'product_id',

        // Core mapping
        'vendor',
        'sku',
        'offer_id',
        'sku_id',
        'meter_id',
        'billing_cycle',
        'term',
        'term_duration',

        // Display
        'title',
        'product_type',
        'product_family',
        'category',

        // Pricing
        'currency',
        'price',
        'msrp',
        'available_for_purchase',
        'cost_unit',
        'erp_unit',
        'uom',
    ];

    protected $casts = [
        'available_for_purchase' => 'boolean',
        'price' => 'decimal:6',
        'msrp' => 'decimal:6',
        'cost_unit' => 'decimal:6',
        'erp_unit' => 'decimal:6',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Backwards/compat: prefer term_duration, fallback to term.
     */
    public function getEffectiveTermDurationAttribute(): ?string
    {
        return $this->term_duration ?: $this->term;
    }
}

