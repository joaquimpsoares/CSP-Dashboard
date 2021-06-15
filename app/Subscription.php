<?php

namespace App;

use App\Http\Traits\ActivityTrait;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    //use ActivityTrait;

    protected $guarded = [];

    public function status() {
        return $this->belongsTo(Status::class);
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

}
