<?php

namespace App\Jobs;

use App\Order;
use Exception;
use App\Instance;
use Carbon\Carbon;
use App\Subscription;
use Illuminate\Bus\Queueable;
use App\Notifications\OrderStatus;
use App\Services\CheckoutServices;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use romanzipp\QueueMonitor\Traits\IsMonitored;
use Tagydes\MicrosoftConnection\Models\Cart as TagydesCart;
use Tagydes\MicrosoftConnection\Facades\Order as TagydesOrder;
use Tagydes\MicrosoftConnection\Models\Product as TagydesProduct;
use Tagydes\MicrosoftConnection\Models\Customer as TagydesCustomer;
use Tagydes\MicrosoftConnection\Facades\Product as MicrosoftProduct;


class PlaceOrderMicrosoft implements ShouldQueue
{

    private $order;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IsMonitored;

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
        foreach ($products as $key => $value) {
            dd($value->name);
        }

        foreach ($products as $product) {
            $this->order->details = ('Placing Order for: ' . $product['name'] . ' for Customer: ' . $customer->company_name);
            $this->order->save();
        }

        Log::info('tenant Cart: ' . $this->order->customer->microsoftTenantInfo->first());

        $instanceid = $products->first()->instance_id;
        Log::info('Instance ID: ' . $instanceid);

        $instance = Instance::where('id', $instanceid)->first();
        Log::info('Instance: ' . $instance);

        $quantity = 0;
        $billing_cycle = null;

        Log::info('ext_company_id: ' . $this->order->customer->microsoftTenantInfo->first()->tenant_id);

        $existingCustomer = new TagydesCustomer([
            'id' => $this->order->customer->microsoftTenantInfo->first()->tenant_id,
            'username' => 'name@email.com',
            'password' => 'ljhbpirtf',
            'firstName' => 'name',
            'lastName' => 'name',
            'PartnerIdOnRecord' => $this->order->customer->format()['mpnid'] ?? null,
            'email' => 'name@email.com',
        ]);

        Log::info('Adding existing Customer: ' . $this->order->customer->microsoftTenantInfo->first()->tenant_id);
        Log::info('Adding existing Customer: ' . $existingCustomer);

