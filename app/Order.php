<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Order extends Model
{
    protected $casts = [
        'errors' => 'collection',
    ];

    public function format()
    {
        return [
            'id'            => $this->id,
            'comments'      => $this->comments,
            'details'       => $this->details,
            'customer'      => $this->customer()->first(),
            'avatar'        => $this->user,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'status'        => $this->status,
            'orderproducts' => $this->orderproduct,
            'products'      => $this->products,
        ];
    }

    public function orderproduct()
    {
        return $this->belongsTo(OrderProducts::class, 'id', 'order_id');
    }

    public function status()
    {
        return $this->hasOne(OrderStatus::class, 'id', 'order_status_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('id', 'quantity', 'price', 'retail_price', 'billing_cycle', 'term_duration');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function importProducts()
    {
        $order = new Order([
            'token' => Str::uuid(),
            'user_id' => Auth::user()->id,
            'details' => "Importing MS Products",
        ]);
        return $order;
    }


    protected static function booted()
    {
        static::addGlobalScope('access_level', function (Builder $query) {
            $user = Auth::user();
            if ($user && $user->userLevel->name === config('app.provider')) {
                $query->whereHas('customer', function (Builder $query) use ($user) {
                    $query->whereHas('resellers', function (Builder $query) use ($user) {
                        $query->whereHas('provider', function (Builder $query) use ($user) {
                            $query->where('id', $user->provider->id);
                        });
                    });
                });
            }
            if ($user && $user->userLevel->name === config('app.reseller')) {
                $query->whereHas('customer', function (Builder $query) use ($user) {
                    $query->whereHas('resellers', function (Builder $query) use ($user) {
                    });
                });
            }
            if ($user && $user->userLevel->name === config('app.customer')) {
                $query->whereHas('customer', function (Builder $query) use ($user) {
                    $query->where('customer_id', $user->customer->id);
                });
            }
        });
    }
}
