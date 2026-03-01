<?php

namespace App\Models\Pricing;

use Illuminate\Database\Eloquent\Model;

class PriceRuleSet extends Model
{
    protected $table = 'price_rule_sets';

    protected $fillable = [
        'provider_id',
        'name',
        'priority',
        'is_active',
        'valid_from',
        'valid_to',
        'applies_to',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'valid_from' => 'datetime',
        'valid_to' => 'datetime',
    ];

    public function rules()
    {
        return $this->hasMany(PriceRule::class, 'rule_set_id');
    }
}
