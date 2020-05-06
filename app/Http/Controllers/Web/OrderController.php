<?php

namespace App\Http\Controllers\Web;

use App\Cart;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Traits\UserTrait;
use App\Instance;
use App\Order;
use App\Product;
use App\Repositories\ProductRepositoryInterface;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;
use Tagydes\MicrosoftConnection\Facades\Customer as TagydesCustomer;
use Tagydes\MicrosoftConnection\Facades\Order as TagydesOrder;
use Tagydes\MicrosoftConnection\Models\Cart as TagydesCart;
use Tagydes\MicrosoftConnection\Models\Product as TagydesProduct;

class OrderController extends Controller
{

    use UserTrait;
    private $productRepository;
    

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {

        $orders = Order::first();
        $cart = $orders;
        // $cart = json_decode($cart);
        
        $rr = unserialize($cart->cart);
        dd($cart);
        
dd($rr);
        var_dump(unserialize($cart));

        return view('order.index', compact('orders'));
    }

    // public function getCart() {
    //     if (!Session::has('cart')) {
    //         return view('store.shoppingcart');
    //     }

    //     $oldCart = Session::get('cart');
    //     $cart = new Cart($oldCart);

    //     return view('order.cart', ['products' => $cart->items]);
    // }


    public function placeOrder(Cart $cart)
    {

        $cart = Cart::with(['products'])->where('id', $cart->id)->first();

        foreach ($orderConfirm->subscriptions() as $subscription)
            {
                $subscriptions = new Subscription();
                $subscriptions->subscriptionid = $subscription->id;
                $subscriptions->orderId = $subscription->orderId;
                $subscriptions->productid = $subscription->offerId;
                $subscriptions->customerId = $subscription->customerId;
                $subscriptions->name = $subscription->name;
                $subscriptions->amount = $subscription->quantity;
                $subscriptions->currency = $subscription->currency;
                $subscriptions->billing_period = $subscription->billingCycle;
                $subscriptions->customer_id=$id;
                $subscriptions->expiration_data=Carbon::now()->addYear()->toDateTimeString();
                $subscriptions->tenant_name=$cart->domain;
                $subscriptions->save();
            }
   


        dd($cart->products()->pivot->price);

        $order = new Order;
        $order->user_id         = $this->getUser()->id;
        // $order->cart            = serialize($cart);
        $order->product_id      = $cart->product_id;
        $order->quantity        = $cart->quantity;
        $order->price           = $cart->price;
        $order->msrp            = $cart->msrp;
        $order->customer_id     = $cart->customer_id;
        
        $order->order_status_id = 1;
        $order->save();


        return redirect()->route('home')->with('success', 'Successfully purchased products!');
    }






}
