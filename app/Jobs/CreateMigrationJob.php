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
use Tagydes\MicrosoftConnection\Facades\Subscription as SubscriptionFacade;
use Tagydes\MicrosoftConnection\Models\Subscription as TagydesSubscription;
use App\Exceptions\UpdateSubscriptionException;

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
    *
    * @return void
    */
    public function __construct(Subscription $subscription, $amount, $billing_period, $term, $newterm, $order)
    {
        $this->subscription     = $subscription;
        $this->amount           = $amount;
        $this->billing_period   = $billing_period;
        $this->term             = $term;
        $this->newterm          = $newterm;
        $this->order            = $order;
    }

    /**
    * Execute the job.
    *
    * @return void
    */
    public function handle()
    {
        $instance = Instance::where('id', $this->subscription->instance_id)->first();

        $subscription = new TagydesSubscription([
            'id'            => $this->subscription->subscription_id,
            'orderId'       => $this->subscription->order_id,
            'offerId'       => $this->subscription->product_id,
            'customerId'    => $this->subscription->customer->microsoftTenantInfo->first()->tenant_id,
            'name'          => $this->subscription->name,
            'status'        => $this->subscription->status_id,
            'quantity'      => $this->subscription->amount,
            'currency'      => $this->subscription->currency,
            'billingCycle'  => $this->subscription->billing_period,
            'created_at'    => $this->subscription->created_at->__toString(),
        ]);


        $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token)->
        CreateMigrationSubscription($subscription->customerId, $subscription, $this->amount, $this->billing_period, $this->term, $this->newterm);

        Log::info('Creating: ' . $update);

    // $update =  collect([
    //     "id" => "f779c1e6-e49f-4819-8aad-a818ced86fba",
    //     "startedTime" => "2022-02-08T22:44:20.5513905Z",
    //     "currentSubscriptionId" => "B6465E83-F7C4-41F6-B372-F406DA74F8E8",
    //     "status" => "Processing",
    //     "customerTenantId" => "13d77275-dfbb-4e6f-b461-6f4cae706cb0",
    //     "catalogItemId" => "CFQ7TTC0LH1G:0001:CFQ7TTC0KH04",
    //     "newCommerceOrderId" => "61ca3ec48c62",
    //     "subscriptionEndDate" => "2022-02-15T00:00:00Z",
    //     "quantity" => 1,
    //     "termDuration" => "P1Y",
    //     "billingCycle" => "Monthly",
    //     "purchaseFullTerm" => false,
    // ]);


        if(Str::contains($update, '900215')){
            $this->order->errors = ('Error Migrating Subscription: ' . substr($update, strrpos($update, '"description":"' )));
            $this->order->details = ('Error Migrating Subscription: ' . substr($update, strrpos($update, '"description":"' )));
            $this->order->order_status_id = 3;
            $this->order->save();
            return false;
        }

        Log::info('Creating This is from updating: ' . $update);
        $this->order->markAsOrderPlaced();
        $this->order->subscription_id   = $subscription->id;
        $this->order->ext_order_id      = $subscription->orderId;
        $this->order->order_status_id   = 4; //Order Completed state
        $this->order->save();

        $product_id = explode(':', $update['catalogItemId']);
        $product_id = $product_id[0].':'.$product_id[1];

        $subscription                  = new Subscription();
        $subscription->name            = $this->subscription->name;
        $subscription->subscription_id = $this->subscription->id;
        $subscription->customer_id     = $this->subscription->customer->id; //Local customer id
        $subscription->product_id      = $product_id;
        $subscription->catalog_item_id = $update['catalogItemId'];
        $subscription->instance_id     = $this->subscription->instance_id;
        $subscription->billing_type    = 'license';
        $subscription->term            = $update['termDuration'];
        $subscription->order_id        = $update['newCommerceOrderId'];
        $subscription->amount          = $update['quantity'];
        $subscription->msrpid          = $this->subscription->msrpid;
        $subscription->expiration_data = $this->subscription->expiration_data;
        $subscription->billing_period  = $update['billingCycle'];
        $subscription->currency        = $this->subscription->currency;
        $subscription->tenant_name     = $this->subscription->tenant_name;
        $subscription->status_id       = 1;
        $subscription->save();

        $newmigration = Ncemigration::create([
            'migration_id'              => $update['id'],
            'subscription_id'           => $this->subscription->id,
            'new_subscription_id'       => $subscription->id,
            'startedTime'               => $update['startedTime'],
            'currentSubscriptionId'     => $update['currentSubscriptionId'],
            'status'                    => $update['status'],
            'customerTenantId'          => $update['customerTenantId'],
            'catalogItemId'             => $update['catalogItemId'],
            'newCommerceOrderId'        => $update['newCommerceOrderId'],
            'quantity'                  => $update['quantity'],
            'termDuration'              => $update['termDuration'],
            'billingCycle'              => $update['billingCycle'],
            'purchaseFullTerm'          => $update['purchaseFullTerm'],
        ]);
        Log::info('migration created Successfully: ' . $newmigration);

        return $subscription;
        Log::info('Subscription created Successfully: ' . $subscription);

    }

    public function failed($exception)
    {
        $message = substr($exception, strrpos($exception, '"description":"' ));
        logger($message);


    }
}
