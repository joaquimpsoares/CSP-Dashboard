<?php

namespace App\Http\Livewire\Subscription;

use Exception;
use App\Product;
use App\Instance;
use App\Subscription;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use App\Notifications\SubscriptionUpdate;
use Illuminate\Support\Facades\Notification;
use App\Exceptions\UpdateSubscriptionException;
use Tagydes\MicrosoftConnection\Facades\Subscription as SubscriptionFacade;
use Tagydes\MicrosoftConnection\Models\Subscription as TagydesSubscription;

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
    public $upgradeOffers;
    public $upgradeOfferselected;
    public $isLoading = true;
    public $ScheduleEdit = false;

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

        if($this->subscription->productonce->isNCE()){
            foreach ($this->subscription->refundableQuantity as $item){
                $min_quantity = $this->subscription->amount - $item['totalQuantity'];
            }
        }

        return [
            'editing.name'              => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
            'editing.amount'            => ['required', 'integer', 'max:'.$max_quantity, 'min:'.$min_quantity],
            'editing.billing_period'    => ['required'],
            'editing.autorenew'         => ['required', 'boolean'],
            'editing.status_id'         => ['required', 'exists:statuses,id'],
        ];
    }

    public function updated($propertyName){$this->validateOnly($propertyName);}


    public function edit(Subscription $subs)
    {

        $this->ScheduleEdit= false;
        $this->showEditModal = true;
        $this->min_quantity = $subs->productonce->minimum_quantity;
        $this->max_quantity = $subs->productonce->maximum_quantity;
        $this->editing      = $subs;
    }

    public function save()
    {
        $this->showEditModal = false;
        $this->validate();
        DB::beginTransaction();
        $this->editing->update();


        if(collect($this->editing->getChanges())->has('autorenew')){
            try {
                $update =$this->editing->changeAutorenew($this->editing->autorenew);
                if($update){
                    $this->editing->update([
                        'refundableQuantity' => [$update->refundableQuantity] ?? null,
                        'expiration_data'    => date('Y-m-d', strtotime($update->commitmentEndDate)),
                    ]);
                }
            } catch (\Throwable $th) {
                DB::rollBack();
            }
        }

        if(collect($this->editing->getChanges())->has('status_id')){
            try {
                if(collect($this->editing->getChanges())['status_id'] == 1){
                    $this->editing->activate();
                }else{
                    $this->editing->suspend();
                }
            } catch (\Throwable $th) {
                $this->showEditModal = false;
                DB::rollBack();
            }
        }

        if(collect($this->editing->getChanges())->has('amount')){
            try {
                $update =$this->editing->changeAmount($this->editing->amount);
                if(Str::contains($update, '800082')){
                    throw new UpdateSubscriptionException($update);
                }
                if(Str::contains($update, '800094')){
                    throw new UpdateSubscriptionException($update);
                }
                if(Str::contains($update, '800088')){
                    // dd(Str::contains($update, '800094'),Str::contains($update, '800082'), substr($update, strrpos($update, '"description":"' )+1),$update);
                    throw new UpdateSubscriptionException($update);
                }
            } catch (UpdateSubscriptionException $th) {
                $this->showEditModal = false;
                $message = substr($th->getMessage(), strrpos($th->getMessage(), '"description":"' ));
                $this->notify('',$message, 'error');
                DB::rollBack();
                return false;
            } catch (\Throwable $th) {
                $this->showEditModal = false;
                $this->notify('',$message, 'error');
                DB::rollBack();
                return false;
            }

            if(isset($update))
            {
                $this->editing->update([
                    'refundableQuantity' => [$update->refundableQuantity],
                    'expiration_data'    => date('Y-m-d', strtotime($update->commitmentEndDate)),
                ]);
            }
        }

        if(collect($this->editing->getChanges())->has('billing_period')){
            try {
                $this->editing->changeBillingCycle($this->editing->billing_period);
            } catch (\Throwable $th) {
                DB::rollBack();
                $this->showEditModal = false;
                $this->notify('error','updating ' . $th->getMessage());
            }
        }
        DB::commit();

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
            if ($this->autorenew == true)
            {
                $subscription->fill([
                    'autorenew' => '1',
                    ])->save();
                }else
                $subscription->fill(
                    [
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
                        $this->showEditModal = true;
                        $this->ScheduleEdit = true;
                        $this->quantity = $subscription->amount;
                        $this->upgradeOffers = $subscription->productonce->upgrade_target_offers->map(function ($item, $key) use($subscription) {
                            return Product::where('sku', $item)->where('catalog_item_id', '!=' ,$subscription->product_id)->first();
                        })->filter();
                    }

                    public function validateisEligible(Subscription $subscription)
                    {
                        $this->tt = $this->subscription->validatemigration($subscription->customer, $subscription);
                        $this->isLoading = false;
                        $this->emit('refreshTransactions');

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
