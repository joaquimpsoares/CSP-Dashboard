<?php

namespace App\Http\Livewire\Subscription;

use Exception;
use App\Subscription;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Notifications\SubscriptionUpdate;
use Illuminate\Support\Facades\Notification;
use Tagydes\MicrosoftConnection\Facades\Subscription as SubscriptionFacade;
use Tagydes\MicrosoftConnection\Models\Subscription as TagydesSubscription;

class ShowSubscription extends Component
{
    public $status;
    public $max_quantity;
    public $amount;
    public $subscription;
    public Subscription $editing;
    public $showEditModal = false;
    public $showconfirmationModal = false;

    public function rules()
    {
        $max_quantity = $this->subscription->products->where('instance_id', $this->subscription->instance_id)->first()->maximum_quantity;
        $min_quantity = $this->subscription->products->where('instance_id', $this->subscription->instance_id)->first()->minimum_quantity;
        return [
            'editing.name'              => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
            'editing.amount'            => ['required', 'max:'.$max_quantity, 'min:'.$min_quantity],
            'editing.autorenew'         => ['nullable'],
            'editing.billing_period'    => ['required'],
            'editing.status_id'         => ['required', 'exists:statuses,id'],

        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function edit(Subscription $subscription)
    {
        $this->editing = $subscription;
        $this->showEditModal = true;
    }

    protected $listeners = ['refreshStatus'];

    public function checkout(Subscription $subscription){

    }

    public function mount(){
        $this->amount = $this->subscription->amount;
        $this->max_quantity = $this->subscription->products->where('instance_id', $this->subscription->instance_id)->first()->maximum_quantity;
        $this->status = $this->subscription->status->name;

    }

    public function disable(Subscription $subscriptions){
        $this->showconfirmationModal = false;

        $subscription = new TagydesSubscription([
            'id'            => $subscriptions->subscription_id,
            'orderId'       => $subscriptions->order_id,
            'offerId'       => $subscriptions->product_id,
            'customerId'    => $subscriptions->customer->microsoftTenantInfo->first()->tenant_id,
            'name'          => $subscriptions->name,
            'status'        => $subscriptions->status_id,
            'quantity'      => $subscriptions->amount,
            'currency'      => $subscriptions->currency,
            'billingCycle'  => $subscriptions->billing_period,
            'created_at'    => $subscriptions->created_at->__toString(),
            ]);

            Log::info('MS subscriptions: '.$subscription);

        try {

            $update = SubscriptionFacade::withCredentials($subscriptions->instance->external_id, $subscriptions->instance->external_token) //change status only
            ->update($subscription, ['status' => 'suspended']);
    } catch (Exception $e) {
        return Redirect::back()->with('danger','Error Placing order to Microsoft: '.$e->getMessage());
        Log::info('Error Placing order to Microsoft: '.$e->getMessage());
    }


    $subscriptions->update(['status_id' => 2]);
    $this->notify('Subscription ' . $subscription->name . ' is suspended, refresh page');
    Notification::send($subscriptions->customer->users->first(), new SubscriptionUpdate($subscriptions));
    Log::info('Status changed: Suspended');
    $this->redirect('#');

    }

    public function enable(Subscription $subscriptions){

        $subscription = new TagydesSubscription([
            'id'            => $subscriptions->subscription_id,
            'orderId'       => $subscriptions->order_id,
            'offerId'       => $subscriptions->product_id,
            'customerId'    => $subscriptions->customer->microsoftTenantInfo->first()->tenant_id,
            'name'          => $subscriptions->name,
            'status'        => $subscriptions->status_id,
            'quantity'      => $subscriptions->amount,
            'currency'      => $subscriptions->currency,
            'billingCycle'  => $subscriptions->billing_period,
            'created_at'    => $subscriptions->created_at->__toString(),
            ]);

            Log::info('MS subscriptions: '.$subscription);

        try {
            $update = SubscriptionFacade::withCredentials($subscriptions->instance->external_id, $subscriptions->instance->external_token) //change status only
            ->update($subscription, ['status' => 'active']);
        } catch (Exception $e) {
        return Redirect::back()->with('danger','Error Placing order to Microsoft: '.$e->getMessage());
        Log::info('Error Placing order to Microsoft: '.$e->getMessage());
    }

    $subscriptions->update(['status_id' => 1]);
    $this->notify('Subscription ' . $subscription->name . ' is Active, refresh page');
    Notification::send($subscriptions->customer->users->first(), new SubscriptionUpdate($subscriptions));
    Log::info('Status changed: Enabled');
    $this->redirect('#');

    }

    public function render()
    {
        $subscription = $this->subscription;
        return view('livewire.subscription.show-subscription', compact('subscription'));
    }
}
