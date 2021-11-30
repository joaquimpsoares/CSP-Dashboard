<?php

namespace App\Http\Livewire\Subscription;

use App\Subscription;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\Notifications\SubscriptionUpdate;
use Illuminate\Support\Facades\Notification;

class SubscriptionCostumer extends Component
{
    public Subscription $editing;
    public $showEditModal = false;
    public $subs;
    public $showconfirmationModal = false;
    public $max_quantity = '999999999';
    public $min_quantity = '1';

    public $filters = [
        'search' => '',
        'status' => '',
        'amount-min' => null,
        'amount-max' => null,
        'date-min' => null,
        'date-max' => null,
    ];

    public function rules()
    {
        return [
            'editing.name'              => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
            'editing.amount'            => ['required', 'numeric','max:'.$this->max_quantity, 'min:'.$this->min_quantity],
            'editing.billing_period'    => ['required'],
            'editing.autorenew'         => ['required', 'boolean'],
            'editing.status_id'         => ['required', 'exists:statuses,id'],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function edit(Subscription $subs)
    {
        $this->showEditModal = true;
        $this->min_quantity = $subs->product->minimum_quantity;
        $this->max_quantity = $subs->product->maximum_quantity;
        $this->editing      = $subs;
    }

    public function save()
    {
        $this->validate();
        $this->showEditModal = false;
        $this->editing->save();

        if(collect($this->editing->getChanges())->has('status_id')){
            if(collect($this->editing->getChanges())['status_id'] == 1){
                $this->editing->activate();
            }else{
                $this->editing->suspend();
            }
        }
        if(collect($this->editing->getChanges())->has('amount')){
            $this->editing->changeAmount($this->editing->amount);
        }

        if(collect($this->editing->getChanges())->has('billing_period')){
            $this->editing->changeBillingCycle($this->editing->billing_period);
        }

        $this->showEditModal = false;
        $fields = collect($this->editing->getChanges())->except(['updated_at']);

        $this->notify('You\'ve updated '.  $fields .' Subscription');
        $this->emit('refreshTransactions');

    }

    public function disable(Subscription $subscription)
    {
        $this->showconfirmationModal = false;
        $subscription->suspend();
        $this->emit('refreshTransactions');
    }

    public function enable(Subscription $subscription)
    {
        $subscription->active();
        $this->notify('Subscription ' . $subscription->name . ' is Active, refresh page');
        Notification::send($subscription->customer->users->first(), new SubscriptionUpdate($subscription));
        Log::info('Status changed: Enabled');
        $this->emit('refreshTransactions');
    }


    public function render()
    {
        $query = Subscription::all();
        $subscriptions = $query;
        return view('livewire.subscription.subscription-costumer', compact('subscriptions'));
    }
}
