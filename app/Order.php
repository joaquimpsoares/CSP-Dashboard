<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];


    public function status()
    {
    	return $this->belongsTo('App\OrderStatus');
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
