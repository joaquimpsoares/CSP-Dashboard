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

    //     $user = $this->getUser();

    //     switch ($this->getUserLevel()) {
    //         case config('app.super_admin'):

    //             $orders = Order::with(['status'])->get()->map->format()->sortDesc()->paginate(10);

    //         break;

    //         case config('app.admin'):
    //             $orders = Order::with(['status'])->get()->map->format()->sortDesc()->paginate(10);
    //         break;



    //         case config('app.provider'):

    //             $resellers = Reseller::where('provider_id', $user->provider->id)->pluck('id')->toArray();

    //             $customers = Customer::whereHas('resellers', function($query) use  ($resellers) {
    //                 $query->whereIn('id', $resellers);
    //             })->pluck('id');


    //             $orders = Order::with(['status'])->whereHas('customer', function($query) use  ($customers) {
    //                 $query->whereIn('id', $customers);
    //             })->get()->map->format()->sortDesc()->paginate(10);

    //         break;

    //         case config('app.reseller'):

    //             $reseller = $user->reseller;

    //             if($reseller->customers->count() == 0){
    //                 $customers = '0';
    //                 $orders = '0';
    //             }else{
    //                 $customers = Customer::whereHas('resellers', function($query) use  ($reseller) {
    //                     $query->whereIn('id', $reseller);
    //                 })->pluck('id');
    //                 $orders = Order::with(['status'])->whereHas('customer', function($query) use  ($customers) {
    //                     $query->whereIn('id', $customers);
    //                 })->get()->map->format()->sortDesc()->paginate(10);
    //             }

    //         break;
    //         case config('app.customer'):

    //             $orders = $user->customer->orders->map->format()->sortDesc()->paginate(10);
    //         break;

    //         default:
    //         return abort(403, __('errors.unauthorized_action'));
    //     break;
    // }

    // return $orders;
}

public function newFromCartToken($token)
{
    $cart = Cart::where('token', $token)->with('products')->first();

    DB::beginTransaction();

    try {
        $order = $this->createOrderFromCart($cart);

        $engine = app(\App\Services\Pricing\PricingEngine::class);

        foreach ($cart->products as $product)
        {
            // Build a pricing context and persist an immutable pricing snapshot on the order line.
            // Past orders must not change if price lists/rules change later.
            $user = $this->getUser();
            $customer = $order->customer;
            $reseller = $customer?->resellers?->first();
            $provider = $user?->provider ?? $user?->reseller?->provider ?? $reseller?->provider;

            $productType = $product->IsAzure() ? 'azure' : ($product->IsPerpetual() ? 'perpetual' : 'license');

            $pli = null;
            if (!empty($product->pivot->price_list_item_id)) {
                $pli = \App\Models\Pricing\PriceListItem::query()->find($product->pivot->price_list_item_id);
            }

            $ctx = new \App\Services\Pricing\PriceContext(
                providerId: (int)($provider?->id ?? 0),
                resellerId: $reseller?->id,
                customerId: $customer?->id,
                market: 'ES',
                currency: $product->pivot->currency ?? 'EUR',
                productType: $productType,
                offerId: $pli?->offer_id,
                skuId: $pli?->sku_id ?? $product->sku,
                meterId: $pli?->meter_id,
                productFamily: null,
                category: $product->category,
                tags: [],
                billingCycle: $pli?->billing_cycle ?? $product->pivot->billing_cycle,
                term: $pli?->term_duration ?? $product->pivot->term_duration,
                quantity: (int)$product->pivot->quantity,
                at: now(),
                includeTrace: true,
            );

            $result = $engine->explainLine($ctx);
            $arr = $result->toArray();

            $inputs = $arr['inputs'] ?? [];
            $winning = $arr['winning_rule'] ?? null;
            $outputs = $arr['outputs'] ?? [];

            $sellUnit = $outputs['sell_unit'] ?? null;
            $sellTotal = $outputs['sell_total'] ?? null;

            // Backwards-compatible fallback if pricing engine can't quote (legacy price fields still exist)
            if (!$result->ok || $sellUnit === null || $sellTotal === null) {
                $sellUnit = $product->pivot->retail_price ?? $product->pivot->price;
                $sellTotal = $sellUnit !== null ? ((float)$sellUnit * (int)$product->pivot->quantity) : null;
            }

            $order->products()->attach($product->id, [
                // legacy fields (keep for backwards compatibility)
                'price' => $product->pivot->price,
                'retail_price' => $product->pivot->retail_price,
                'billing_cycle' => $product->pivot->billing_cycle,
                'id' => Str::uuid(),
                'quantity' => $product->pivot->quantity,
                'term_duration' => $product->pivot->term_duration ?? null,

                // snapshot fields
                'price_list_id' => $inputs['price_list_id'] ?? null,
                'price_list_item_id' => $inputs['price_list_item_id'] ?? null,
                'pricing_rule_set_id' => $winning['rule_set_id'] ?? null,
                'pricing_rule_id' => $winning['id'] ?? null,
                'market' => $ctx->market,
                'currency' => $ctx->currency,
                'fx_rate_to_currency' => null,
                'cost_unit_snapshot' => $inputs['cost_unit'] ?? null,
                'erp_unit_snapshot' => $inputs['erp_unit'] ?? null,
                'promo_adjustment_snapshot' => $inputs['promo_adjustment'] ?? 0,
                'sell_unit_snapshot' => $sellUnit,
                'sell_total_snapshot' => $sellTotal,
                'pricing_trace' => $arr['rule_trace'] ?? null,
                'pricing_selected_reason' => $arr['selection_reason'] ?? null,
                'pricing_calculated_at' => now(),
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

        if($cart->order){
            return $cart->order;
        }

        $order = new Order();
        $order->customer_id = $cart->customer_id;
        $order->domain = $cart->domain;
        $order->token = $cart->token;
        $order->user_id = $cart->user_id;
        $order->agreement_firstname = $cart->agreement_firstname;
        $order->agreement_lastname = $cart->agreement_lastname;
        $order->agreement_email = $cart->agreement_email;
        $order->agreement_phone = $cart->agreement_phone;
        $order->comments = $cart->comments;
        $order->save();

        return $order;

    }

    public function UpdateMSSubscription($subscription, $request){
        dd($subscription->verify);

        $amount = collect($request->amount)->diff(collect($subscription->amount));
        $billing_period = collect($request->billing_period)->diff(collect($subscription->billing_period));
        $status = collect($request->status)->diff(collect($subscription->status_id));

        $order = new Order();
        $order->customer_id = $subscription->customer_id;
        $order->domain = $subscription->domain;
        $order->token = Str::uuid();
        $order->user_id = Auth::user()->id;
        // $order->verify = $subscription->verify;

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

    public function ImportProductsMicrosoftOrder(){

        $order = new Order();

        $order->token = Str::uuid();
        $order->user_id = Auth::user()->id;
        $order->details = "Importing MS Products";

        $order->save();

        return $order;

    }

}
