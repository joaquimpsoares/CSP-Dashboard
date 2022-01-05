<?php

namespace App\Jobs;

use App\Order;
use Exception;
use App\Instance;
use Carbon\Carbon;
use App\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use romanzipp\QueueMonitor\Traits\IsMonitored;
use Tagydes\MicrosoftConnection\Models\Cart as TagydesCart;
use Tagydes\MicrosoftConnection\Facades\Order as TagydesOrder;
use Tagydes\MicrosoftConnection\Models\Product as TagydesProduct;
use Tagydes\MicrosoftConnection\Facades\Product as MicrosoftProduct;
use Tagydes\MicrosoftConnection\Models\Customer as TagydesCustomer;


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

        foreach ($products as $product) {
            $this->order->details = ('Stage 2 - Placing Order for: ' . $product['name'] . ' for Customer: ' . $customer->company_name);
            $this->order->save();
        }
        Log::info('tenant Cart: ' . $this->order->customer->microsoftTenantInfo->first());

        $instanceid = $products->first()->instance_id;
        Log::info('Creating Cart: ' . $instanceid);

        $instance = Instance::where('id', $instanceid)->first();
        Log::info('Creating Cart: ' . $instance);

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
                $billing_cycle = $product->pivot->billing_cycle;
                Log::info('Billing cycle!: ' . $billing_cycle);

                $tagydescart->setCustomer($existingCustomer);
                Log::info('Setting Customer to Cart: ' . $tagydescart);

                $productData = [
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'minimumQuantity' => $product['minimum_quantity'],
                    'maximumQuantity' => $product['maximum_quantity'],
                    'term' => $product['term'],
                    'limit' => $product['limit'] ?? 0,
                    'PartnerIdOnRecord' => $this->order->customer->format()['mpnid']  ?? null,
                    'isTrial' => $product['is_trial'],
                    'uri' => $product['uri'],
                    'supportedBillingCycles' => ['annual', 'monthly', 'one_time', 'none'],
                ];

                if ($product['is_perpetual']) {
                    Log::info('Catalog Item URL: ' . $product['uri']);
                    $catalogItemId = MicrosoftProduct::withCredentials($instance->external_id, $instance->external_token)->getPerpetualCatalogItemId($product['uri']);
                    Log::info('Catalog Item ID: ' . $catalogItemId);

                    $TagydesProduct = new TagydesProduct([
                        'id' => $catalogItemId
                    ] + $productData);

                    $tagydescart->addProduct($TagydesProduct, $quantity, $billing_cycle);
                    Log::info('Adding Perpetual Product to Cart: ' . $tagydescart);
                }
                elseif($product->IsNCE()){
                    $catalogItemId = MicrosoftProduct::withCredentials($instance->external_id, $instance->external_token)->getNCECatalogItemId($product['uri']);
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
                $orderConfirm = TagydesOrder::withCredentials($instance->external_id, $instance->external_token)->confirm($tagydesorder);
                Log::info('Confirmation of cart Cart: ', $orderConfirm->subscriptions()->toArray());
            } catch (\Throwable $th) {
                throw $th;
            }

            if ($orderConfirm->errors()->count() > 0) {
                foreach ($orderConfirm->errors() as $error) {
                    logger('Error found: ' . $error);
                }
            }

            logger("Tenemos {$orderConfirm->subscriptions()->count()} subscripciones");
            foreach ($orderConfirm->subscriptions() as $subscription) {

                $subscriptions = new Subscription();
                $subscriptions->name = $subscription->name;
                $subscriptions->subscription_id = $subscription->id;
                $subscriptions->customer_id = $customer->id; //Local customer id
                $subscriptions->product_id = $subscription->offerId;
                $subscriptions->instance_id = $instanceid;
                $subscriptions->billing_type = $product->billing ?? 'license';
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
            }
        } catch (Exception $e) {
            Log::info('Error Placing order to Microsoft: ' . $e->getMessage());

            $this->order->details = ('Error Placing order to Microsoft: ' . $e->getMessage());
            $this->order->order_status_id = 3;
            $this->order->save();
        }
    }
}
