<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;;

class Order extends Model
{

    // use ActivityTrait;

    protected $guarded = [];

    public function format()
    {
        return [
            'id'            => $this->id,
            'comments'      => $this->comments,
            'details'       => $this->details,
            'customer'      => $this->customer()->first(),
            'avatar'        => $this->user,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'status'        => $this->status,
            'orderproducts' => $this->orderproduct,
            'products'      => $this->products,

        ];
    }

    public function orderproduct()
    {
        return $this->belongsTo('App\OrderProducts', 'id', 'order_id');
    }

    public function status()
    {
        return $this->hasOne('App\OrderStatus', 'id', 'order_status_id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product')->withPivot('id', 'quantity', 'price', 'retail_price', 'billing_cycle');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    protected static function booted(){
        static::addGlobalScope('access_level', function(Builder $query){
            $user = Auth::user();
            // if($user && $user->userLevel->name === config('app.provider')){
            //     $query->whereHas('customer', function(Builder $query) use($user){
            //     //     $query->whereHas('resellers', function(Builder $query) use($user){
            //     //         $query->whereHas('provider', function(Builder $query) use($user){
            //     //             $query->where('id', $user->id);
            //     //         });
            //     //     });
            //     });
            // }
            if($user && $user->userLevel->name === config('app.reseller')){
                $query->whereHas('customer');
            }
        });
    }
}
