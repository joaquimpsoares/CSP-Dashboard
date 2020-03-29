<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    protected $casts = [
        'addons' => 'collection',
        'supported_billing_cycles' => 'collection',
        'conversion_target_offers' => 'collection',
        'resellee_qualifications' => 'collection',
        'reseller_qualifications' => 'collection',
    ];


    public function getAddons(){
        return $this->addons->map(function($item){
            return unserialize($item);
        });
    }

    public function priceLists()
    {
        return $this->belongsToMany('App\PriceList', 'price_list_product', 'price_list_id', 'product_sku');
    }
}
