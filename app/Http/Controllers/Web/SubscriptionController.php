<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Instance;
use App\Subscription;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProviderRepositoryInterface;
use App\Repositories\ResellerRepositoryInterface;
use App\Repositories\SubscriptionRepositoryInterface;
use Tagydes\MicrosoftConnection\Facades\Subscription as SubscriptionFacade;
use Tagydes\MicrosoftConnection\Models\Subscription as TagydesSubscription;



class SubscriptionController extends Controller
{

    use UserTrait;
    private $subscriptionRepository;
    private $providerRepository;
    private $resellerRepository;
    private $customerRepository;
    private $orderRepository;



    public function __construct(ResellerRepositoryInterface $resellerRepository, OrderRepositoryInterface $orderRepository, CustomerRepositoryInterface $customerRepository,SubscriptionRepositoryInterface $subscriptionRepository, ProviderRepositoryInterface $providerRepository)
    {
        $this->resellerRepository = $resellerRepository;
        $this->customerRepository = $customerRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->providerRepository = $providerRepository;
        $this->orderRepository = $orderRepository;
    }




    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        if ($this->getUserLevel() === 'Customer'){
            return view('subscriptions.customer');
        }
        return view('subscriptions.index');
    }


    /**
    * Display the specified resource.
    *
    * @param  \App\Models\Subscription  $subscription
    * @return \Illuminate\Http\Response
    */
    public function show(Subscription $subscription)
    {

        return view('subscriptions.show', compact('subscription'));

    }


    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Subscription  $subscription
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Subscription $subscription)
    {
        $amount         = collect($request->amount)->diff(collect($subscription->amount));
        $billing_period = collect($request->billing_period)->diff(collect($subscription->billing_period));
        $status         = collect($request->status)->diff(collect($subscription->status_id));


        $order = $this->orderRepository->UpdateMSSubscription($subscription,$request);

        $subscriptions = Subscription::findOrFail($subscription->id);
        $instance = Instance::where('id', $subscription->instance_id)->first();

        Log::info('Subscription: '.$subscriptions);
        Log::info('Instance: '.$instance);


        $this->validate($request, [
            'amount' => 'required|integer',
            ]);


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

        Log::info('MS subscriptions: '.$subscription);

        if($status->isempty() &&  $billing_period->isempty() && !$amount->isempty()){ //change only amount
            try{
                if($request->scheduled === 'true'){
                    $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token)->updateOnRenew($subscription, ['quantity' => $request->amount]);
                    $subscriptions->update(['changes_on_renew' => ['amount'=> $request->amount]]);
                } else {
                    $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token)->update($subscription, ['quantity' => $request->amount]);
                    $subscriptions->update(['changes_on_renew' => null, 'amount'=> $request->amount]);
                }
                Log::info('License changed: '.$update);
                Log::info('License changed: '.$request->amount);
                // $order->update(['order_status_id'=> 4]);
            } catch (Exception $e) {
                Log::info('Error Placing order to Microsoft: '.$e->getMessage());
                $order->update(['order_status_id'=> 3]);
                return Redirect::back()->with('danger','Error Placing order to Microsoft: '.$e->getMessage());
            }
        }elseif ($status->isempty() &&  !$billing_period->isempty() && $amount->isempty()){ //Change billing period
            try{
                if($request->scheduled === 'true'){
                    $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token)->changeBillingCycleOnRenew($subscription, $request->billing_period);
                    $subscriptions->update(['changes_on_renew' => ['billing_period'=> $request->billing_period]]);
                } else {
                    $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token)->changeBillingCycle($subscription, $request->billing_period);
                    $subscriptions->update(['changes_on_renew' => null, 'billing_period'=> $request->billing_period]);
                }
                Log::info('Billing Cycle changed: '.$request->billing_period);
                // $order->update(['order_status_id'=> 4]);

            } catch (Exception $e) {
                Log::info('Error Placing order to Microsoft: '.$e->getMessage());
                $order->update(['order_status_id'=> 3]);
                return Redirect::back()->with('danger','Error Placing order to Microsoft: '.$e->getMessage());
            }
        }elseif ($status->isempty() &&  !$billing_period->isempty() && !$amount->isempty()){ //Change billing period AND AMOUNT
            try{
                if($request->scheduled === 'true'){
                    $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token)->changeBillingCycleAndQuantityOnRenew($subscription, $request->billing_period);
                    $subscriptions->update([
                        'changes_on_renew' => [
                            'billing_period'=> $request->billing_period,
                            'amount'=> $request->amount
                        ]
                    ]);
                } else {
                    $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token)->changeBillingCycle($subscription, $request->billing_period);
                    $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token)->update($subscription, ['quantity' => $request->amount]);
                    $subscriptions->update([
                        'changes_on_renew' => null,
                        'billing_period'=> $request->billing_period,
                        'amount'=> $request->amount
                    ]);
                }

                $order->update(['order_status_id'=> 4]);
                Log::info('Billing Cycle changed To: '.$request->billing_period. "and amount changed to ". $request->amount);

                } catch (Exception $e) {
                    $order->update(['order_status_id'=> 3]);
                    Log::info('Error Placing order to Microsoft: '.$e->getMessage());
                    return Redirect::back()->with('danger','Error Placing order to Microsoft: '.$e->getMessage());
                }
        }elseif(!$status->isempty()){
            try{
                if($subscription->billingCycle == "one_time"){
                    if($request->scheduled === 'true'){
                        $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token) //change status only
                        ->cancelSoftwareOnRenew($subscription);
                        if ($request->status == 'active') {
                            $request->merge(['status' => 1]);
                        }else {
                            $request->merge(['status' => 3]);
                        }
                        $subscriptions->update(['changes_on_renew' => ['status_id' => $request->status]]);
                    } else {
                        $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token) //change status only
                        ->cancelSoftware($subscription);
                        if ($request->status == 'active') {
                            $request->merge(['status' => 1]);
                        }else {
                            $request->merge(['status' => 3]);
                        }
                        $subscriptions->update(['changes_on_renew' => null, 'status_id' => $request->status]);
                    }
                }else{
                    if($request->scheduled === 'true'){
                        $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token) //change status only
                        ->updateOnRenew($subscription, ['status' => $request->status]);
                        if ($request->status == 'active') {
                            $request->merge(['status' => 1]);
                        }else {
                            $request->merge(['status' => 2]);
                        }
                        $subscriptions->update(['changes_on_renew' => [
                            'status_id' => $request->status
                        ]]);
                    } else {
                        $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token) //change status only
                        ->update($subscription, ['status' => $request->status]);
                        if ($request->status == 'active') {
                            $request->merge(['status' => 1]);
                        }else {
                            $request->merge(['status' => 2]);
                        }
                        $subscriptions->update(['changes_on_renew' => null, 'status_id' => $request->status]);
                    }
                }

                Log::info('Status changed: '.$request->status);

            } catch (Exception $e) {
                $order->update(['order_status_id'=> 3]);
                Log::info('Error Placing order to Microsoft: '.$e->getMessage());
                return Redirect::back()->with('danger','Error Placing order to Microsoft: '.$e->getMessage());
            }
        }else{
            return Redirect::back()->with('danger','nothing to do');
        }

        $order->update(['order_status_id'=> 4]);
        $order->update(['subscription_id'=> $subscriptions->id]);
        return redirect()->back()->with('success', 'Subscription updated succesfully');

    }


    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Subscription  $subscription
    * @return \Illuminate\Http\Response
    */
    public function destroy(Subscription $subscription)
    {
        //
    }


}
