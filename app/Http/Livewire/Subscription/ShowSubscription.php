<?php

namespace App\Http\Livewire\Subscription;

use Exception;
use App\Subscription;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use App\Notifications\SubscriptionUpdate;
use Illuminate\Support\Facades\Notification;
use Tagydes\MicrosoftConnection\Facades\Subscription as SubscriptionFacade;
use Tagydes\MicrosoftConnection\Models\Subscription as TagydesSubscription;
use App\Instance;

class ShowSubscription extends Component
{
    public $status;
    public $amount;
    public $subs;
    public $tt;
    public $subscription;
    public $validate;
    public $autorenew;
    public $max_quantity = '999999999';
    public $min_quantity = '1';
    public $showEditModal = false;
    public $isLoading = true;
    public $showconfirmationModal = false;
    public $showcancelconfirmationModal = false;

    public Subscription $editing;

    protected $listeners = ['refreshTransactions' => '$refresh'];

    public function rules()
    {
        if ($this->subscription->productonce){
            $max_quantity = $this->subscription->productonce->where('instance_id', $this->subscription->instance_id)->first()->maximum_quantity;
            $min_quantity = $this->subscription->productonce->where('instance_id', $this->subscription->instance_id)->first()->minimum_quantity;
        }else{
            $max_quantity = 1;
            $min_quantity = 1;
        }


        return [
            'editing.name'              => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
            'editing.amount'            => ['required', 'integer', 'max:'.$max_quantity, 'min:'.$min_quantity],
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
        $this->min_quantity = $subs->productonce->minimum_quantity;
        $this->max_quantity = $subs->productonce->maximum_quantity;
        $this->editing      = $subs;
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

        if(collect($this->editing->getChanges())->has('billing_period')){
            $this->editing->changeBillingCycle($this->editing->billing_period);
        }

        $this->showEditModal = false;
        $fields = collect($this->editing->getChanges())->except(['updated_at']);

        $this->notify('You\'ve updated '.  $fields .' Subscription');
        $this->emit('refreshTransactions');
    }

    public function saveScheduled(){
        // TODO: Pending to adapt on Livewire usage
        $instance = Instance::where('id', $this->editing->instance_id)->first();

        $subscription = new TagydesSubscription([
            'id'            => $this->editing->subscription_id,
            'orderId'       => $this->editing->order_id,
            'offerId'       => $this->editing->upgradeToOffer ?? $this->editing->product_id,
            'customerId'    => $this->editing->customer->microsoftTenantInfo->first()->tenant_id,
            'name'          => $this->editing->name,
            'status'        => $this->editing->status_id,
            'quantity'      => $this->editing->amount,
            'currency'      => $this->editing->currency,
            'billingCycle'  => $this->editing->billing_period,
            'created_at'    => $this->editing->created_at->__toString(),
        ]);

        SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token)->updateOnRenew($subscription, [
            'billingCycle' => $this->editing->billing_period,
            'quantity' => $this->editing->amount,
            'term' => $this->editing->term,
        ]);

        $this->editing->update(['changes_on_renew' => [
            'amount' => $this->editing->amount,
            'billingCycle' => $this->editing->billing_period,
            'term' => $this->editing->term,
            'product_id' => $this->editing->upgradeToOffer ?? $this->editing->product_id,
        ]]);
    }

    public function autorenewcheck(Subscription $subscription)
    {
        // dd($this->autorenew == true);
        if ($this->autorenew == true) {
            $subscription->fill([
                'autorenew' => '1',
                ])->save();
            }else
            $subscription->fill([
                'autorenew' => '0',
                ])->save();
            $this->emit('refreshTransactions');
    }

    public function migrateToMCE(Subscription $subscription)
    {
        dd($subscription);
    }

    public function manageSchedule(Subscription $subscription)
    {
        dd($subscription);
    }

    public function validateisEligible(Subscription $subscription)
    {
       $this->tt = $this->subscription->validatemigration($subscription->customer, $subscription);
       $this->isLoading = false;

    }

    public function mount()
    {
        $this->autorenew = $this->subscription->autorenew;
        $this->amount = $this->subscription->amount;
        $this->max_quantity = $this->subscription->products->where('instance_id', $this->subscription->instance_id)->first()->maximum_quantity ?? null;
        $this->status = $this->subscription->status->name;
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
    public function cancel(Subscription $subscription){

        $this->showcancelconfirmationModal = false;

        $subscription->cancel();

        $this->notify('Subscription ' . $subscription->name . ' was canceled, refresh page');
        Notification::send($subscription->customer->users->first(), new SubscriptionUpdate($subscription));
        Log::info('Status changed: canceled');
        $this->emit('refreshTransactions');

    }

    public function render()
    {
        $subscription = $this->subscription;
        return view('livewire.subscription.show-subscription', compact('subscription'));
    }
}
