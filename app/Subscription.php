<?php

namespace App;

use App\Order;
use App\Models\Addon;
use Illuminate\Support\Str;
use App\Models\AzureResource;
use App\Http\Traits\ActivityTrait;
use App\Models\Ncemigration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Modules\MicrosoftCspConnection\Models\MicrosoftCspConnection;
use Modules\MicrosoftCspConnection\Services\MicrosoftCspClient;
use Modules\MicrosoftCspConnection\Services\SubscriptionService;

class Subscription extends Model
{
    use ActivityTrait;

    public function format(){
        return [
            'path' => $this->path(),
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

    // -------------------------------------------------------------------------
    // Internal helpers
    // -------------------------------------------------------------------------

    /**
     * Resolve a SubscriptionService scoped to this subscription's provider connection.
     */
    private function getSubscriptionService(): SubscriptionService
    {
        $connection = MicrosoftCspConnection::where('provider_id', $this->instance->provider_id)->firstOrFail();
        $client     = new MicrosoftCspClient($connection, config('microsoftcspconnection'));
        return new SubscriptionService($client);
    }

    /**
     * Return the Microsoft tenant ID for this subscription's customer.
     */
    private function getCustomerTenantId(): string
    {
        return $this->customer->microsoftTenantInfo->first()->tenant_id;
    }

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function instance(){
        return $this->belongsTo(Instance::class);
    }

    public function addons(){
        return $this->hasMany(Addon::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function migratedTo(){
        return $this->hasOne(Ncemigration::class, 'new_subscription_id', 'id');
    }

    public function migratedToOrders(){
        return $this->hasMany(Order::class, 'subscription_id', 'currentSubscriptionId');
    }

    public function orders(){
        return $this->hasMany(Order::class);
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

    // -------------------------------------------------------------------------
    // Status helpers
    // -------------------------------------------------------------------------

    public function markAsActive(){
        $this->fill(['status_id' => '1'])->save();
    }

    public function markAsDisabled(){
        $this->fill(['status_id' => '2'])->saveQuietly();
    }

    public function markAsDontrenew(){
        $this->fill(['autorenew' => false])->saveQuietly();
    }

    public function markAsrenew(){
        $this->fill(['autorenew' => true])->saveQuietly();
    }

    public function markAsCanceled(){
        $this->fill(['status_id' => '3'])->saveQuietly();
    }

    public function IsMigrated(){
        if(Ncemigration::where('new_subscription_id', $this->id)->first()){
            return true;
        }
        return false;
    }

    // -------------------------------------------------------------------------
    // Partner Center operations
    // -------------------------------------------------------------------------

    /**
     * Suspend (disable) this subscription in Partner Center.
     */
    public function suspend(){
        $this->billing_period = strtolower($this->billing_period);

        $order = new Order();
        $order->subscription_id = $this->id;
        $order->customer_id     = $this->customer_id;
        $order->domain          = $this->domain;
        $order->token           = Str::uuid();
        $order->user_id         = Auth::user()->id ?? '10001';

        try {
            $subscriptionService = $this->getSubscriptionService();
            $subscriptionService->update(
                $this->getCustomerTenantId(),
                $this->subscription_id,
                ['status' => 'suspended', 'autoRenewEnabled' => true]
            );
        } catch (\Exception $th) {
            $order->details         = 'Error placing order: ' . $th->getMessage();
            $order->order_status_id = 3;
            $order->save();
            return $th->getMessage();
        }

        $this->markAsDisabled();
        $order->details         = 'changing subscription ' . $this->name . ' status to suspended';
        $order->order_status_id = 4;
        $order->save();
        Log::info('Status changed: Suspended ' . $this->subscription_id);

        return $this;
    }

    /**
     * Activate (resume) this subscription in Partner Center.
     */
    public function active(){
        $this->billing_period = strtolower($this->billing_period);

        $order = new Order();
        $order->subscription_id = $this->id;
        $order->customer_id     = $this->customer_id;
        $order->domain          = $this->domain;
        $order->token           = Str::uuid();
        $order->user_id         = Auth::user()->id;

        try {
            $subscriptionService = $this->getSubscriptionService();
            $subscriptionService->update(
                $this->getCustomerTenantId(),
                $this->subscription_id,
                ['status' => 'active', 'autoRenewEnabled' => false]
            );
        } catch (\Exception $th) {
            $order->details         = 'Error placing order: ' . $th->getMessage();
            $order->order_status_id = 3;
            $order->save();
            return $th->getMessage();
        }

        $this->markAsActive();
        $this->markAsDontrenew();
        $order->details         = 'changing subscription ' . $this->name . ' status to active';
        $order->order_status_id = 4;
        $order->save();
        Log::info('Status changed: Active ' . $this->subscription_id);

        return $this;
    }

    /**
     * Change the billing cycle of this subscription in Partner Center.
     */
    public function changeBillingCycle($cycle){
        $order = new Order();
        $order->customer_id     = $this->customer_id;
        $order->subscription_id = $this->id;
        $order->domain          = $this->domain;
        $order->token           = Str::uuid();
        $order->user_id         = Auth::user()->id;

        try {
            $subscriptionService = $this->getSubscriptionService();
            $subscriptionService->updateBillingCycle(
                $this->getCustomerTenantId(),
                $this->subscription_id,
                $cycle
            );
        } catch (\Exception $th) {
            $order->details         = 'Error placing order: ' . $th->getMessage();
            $order->order_status_id = 3;
            $order->save();
            return $th->getMessage();
        }

        $order->details         = 'changing subscription ' . $this->name . ' billing period from ' . $this->billing_period . ' to ' . $cycle;
        $order->order_status_id = 4;
        $order->save();

        return $this;
    }

    /**
     * Change the seat quantity of this subscription in Partner Center.
     */
    public function changeAmount($quantity, $autorenew, $before){
        $autorenew = (bool) $autorenew;

        $order = new Order();
        $order->customer_id     = $this->customer_id;
        $order->subscription_id = $this->id;
        $order->domain          = $this->domain;
        $order->token           = Str::uuid();
        $order->user_id         = Auth::user()->id;

        try {
            $subscriptionService = $this->getSubscriptionService();
            $update = $subscriptionService->update(
                $this->getCustomerTenantId(),
                $this->subscription_id,
                ['quantity' => (int) $quantity, 'autoRenewEnabled' => $autorenew]
            );
        } catch (\Exception $th) {
            $order->details         = 'Error placing order: ' . $th->getMessage();
            $order->order_status_id = 3;
            $order->save();
            return $th->getMessage();
        }

        $order->details         = 'changing subscription ' . $this->name . ' amount from ' . $before . ' to ' . $quantity;
        $order->order_status_id = 4;
        $order->save();

        return $update;
    }

    /**
     * Toggle the auto-renew setting of this subscription in Partner Center.
     */
    public function changeAutorenew($quantity, $autorenew){
        $autorenew = (bool) $autorenew;

        $order = new Order();
        $order->customer_id     = $this->customer_id;
        $order->subscription_id = $this->id;
        $order->domain          = $this->domain;
        $order->token           = Str::uuid();
        $order->user_id         = Auth::user()->id;

        try {
            $subscriptionService = $this->getSubscriptionService();
            $update = $subscriptionService->update(
                $this->getCustomerTenantId(),
                $this->subscription_id,
                ['autoRenewEnabled' => $autorenew]
            );
        } catch (\Exception $th) {
            $order->details         = 'Error placing order: ' . $th->getMessage();
            $order->order_status_id = 3;
            $order->save();
            return $th->getMessage();
        }

        $order->details         = 'changing subscription ' . $this->name . ' autorenew to ' . ($autorenew ? 'true' : 'false');
        $order->order_status_id = 4;
        $order->save();

        return $update;
    }

    /**
     * Cancel an NCE subscription in Partner Center.
     */
    public function cancel(Customer $customer, Subscription $subscription){
        try {
            $subscriptionService = $this->getSubscriptionService();
            $update = $subscriptionService->cancelSubscription(
                $customer->microsoftTenantInfo->first()->tenant_id,
                $subscription->subscription_id
            );
        } catch (\Exception $th) {
            Log::error('Error canceling subscription: ' . $th->getMessage());
            return collect(['code' => 1, 'description' => $th->getMessage()]);
        }

        $this->markAsCanceled();
        Log::info('Status changed: Canceled ' . $subscription->subscription_id);

        return collect($update);
    }

    /**
     * Get the full subscription record from Partner Center.
     *
     * @return \Illuminate\Support\Collection  Subscription resource as a Collection
     */
    public function getSubscription($customer, $subscription){
        try {
            $subscriptionService = $this->getSubscriptionService();
            $result = $subscriptionService->get(
                $customer->microsoftTenantInfo->first()->tenant_id,
                $this->subscription_id
            );
            return collect($result);
        } catch (\Exception $th) {
            Log::error('Error fetching subscription from Partner Center: ' . $th->getMessage());
            return collect([]);
        }
    }

    /**
     * Validate whether a legacy subscription can be migrated to NCE.
     *
     * @return \Illuminate\Support\Collection  Validation result
     */
    public function validatemigration($customer, $subscription){
        try {
            $subscriptionService = $this->getSubscriptionService();
            $result = $subscriptionService->validateMigration(
                $customer->microsoftTenantInfo->first()->tenant_id,
                $this->subscription_id
            );
            return collect($result);
        } catch (\Exception $th) {
            Log::error('Error validating migration: ' . $th->getMessage());
            return collect([]);
        }
    }

    /**
     * Create an NCE migration for this subscription.
     */
    public function migrateSubscriptionMCE($customer, $subscription, $amount, $billing_period, $term, $newterm){
        try {
            $subscriptionService = $this->getSubscriptionService();
            $result = $subscriptionService->createMigration(
                $customer->microsoftTenantInfo->first()->tenant_id,
                $this->subscription_id,
                [
                    'quantity'      => (int) $amount,
                    'billingCycle'  => $billing_period,
                    'termDuration'  => $term,
                    'purchaseFullTerm' => ($newterm !== $term),
                ]
            );
            return collect($result);
        } catch (\Exception $th) {
            Log::error('Error creating migration: ' . $th->getMessage());
            return collect([]);
        }
    }

    /**
     * Check the status of an NCE migration.
     */
    public function CheckMigrationSubscription($customer, $migration_id){
        try {
            $subscriptionService = $this->getSubscriptionService();
            $migrationId = is_object($migration_id) ? ($migration_id->newCommerceSubscriptionId ?? $migration_id->id) : $migration_id;
            $result = $subscriptionService->getMigration(
                $customer->microsoftTenantInfo->first()->tenant_id,
                $this->subscription_id,
                $migrationId
            );
            return $result;
        } catch (\Exception $th) {
            Log::error('Error checking migration: ' . $th->getMessage());
            return [];
        }
    }

    /**
     * Set a spending budget (Azure plan only — not applicable to license subscriptions).
     * Retained as a no-op stub; Azure budget management requires a separate module.
     */
    public function setbudget($value){
        Log::warning('Subscription::setbudget() called but Azure budget API is not yet implemented in MicrosoftCspConnection module.');
        $this->markAsDisabled();
        return $this;
    }

    public function path(){
        return url("/subscription/{$this->id}-" . Str::slug($this->name, '-'));
    }

    protected static function booted(){
        static::addGlobalScope('access_level', function(Builder $query){
            $user = \Illuminate\Support\Facades\Auth::user();
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
