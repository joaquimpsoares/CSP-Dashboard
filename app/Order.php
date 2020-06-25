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

    public function format()
    {
        return [
            'id' => $this->id,
            'comments' => $this->comments,
            'details' => $this->details,
            'customer' => $this->customer->company_name,
            'avatar' => $this->customer->users->first(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status(),
            // 'postal_code' => $this->postal_code,
            // 'status' => $this->status->name,
            // 'path' => $this->path(),
            // 'pathUpdate' => $this->pathUpdate(),
            // 'reseller' => $this->resellers()->first(),
            // 'subscriptions' => $this->subscriptions->count(),
            // 'priceLists' => $this->priceLists()->first(),
            // 'mainUser' => $this->users()->first(),
            // 'orders' => $this->orders()->get(),
            // 'users' => $this->users()->get()
            
        ];

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
}
