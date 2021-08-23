<?php

namespace App\Models;

use App\Order;
use App\Price;
use App\Product;
use App\Models\Status;
use App\Subscription;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    use HasFactory;

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'sku', 'product_id');
    }

    public function price()
    {
        return $this->belongsTo(Price::class, 'product_id', 'product_sku');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'id', 'ext_subscription_id');
    }
}
