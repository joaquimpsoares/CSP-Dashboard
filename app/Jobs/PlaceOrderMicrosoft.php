<?php

namespace App\Jobs;

use App\Cart;
use App\Instance;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Session;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Tagydes\MicrosoftConnection\Models\Cart as TagydesCart;
use Tagydes\MicrosoftConnection\Facades\Order as TagydesOrder;
use Tagydes\MicrosoftConnection\Models\Product as TagydesProduct;
use Tagydes\MicrosoftConnection\Facades\Customer as TagydesCustomer;

class PlaceOrderMicrosoft implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $user = $this->getUser();

        // $instance = Instance::first();
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        dd($cart);

        // $products = [];
        
        // dd($cart);

        
        //try {

        //     $tagydescart = new TagydesCart();


        //     foreach ($cart->items as $key => $product) {
        //         $TagydesProduct = new TagydesProduct([
        //             'id' => $product['item']['sku'],
        //             'name' => $product['item']['name'],
        //             'description' => $product['item']['description'],
        //             'minimumQuantity' => $product['item']['minimum_quantity'],
        //             'maximumQuantity' => $product['item']['maximum_quantity'],
        //             'term' => $product['item']['term'],
        //             'limit' => $product['item']['limit'],
        //             'isTrial' => $product['item']['is_trial'],
        //             'uri' => $product['item']['uri'],
        //             'supportedBillingCycles' => ['anual','monthly'],
        //         ]);

        //         $tagydescart->addProduct($TagydesProduct, $product['quantity'], "monthly");
        //     }

        //     dd($tagydescart);

        //     $tagydesorder = TagydesOrder::withCredentials($instance->external_id, $instance->external_token)->create($tagydescart);

        //     $orderConfirm = TagydesOrder::withCredentials($instance->external_id, $instance->external_token)->confirm($tagydesorder);

        //     foreach ($orderConfirm->subscriptions() as $subscription)
        //     {
        //         $subscriptions = new Subscription();
        //         $subscriptions->subscriptionid = $subscription->id;
        //         $subscriptions->orderId = $subscription->orderId;
        //         $subscriptions->productid = $subscription->offerId;
        //         $subscriptions->customerId = $subscription->customerId;
        //         $subscriptions->name = $subscription->name;
        //         $subscriptions->amount = $subscription->quantity;
        //         $subscriptions->currency = $subscription->currency;
        //         $subscriptions->billing_period = $subscription->billingCycle;
        //         $subscriptions->customer_id=$id;
        //         $subscriptions->expiration_data=Carbon::now()->addYear()->toDateTimeString();
        //         $subscriptions->tenant_name=$cart->domain;
        //         $subscriptions->save();
        //     }
            
        //     $order1 = new Order();
        //     $order1->cart = serialize($cart);
        //     $order1->company_id = $cart->customer['id'];
        //     $order1->order_id = $orderConfirm->subscriptions()->first()->id;
        //     $user->orders()->save($order1);


        // /*} catch (\Exception $e) {
        //     // return redirect()->route('checkout')->with('error', $e->getMessage());
        // }*/
        
        // // Session::forget('cart');

        // dd($cart);

        return redirect()->route('dashboard')->with('success', 'Successfully purchased products!');
    }
}
