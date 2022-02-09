<?php

namespace App\Http\Livewire\Subscription;

use App\Order;
use Exception;
use Throwable;
use App\Product;
use App\Instance;
use App\Subscription;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Ncemigration;
use App\Jobs\CreateMigrationJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use App\Notifications\SubscriptionUpdate;
use Illuminate\Support\Facades\Notification;
use App\Exceptions\UpdateSubscriptionException;
use Tagydes\MicrosoftConnection\Facades\Subscription as SubscriptionFacade;
use Tagydes\MicrosoftConnection\Models\Subscription as TagydesSubscription;

class ShowSubscription extends Component
{
    public $user;
    public $status;
    public $amount;
    public $billing_period;
    public $term;
    public $newterm;
    public $tt;

    public $subs;
    public $subscription;
    public $validate;
    public $autorenew;
    public $max_quantity = '999999999';
    public $min_quantity = '1';
    public $upgradeOffers;
    public $upgradeOfferselected;

    public $isLoading = true;
    public $showEditModal = false;
    public $ScheduleEdit = false;

    public $showconfirmationModal = false;
    public $showcancelconfirmationModal = false;

    public Subscription $editing;

    protected $listeners = ['refreshTransactions' => '$refresh'];

    public function updated($propertyName){$this->validateOnly($propertyName);}

    public function rules(){
        if ($this->subscription->productonce){
            $max_quantity = $this->subscription->productonce->where('instance_id', $this->subscription->instance_id)->first()->maximum_quantity;
            $min_quantity = $this->subscription->productonce->where('instance_id', $this->subscription->instance_id)->first()->minimum_quantity;
        }else{
            $max_quantity = 1;
            $min_quantity = 1;
        }
        if($this->subscription->productonce[0] != null){
        if($this->subscription->productonce->isNCE()){
            if($this->subscription->refundableQuantity){
                foreach ($this->subscription->refundableQuantity as $item){
                    $min_quantity = $this->subscription->amount - $item['totalQuantity'];
                }
            }
        }
        }
        return [
            'editing.name'              => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
            'editing.amount'            => ['required', 'integer', 'max:'.$max_quantity, 'min:'.$min_quantity],
            'editing.billing_period'    => ['required'],
            'editing.term'              => ['required'],
            'editing.autorenew'         => ['required', 'boolean'],
            'editing.status_id'         => ['required', 'exists:statuses,id'],
        ];
    }
    public function edit(Subscription $subs){

        $this->ScheduleEdit= false;
        $this->showEditModal = true;
        $this->min_quantity = $subs->productonce->minimum_quantity;
        $this->max_quantity = $subs->productonce->maximum_quantity;
        $this->editing      = $subs;
    }

