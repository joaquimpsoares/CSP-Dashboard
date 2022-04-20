<?php

namespace App\Http\Controllers\Web;

use App\Customer;
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
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OrderPendingToConfirm;

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

        $order->sendToMicrosoft();

        return view('store.index')->with(['alert' => 'success', 'message' => trans('messages.order_placed_susscessfully')]);
    }

    public function syncproducts(Request $request)
    {
        $order = $this->orderRepository->ImportProductsMicrosoftOrder();

        ImportProductsMicrosoftJob::dispatch($request, $order)->onQueue('SyncProducts')
            ->delay(now()->addSeconds(10));

        return view('order')->with(['alert' => 'success', 'message' => trans('messages.Provider Updated successfully')]);
    }

    public function saveOrderForVerification(Request $request){
        $validate = $request->validate([
            'token' => 'required|uuid',
        ]);

        $order = $this->orderRepository->newFromCartToken($validate['token']);

        $order->update(['asked_verification_by' => Auth::user()->id]);

        if(Auth::user()->hasRole('reseller')){
            $verifier = $order->customer->user;

            $verifier->givePermissionTo('verify order '.$order->id);

            $verifier->notify(new OrderPendingToConfirm);
        }

        if(Auth::user()->hasRole('customer')){
            $verifier = Auth::user()->customer->resellers->first()->user;

            $verifier->givePermissionTo('verify order '.$order->id);

            $verifier->notify(new OrderPendingToConfirm);
        }

        return view('store.index')->with(['alert' => 'success', 'message' => trans('messages.order_placed_susscessfully')]);
    }

    public function verifyOrder(Request $request){
        $order = Order::find($request->order_id);

        throw_unless(Auth::user()->can('verify order '.$order->id), AuthorizationException::class);

        $order->update(['verified_at' => now()]);

        $order->sendToMicrosoft();

        return view('store.index')->with(['alert' => 'success', 'message' => trans('messages.order_placed_susscessfully')]);
    }
}
