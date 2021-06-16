<?php

namespace App\Jobs;

use App\Order;
use Exception;
use App\Instance;
use App\Subscription;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use romanzipp\QueueMonitor\Traits\IsMonitored;
use Tagydes\MicrosoftConnection\Facades\Subscription as SubscriptionFacade;
use Tagydes\MicrosoftConnection\Models\Subscription as TagydesSubscription;

class updateSubscriptionMicrosoftJob implements ShouldQueue
{

    private $subscription;
    private $request;
    public $order;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IsMonitored;

    /**
    * Create a new job instance.
    *
    * @return void
    */
    public function __construct(Subscription $subscription, $request, Order $order)
    {
        $this->subscription = $subscription;
        $this->request = $request;
        $this->order = $order;
    }

    /**
    * Execute the job.
    *
    * @return void
    */
    public function handle()
    {


        $this->order->order_status_id = 2; //Order running state
        $this->order->save();


        $request = $this->request;

        Log::info('Setting Customer to Cart: '.$this->subscription);


        $subscriptions = Subscription::findOrFail($this->subscription->id);
        $instance = Instance::where('id', $subscriptions->instance_id)->first();

        $subscription = new TagydesSubscription([
            'id'            => $subscriptions->subscription_id,
            'orderId'       => $subscriptions->order_id,
            'offerId'       => $subscriptions->product_id,
            'customerId'    => $subscriptions->customer->microsoftTenantInfo->first()->tenant_id,
            'name'          => $subscriptions->name,
            'status'        => $subscriptions->status_id,
            'quantity'      => $subscriptions->amount,
            'currency'      => $subscriptions->currency,
            'billingCycle'  => $subscriptions->billing_period,
            'created_at'    => $subscriptions->created_at->__toString(),
        ]);

        if($request['amount'] != $subscriptions->amount){
            try{
                dd('jj');
                $this->order->details = ('Changing amount of license: '.$request['amount']. ' for Subscription: '. $subscriptions->name. ' for customer: '. $subscriptions->customer->company_name );
                $this->order->subscription_id = $subscription['id'];
                $this->order->save();

                $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token)->
                update($subscription, ['quantity' => $request['amount']]);

                $subscriptions->update(['amount'=> $request['amount']]);

                Log::info('License changed: '.$request['amount']);
                $this->order->order_status_id = 4; //Order Completed state
                $this->order->subscription_id = $subscription['id'];
                $this->order->save();

            } catch (Exception $e) {
                Log::info('Error Placing order to Microsoft: '.$e->getMessage());

                $this->order->order_status_id = 3; //Order failed state
                $this->order->subscription_id = $subscription['id'];
                $this->order->save();

                return redirect()->back()->with(['alert' => 'error', 'message' => ucwords(trans_choice('messages.something_went_wrong_try_again', 1))]);
            }
        }else if ($request['billing_period'] != $subscriptions->billing_period){
            try{

                $this->order->details = ('Changing current billing Cycle: '.$subscriptions['billing_period']. ' to '.$request['billing_period'] . ' for Subscription: '. $subscriptions->name. ' for customer: '. $subscriptions->customer->company_name );
                $this->order->subscription_id = $subscription['id'];
                $this->order->save();

                $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token)->changeBillingCycle($subscription, $request['billing_period']);
                $subscriptions->update(['billing_period'=> $request['billing_period']]);

                Log::info('Billing Cycle changed: '.$request['billing_period']);

                $this->order->order_status_id = 4; //Order Completed state
                $this->order->subscription_id = $subscription['id'];
                $this->order->save();

            } catch (Exception $e) {
                Log::info('Error Placing order to Microsoft: '.$e->getMessage());
                $this->order->order_status_id = 3; //Order failed state
                $this->order->subscription_id = $subscription['id'];
                $this->order->save();
                return redirect()->back()->with(['alert' => 'error', 'message' => ucwords(trans_choice('messages.something_went_wrong_try_again', 1))]);
            }
        }else {
            try{
                $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token)
                ->update($subscription, ['status' => $request['status']]);

                $subscriptions->update(['status_id' => $request['status']]);
                Log::info('Status changed: '.$update);
                $this->order->order_status_id = 4; //Order Completed state
                $this->order->subscription_id = $subscription['id'];
                $this->order->save();

            }
            catch (Exception $e) {
                Log::info('Error Placing order to Microsoft: '.$e->getMessage());
                $this->order->order_status_id = 3; //Order failed state
                $this->order->subscription_id = $subscription['id'];
                $this->order->save();
                return redirect()->back()->with(['alert' => 'error', 'message' => ucwords(trans_choice('messages.something_went_wrong_try_again', 1))]);
            }
            $this->order->order_status_id = 4; //Order Completed state
            $this->order->subscription_id = $subscription['id'];
            $this->order->save();
        }
    }
}
