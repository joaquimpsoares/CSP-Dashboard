<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PriceList extends Model
{
    public $dates = ['confirmed_changes_at'];

    public function format()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'prices' => $this->prices(),
            'provider' => $this->provider()->count(),
            'reseller' => $this->reseller()->count(),
            'created_at' => $this->created_at,
            'customer' => $this->customer()->count()
        ];
    }

    public function prices(){
        return $this->hasMany(Price::class);
    }

    public function provider() {
        return $this->belongsTo(Provider::class);
    }

    public function reseller() {
        return $this->belongsTo(Reseller::class);
    }

    protected static function booted(){
        static::addGlobalScope('access_level', function(Builder $query){
            $user = Auth::user();
            if($user && $user->userLevel->name === config('app.provider')){
                $query->whereHas('provider', function(Builder $query) use($user){
                    $query->where('provider_id', $user->provider->id);
                });
            }
            if($user && $user->userLevel->name === config('app.reseller')){
                $query->whereHas('reseller', function(Builder $query) use($user){
                    $query->where('reseller_id', $user->reseller->id);
                });
            }
            if($user && $user->userLevel->name === config('app.customer')){
                $query->whereHas('customer', function(Builder $query) use($user){
                    $query->where('customer_id', $user->customer->id);
                });
            }
        });
    }
}
