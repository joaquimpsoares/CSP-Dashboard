<?php

namespace App\Http\Controllers\Web;

use App\Cart;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Traits\UserTrait;
use App\Instance;
use App\Order;
use App\Product;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;


class OrderController extends Controller
{

    use UserTrait;
    private $productRepository;
    private $orderRepository;
    

    public function __construct(ProductRepositoryInterface $productRepository, OrderRepositoryInterface $orderRepository)
    {
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {

        /*$orders = Order::first();
        $cart = $orders;
        // $cart = json_decode($cart);
        
        $rr = unserialize($cart->cart);
        dd($cart);
        
        dd($rr);
        var_dump(unserialize($cart));

        return view('order.index', compact('orders'));*/
    }

    public function placeOrder(Request $request)
    {
        
        $validate = $request->validate([
            'token' => 'required|uuid',
        ]);

        $order = $this->orderRepository->newFromCartToken($validate['token']);
        
        dd($order);
        
    }






}
