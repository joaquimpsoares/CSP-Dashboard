<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Product;
use App\Customer;
use App\Instance;
use App\Provider;
use App\Reseller;
use App\Subscription;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Jobs\updateSubscriptionMicrosoftJob;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProviderRepositoryInterface;
use App\Repositories\ResellerRepositoryInterface;
use App\Repositories\SubscriptionRepositoryInterface;
use Tagydes\MicrosoftConnection\Facades\ServiceCosts;
use Tagydes\MicrosoftConnection\Models\Customer as TagydesCustomer;
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
        // dd($request->all());

        $subscriptions = [];
        // $subscriptions = $this->subscriptionRepository->all();
        $subscriptions = $this->subscriptionRepository->paginate($perPage = 10, $request->search, $request->customer);

        switch ($this->getUserLevel()) {

            case 'Provider':
                $provider = $this->getUser()->provider;
                // $subscriptions = $this->listFromProvider($provider);
                // dd($subscriptions);
            $subscriptions = $this->subscriptionRepository->paginateProvider($perPage = 10, $request->search, $request->customer, $provider);


            break;
            case 'Reseller':
                $reseller = $this->getUser()->reseller;
                $subscriptions = $this->listFromReseller($reseller)->paginate('10');
            break;
            case 'Customer':
                $customer = $this->getUser()->customer;
                $subscriptions = $this->listFromCustomer($customer)->paginate('10');
            break;

            default:
            # code...
        break;
    }


    return view('subscriptions.index', compact('subscriptions'));
}

public function card()
{
    $subscriptions = [];
    switch ($this->getUserLevel()) {
        case 'Provider':
            $provider = $this->getUser()->provider;
            $subscriptions = $this->listFromProvider($provider);
        break;
        case 'Reseller':
            $reseller = $this->getUser()->reseller;
            $subscriptions = $this->listFromReseller($reseller);
        break;
        case 'Customer':
            $customer = $this->getUser()->customer;
            $subscriptions = $this->listFromCustomer($customer);
        break;

        default:
        # code...
    break;
}

return view('subscriptions.customer', compact('subscriptions'));
}



/**
* Display the specified resource.
*
* @param  \App\Subscription  $subscription
* @return \Illuminate\Http\Response
*/
public function show(Subscription $subscription)
{
    $subscriptions = Subscription::findOrFail($subscription->id);

    $usage = Product::where('sku', $subscriptions->product_id)->first();

    $products = Product::where('sku', $subscriptions->product_id)->where('instance_id', $subscriptions->instance_id)->get();

    switch ($usage->billing) {
        case 'usage':
            $subscriptions = Subscription::findOrFail($subscription->id);
            return view('subscriptions.editazure', compact('subscriptions', 'products'));
        break;
        case 'license':
            foreach ($products as $key => $product) {
                $addons = $product->getaddons()->all();
            }
            return view('subscriptions.edit', compact('subscriptions', 'products', 'addons'));
        break;

        default:
        # code...
    break;
}


}


/**
* Update the specified resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @param  \App\Subscription  $subscription
* @return \Illuminate\Http\Response
*/
public function update(Request $request, Subscription $subscription)
{
    $amount = collect($request->amount)->diff(collect($subscription->amount));
    $billing_period = collect($request->billing_period)->diff(collect($subscription->billing_period));
    $status = collect($request->status)->diff(collect($subscription->status_id));

    $order = $this->orderRepository->UpdateMSSubscription($subscription,$request);

    // PlaceOrderMicrosoft::dispatch($order)->allOnQueue('PlaceordertoMS');
    // Log::info('Data to Place order: '.$order);

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
                    $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token)->
                    update($subscription, ['quantity' => $request->amount]);
                    $subscriptions->update(['amount'=> $request->amount]);
                    Log::info('License changed: '.$update);
                    Log::info('License changed: '.$request->amount);
                } catch (Exception $e) {
                    Log::info('Error Placing order to Microsoft: '.$e->getMessage());
                    return Redirect::back()->with('danger','Error Placing order to Microsoft: '.$e->getMessage());
                }
            }elseif ($status->isempty() &&  !$billing_period->isempty() && $amount->isempty()){ //Change billing period
                try{
                    $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token)->changeBillingCycle($subscription, $request->billing_period);
                    $subscriptions->update(['billing_period'=> $request->billing_period]);
                    Log::info('Billing Cycle changed: '.$request->billing_period);

                } catch (Exception $e) {
                    Log::info('Error Placing order to Microsoft: '.$e->getMessage());
                    return Redirect::back()->with('danger','Error Placing order to Microsoft: '.$e->getMessage());
                }
            }elseif ($status->isempty() &&  !$billing_period->isempty() && !$amount->isempty()){ //Change billing period AND AMOUNT
                try{
                    $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token)->changeBillingCycle($subscription, $request->billing_period);
                    $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token)->update($subscription, ['quantity' => $request->amount]);
                    $subscriptions->update([
                        'billing_period'=> $request->billing_period,
                        'amount'=> $request->amount
                        ]);
                        Log::info('Billing Cycle changed To: '.$request->billing_period. "and amount changed to ". $request->amount);

                    } catch (Exception $e) {
                        return Redirect::back()->with('danger','Error Placing order to Microsoft: '.$e->getMessage());
                        Log::info('Error Placing order to Microsoft: '.$e->getMessage());
                    }
                }elseif(!$status->isempty()){
                    try{

                        $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token) //change status only
                        ->update($subscription, ['status' => $request->status]);

                        if ($request->status == 'active') {
                            $request->merge(['status' => 1]);
                        }else {
                            $request->merge(['status' => 2]);
                        }
                        $tt = $subscriptions->update(['status_id' => $request->status]);
                        Log::info('Status changed: '.$request->status);

                    } catch (Exception $e) {
                        return Redirect::back()->with('danger','Error Placing order to Microsoft: '.$e->getMessage());
                        Log::info('Error Placing order to Microsoft: '.$e->getMessage());
                    }
                }else{

                    return Redirect::back()->with('danger','nothing to do');
                }


                return redirect()->back()->with('success', 'Subscription updated succesfully');

            }




            /**
            * Remove the specified resource from storage.
            *
            * @param  \App\Subscription  $subscription
            * @return \Illuminate\Http\Response
            */
            public function destroy(Subscription $subscription)
            {
                //
            }

            public function listFromProvider(Provider $provider)
            {
                $subscriptions = $this->providerRepository->getSubscriptions($provider);

                return $subscriptions;
            }

            public function listFromReseller(Reseller $reseller)
            {
                $subscriptions = $this->resellerRepository->getSubscriptions($reseller);

                return $subscriptions;
            }

            public function listFromCustomer(Customer $customer)
            {
                $subscriptions = $this->customerRepository->getSubscriptions($customer);

                return $subscriptions;
            }
        }
