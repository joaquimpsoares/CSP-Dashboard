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
use Modules\MicrosoftCspConnection\Models\MicrosoftCspConnection;
use Modules\MicrosoftCspConnection\Services\MicrosoftCspClient;
use Modules\MicrosoftCspConnection\Services\CustomerService;
use Modules\MicrosoftCspConnection\Services\OfferService;
use Modules\MicrosoftCspConnection\Services\OrderService;

class PlaceOrderMicrosoft implements ShouldQueue
{
    private $order;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IsMonitored;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $products = $this->order->products;
        $customer = $this->order->customer;

        foreach ($products as $product) {
            $this->order->details = ('Placing Order for: ' . $product['name'] . ' for Customer: ' . $customer->company_name);
            $this->order->save();
        }

        Log::info('tenant Cart: ' . $this->order->customer->microsoftTenantInfo->first());

        $instanceId = $products->first()->instance_id;
        Log::info('Instance ID: ' . $instanceId);

        $instance = Instance::where('id', $instanceId)->first();
        Log::info('Instance: ' . $instance);

        $customerId = $this->order->customer->microsoftTenantInfo->first()->tenant_id;
        Log::info('Customer tenant ID: ' . $customerId);

        // Resolve CSP connection for this provider
        $connection    = MicrosoftCspConnection::where('provider_id', $instance->provider_id)->firstOrFail();
        $client        = new MicrosoftCspClient($connection, config('microsoftcspconnection'));
        $customerSvc   = new CustomerService($client);
        $offerService  = new OfferService($client);
        $orderService  = new OrderService($client);

        // Verify the customer exists in Partner Center
        try {
            $customerSvc->get($customerId);
            Log::info('Customer verified in Partner Center: ' . $customerId);
        } catch (Exception $e) {
            Log::error('Customer not found in Partner Center: ' . $e->getMessage());
            $this->order->errors = 'Customer not found in Partner Center: ' . $e->getMessage();
            $this->order->order_status_id = 3;
            $this->order->save();
            return;
        }

        // Build cart line items from order products
        $lineItems = [];

        try {
            foreach ($products as $product) {
                $quantity = $product->pivot->quantity;

                $pli = null;
                if (!empty($product->pivot->price_list_item_id)) {
                    $pli = \App\Models\Pricing\PriceListItem::query()->find($product->pivot->price_list_item_id);
                }

                $billingCycle = strtolower((string)($pli?->billing_cycle ?? $product->pivot->billing_cycle ?? 'none'));
                $termDuration = strtolower((string)($pli?->term_duration ?? $product->pivot->term_duration ?? 'none'));
                $mpnId = $this->order->customer->format()['mpnid'] ?? null;

                // Resolve catalog item from the *price list item mapping*, not from Product.
                $catalogItemId = $pli?->offer_id ?: ($pli?->sku_id ?: ($pli?->meter_id ?: $product['sku']));

                // Fallback for legacy logic when mapping isn't present (kept for backwards compat)
                if (empty($catalogItemId)) {
                    if ($product['is_perpetual']) {
                        Log::info('Catalog Item URL: ' . $product['uri']);
                        $catalogItemId = $offerService->getCatalogItemId($product['uri']);
                    } elseif ($product->IsNCE()) {
                        $country = $customer->country->iso_3166_2;
                        $sku     = strtok($product->sku, ':');
                        $id      = substr($product->sku, strpos($product->sku, ':') + 1);
                        $nceUri  = "products/{$sku}/skus/{$id}/availabilities?country={$country}";
                        $catalogItemId = $offerService->getCatalogItemId($nceUri);
                    } else {
                        $catalogItemId = $product['sku'];
                    }
                }

                $lineItem = [
                    'catalogItemId' => $catalogItemId,
                    'quantity'      => $quantity,
                    'billingCycle'  => $billingCycle,
                    'termDuration'  => $termDuration,
                ];

                if ($mpnId) {
                    $lineItem['partnerId'] = $mpnId;
                }

                $lineItems[] = $lineItem;
            }

        } catch (Exception $e) {
            Log::error('Error building cart line items: ' . $e->getMessage());
            $this->order->errors = 'Error building cart: ' . $e->getMessage();
            $this->order->order_status_id = 3;
            $this->order->save();
            return;
        }

        // Create and checkout the cart
        try {
            $cart = $orderService->createCart($customerId, $lineItems);
            Log::info('Cart created: ' . json_encode($cart));

            $this->order->request_body = json_encode($cart);
            $this->order->save();

            $cartId   = $cart['id'] ?? null;
            if (! $cartId) {
                throw new Exception('Partner Center did not return a cart ID.');
            }

            $checkout = $orderService->checkoutCart($customerId, $cartId);
            Log::info('Cart checked out: ' . json_encode($checkout));

        } catch (Exception $th) {
            Log::error('Error placing order via Partner Center', ['message' => $th->getMessage()]);
            $this->order->errors = 'Error placing order to Partner Center: ' . $th->getMessage();
            $this->order->order_status_id = 3;
            $this->order->save();
            return;
        }

        // Persist resulting subscriptions into the local Subscription table
        $orders = $checkout['orders'] ?? [];

        foreach ($orders as $pcOrder) {
            $pcSubscriptions = $pcOrder['lineItems'] ?? [];

            foreach ($pcSubscriptions as $lineItem) {
                $offerId  = $lineItem['offerId'] ?? '';
                $parts    = explode(':', $offerId);
                $productId = isset($parts[1]) ? ($parts[0].':'.$parts[1]) : $offerId;

                $sub = new Subscription();
                $sub->subscription_id  = $lineItem['subscriptionId']  ?? null;
                $sub->name             = $products->first()->name ?? '';
                $sub->customer_id      = $customer->id;
                $sub->product_id       = $productId;
                $sub->catalog_item_id  = $offerId;
                $sub->term             = $lineItem['termDuration']     ?? 'none';
                $sub->billing_type     = $products->first()->billing   ?? 'license';
                $sub->instance_id      = $instanceId;
                $sub->order_id         = $pcOrder['id']                ?? null;
                $sub->amount           = $lineItem['quantity']         ?? 1;
                $sub->msrpid           = $this->order->customer->format()['mpnid'] ?? null;
                $sub->expiration_data  = Carbon::now()->addYear()->toDateTimeString();
                $sub->billing_period   = strtolower($lineItem['billingCycle'] ?? 'none');
                $sub->currency         = $pcOrder['currencyCode']      ?? null;
                $sub->tenant_name      = $this->order->domain
                    ?? $this->order->customer->microsoftTenantInfo->first()->tenant_domain;
                $sub->status_id        = 1; // Active
                $sub->save();

                Log::info('Subscription created successfully: ' . $sub->id);

                $this->order->subscription_id = $sub->id;
                $this->order->ext_order_id    = $pcOrder['id'] ?? null;
                $this->order->order_status_id = 4; //Order Completed state
                $this->order->save();
            }
        }
    }
}
