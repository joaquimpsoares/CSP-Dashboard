<?php

namespace App\Models\Pricing;

use Illuminate\Database\Eloquent\Model;

class PricingProductFamilyMap extends Model
{
    protected $table = 'pricing_product_family_maps';

    protected $fillable = [
        'provider_id',
        'match_type',
        'match_value',
        'product_family',
        'priority',
        'enabled',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];
}
