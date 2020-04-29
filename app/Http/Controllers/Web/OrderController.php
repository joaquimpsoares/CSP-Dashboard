<?php

namespace App\Http\Controllers\Web;

use Session;
use App\Cart;
use App\Order;
use App\Product;
use App\Customer;
use App\Instance;
use Carbon\Carbon;
use App\Subscription;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepositoryInterface;
use Tagydes\MicrosoftConnection\Models\Cart as TagydesCart;
use Tagydes\MicrosoftConnection\Facades\Order as TagydesOrder;
use Tagydes\MicrosoftConnection\Models\Product as TagydesProduct;
use Tagydes\MicrosoftConnection\Facades\Customer as TagydesCustomer;

class OrderController extends Controller
{

    use UserTrait;
    private $productRepository;
    

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function addProductToCart(Request $request)
    {

        $product = Product::find($request->product_id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $request->qty);
                // ($cart->items[$product->id]['qty']);

        $request->session()->put('cart', $cart);

        return redirect()->route('order.shoppingcart');
    }

    public function getCart() {
        if (!Session::has('cart')) {
            return view('store.shoppingcart');
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        return view('order.cart', ['products' => $cart->items]);
    }

    public function changeProductQuantity(Request $request, Product $product, $quantity) {

        if ($this->productRepository->verifyQuantities($product, $quantity)) {
            $oldCart = \Session::get('cart');
            $cart = new Cart($oldCart);
            $cart->items[$product->id]['quantity'] = $quantity;
            $request->session()->put('cart', $cart);

            return true;
        }

        return false;

    }


    public function placeOrder(Request $request)
    {
        if (!Session::has('cart')) {
            return redirect()->route('store.index');
        }

        $user = $this->getUser();

        $instance = Instance::first();
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        $products = [];
        
        // dd($cart);

        
        //try {

            $tagydescart = new TagydesCart();

            $searchCustomer = Customer::where('id', $cart->customer['id'])->with('country')->first();

            $customer = TagydesCustomer::withCredentials($instance->external_id, $instance->external_token)->create([
                'company' => $searchCustomer->company_name,
                'domain' => $cart->domain,
                'culture' => 'EN-US',
                'email' => $cart->mcaUser['email'],
                'language' => 'en',
                'firstName' => $cart->mcaUser['firstName'],
                'lastName' => $cart->mcaUser['lastName'],
                'address' => $searchCustomer->address_1,
                'city' => $searchCustomer->city,
                'province' => $searchCustomer->state,
                'postalCode' => $searchCustomer->postal_code,
                'country' => 'ma' //$searchCustomer->country->iso_3166_2,
            ]);

            $tagydescart->setCustomer($customer);

            foreach ($cart->items as $key => $product) {
                $TagydesProduct = new TagydesProduct([
                    'id' => $product['item']['sku'],
                    'name' => $product['item']['name'],
                    'description' => $product['item']['description'],
                    'minimumQuantity' => $product['item']['minimum_quantity'],
                    'maximumQuantity' => $product['item']['maximum_quantity'],
                    'term' => $product['item']['term'],
                    'limit' => $product['item']['limit'],
                    'isTrial' => $product['item']['is_trial'],
                    'uri' => $product['item']['uri'],
                    'supportedBillingCycles' => ['anual','monthly'],
                ]);

                $tagydescart->addProduct($TagydesProduct, $product['quantity'], "monthly");
            }

            // dd($tagydescart);

            $tagydesorder = TagydesOrder::withCredentials($instance->external_id, $instance->external_token)->create($tagydescart);

            $orderConfirm = TagydesOrder::withCredentials($instance->external_id, $instance->external_token)->confirm($tagydesorder);

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

            $order1 = new Order();
            $order1->cart = serialize($cart);
            $order1->company_id = $cart->customer['id'];
            $order1->order_id = $orderConfirm->subscriptions()->first()->id;
            $user->orders()->save($order1);


        /*} catch (\Exception $e) {
            // return redirect()->route('checkout')->with('error', $e->getMessage());
        }*/
        
        // Session::forget('cart');

        dd($cart);

        return redirect()->route('dashboard')->with('success', 'Successfully purchased products!');
    }


}
