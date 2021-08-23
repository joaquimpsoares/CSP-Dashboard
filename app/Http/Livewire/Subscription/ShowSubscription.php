<?php

namespace App\Http\Livewire\Subscription;

use Exception;
use Livewire\Component;
use App\Subscription;
use Illuminate\Support\Facades\Log;
use App\Notifications\SubscriptionUpdate;
use Illuminate\Support\Facades\Notification;

class ShowSubscription extends Component
{
    public $status;
    public $max_quantity;
    public $amount;
    public $subscription;
    public Subscription $editing;
    public $showEditModal = false;
    public $showconfirmationModal = false;

    protected $listeners = ['refreshTransactions' => '$refresh'];

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
    public function save()
    {
        $this->showEditModal = false;
        $this->validate();
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

        $this->showEditModal = false;
        $fields = collect($this->editing->getChanges())->except(['updated_at']);

        $this->notify('You\'ve updated '.  $fields .' Subscription');
        $this->emit('refreshTransactions');

    }


    public function checkout(Subscription $subscription){

    }

    public function mount(){
        $this->amount = $this->subscription->amount;
        $this->max_quantity = $this->subscription->products->where('instance_id', $this->subscription->instance_id)->first()->maximum_quantity;
        $this->status = $this->subscription->status->name;

    }

    public function disable(Subscription $subscription){

        $this->showconfirmationModal = false;


        $subscription->suspend();


        $this->emit('refreshTransactions');

    }

    public function enable(Subscription $subscription){

        $subscription->active();

        $this->notify('Subscription ' . $subscription->name . ' is Active, refresh page');
        Notification::send($subscription->customer->users->first(), new SubscriptionUpdate($subscription));
        Log::info('Status changed: Enabled');
        $this->emit('refreshTransactions');


    }

    public function render()
    {
        $subscription = $this->subscription;
        return view('livewire.subscription.show-subscription', compact('subscription'));
    }
}
