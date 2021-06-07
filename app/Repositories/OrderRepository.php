<?php

namespace App\Repositories;

use App\Cart;
use App\Order;
use App\Customer;
use App\Reseller;
use Illuminate\Support\Str;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Redirect;
use App\Repositories\OrderRepositoryInterface;

/**
*
*/
class OrderRepository implements OrderRepositoryInterface
{

    use UserTrait;


    public function all()
    {

        $user = $this->getUser();

        switch ($this->getUserLevel()) {
            case config('app.super_admin'):

                $orders = Order::with(['status'])->get()->map->format()->sortDesc()->paginate(10);

            break;

            case config('app.admin'):
                $orders = Order::with(['status'])->get()->map->format()->sortDesc()->paginate(10);
            break;



            case config('app.provider'):

                $resellers = Reseller::where('provider_id', $user->provider->id)->pluck('id')->toArray();

                $customers = Customer::whereHas('resellers', function($query) use  ($resellers) {
                    $query->whereIn('id', $resellers);
                })->pluck('id');


                $orders = Order::with(['status'])->whereHas('customer', function($query) use  ($customers) {
                    $query->whereIn('id', $customers);
                })->get()->map->format()->sortDesc()->paginate(10);

            break;

            case config('app.reseller'):

                $reseller = $user->reseller;

                if($reseller->customers->count() == 0){
                    $customers = '0';
                    $orders = '0';
                }else{
                    $customers = Customer::whereHas('resellers', function($query) use  ($reseller) {
                        $query->whereIn('id', $reseller);
                    })->pluck('id');
                    $orders = Order::with(['status'])->whereHas('customer', function($query) use  ($customers) {
                        $query->whereIn('id', $customers);
                    })->get()->map->format()->sortDesc()->paginate(10);
                }

            break;
            case config('app.customer'):

                $orders = $user->customer->orders->map->format()->sortDesc()->paginate(10);
            break;

            default:
            return abort(403, __('errors.unauthorized_action'));
        break;
    }

    return $orders;
}

public function newFromCartToken($token)
{
    $cart = Cart::where('token', $token)->with('products')->first();

    DB::beginTransaction();

    try {
        $order = $this->createOrderFromCart($cart);

        foreach ($cart->products as $product)
        {
            $order->products()->attach($product->id, [
                'price' => $product->pivot->price,
                'retail_price' => $product->pivot->retail_price,
                'billing_cycle' => $product->pivot->billing_cycle,
                'id' => Str::uuid(),
                'quantity' => $product->pivot->quantity
                ]);
            }

            $cart->delete();

            DB::commit();

        } catch (\PDOException $e) {
            DB::rollBack();
            return false;
        }


        return $order;
    }

    private function createOrderFromCart($cart)
    {
        $order = new Order();

        $order->customer_id = $cart->customer_id;
        $order->domain = $cart->domain;
        $order->token = $cart->token;
        $order->user_id = $cart->user_id;
        $order->verify = $cart->verify;
        $order->verified = $cart->verified;
        $order->agreement_firstname = $cart->agreement_firstname;
        $order->agreement_lastname = $cart->agreement_lastname;
        $order->agreement_email = $cart->agreement_email;
        $order->agreement_phone = $cart->agreement_phone;
        $order->comments = $cart->comments;

        $order->save();

        return $order;

    }

    public function UpdateMSSubscription($subscription, $request)
    {


        $amount = collect($request->amount)->diff(collect($subscription->amount));
        $billing_period = collect($request->billing_period)->diff(collect($subscription->billing_period));
        $status = collect($request->status)->diff(collect($subscription->status_id));

        $order = new Order();
        $order->customer_id = $subscription->customer_id;
        $order->domain = $subscription->domain;
        $order->token = Str::uuid();
        $order->user_id = Auth::user()->id;
        $order->verify = $subscription->verify;
        if ($status->isempty() &&  $billing_period->isempty() && !$amount->isempty()){
            $order->details = "changing subscription ".$subscription->name ." amount from ". $subscription->amount. " to ". $request->amount;
        }elseif ($status->isempty() &&  !$billing_period->isempty() && !$amount->isempty()){
            $order->details = "changing subscription ".$subscription->name ." amount from ". $subscription->amount. " to ". $request->amount ." and " ." Billing Period from ". $subscription->billing_period. " to ". $request->billing_period;
        }elseif ($status->isempty() &&  !$billing_period->isempty() && $amount->isempty()){
            $order->details = "changing subscription ".$subscription->name ." Billing Period from ". $subscription->billing_period. " to ". $request->billing_period;
        }elseif(!$status->isempty()){
            if   ($request->status === '1') {
                $request->merge(['status' => 'active']);
            }else {
                $request->merge(['status' => 'suspended']);
            }
            $order->details = "changing subscription ".$subscription->name . " and changing the status to " . $request->status;
        }else{
            return Redirect::back()->with('danger','nothing to do');
        }
        $order->save();

        return $order;

    }


    public function ImportProductsMicrosoftOrder()
    {

        $order = new Order();

        $order->token = Str::uuid();
        $order->user_id = Auth::user()->id;
        $order->details = "Importing MS Products";

        $order->save();

        return $order;

    }




}
