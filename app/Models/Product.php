<?php

namespace App\Models;

use App\Models\Metafield;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Product extends Model
{
    protected $casts = [
        'has_addons' => 'boolean',
        'addons' => 'collection',
        'upgrade_target_offers' => 'collection',
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
            'instance' => $this->instance->name,
            'id' => $this->id,
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

    public function getUpgradeProducts(){
        return $this->upgrade_target_offers->map(function($item){
            return unserialize($item);
        });
    }

    public function price() {
        return $this->hasOne(Price::class, 'product_id', 'id');
    }

    public function instance() {
        return $this->hasOne(Instance::class, 'id', 'instance_id');
    }

    public function path() {
        return url("/product/{$this->id}-" . Str::slug($this->name, '-'));
    }

    public function subsriptions() {
        return $this->hasMany(Subscription::class, 'sku', 'product_id');
    }

    public function tiers() {
        return $this->hasMany(Tier::class, 'product_sku', 'sku');
    }

    public function metafields(){
        return $this->morphMany(Metafield::class, 'metafieldable');
    }

    protected static function booted(){
        static::addGlobalScope('access_level', function(Builder $query){
            $user = Auth::user();
            if($user && $user->userLevel->name === config('app.provider')){
                $query->whereHas('instance', function(Builder $query) use($user){
                    $query->where('id', $user->provider->id);
                });
            }
        });
    }
}
