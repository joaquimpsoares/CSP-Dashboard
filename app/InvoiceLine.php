<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceLine extends Model
{
    protected $table = 'invoice_lines';

    protected $fillable = [
        'invoice_id','order_id','order_product_id','product_id','product_sku','quantity','billing_cycle','term_duration',
        'price_list_id','price_list_item_id','pricing_rule_set_id','pricing_rule_id','market','currency','fx_rate_to_currency',
        'cost_unit_snapshot','erp_unit_snapshot','promo_adjustment_snapshot','sell_unit_snapshot','sell_total_snapshot',
        'pricing_trace','pricing_selected_reason','pricing_calculated_at',
    ];

    protected $casts = [
        'pricing_trace' => 'array',
        'pricing_calculated_at' => 'datetime',
        'cost_unit_snapshot' => 'decimal:6',
        'erp_unit_snapshot' => 'decimal:6',
        'promo_adjustment_snapshot' => 'decimal:6',
        'sell_unit_snapshot' => 'decimal:6',
        'sell_total_snapshot' => 'decimal:6',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function getUnitSellPrice(): ?string
    {
        return $this->sell_unit_snapshot;
    }

    public function getTotalSellPrice(): ?string
    {
        return $this->sell_total_snapshot;
    }

    public function getUnitCost(): ?string
    {
        return $this->cost_unit_snapshot;
    }
}
