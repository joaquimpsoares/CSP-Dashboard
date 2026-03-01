<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProducts extends Pivot
{
    protected $table = "order_product";

    protected $casts = [
        'pricing_trace' => 'array',
        'pricing_calculated_at' => 'datetime',
        'cost_unit_snapshot' => 'decimal:6',
        'erp_unit_snapshot' => 'decimal:6',
        'promo_adjustment_snapshot' => 'decimal:6',
        'sell_unit_snapshot' => 'decimal:6',
        'sell_total_snapshot' => 'decimal:6',
    ];

    public function getUnitSellPrice(): ?string
    {
        return $this->sell_unit_snapshot ?? $this->retail_price ?? $this->price;
    }

    public function getTotalSellPrice(): ?string
    {
        if ($this->sell_total_snapshot !== null) {
            return $this->sell_total_snapshot;
        }

        // Legacy fallback: older UI treated annual as monthly*12.
        if ($this->retail_price !== null && $this->quantity !== null) {
            $mult = ($this->billing_cycle ?? null) === 'annual' ? 12 : 1;
            return (string) ((float) $this->retail_price * (int) $this->quantity * $mult);
        }
        if ($this->price !== null && $this->quantity !== null) {
            $mult = ($this->billing_cycle ?? null) === 'annual' ? 12 : 1;
            return (string) ((float) $this->price * (int) $this->quantity * $mult);
        }

        return null;
    }

    public function getUnitCost(): ?string
    {
        return $this->cost_unit_snapshot;
    }


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
