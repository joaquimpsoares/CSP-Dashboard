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

    public function getCart() {
        if (!Session::has('cart')) {
            return view('store.shoppingcart');
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        return view('order.cart', ['products' => $cart->items]);
    }

    public function placeOrder(Cart $cart)
    {




        $instance = Instance::first();

        $cart = Cart::with(['products'])->where('id', $cart->id)->first();

        $order = new Order;
        $order->user_id = $this->getUser()->id;
        $order->cart = serialize($cart);
        $order->customer_id = $cart->customer_id;
        $order->order_id = $cart->id;
        $order->order_status_id = 1;
        $order->save();


        return redirect()->route('home')->with('success', 'Successfully purchased products!');
    }


}
