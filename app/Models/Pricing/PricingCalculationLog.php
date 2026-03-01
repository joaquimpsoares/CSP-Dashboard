<?php

namespace App\Models\Pricing;

use Illuminate\Database\Eloquent\Model;

class PricingCalculationLog extends Model
{
    protected $table = 'pricing_calculation_logs';

    protected $fillable = [
        'provider_id',
        'reseller_id',
        'customer_id',
        'offer_id',
        'sku_id',
        'meter_id',
        'quantity',
        'market',
        'currency',
        'winning_rule_id',
        'inputs',
        'outputs',
        'safeguards_applied',
        'rule_trace',
        'calculated_at',
    ];

    protected $casts = [
        'inputs' => 'array',
        'outputs' => 'array',
        'safeguards_applied' => 'array',
        'rule_trace' => 'array',
        'calculated_at' => 'datetime',
    ];
}
