<?php

namespace App\Models\Pricing;

use Illuminate\Database\Eloquent\Model;

class PricingSafeguard extends Model
{
    protected $table = 'pricing_safeguards';

    protected $fillable = [
        'provider_id',
        'block_below_cost',
        'min_margin_percent_default',
        'min_margin_fixed_default',
        'max_over_erp_percent',
        'max_discount_off_erp_percent',
        'clamp_mode',
        'require_approval_on_violation',
    ];

    protected $casts = [
        'block_below_cost' => 'boolean',
        'min_margin_percent_default' => 'decimal:3',
        'min_margin_fixed_default' => 'decimal:6',
        'max_over_erp_percent' => 'decimal:3',
        'max_discount_off_erp_percent' => 'decimal:3',
        'require_approval_on_violation' => 'boolean',
    ];
}
