<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    protected $casts = [
        'has_addons' => 'boolean',
        'addons' => 'collection',
        'supported_billing_cycles' => 'collection',
        'conversion_target_offers' => 'collection',
        'resellee_qualifications' => 'collection',
        'reseller_qualifications' => 'collection',
    ];

    public function format()
    {

        return [
            'vendor' => $this->vendor,
            'instance_id' => $this->instance_id,
            'sku' => $this->sku,
            'name' => $this->name,
            'description' => $this->description,
            'uri' => $this->uri,
            'minimum_quantity' => $this->minimum_quantity,
            'minimum_quantity' => $this->minimum_quantity,
            'limit' => $this->limit,
            'term' => $this->term,
            'is_available_for_purchase' => $this->is_available_for_purchase,
            'locale' => $this->locale,
            'country' => $this->country,
            'has_addons' => $this->has_addons,
            'is_trial' => $this->is_trial,
            'is_autorenewable' => $this->is_autorenewable,
            'billing' => $this->billing,
            'acquisition_type' => $this->acquisition_type,
            'addons' => $this->addons,
            'getproductaddons' => $this->getAddons(),
            'category' => $this->category,
            'upgrade_target_offers' => $this->upgrade_target_offers,
            'supported_billing_cycles' => $this->supported_billing_cycles,
            'conversion_target_offers' => $this->conversion_target_offers,
            'resellee_qualifications' => $this->resellee_qualifications,
            'reseller_qualifications' => $this->reseller_qualifications,
            'price' => $this->price,
            'path' => $this->path()
        ];
    }

    public function getAddons(){
        return $this->addons->map(function($item){
            return unserialize($item);
        });
    }

    public function price() {
        return $this->hasOne('App\Price', 'product_sku', 'sku')->where('product_vendor', $this->vendor);
    }

    public function instance() {
        return $this->hasOne('App\Instance', 'id', 'instance_id');
    }

    public function path() {
        return url("/product/{$this->id}-" . Str::slug($this->socket_shutdown, '-'));
    }

    public function subsriptions() {
        return $this->hasMany('App\Subscription', 'sku', 'product_id');
    }
}
