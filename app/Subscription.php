<?php

namespace App;

use App\Order;
use App\Price;
use App\Models\Addon;
use Illuminate\Support\Str;
use App\Models\AzureResource;
use App\Http\Traits\Expirable;
use App\Http\Traits\ActivityTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\SubscriptionUpdate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Notification;
use Tagydes\MicrosoftConnection\Facades\Subscription as SubscriptionFacade;
use Tagydes\MicrosoftConnection\Models\Subscription as TagydesSubscription;

class Subscription extends Model
{
    use ActivityTrait;
    // use Expirable;


    const STATUSES = [
        '1' => 'Active',
        '2' => 'Inactive',
        '3' => 'Canceled',
        '4' => 'Expired',
        '5' => 'pending',
    ];

    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function instance() {
        return $this->belongsTo(Instance::class);
    }

    public function activate()
    {
        $subscription = new TagydesSubscription([
            'id'            => $this->subscription_id,
            'orderId'       => $this->order_id,
            'offerId'       => $this->product_id,
            'customerId'    => $this->customer->microsoftTenantInfo->first()->tenant_id,
            'name'          => $this->name,
            'status'        => $this->status_id,
            'quantity'      => $this->amount,
            'currency'      => $this->currency,
            'billingCycle'  => $this->billing_period,
            'created_at'    => $this->created_at->__toString(),
        ]);

        $update = SubscriptionFacade::withCredentials($this->instance->external_id, $this->instance->external_token) //change status only
        ->update($subscription, ['status' => 'active']);

        $this->markAsActive();

        return $this;
    }

    public function markAsActive()
    {
        $this->fill([
            'status_id' => '1',
        ])->save();
    }

    public function changeBillingCycle($cycle)
    {
        // $product = Price::where('product_id', $this->product_id)->first();
        $subscription = new TagydesSubscription([
            'id'            => $this->subscription_id,
            'orderId'       => $this->order_id,
            'offerId'       => $this->product_id,
            'customerId'    => $this->customer->microsoftTenantInfo->first()->tenant_id,
            'name'          => $this->name,
            'status'        => $this->status_id,
            'quantity'      => $this->amount,
            'currency'      => $this->currency,
            'billingCycle'  => $this->billing_period,
            'created_at'    => $this->created_at->__toString(),
        ]);
        // $order = new Order();
        // $order->details = "changing subscription ".$this->name ." from ". $subscription->billing_period. " to ". $cycle;
        // $order->token = Str::uuid();
        // $order->user_id = Auth::user()->id;
        // $order->save();
        // $order->products()->attach($this->product_id, [
        //     'id' => Str::uuid(),
        //     'price' => $product->price ?? '0',
        //     'retail_price' => $product->msrp ?? '0',
        //     'billing_cycle' => $cycle,
        //     'quantity' => $this->quantity ?? '0'
        //     ]);

            $update = SubscriptionFacade::withCredentials($this->instance->external_id, $this->instance->external_token)->changeBillingCycle($subscription, $cycle);

        return $this;
    }

    public function changeAmount($quantity)
    {

        $product = Price::where('product_id', $this->product_id)->first();
        $subscription = new TagydesSubscription([
            'id'            => $this->subscription_id,
            'orderId'       => $this->order_id,
            'offerId'       => $this->product_id,
            'customerId'    => $this->customer->microsoftTenantInfo->first()->tenant_id,
            'name'          => $this->name,
            'status'        => $this->status_id,
            'quantity'      => $this->amount,
            'currency'      => $this->currency,
            'billingCycle'  => $this->billing_period,
            'created_at'    => $this->created_at->__toString(),
        ]);
        $order = new Order();
        $order->details = "changing subscription ".$this->name ." amount from ". $subscription->amount. " to ". $quantity;
        $order->token = Str::uuid();
        $order->user_id = Auth::user()->id;
        $order->save();
        $order->products()->attach($this->product_id, [
            'id' => Str::uuid(),
            'price' => $product->price ?? '0',
            'retail_price' => $product->msrp ?? '0',
            'billing_cycle' => $this->billing_period,
            'quantity' => $quantity
            ]);


        $update = SubscriptionFacade::withCredentials($this->instance->external_id, $this->instance->external_token)->
        update($subscription, ['quantity' => $quantity]);

        return $this;
    }

    public function suspend()
    {

        $subscription = new TagydesSubscription([
            'id'            => $this->subscription_id,
            'orderId'       => $this->order_id,
            'offerId'       => $this->product_id,
            'customerId'    => $this->customer->microsoftTenantInfo->first()->tenant_id,
            'name'          => $this->name,
            'status'        => $this->status_id,
            'quantity'      => $this->amount,
            'currency'      => $this->currency,
            'billingCycle'  => $this->billing_period,
            'created_at'    => $this->created_at->__toString(),
        ]);

        $update = SubscriptionFacade::withCredentials($this->instance->external_id, $this->instance->external_token) //change status only
        ->update($subscription, ['status' => 'suspended']);

        $this->markAsCancelled();
        // $this->notify('Subscription ' . $subscription->name . ' is suspended, refresh page');
        // Notification::send($subscription->customer->users->first(), new SubscriptionUpdate($subscription));
        Log::info('Status changed: Suspended');

        return $this;
    }

    public function setbudget($value)
    {

        SubscriptionFacade::withCredentials($this->instance->external_id, $this->instance->external_token) //change status only
        ->update($subscription, ['status' => 'suspended']);

        $this->markAsCancelled();
        // $this->notify('Subscription ' . $subscription->name . ' is suspended, refresh page');
        // Notification::send($subscription->customer->users->first(), new SubscriptionUpdate($subscription));
        Log::info('Status changed: Suspended');

        return $this;
    }

    public function markAsCancelled()
    {
        $this->fill([
            'status_id' => '2',
            ])->save();
        }

    public function addons() {
        return $this->hasMany(Addon::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function order() {
        return $this->hasMany(Order::class, 'subscription_id', 'id');
    }

    public function products() {
        return $this->hasMany(Product::class, 'sku', 'product_id');
    }

    public function azureresources() {
        return $this->belongsToMany(AzureResource::class);
    }

    protected static function booted(){
        static::addGlobalScope('access_level', function(Builder $query){
            $user = Auth::user();
            if($user && $user->userLevel->name === config('app.provider')){
                $query->whereHas('customer', function(Builder $query) use($user){
                    $query->whereHas('resellers', function(Builder $query) use($user){
                        $query->whereHas('provider', function(Builder $query) use($user){
                            $query->where('id', $user->provider->id);
                        });
                    });
                });
            }
            if($user && $user->userLevel->name === config('app.reseller')){
                $query->whereHas('customer', function(Builder $query) use($user){
                    $query->whereHas('resellers', function(Builder $query) use($user){
                        $query->where('id', $user->reseller->id);
                    });
                });
            }
            if($user && $user->userLevel->name === config('app.customer')){
                $query->whereHas('customer', function(Builder $query) use($user){
                    $query->where('id', $user->customer->id);
                });
            }
        });
    }
}