    public function save(){
        $this->showEditModal = false;
        $this->validate();
        DB::beginTransaction();
        $this->editing->update();
        if(collect($this->editing->getChanges())->has('autorenew')){
            if(collect($this->editing->getChanges())['autorenew'] == 1){
                $this->editing->autorenew = true;
            }else{
                $this->editing->autorenew = false;
            }
            try {
                $update =$this->editing->changeAutorenew($this->editing->amount,$this->editing->autorenew);

                if(Str::contains($update, '800082')){
                    throw new UpdateSubscriptionException($update);
                }
                if(Str::contains($update, '800094')){
                    throw new UpdateSubscriptionException($update);
                }
                if(Str::contains($update, '800088')){
                    throw new UpdateSubscriptionException($update);
                }
                if($update){
                    $this->editing->update([
                        'refundableQuantity' => [$update->refundableQuantity] ?? null,
                        'expiration_data'    => date('Y-m-d', strtotime($update->commitmentEndDate)),
                        'CancellationAllowedUntil' => $update->CancellationAllowedUntil,
                    ]);
                }

            } catch (UpdateSubscriptionException $th) {
                $this->showEditModal = false;
                $message = substr($th->getMessage(), strrpos($th->getMessage(), '"description":"' ));
                $this->notify('',$message, 'error');
                DB::rollBack();
                return false;
            } catch (\Throwable $th) {
                DB::rollBack();
            }
        }

        if(collect($this->editing->getChanges())->has('status_id')){
            if(collect($this->editing->getChanges())['status_id'] == 1){
                $this->editing->activate();
            }else{
                $this->editing->suspend();
            }
            try {
            } catch (\Throwable $th) {
                $this->showEditModal = false;
                DB::rollBack();
            }
        }

        if(collect($this->editing->getChanges())->has('amount')){

            if($this->editing->autorenew == 1){
                $this->editing->autorenew = true;
            }else{
                $this->editing->autorenew = false;
            }

            try {
                $update =$this->editing->changeAmount($this->editing->amount, $this->editing->autorenew);
                if(Str::contains($update, '800082')){
                    throw new UpdateSubscriptionException($update);
                }
                if(Str::contains($update, '800094')){
                    throw new UpdateSubscriptionException($update);
                }
                if(Str::contains($update, '800088')){
                    throw new UpdateSubscriptionException($update);
                }
                if(Str::contains($update, 'Client error')){
                    throw new UpdateSubscriptionException($update);
                }
            } catch (UpdateSubscriptionException $th) {
                $this->showEditModal = false;
                $message = substr($th->getMessage(), strrpos($th->getMessage(), '"description":"' ));
                $this->notify('',$th->getMessage(), 'error');
                DB::rollBack();
                return false;
            } catch (\Exception $th) {
                $this->showEditModal = false;
                $this->notify('',$th->getMessage(), 'error');
                DB::rollBack();
                return false;
            }

            if(isset($update->refundableQuantity))
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
        $fields = collect($this->editing->getChanges())->except(['updated_at','refundableQuantity','expiration_data','CancellationAllowedUntil']);
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

    public function autorenewcheck(Subscription $subscription){
        if ($this->autorenew == true)
        {
            try {
                $update = $this->subscription->changeAutorenew($subscription->amount,$this->autorenew);
                if(Str::contains($update, '800082')){
                    throw new UpdateSubscriptionException($update);
                }
                if(Str::contains($update, '800094')){
                    throw new UpdateSubscriptionException($update);
                }
                if(Str::contains($update, '800088')){
                    throw new UpdateSubscriptionException($update);
                }
                if(Str::contains($update, 'Client error')){
                    throw new UpdateSubscriptionException($update);
                }
                if($update){
                    $this->editing->update([
                        'refundableQuantity' => [$update->refundableQuantity] ?? null,
                        'expiration_data'    => date('Y-m-d', strtotime($update->commitmentEndDate)),
                        'CancellationAllowedUntil' => $update->CancellationAllowedUntil,
                    ]);
                }

            } catch (UpdateSubscriptionException $th) {
                $this->showEditModal = false;
                $message = substr($th->getMessage(), strrpos($th->getMessage(), '"description":"' ));
                $this->notify('',$message, 'error');
                DB::rollBack();
                return false;
            } catch (\Throwable $th) {
                DB::rollBack();
            }
            $subscription->fill(['autorenew' => '1',])->save();
        }else
        $this->autorenew = false;
        try {
            $update = $this->subscription->changeAutorenew($subscription->amount,$this->autorenew);
            if(Str::contains($update, '800082')){
                throw new UpdateSubscriptionException($update);
            }
            if(Str::contains($update, '800094')){
                throw new UpdateSubscriptionException($update);
            }
            if(Str::contains($update, '800088')){
                throw new UpdateSubscriptionException($update);
            }
            if(Str::contains($update, 'Client error')){
                throw new UpdateSubscriptionException($update);
            }
            if($update){
                $this->editing->update([
                    'refundableQuantity' => [$update->refundableQuantity] ?? null,
                    'expiration_data'    => date('Y-m-d', strtotime($update->commitmentEndDate)),
                    'CancellationAllowedUntil' => $update->CancellationAllowedUntil,
                ]);
            }

        } catch (UpdateSubscriptionException $th) {
            $this->showEditModal = false;
            $message = substr($th->getMessage(), strrpos($th->getMessage(), '"description":"' ));
            $this->notify('',$message, 'error');
            DB::rollBack();
            return false;
        } catch (\Throwable $th) {
            DB::rollBack();
        }
        $subscription->fill(
            ['autorenew' => '0',])->save();

            $this->notify('You\'ve updated autorenew Subscription');
            $this->emit('refreshTransactions');
    }

    public function migrateToMCE(Subscription $subscription, $user){

        $order = new Order();
        $order = $order->createOrder($subscription, $user);

        Bus::chain([
        new CreateMigrationJob($subscription, $this->amount, $this->billing_period, $this->term, $this->newterm, $order)])
        ->catch(function (Throwable $e) use($order){
            $order->details = ('Error migration subscription: '.$e->getMessage());
            $order->save();
        })->dispatch();

        $subscription->markAsDisabled();
        $this->emit('refreshTransactions');

    }

    public function manageSchedule(Subscription $subscription){
        $this->showEditModal = true;
        $this->ScheduleEdit = true;
        $this->quantity = $subscription->amount;
        $this->upgradeOffers = $subscription->productonce->upgrade_target_offers->map(function ($item, $key) use($subscription) {
            return Product::where('sku', $item)->where('catalog_item_id', '!=' ,$subscription->product_id)->first();
        })->filter();
    }

    public function validateisEligible(Subscription $subscription){
        $this->tt = $this->subscription->validatemigration($subscription->customer, $subscription);
        $this->isLoading = false;
        $this->emit('refreshTransactions');
    }

    public function CheckMigrationSubscription(Subscription $subscription){
        $migrations = Ncemigration::where('new_subscription_id', $subscription->id)->first();
        $tt = $this->subscription->CheckMigrationSubscription($subscription->customer, $migrations);

        $subscription->subscription_id = $tt['newCommerceSubscriptionId'];
        $subscription->expiration_data = $tt['subscriptionEndDate'];
        $subscription->term= $tt['termDuration'];
        $subscription->save();

        $migrations->completedTime             = $tt['completedTime'];
        $migrations->newCommerceSubscriptionId = $tt['newCommerceSubscriptionId'];
        $migrations->status                    = $tt['status'];
        $migrations->save();
        $this->emit('refreshTransactions');
    }

    public function mount(){
        $this->autorenew = $this->subscription->autorenew;
        $this->amount = $this->subscription->amount;
        $this->max_quantity = $this->subscription->products->where('instance_id', $this->subscription->instance_id)->first()->maximum_quantity ?? null;
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

    public function cancel(Subscription $subscription){

        $this->showcancelconfirmationModal = false;
        $subscription->cancel();
        $this->notify('Subscription ' . $subscription->name . ' was canceled, refresh page');
        Notification::send($subscription->customer->users->first(), new SubscriptionUpdate($subscription));
        Log::info('Status changed: canceled');
        $this->emit('refreshTransactions');

    }

    public function render(){
        $subscription = $this->subscription;
        return view('livewire.subscription.show-subscription', compact('subscription'));
    }
}
