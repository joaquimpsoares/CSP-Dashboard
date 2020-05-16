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
use App\Jobs\PlaceOrderMicrosoft;
use App\Http\Controllers\Controller;
use App\Jobs\CreateCustomerMicrosoft;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;


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

        $orders = Order::with('status')->with('customer')->get();


        dd($orders->customers->company_name);
        $customers = Customer::where('id', $orders->customer_id)->get();
        // dd($customers);

        // dd($orders->status());

        return view('order.index', compact('orders', 'customers'));
    }

    public function placeOrder(Request $request)
    {
        $validate = $request->validate([
            'token' => 'required|uuid',
        ]);

        $order = $this->orderRepository->newFromCartToken($validate['token']);

        CreateCustomerMicrosoft::dispatch($order)->onQueue('CreateCustomer')
        ->delay(now()->addSeconds(10));            
        
        // dd($$rr);
        
    }






}
