<?php

namespace App\Http\Controllers\Web;

use App\Order;
use Throwable;
use App\MicrosoftTenantInfo;
use Illuminate\Http\Request;
use App\Http\Traits\UserTrait;
use App\Jobs\PlaceOrderMicrosoft;
use App\Http\Traits\ActivityTrait;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Jobs\CreateCustomerMicrosoft;
use App\Jobs\ImportProductsMicrosoftJob;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;


class OrderController extends Controller
{

    use UserTrait;
    use ActivityTrait;
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
        return view('order.index');
    }

    public function placeOrder(Request $request)
    {
        $validate = $request->validate([
            'token' => 'required|uuid',
            ]);

            $order = $this->orderRepository->newFromCartToken($validate['token']);

            $tt = MicrosoftTenantInfo::where('tenant_domain', 'like', $order->domain.'%')->first();

            if($tt == null){
                Bus::chain([
                    new CreateCustomerMicrosoft($order),
                    new PlaceOrderMicrosoft($order)])
                    ->catch(function (Throwable $e) use($order){
                        $order->details = ('Error placing order to Microsoft: '.$e->getMessage());
                        $order->save();
                    })->onQueue('PlaceordertoMS')
                ->dispatch();
            }
            else{

                PlaceOrderMicrosoft::dispatch($order)->OnQueue('PlaceordertoMS');
                Log::info('Data to Place order: '.$order);
            }

            return view('store.index')->with(['alert' => 'success', 'message' => trans('messages.order_placed_susscessfully')]);
        }

        public function syncproducts(Request $request)
        {

            $order = $this->orderRepository->ImportProductsMicrosoftOrder();

            ImportProductsMicrosoftJob::dispatch($request, $order)->onQueue('SyncProducts')
            ->delay(now()->addSeconds(10));

            return view('order')->with(['alert' => 'success', 'message' => trans('messages.Provider Updated successfully')]);
        }


    }
