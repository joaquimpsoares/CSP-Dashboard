<?php

namespace App;

use App\Jobs\CreateCustomerMicrosoft;
use App\Jobs\PlaceOrderMicrosoft;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Throwable;

class Order extends Model
{
    protected $dates = ['verified_at'];

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

    public function createOrder($request, $user){
        $token = Str::uuid();
        $order = new Order();
        $order->token = $token;
        $order->customer_id = $request->customer->id;
        $order->domain = $request->domain;
        $order->user_id = $user['id'];
        $order->verify = $request->verify;
        $order->verified = $request->verified;
        $order->agreement_firstname = $request->agreement_firstname;
        $order->agreement_lastname = $request->agreement_lastname;
        $order->agreement_email = $request->agreement_email;
        $order->agreement_phone = $request->agreement_phone;
        $order->comments = $request->comments;
        $order->save();

        return $order;
    }

    public function sendToMicrosoft(){
        $tenant = MicrosoftTenantInfo::where('tenant_domain', 'like', $this->domain . '%')->first();

        if ($tenant == null) {
            Bus::chain([
                new CreateCustomerMicrosoft($this),
                new PlaceOrderMicrosoft($this)
            ])->catch(function (Throwable $e) {
                $this->details = ('Error placing order to Microsoft: ' . $e->getMessage());
                $this->save();
            })->onQueue('PlaceordertoMS')->dispatch();
        } else {
            PlaceOrderMicrosoft::dispatch($this)->OnQueue('PlaceordertoMS');
            Log::info('Data to Place order: ' . $this);
        }
    }

    public function markAsOrderPlaced(){
        $this->fill([
            'order_status_id' => '1',
        ])->save();
    }

    public function markAsRunning(){
        $this->fill([
            'order_status_id' => '2',
        ])->save();
    }

    public function markAsFailed(){
        $this->fill([
            'order_status_id' => '3',
        ])->save();
    }

    public function markAsCompleted(){
        $this->fill([
            'order_status_id' => '4',
        ])->save();
    }

    public function orderproduct(){
        return $this->belongsTo(OrderProducts::class, 'id', 'order_id');
    }

    public function status(){
        return $this->hasOne(OrderStatus::class, 'id', 'order_status_id');
    }

    public function products(){
        return $this->belongsToMany(Product::class)->withPivot('id', 'quantity', 'price', 'retail_price', 'billing_cycle', 'term_duration');
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function importProducts(){
        $order = new Order([
            'token' => Str::uuid(),
            'user_id' => Auth::user()->id,
            'details' => "Importing MS Products",
        ]);
        return $order;
    }


    protected static function booted(){
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
