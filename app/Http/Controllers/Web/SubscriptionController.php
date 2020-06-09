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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Symfony\Component\Console\Input\Input;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProviderRepositoryInterface;
use App\Repositories\ResellerRepositoryInterface;
use App\Repositories\SubscriptionRepositoryInterface;
use PhpParser\Node\Stmt\Foreach_;
use Tagydes\MicrosoftConnection\Facades\Subscription as SubscriptionFacade;
use Tagydes\MicrosoftConnection\Models\Subscription as TagydesSubscription;



class SubscriptionController extends Controller
{
    
    use UserTrait;
    private $subscriptionRepository;
    private $providerRepository;
    private $resellerRepository;
    private $customerRepository;
    
    
    public function __construct(ResellerRepositoryInterface $resellerRepository, CustomerRepositoryInterface $customerRepository,SubscriptionRepositoryInterface $subscriptionRepository, ProviderRepositoryInterface $providerRepository)
    {
        $this->resellerRepository = $resellerRepository;
        $this->customerRepository = $customerRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->providerRepository = $providerRepository;
    }
    
    
    
    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
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
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{
    //
}

/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(Request $request)
{
    //
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
    // dd($subscriptions);
    
    $products = Product::where('sku', $subscriptions->product_id)->get();
    
    
    foreach ($products as $key => $product) {
        $addons = $product->getaddons()->all();
    }
    
    // dd($products);
    foreach ($products as $key => $product) {
        // dd($product->billing);
        if ($product === 'usage'){
            return view('subscriptions.edit', compact('subscriptions', 'products'));
        }
    }
    
    
    return view('subscriptions.edit', compact('subscriptions', 'products', 'addons'));
}

/**
* Show the form for editing the specified resource.
*
* @param  \App\Subscription  $subscription
* @return \Illuminate\Http\Response
*/
public function edit(Subscription $subscriptions)
{
    $subscription = Subscription::where('id', $subscriptions)->first();
    return view('subscriptions.edit', compact('subscription'));
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
    // dd($request->all());
    
    $subscriptions = Subscription::findOrFail($subscription->id);
    $instance = Instance::first();    
    // dd($instance);
    
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
            
            
            if ($request->status == 1) {
                $request->merge(['status' => 'active']);
            }else {
                $request->merge(['status' => 'suspended']);
            }
            
            if($request->status == $subscriptions->status){
                try{
                    $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token)->
                    update($subscription, ['quantity' => $request->amount]);
                    $subscriptions->update(['amount'=> $request->amount]);
                    Log::info('License changed: '.$request->amount);
                } catch (Exception $e) {
                    Log::info('Error Placing order to Microsoft: '.$e->getMessage());
                    return redirect()->back()->with(['alert' => 'error', 'message' => ucwords(trans_choice('messages.something_went_wrong_try_again', 1))]);
                }
            }else if ($request->billing_period != $subscriptions->billing_period){
                try{
                    $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token)->changeBillingCycle($subscription, $request->billing_period);
                    $subscriptions->update(['billing_period'=> $request->billing_period]);
                    Log::info('Billing Cycle changed: '.$request->billing_period);
                    
                } catch (Exception $e) {
                    Log::info('Error Placing order to Microsoft: '.$e->getMessage());
                    return redirect()->back()->with(['alert' => 'error', 'message' => ucwords(trans_choice('messages.something_went_wrong_try_again', 1))]);
                }
            }else {
                try{
                    $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token)
                    ->update($subscription, ['status' => $request->status]);
                    
                    if ($request->status == 'active') {
                        $request->merge(['status' => 1]);
                    }else {
                        $request->merge(['status' => 2]);
                    }
                    $subscriptions->update(['status_id' => $request->status]);
                    Log::info('Status changed: '.$update);
                    
                } 
                catch (Exception $e) {
                    Log::info('Error Placing order to Microsoft: '.$e->getMessage());
                    return redirect()->back()->with(['alert' => 'error', 'message' => ucwords(trans_choice('messages.something_went_wrong_try_again', 1))]);
                }
            }
            return redirect()->back()->with(['alert' => 'success', 'message' => ucwords(trans_choice('messages.subscription_updated_successfully', 1))]);
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
