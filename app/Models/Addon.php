<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function subscription() {
        return $this->belongsTo('App\Subscription');
    }

    public function products() {
        return $this->hasMany('App\Product', 'sku', 'product_id');
    }

    public function price() {
        return $this->belongsTo('App\Price', 'product_id', 'product_sku');
    }

    public function status() {
        return $this->belongsTo('App\Status');
    }

    public function order() {
        return $this->hasMany('App\Order', 'id', 'ext_subscription_id');
    }
}
