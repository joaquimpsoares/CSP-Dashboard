<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProducts extends Model
{
    protected $table = "order_product";
    
    public function product() {
    	return $this->belongsTo('App\Product', 'product_id', 'id');
    }
}