        try {
            $tagydescart = new TagydesCart();
            logger("Tenemos {$products->count()} productos", $products->toArray());

            foreach ($products as $product) {
                $quantity = $product->pivot->quantity;
                $billing_cycle = strtolower($product->pivot->billing_cycle);
                $term_duration = strtolower($product->pivot->term_duration);
                Log::info('Billing cycle!: ' . $billing_cycle);
                Log::info('Term Duration!: ' . $term_duration);

                $tagydescart->setCustomer($existingCustomer);
                Log::info('Setting Customer to Cart: ' . $tagydescart);

                $productData = [
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'minimumQuantity' => $product['minimum_quantity'],
                    'maximumQuantity' => $product['maximum_quantity'],
                    'term' => $term_duration,
                    'limit' => $product['limit'] ?? 0,
                    'PartnerIdOnRecord' => $this->order->customer->format()['mpnid']  ?? null,
                    'isTrial' => $product['is_trial'],
                    'uri' => $product['uri'],
                    'supportedBillingCycles' => ['annual', 'monthly', 'one_time', 'none'],
                ];

                if ($product['is_perpetual']) {
                    Log::info('Catalog Item URL: ' . $product['uri']);
                    $catalogItemId = MicrosoftProduct::withCredentials($instance->external_id, $instance->external_token)->getPerpetualCatalogItemId($product['uri']);

                    $TagydesProduct = new TagydesProduct([
                        'id' => $catalogItemId
                    ] + $productData);

                    $tagydescart->addProduct($TagydesProduct, $quantity, $billing_cycle);
                    Log::info('Adding Perpetual Product to Cart: ' . $tagydescart);
                }

                elseif($product->IsNCE()){

                    $country = $customer->country->iso_3166_2;
                    $sku = strtok($product->sku, ':');
                    $id = substr($product->sku, strpos($product->sku, ":") + 1);

                    $catalogItemId = MicrosoftProduct::withCredentials($instance->external_id, $instance->external_token)->getPerpetualCatalogItemIdNCE($country,$sku,$id);
                    Log::info('catalogItemId1: ' . $catalogItemId);
                    $TagydesProduct = new TagydesProduct([
                        'id' => $catalogItemId
                        ] + $productData);

                    $tagydescart->addProduct($TagydesProduct, $quantity, $billing_cycle);

                    Log::info('Adding NCE Product to Cart: ' . $tagydescart);
                }else{
                    $TagydesProduct = new TagydesProduct([
                        'id' => $product['sku'],
                    ] + $productData);
                    $tagydescart->addProduct($TagydesProduct, $quantity, $billing_cycle);
                    Log::info('Adding Product to Cart: ' . $tagydescart);
                }
            }
            try {

                $tagydesorder = TagydesOrder::withCredentials($instance->external_id, $instance->external_token)->create($tagydescart);
                Log::info('Creating Cart: ' . $tagydesorder);


                $this->order->request_body = $tagydesorder->requestBody;
                $this->order->save();

                if ($tagydesorder->errors) {
                    $this->order->errors = $tagydesorder->errors();
                    foreach ($tagydesorder->errors() as $error) {
                        $this->order->errors = ('Error Placing order to Microsoft, Error Code: ' . $error['error_code'] . ' Description: ' . $error['description']);
                        $this->order->order_status_id = 3;
                        $this->order->save();
                        logger('Error found: ' . $error);
                    }
                }

                $orderConfirm = TagydesOrder::withCredentials($instance->external_id, $instance->external_token)->confirm($tagydesorder);

                // $this->order->errors = $orderConfirm->errors();

                if ($orderConfirm->errors) {
                    $this->order->errors = $orderConfirm->errors();
                    foreach ($orderConfirm->errors() as $error) {
                        $this->order->errors = ('Error Placing order to Microsoft, Error Code: ' . $error['error_code'] . ' Description: ' . $error['description']);
                        $this->order->order_status_id = 3;
                        $this->order->save();
                        logger('Error found: ' . $error);
                    }
                }

            } catch (Exception $th){
                $this->order->errors = ('Error Placing order to Microsoft, Error Code: ' . $error['error_code'] . ' Description: ' . $error['description']);
                $this->order->order_status_id = 3;
                $this->order->save();
                logger('Error found: ' . $error);
                Log::info('Error Cart 1', ['message' => $th->getMessage()]);
            }

            foreach ($orderConfirm->subscriptions() as $subscription) {
                logger('this is the subscription '.$subscription);

                // if($product->IsNCE()){
                $product_id = explode(':', $subscription->offerId);
                $product_id = $product_id[0].':'.$product_id[1];
                // }

                $subscriptions = new Subscription();
                $subscriptions->subscription_id = $subscription->id;
                $subscriptions->name = $subscription->name;
                $subscriptions->customer_id = $customer->id; //Local customer id
                $subscriptions->product_id = $product_id;
                $subscriptions->catalog_item_id = $subscription->offerId ?? [];
                $subscriptions->term = $subscription->termDuration ?? 'none';
                $subscriptions->billing_type = $product->billing ?? 'license';
                $subscriptions->instance_id = $instanceid;
                $subscriptions->order_id = $subscription->orderId;
                $subscriptions->amount = $subscription->quantity;
                $subscriptions->msrpid = $this->order->customer->format()['mpnid'];
                $subscriptions->expiration_data = Carbon::now()->addYear()->toDateTimeString(); //Set subscription expiration date
                $subscriptions->billing_period = $subscription->billingCycle;
                $subscriptions->currency = $subscription->currency;
                $subscriptions->tenant_name = $this->order->domain ?? $this->order->customer->microsoftTenantInfo->first()->tenant_domain;
                $subscriptions->status_id = 1;
                $subscriptions->save();

                Log::info('Subscription created Successfully: before writing to order table' . $subscription);

                $this->order->subscription_id   = $subscriptions->id;
                $this->order->ext_order_id      = $subscription->orderId;
                $this->order->order_status_id   = 4; //Order Completed state
                $this->order->save();

                Log::info('Subscription created Successfully: ' . $subscription);
                // Notification::send($subscription->customer->users->first(), new OrderStatus($this->order, 'success'));

            }
        } catch (Exception $th) {
            if($th->getMessage() == 'Array to string conversion'){
                $this->order->errors = ('Error Placing order to Microsoft, Error Code: ' . $error['error_code'] . ' Description: ' . $error['description']);
            }else{
                $this->order->errors = ('Error Placing order to Microsoft to checkout: ' . $th->getMessage() );
            }
                $this->order->order_status_id = 3;
                $this->order->save();
            logger('Error Cart.', ['message' => $th->getMessage()]);
        }
    }
}
