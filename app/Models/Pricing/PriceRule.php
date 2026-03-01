<?php

namespace App\Models\Pricing;

use Illuminate\Database\Eloquent\Model;

class PriceRule extends Model
{
    protected $table = 'price_rules';

    protected $fillable = [
        'rule_set_id',
        'scope_type',
        'scope_id',
        'match_type',
        'match_value',
        'base_price',
        'operation',
        'value',
        'min_margin_percent',
        'min_margin_fixed',
        'max_discount_percent',
        'rounding_mode',
        'priority',
        'enabled',
    ];

    protected $casts = [
        'value' => 'decimal:6',
        'min_margin_percent' => 'decimal:3',
        'min_margin_fixed' => 'decimal:6',
        'max_discount_percent' => 'decimal:3',
        'enabled' => 'boolean',
    ];

    public function ruleSet()
    {
        return $this->belongsTo(PriceRuleSet::class, 'rule_set_id');
    }
}
