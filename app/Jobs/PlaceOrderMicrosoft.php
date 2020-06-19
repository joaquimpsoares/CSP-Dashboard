<?php

namespace App\Jobs;

use App\Order;
use Exception;
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
        
        $products = $this->order->products;
        $customer = $this->order->customer;
        
        $instanceid = $products->first()->instance_id;
        
        $instance = Instance::where('id',$instanceid)->first();

        $quantity=0;
        $billing_cycle = null;
        
        $existingCustomer = new TagydesCustomer([
            'id' =>$this->order->ext_company_id,
            'username' => 'name@email.com',
            'password' => 'ljhbpirtf',
            'firstName' => 'name',
            'lastName' => 'name',
            'email' => 'name@email.com',
            ]);
            
            try {
                $tagydescart = new TagydesCart();
                foreach ($products as $product) 
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
                        Log::info('Setting Customer to Cart: '.$tagydescart);
                        
                        $tagydescart->addProduct($TagydesProduct, $quantity, $billing_cycle);
                        Log::info('Adding Product to Cart: '.$tagydescart);
                        
                        $tagydesorder = TagydesOrder::withCredentials($instance->external_id, $instance->external_token)->create($tagydescart);
                        Log::info('Creating Cart: '.$tagydesorder);
                        
                        $orderConfirm = TagydesOrder::withCredentials($instance->external_id, $instance->external_token)->confirm($tagydesorder);
                        Log::info('Confirmation of cart Cart: '.$orderConfirm);
                        
                        
                        foreach ($orderConfirm->subscriptions() as $subscription)
                        {
                            $subscriptions = new Subscription();
                            $subscriptions->name = 				$subscription->name;
                            $subscriptions->subscription_id = 	$subscription->id;
                            $subscriptions->customer_id = 		$customer->id; //customer id from request recieved from Microsoft
                            $subscriptions->product_id = 		$subscription->offerId;
                            $subscriptions->instance_id =		$instanceid;
                            $subscriptions->billing_type =      $product->billing;
                            $subscriptions->order_id = 			$subscription->orderId;
                            $subscriptions->amount = 			$subscription->quantity;
                            $subscriptions->expiration_data	=	Carbon::now()->addYear()->toDateTimeString(); //Set subscription expiration date
                            $subscriptions->billing_period = 	$subscription->billingCycle;
                            $subscriptions->currency = 			$subscription->currency;
                            $subscriptions->tenant_name	=		$this->order->domain;
                            $subscriptions->status_id =         1;
                            $subscriptions->save();
                        }
                    }
                    
                    $this->order->ext_order_id = $subscription->orderId;
                    $this->order->order_status_id = 4; //Order Completed state
                    $this->order->save();
                    
                    Log::info('Subscription created Successfully: '.$subscription);
                    
                } catch (Exception $e) {
                    Log::info('Error Placing order to Microsoft: '.$e->getMessage());

                    $this->order->order_status_id = 3; 
                    $this->order->save();
                }
            }
        }
