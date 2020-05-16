<?php

namespace App;

use App\OrderStatus;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    // public function status() {
    //     return $this->belongsTo(OrderStatus::class);
    // }

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
}
