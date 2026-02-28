<?php

namespace App\Jobs;

use App\Order;
use Exception;
use App\Instance;
use App\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use romanzipp\QueueMonitor\Traits\IsMonitored;
use Modules\MicrosoftCspConnection\Models\MicrosoftCspConnection;
use Modules\MicrosoftCspConnection\Services\MicrosoftCspClient;
use Modules\MicrosoftCspConnection\Services\SubscriptionService;

class updateSubscriptionMicrosoftJob implements ShouldQueue
{
    private $subscription;
    private $request;
    public $order;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IsMonitored;

    /**
     * Create a new job instance.
     */
    public function __construct(Subscription $subscription, $request, Order $order)
    {
        $this->subscription = $subscription;
        $this->request      = $request;
        $this->order        = $order;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $this->order->order_status_id = 2; //Order running state
        $this->order->save();

        $request       = $this->request;
        $subscriptions = Subscription::findOrFail($this->subscription->id);
        $instance      = Instance::where('id', $subscriptions->instance_id)->first();

        Log::info('Updating Subscription: '.$subscriptions->id);

        $customerId     = $subscriptions->customer->microsoftTenantInfo->first()->tenant_id;
        $subscriptionId = $subscriptions->subscription_id;

        // Resolve CSP connection for this provider
        $connection = MicrosoftCspConnection::where('provider_id', $instance->provider_id)->firstOrFail();
        $client              = new MicrosoftCspClient($connection, config('microsoftcspconnection'));
        $subscriptionService = new SubscriptionService($client);

        if ($request['amount'] != $subscriptions->amount) {
            // Update seat quantity
            try {
                $this->order->details = (
                    'Changing amount of license: '.$request['amount'].
                    ' for Subscription: '.$subscriptions->name.
                    ' for customer: '.$subscriptions->customer->company_name
                );
                $this->order->subscription_id = $subscriptionId;
                $this->order->save();

                $subscriptionService->updateQuantity($customerId, $subscriptionId, (int) $request['amount']);
                $subscriptions->update(['amount' => $request['amount']]);

                Log::info('License changed: '.$request['amount']);
                $this->order->order_status_id = 4; //Order Completed state
                $this->order->subscription_id = $subscriptionId;
                $this->order->save();

            } catch (Exception $e) {
                Log::error('Error updating subscription quantity: '.$e->getMessage());
                $this->order->order_status_id = 3; //Order failed state
                $this->order->subscription_id = $subscriptionId;
                $this->order->save();
            }

        } elseif ($request['billing_period'] != $subscriptions->billing_period) {
            // Update billing cycle
            try {
                $this->order->details = (
                    'Changing current billing Cycle: '.$subscriptions['billing_period'].
                    ' to '.$request['billing_period'].
                    ' for Subscription: '.$subscriptions->name.
                    ' for customer: '.$subscriptions->customer->company_name
                );
                $this->order->subscription_id = $subscriptionId;
                $this->order->save();

                $subscriptionService->updateBillingCycle($customerId, $subscriptionId, $request['billing_period']);
                $subscriptions->update(['billing_period' => $request['billing_period']]);

                Log::info('Billing Cycle changed: '.$request['billing_period']);
                $this->order->order_status_id = 4; //Order Completed state
                $this->order->subscription_id = $subscriptionId;
                $this->order->save();

            } catch (Exception $e) {
                Log::error('Error updating billing cycle: '.$e->getMessage());
                $this->order->order_status_id = 3; //Order failed state
                $this->order->subscription_id = $subscriptionId;
                $this->order->save();
            }

        } else {
            // Update status
            try {
                $subscriptionService->updateStatus($customerId, $subscriptionId, $request['status']);
                $subscriptions->update(['status_id' => $request['status']]);

                Log::info('Status changed: '.$request['status']);
                $this->order->order_status_id = 4; //Order Completed state
                $this->order->subscription_id = $subscriptionId;
                $this->order->save();

            } catch (Exception $e) {
                Log::error('Error updating subscription status: '.$e->getMessage());
                $this->order->order_status_id = 3; //Order failed state
                $this->order->subscription_id = $subscriptionId;
                $this->order->save();
            }
        }
    }
}
