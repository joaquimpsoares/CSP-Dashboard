<?php

namespace App\Http\Livewire\Subscription;

use App\Order;
use Exception;
use App\Instance;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Subscription;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\SubscriptionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;
use Tagydes\MicrosoftConnection\Facades\Subscription as SubscriptionFacade;
use Tagydes\MicrosoftConnection\Models\Subscription as TagydesSubscription;

class SubscriptionTable extends Component
{
    use WithPagination;
    public $search = '';
    public $quantity = '';
    public $addons = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function addAddon($addon, Subscription $subscription)
    {
        $instance = Instance::where('id', $subscription->instance_id)->first();
        $subscription = new TagydesSubscription([
            'id'                => $subscription->subscription_id,
            'orderId'           => $subscription->order_id,
            'offerId'           => $addon,
            'customerId'        => $subscription->customer->microsoftTenantInfo->first()->tenant_id,
            'name'              => $subscription->name,
            'status'            => $subscription->status_id,
            'quantity'          => $this->quantity,
            'PartnerIdOnRecord' => $subscription->msrpid,
            'currency'          => $subscription->currency,
            'billingCycle'      => $subscription->billing_period,
            'created_at'        => $subscription->created_at->__toString(),
            ]);



    try {
        $order = $this->createOrderFromCart($subscription);

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
        try{
            $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token)->
            AddAddonToSubscription($subscription, ['quantity' => $this->quantity]);

            // $subscription->update(['amount'=> $this->quantity]);
            Log::info('License changed: '.$update);
            Log::info('License changed: '.$this->quantity);
            // $order->update(['order_status_id'=> 4]);
        } catch (Exception $e) {
            Log::info('Error Placing order to Microsoft: '.$e->getMessage());
            // $order->update(['order_status_id'=> 3]);
            return Redirect::back()->with('danger','Error Placing order to Microsoft: '.$e->getMessage());
        }

    }

    public function exportSelected()
    {
        return Excel::download(new SubscriptionsExport, 'Subscriptions.xlsx');
    }

    private function createOrderFromCart($cart)
    {

        $order = new Order();

        $order->customer_id = $cart->customer_id;
        $order->domain = $cart->domain;
        $order->user_id = Auth::user()->id;
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

    public function render()
    {

        $query = Subscription::query();
        $subscriptions = $query
            ->where(function ($q)  {
                $q->where('name', "like", "%{$this->search}%");
                $q->orWhere('id', 'like', "%{$this->search}%");
                $q->orWhere('billing_period', 'like', "%{$this->search}%");
                $q->orwhereHas('customer', function(Builder $q){
                    $q->where('company_name', 'like', "%{$this->search}%");
                });
            })->paginate(10);


        // $subscriptions->getCollection()->map(function(Subscription $subscription){
        //     $subscription->setRawAttributes(json_decode(json_encode($subscription->format()), true)); // Coverts to array recursively (make helper from it?)
        //     return $subscription;
        // });
        return view('livewire.subscription.subscription-table', compact('subscriptions'));
    }
}
