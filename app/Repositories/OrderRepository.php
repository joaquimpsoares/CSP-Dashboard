<?php

namespace App\Repositories;

use App\Cart;
use App\Order;
use App\Customer;
use App\Reseller;
use Illuminate\Support\Str;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
                $orders = Order::with('status', 'customer')->get()->sortByDesc('id')->map->format();
			break;

			case config('app.admin'):
                $orders = Order::with('status', 'customer')->get()->sortByDesc('id')->map->format();
			break;

            case config('app.provider'):

            $resellers = Reseller::where('provider_id', $user->provider->id)->pluck('id')->toArray();

            $customers = Customer::whereHas('resellers', function($query) use  ($resellers) {
                $query->whereIn('id', $resellers);
            })->get()->map->format()->toArray();


            foreach($customers as $customer){
                $orders = Order::with('status', 'customer')->where('customer_id', $customer['id'])
                ->get()->sortByDesc('id')->map->format();
                // dd($orders);
            }

            // foreach ($orders as $users ){
            //     foreach($users['users'] as $avatar){
            //         // dd($avatar->avatar);
            //     }
            // }

            break;
            
            case config('app.reseller'):

                $resellers = Reseller::where('provider_id', $user->provider->id)->pluck('id')->toArray();

                $orders = Customer::whereHas('resellers', function($query) use  ($resellers) {
                    $query->whereIn('id', $resellers);
                })->get()->map->format();

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

    public function UpdateMSSubscription($subscription)
    {

        $order = new Order();

        $order->customer_id = $subscription->customer_id;
        $order->domain = $subscription->domain;
        $order->token = Str::uuid();
        $order->user_id = Auth::user()->id;
        $order->verify = $subscription->verify;
        $order->comments = $subscription->quantity;


        $order->save();

        return $order;

    }


    

}