<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    protected $casts = [
        'cart' => 'collection',
    ];

    public function cart()
    {
    	return $this->belongsTo('App\Cart', 'cart_id', 'cart');
    }

    public function status()
    {
    	return $this->belongsTo('App\Cart');
    }
}
