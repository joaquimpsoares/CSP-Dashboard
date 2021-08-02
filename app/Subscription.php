<?php

namespace App;

use App\Models\Addon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Subscription extends Model
{
    const STATUSES = [
        '1' => 'Active',
        '2' => 'Inactive',
        '3' => 'Canceled',
        '4' => 'Expired',
        '5' => 'pending',
    ];

    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function instance() {
        return $this->belongsTo(Instance::class);
    }

    public function addons() {
        return $this->hasMany(Addon::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function order() {
        return $this->hasMany(Order::class, 'subscription_id', 'id');
    }

    public function products() {
        return $this->hasMany(Product::class, 'sku', 'product_id');
    }

    public function azureresources() {
        return $this->belongsToMany(AzureResource::class);
    }

    protected static function booted(){
        static::addGlobalScope('access_level', function(Builder $query){
            $user = Auth::user();
            if($user && $user->userLevel->name === config('app.provider')){
                $query->whereHas('customer', function(Builder $query) use($user){
                    $query->whereHas('resellers', function(Builder $query) use($user){
                        $query->whereHas('provider', function(Builder $query) use($user){
                            $query->where('id', $user->provider->id);
                        });
                    });
                });
            }
            if($user && $user->userLevel->name === config('app.reseller')){
                $query->whereHas('customer', function(Builder $query) use($user){
                    $query->whereHas('resellers', function(Builder $query) use($user){
                        $query->where('id', $user->reseller->id);
                    });
                });
            }
            if($user && $user->userLevel->name === config('app.customer')){
                $query->whereHas('customer', function(Builder $query) use($user){
                        $query->where('id', $user->customer->id);

                });
            }
        });
    }
}
