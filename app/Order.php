<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    protected $casts = [
        'cart' => 'collection',
    ];


    public function getCart(){
        return $this->cart->map(function($item){
            return unserialize($item);
        });
    }
}
