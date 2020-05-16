<?php

namespace App\Repositories;

use App\Cart;
use App\Http\Traits\UserTrait;
use App\Order;
use App\Repositories\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * 
 */
class OrderRepository implements OrderRepositoryInterface
{
	
	use UserTrait;

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

}