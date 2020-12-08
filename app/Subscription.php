<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $guarded = [];
    
    public function status() {
        return $this->belongsTo(Status::class);
    }
    
    public function customer() {
        return $this->belongsTo('App\Customer');
    }
    
    public function products() {
        return $this->hasMany('App\Product', 'sku', 'product_id');
    }
    
}
