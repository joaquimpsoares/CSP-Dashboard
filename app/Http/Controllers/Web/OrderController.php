<?php

namespace App\Http\Controllers\Web;


use App\Order;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use App\Jobs\PlaceOrderMicrosoft;
use App\Http\Controllers\Controller;
use App\Jobs\CreateCustomerMicrosoft;
use App\Jobs\ImportProductsMicrosoftJob;
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

    public function show() {

    }
    
    public function index()
    {
        $orders = Order::with('status', 'customer')->get()->sortByDesc('id');
        
        return view('order.index', compact('orders'));
    }
    
    public function placeOrder(Request $request)
    {
        $validate = $request->validate([
            'token' => 'required|uuid',
            ]);
            
            $order = $this->orderRepository->newFromCartToken($validate['token']);
            
            CreateCustomerMicrosoft::withChain([
                new PlaceOrderMicrosoft($order)
                ])->dispatch($order)->allOnQueue('PlaceordertoMS');
                
                return view('order.index')->with(['alert' => 'success', 'message' => trans('messages.Provider Updated successfully')]);
            }
            
            public function syncproducts(Request $request)
            {
                
                ImportProductsMicrosoftJob::dispatch($order)->onQueue('SyncProducts')
                ->delay(now()->addSeconds(10)); 
                
                // CreateCustomerMicrosoft::withChain([
                    //     new PlaceOrderMicrosoft($order)
                    //     ])->dispatch($order)->allOnQueue('PlaceordertoMS');
                    
                    return view('order')->with(['alert' => 'success', 'message' => trans('messages.Provider Updated successfully')]);
                }
                
                
            }
