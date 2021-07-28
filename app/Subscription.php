<?php

namespace App;

use App\Http\Traits\ActivityTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Subscription extends Model
{
    //use ActivityTrait;

    const STATUSES = [
        '1' => 'Active',
        '2' => 'Inactive',
        '3' => 'Canceled',
        '4' => 'Expired',
        '5' => 'pending',
    ];


    protected $guarded = [];

    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function instance() {
        return $this->belongsTo(Instance::class);
    }

    public function addons() {
        return $this->hasMany('App\Models\Addon');
    }

    public function customer() {
        return $this->belongsTo('App\Customer');
    }

    public function order() {
        return $this->hasMany('App\Order', 'subscription_id', 'id');
    }

    public function products() {
        return $this->hasMany('App\Product', 'sku', 'product_id');
    }

    public function azureresources() {
        return $this->belongsToMany('App\Models\AzureResource');
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
