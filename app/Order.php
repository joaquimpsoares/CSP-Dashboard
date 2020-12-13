<?php

namespace App;

use App\OrderStatus;
use App\Http\Traits\ActivityTrait;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    // use ActivityTrait;

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
            'customer' => $this->customer()->first(),
            'avatar' => $this->user->first(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,

        ];

    }

    public function orderproduct() {
    	return $this->belongsTo('App\OrderProducts', 'id', 'order_id');
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
