<?php

namespace App;

use App\Http\Traits\UserTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cart extends Model
{
    use UserTrait;

    public function __construct($user_id = null)
    {
        if (empty($this->user_id))
        $this->user()->associate($this->getUser());

        if (empty($this->customer))
            $this->customer_id = $this->getUser()->customer->id ?? null;

        if (empty($this->token))
            $this->token = Str::uuid();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('id', 'quantity', 'price', 'retail_price', 'billing_cycle', 'term_duration');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class,'token','token');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
