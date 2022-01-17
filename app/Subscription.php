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
use Tagydes\MicrosoftConnection\Models\Customer as TagydesCustomer;
use Tagydes\MicrosoftConnection\Facades\Subscription as SubscriptionFacade;
use Tagydes\MicrosoftConnection\Models\Subscription as TagydesSubscription;

class Subscription extends Model
{
    use ActivityTrait;

    public function format()
    {
        return [
            'path'          => $this->path(),
        ];
    }
    protected $casts = [
        'changes_on_renew' => 'array',
    ];

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
    public function validatemigration ($customer,$subscription)
    {
// dd($customer->microsoftTenantInfo->first()->tenant_id);
        $customer = new TagydesCustomer([
            'id' => $customer->microsoftTenantInfo->first()->tenant_id,
            'username' => 'bill@tagydes.com',
            'password' => 'blabla',
            'firstName' => 'Nombre',
            'lastName' => 'Apellido',
            'email' => 'bill@tagydes.com',
        ]);

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



    return SubscriptionFacade::withCredentials($this->instance->external_id, $this->instance->external_token) //change status only
        ->ValidateMigratioSubscription($customer, $subscription);

    }
        public function changeBillingCycle($cycle)
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
        try {
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
        } catch (\Exception $th) {
        }
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

        $this->markAsSuspended();
        Log::info('Status changed: Suspended');

        return $this;
    }

    public function cancel()
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
        ->cancelNCE($subscription);

        $this->markAsCanceled();
        Log::info('Status changed: Suspended');

        return $this;
    }

    public function setbudget($value)
    {

        SubscriptionFacade::withCredentials($this->instance->external_id, $this->instance->external_token) //change status only
        ->update($subscription, ['status' => 'suspended']);

        $this->markAsDisabled();
        Log::info('Status changed: Suspended');

        return $this;
    }

    public function markAsDisabled()
    {
        $this->fill([
            'status_id' => '2',
            ])->save();
    }

    public function markAsCanceled()
    {
        $this->fill([
            'status_id' => '3',
            ])->save();
    }

    public function path()
    {
        return url("/subscription/{$this->id}-" . Str::slug($this->name, '-'));
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
        return $this->hasMany(Product::class, 'catalog_item_id', 'product_id');
    }

    public function product() {
        return $this->hasOne(Product::class, 'catalog_item_id', 'product_id');
    }
    public function productonce() {
        return $this->hasOne(Product::class, 'catalog_item_id', 'product_id');
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
