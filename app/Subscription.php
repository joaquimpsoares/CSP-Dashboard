<?php

namespace App;

use App\Order;
use App\Price;
use App\Models\Addon;
use Illuminate\Support\Str;
use App\Models\AzureResource;
use App\Http\Traits\Expirable;
use App\Http\Traits\ActivityTrait;
use App\Models\Ncemigration;
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

    public function format(){
        return [
            'path'          => $this->path(),
        ];
    }

    protected $casts = [
        'changes_on_renew' => 'array',
        'refundableQuantity' => 'array',
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

    public function markAsActive(){
        $this->fill([
            'status_id' => '1',
        ])->save();
    }

    public function validatemigration($customer,$subscription){
        $customer = new TagydesCustomer([
            'id' => $customer->microsoftTenantInfo->first()->tenant_id,
            'username' => 'bill@tagydes.com',
            'password' => 'blabla',
            'firstName' => 'Nombre',
            'lastName' => 'Apellido',
            'email' => 'bill@tagydes.com',
        ]);

        $billingCycle =strtolower($this->billing_period);

        $subscription = new TagydesSubscription([
            'id'            => $this->subscription_id,
            'orderId'       => $this->order_id,
            'offerId'       => $this->product_id,
            'customerId'    => $this->customer->microsoftTenantInfo->first()->tenant_id,
            'name'          => $this->name,
            'status'        => $this->status_id,
            'quantity'      => $this->amount,
            'currency'      => $this->currency,
            'billingCycle'  => $billingCycle,
            'created_at'    => $this->created_at->__toString(),
        ]);
        return SubscriptionFacade::withCredentials($this->instance->external_id, $this->instance->external_token)
        ->ValidateMigratioSubscription($customer, $subscription);
    }

    public function migrateSubscriptionMCE ($customer, $subscription, $amount, $billing_period, $term, $newterm){

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

        return SubscriptionFacade::withCredentials($this->instance->external_id, $this->instance->external_token)
        ->CreateMigrationSubscription($customer, $subscription, $amount, $billing_period, $term, $newterm);
    }

    public function CheckMigrationSubscription ($customer, $migration_id){
        $customer = new TagydesCustomer([
            'id' => $customer->microsoftTenantInfo->first()->tenant_id,
            'username' => 'bill@tagydes.com',
            'password' => 'blabla',
            'firstName' => 'Nombre',
            'lastName' => 'Apellido',
            'email' => 'bill@tagydes.com',
        ]);

        return SubscriptionFacade::withCredentials($this->instance->external_id, $this->instance->external_token)
        ->CheckMigrationSubscription($customer, $migration_id);
    }

    public function changeBillingCycle($cycle){

        $order = new Order();
        $order->customer_id = $this->customer_id;
        $order->domain = $this->domain;
        $order->token = Str::uuid();
        $order->user_id = Auth::user()->id;
        $order->verify = $this->verify;

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
            $update = SubscriptionFacade::withCredentials($this->instance->external_id, $this->instance->external_token)->changeBillingCycle($subscription, $cycle);
        } catch (\Exception $th) {
            $order->details = "Error placing order" . $th->getMessage();
            $order->order_status_id = 3;
            $order->save();

            return $th->getMessage();
        }

        $order->details = "changing subscription ".$this->name ." Billing Period from ". $this->billing_period. " to ". $cycle;
        $order->order_status_id = 4;
        $order->save();
        return $this;
    }

    public function changeAmount($quantity,$autorenew){
        if($autorenew == 1){
            $autorenew == true;
        }else{
            $autorenew == false;
        }

        $order = new Order();
        $order->customer_id = $this->customer_id;
        $order->domain = $this->domain;
        $order->token = Str::uuid();
        $order->user_id = Auth::user()->id;
        $order->verify = $this->verify;

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
            $update = SubscriptionFacade::withCredentials($this->instance->external_id, $this->instance->external_token)->
            update($subscription, [
                'quantity'          => $quantity,
                'AutoRenewEnabled'  => $autorenew,
            ]);

        } catch (\Exception $th) {
            $order->details = "Error placing order" . $th->getMessage();
            $order->order_status_id = 3;
            $order->save();

            return $th->getMessage();
        }

        $order->details = "changing subscription ".$this->name ." amount from ". $this->amount. " to ". $quantity;
        $order->order_status_id = 4;
        $order->save();

        return $update;
    }

    public function changeAutorenew($quantity,$autorenew){

        $order = new Order();
        $order->customer_id = $this->customer_id;
        $order->domain = $this->domain;
        $order->token = Str::uuid();
        $order->user_id = Auth::user()->id;
        $order->verify = $this->verify;

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
            $update = SubscriptionFacade::withCredentials($this->instance->external_id, $this->instance->external_token)->
            update($subscription, [
                'quantity'          => $quantity,
                'AutoRenewEnabled' => $autorenew,
            ]);
        } catch (\Exception $th) {
            $order->details = "Error placing order" . $th->getMessage();
            $order->order_status_id = 3;
            $order->save();
           return $th->getMessage();
        }

        $order->details = "changing subscription ".$this->name ." autorenew ". $this->autorenew . " to ". $autorenew;
        $order->order_status_id = 4;
        $order->save();

        return $update;
    }

    public function IsMigrated(){
        if(Ncemigration::where('new_subscription_id', $this->id)->first()){
            return true;
        }
        return false;
        // return Ncemigration::where('new_subscription_id', $this->id)->first();
    }

    public function active(){
        $this->billing_period = strtolower($this->billing_period);

        $order = new Order();
        $order->customer_id = $this->customer_id;
        $order->domain = $this->domain;
        $order->token = Str::uuid();
        $order->user_id = Auth::user()->id;
        $order->verify = $this->verify;
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
            $update = SubscriptionFacade::withCredentials($this->instance->external_id, $this->instance->external_token) //change status only
            ->update($subscription, [
                'status' => 'active',
                'AutoRenewEnabled' => false,
            ]);

        } catch (\Exception $th) {
            $order->details = "Error placing order" . $th->getMessage();
            $order->order_status_id = 3;
            $order->save();
           return $th->getMessage();
        }

        $this->markAsActive();
        $this->markAsDontrenew();

        $order->details = "changing subscription ".$this->name . " and changing the status to active";
        $order->order_status_id = 4;
        $order->save();
        Log::info('Status changed: Suspended');
        return $this;

    }

    public function suspend(){
        $this->billing_period = strtolower($this->billing_period);

        $order = new Order();
        $order->customer_id = $this->customer_id;
        $order->domain = $this->domain;
        $order->token = Str::uuid();
        $order->user_id = Auth::user()->id;
        $order->verify = $this->verify;
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
            $update = SubscriptionFacade::withCredentials($this->instance->external_id, $this->instance->external_token) //change status only
        ->update($subscription, [
            'status' => 'suspended',
            'AutoRenewEnabled' => true,
        ]);
        } catch (\Exception $th) {
            $order->details = "Error placing order" . $th->getMessage();
            $order->order_status_id = 3;
            $order->save();
           return $th->getMessage();
        }


        $this->markAsDisabled();
        $order->details = "changing subscription ".$this->name . " and changing the status to suspended";

        $order->order_status_id = 4;
        $order->save();
        Log::info('Status changed: Suspended');

        return $this;
    }

    public function cancel(){
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

    public function setbudget($value){

        SubscriptionFacade::withCredentials($this->instance->external_id, $this->instance->external_token) //change status only
        ->update($value, ['status' => 'suspended']);

        $this->markAsDisabled();
        Log::info('Status changed: Suspended');

        return $this;
    }

    public function markAsDisabled(){
        $this->fill([
            'status_id' => '2',
            ])->save();
    }

    public function markAsDontrenew(){
        $this->fill([
            'autorenew' => false,
            ])->save();
    }

    public function markAsrenew(){
        $this->fill([
            'autorenew' => true,
            ])->save();
    }

    public function markAsCanceled(){
        $this->fill([
            'status_id' => '3',
            ])->save();
    }

    public function path(){
        return url("/subscription/{$this->id}-" . Str::slug($this->name, '-'));
    }

    public function addons(){
        return $this->hasMany(Addon::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function migration(){
        return $this->hasone(Ncemigration::class);
    }

    public function order(){
        return $this->hasMany(Order::class, 'subscription_id', 'id');
    }

    public function products(){
        return $this->hasMany(Product::class, 'sku', 'product_id');
    }

    public function product(){
        return $this->hasOne(Product::class, 'sku', 'product_id');
    }

    public function productonce(){
        return $this->hasOne(Product::class, 'sku', 'product_id');
    }

    public function azureresources(){
        return $this->belongsToMany(AzureResource::class);
    }

    protected static function booted()
    {
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
