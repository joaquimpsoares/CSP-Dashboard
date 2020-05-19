<?php

namespace App\Jobs;

use App\Order;
use Exception;
use App\Customer;
use App\Instance;
use Carbon\Carbon;
use App\Subscription;
use App\MicrosoftTenantInfo;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Tagydes\MicrosoftConnection\Models\Cart as TagydesCart;
use Tagydes\MicrosoftConnection\Facades\Order as TagydesOrder;
use Tagydes\MicrosoftConnection\Models\Product as TagydesProduct;
use Tagydes\MicrosoftConnection\Models\Customer as TagydesCustomer;


class PlaceOrderMicrosoft implements ShouldQueue
{
    
    private $order;
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    /**
    * Create a new job instance.
    *
    * @return void
    */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
    
    /**
    * Execute the job.
    *
    * @return void
    */
    public function handle()
    {
        
        $order = $this->order->products;
        $customer = $this->order->customer;

        // dd($products->product);
        
        $instance = $order[0]->instance_id;
        
	    $instance = Instance::where('id',1)->first();
        // dd($instance);
        
        $tenantid = MicrosoftTenantInfo::select('tenant_id')->where('tenant_domain', $this->order->domain)->first('tenant_id')->toArray();
        $quantity=0;
        $billing_cycle = null;
        
        $existingCustomer = new TagydesCustomer([
            'id' => $tenantid['tenant_id'],
            'username' => 'name@email.com',
            'password' => 'ljhbpirtf',
            'firstName' => 'name',
            'lastName' => 'name',
            'email' => 'name@email.com',
            ]);
            
            
            $tagydescart = new TagydesCart();
            foreach ($order as $key => $product) 
            {
                $quantity = $product->pivot->quantity;
                $billing_cycle = $product->pivot->billing_cycle;

                $TagydesProduct = new TagydesProduct([
                    'id' => $product['sku'],
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'minimumQuantity' => $product['minimum_quantity'],
                    'maximumQuantity' => $product['maximum_quantity'],
                    'term' => $product['term'],
                    'limit' => $product['limit'],
                    'isTrial' => $product['is_trial'],
                    'uri' => $product['uri'],
                    'supportedBillingCycles' => ['annual','monthly'],
                    ]);
                    
                    $tagydescart->setCustomer($existingCustomer);
                    
                    $tagydescart->addProduct($TagydesProduct, $quantity, $billing_cycle);
                                        
                    $tagydesorder = TagydesOrder::withCredentials($instance->external_id, $instance->external_token)->create($tagydescart);

                    $orderConfirm = TagydesOrder::withCredentials($instance->external_id, $instance->external_token)->confirm($tagydesorder);                    
                    
                    foreach ($orderConfirm->subscriptions() as $subscription)
                    {
                        $subscriptions = new Subscription();
                        $subscriptions->name = 				$subscription->name;
                        $subscriptions->subscription_id = 	$subscription->id;
                        $subscriptions->customer_id	=		310000;
                            // $subscriptions->customer_id = 		$subscription->customerId; //customer id from request recieved from Microsoft
                        $subscriptions->product_id = 		$subscription->offerId;
                        $subscriptions->order_id = 			$subscription->orderId;
                        $subscriptions->amount = 			$subscription->quantity;
                        $subscriptions->expiration_data	=	Carbon::now()->addYear()->toDateTimeString(); //Set subscription expiration date
                        $subscriptions->billing_period = 	$subscription->billingCycle;
                        $subscriptions->currency = 			$subscription->currency;
                        $subscriptions->tenant_name	=		$customer->MicrosoftTenantInfo[0]->tenant_domain;
                        $subscriptions->status_id =         1;
                        $subscriptions->save();
                    }
                    dd($subscription);
                    
                }
            }
        }
