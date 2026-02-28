<?php

namespace App\Jobs;

use App\Order;
use Exception;
use App\Instance;
use App\Subscription;
use Illuminate\Support\Str;
use App\Models\Ncemigration;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Exceptions\UpdateSubscriptionException;
use Modules\MicrosoftCspConnection\Models\MicrosoftCspConnection;
use Modules\MicrosoftCspConnection\Services\MicrosoftCspClient;

class CreateMigrationJob implements ShouldQueue
{
    public $subscription;
    public $amount;
    public $billing_period;
    public $term;
    public $newterm;
    public $order;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(Subscription $subscription, $amount, $billing_period, $term, $newterm, $order)
    {
        $this->subscription   = $subscription;
        $this->amount         = $amount;
        $this->billing_period = $billing_period;
        $this->term           = $term;
        $this->newterm        = $newterm;
        $this->order          = $order;
    }

    /**
     * Execute the job.
     *
     * Creates an NCE migration for a legacy subscription via the Partner Center
     * subscription migrations endpoint: POST /v1/customers/{id}/subscriptions/{id}/migrations
     */
    public function handle()
    {
        $localSub  = $this->subscription;
        $instance  = Instance::where('id', $localSub->instance_id)->first();
        $customerId    = $localSub->customer->microsoftTenantInfo->first()->tenant_id;
        $subscriptionId = $localSub->subscription_id;

        // Resolve CSP connection for this provider
        $connection = MicrosoftCspConnection::where('provider_id', $instance->provider_id)->firstOrFail();
        $client     = new MicrosoftCspClient($connection, config('microsoftcspconnection'));

        $migrationPayload = [
            'currentSubscriptionId' => $subscriptionId,
            'quantity'              => $this->amount,
            'billingCycle'          => $this->billing_period,
            'termDuration'          => $this->newterm,
            'purchaseFullTerm'      => false,
        ];

        $update = $client->request(
            'POST',
            "customers/{$customerId}/subscriptions/{$subscriptionId}/migrations",
            $migrationPayload
        );

        Log::info('Creating Migration JSON: ' . json_encode($update));

        // Check for Partner Center error codes in the response
        if (isset($update['code']) && Str::contains((string) ($update['code'] ?? ''), '900215')) {
            $this->order->errors        = 'Error Migrating Subscription: ' . ($update['description'] ?? json_encode($update));
            $this->order->details       = 'Error Migrating Subscription: ' . ($update['description'] ?? json_encode($update));
            $this->order->order_status_id = 3;
            $this->order->save();
            return false;
        }

        Log::info('Creating This is from updating: ' . json_encode($update));
        $this->order->markAsOrderPlaced();
        $this->order->subscription_id   = $localSub->id;
        $this->order->ext_order_id      = $update['newCommerceOrderId'] ?? null;
        $this->order->order_status_id   = 4; //Order Completed state
        $this->order->request_body      = json_encode($update);
        $this->order->save();

        $catalogItemId = $update['catalogItemId'] ?? '';
        $parts         = explode(':', $catalogItemId);
        $productId     = isset($parts[1]) ? $parts[0].':'.$parts[1] : $catalogItemId;

        $subscription                  = new Subscription();
        $subscription->name            = $localSub->name;
        $subscription->subscription_id = $localSub->id;
        $subscription->customer_id     = $localSub->customer->id;
        $subscription->product_id      = $productId;
        $subscription->catalog_item_id = $catalogItemId;
        $subscription->instance_id     = $localSub->instance_id;
        $subscription->billing_type    = 'license';
        $subscription->term            = $update['termDuration']   ?? null;
        $subscription->order_id        = 123;
        $subscription->amount          = $update['quantity']        ?? $this->amount;
        $subscription->msrpid          = $localSub->msrpid;
        $subscription->expiration_data = $localSub->expiration_data;
        $subscription->billing_period  = $update['billingCycle']   ?? $this->billing_period;
        $subscription->currency        = $localSub->currency;
        $subscription->tenant_name     = $localSub->tenant_name;
        $subscription->status_id       = 1;
        $subscription->save();

        $newmigration = Ncemigration::create([
            'migration_id'          => $update['id']                    ?? null,
            'subscription_id'       => $localSub->id,
            'new_subscription_id'   => $subscription->id,
            'startedTime'           => $update['startedTime']           ?? null,
            'currentSubscriptionId' => $update['currentSubscriptionId'] ?? $subscriptionId,
            'status'                => $update['status']                ?? null,
            'customerTenantId'      => $update['customerTenantId']      ?? $customerId,
            'catalogItemId'         => $catalogItemId,
            'newCommerceOrderId'    => $update['newCommerceOrderId']    ?? 123,
            'quantity'              => $update['quantity']              ?? $this->amount,
            'termDuration'          => $update['termDuration']          ?? null,
            'billingCycle'          => $update['billingCycle']          ?? null,
            'purchaseFullTerm'      => $update['purchaseFullTerm']      ?? false,
        ]);

        Log::info('Migration created Successfully: ' . $newmigration);
        Log::info('Subscription created Successfully: ' . $subscription);

        return $subscription;
    }

    public function failed($exception)
    {
        $message = substr($exception, strrpos($exception, '"description":"'));
        logger($message);
    }
}
