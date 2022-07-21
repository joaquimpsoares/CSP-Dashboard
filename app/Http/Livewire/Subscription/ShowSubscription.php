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
use Illuminate\Support\Collection;
use App\Notifications\SubscriptionUpdate;
use Illuminate\Support\Facades\Notification;
use App\Exceptions\UpdateSubscriptionException;
use Tagydes\MicrosoftConnection\Models\Product as TagydesProduct;
use Tagydes\MicrosoftConnection\Facades\Product as MicrosoftProduct;
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

    public int $amount2 = 4;
    public int $offset = 0;
    public Collection $orders;

    public bool $showLoadMoreButton;

    public $subs;
    public $subscription;
    public $autorenew;
    public $max_quantity = '999999999';
    public $min_quantity = '1';
    public $upgradeOffers;
    public $upgradeOfferselected = 'no change';

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
        $this->ScheduleEdit     = false;
        $this->showEditModal    = true;
        $this->min_quantity     = $subs->productonce->minimum_quantity;
        $this->max_quantity     = $subs->productonce->maximum_quantity;
        $this->editing          = $subs;
    }

    public function save(){

        $this->showEditModal = false;

        DB::beginTransaction();

        $amountBefore = $this->editing->getOriginal('amount');
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
                    $this->editing->updateQuietly([
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

        /* Changes in amount of licenses for subscription*/
        if(collect($this->editing->getChanges())->has('amount')){

            if($this->editing->autorenew == 1){
                $this->editing->autorenew = true;
            }else{
                $this->editing->autorenew = false;
            }

            try {
                $update =$this->editing->changeAmount($this->editing->amount, $this->editing->autorenew, $amountBefore);
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
            if($update)
            {
                $this->editing->updateQuietly([
                    'refundableQuantity' => [$update->refundableQuantity],
                    'CancellationAllowedUntil' => $update->CancellationAllowedUntil,
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

        if($this->ScheduleEdit == true){
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

        }

        $fields = collect($this->editing->getChanges())->except(['updated_at','refundableQuantity','expiration_data','CancellationAllowedUntil']);
        $this->notify('You\'ve updated '.  $fields .' Subscription');
        $this->emit('refreshTransactions');
    }

    public function manageSchedule(Subscription $subscription){

        $this->upgradeOffers = $subscription->productonce->upgrade_target_offers->map(function ($item, $key) use($subscription) {
            return Product::where('sku', $item)->where('sku', '!=' ,$subscription->product_id)->first();
        })->filter();

        $this->editing = $subscription;
        $this->quantity = $subscription->amount;

        if($subscription->changes_on_renew != null){
            $product = Str::of($subscription->changes_on_renew['product_id'])->explode(':');
            $this->upgradeOfferselected = Product::where('sku', $product[0].':'.$product[1])->first();
            $this->editing = $subscription;
            $this->quantity = $subscription->changes_on_renew['amount'];
            $this->term = $subscription->changes_on_renew['term'];
            $this->billing_period = $subscription->changes_on_renew['billing_period'];
            $this->upgradeOfferselected = $this->upgradeOfferselected->name;
        }

        $this->showEditModal = true;
        $this->ScheduleEdit = true;

    }

    public function saveScheduled(){
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

        $country = $this->subscription->customer->country->iso_3166_2;


        try {
            if($this->upgradeOfferselected != 'no change'){

                $sku = strtok($this->upgradeOfferselected, ':');
                $id = substr($this->upgradeOfferselected, strpos($this->upgradeOfferselected, ":") + 1);

                $catalogItemId = MicrosoftProduct::withCredentials($instance->external_id, $instance->external_token)->getPerpetualCatalogItemIdNCE($country,$sku,$id);
                Log::info('catalogItemId: ' . $catalogItemId);
                $catalogitemid = $catalogItemId;
            }
            $tt =  SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token)->updateOnRenew($subscription, [
                'product' => $catalogitemid ?? $this->editing->catalog_item_id,
                'billingCycle' => $this->billing_period,
                'quantity' => $this->quantity,
                'termDuration' => $this->term ?? $this->editing->term,
            ]);

            if ($tt->has('code') && $tt['code'] == 900212){
                $this->notify('',$tt['description'], 'error');
            }

            if($tt->contains('scheduledNextTermInstructions') ){
                $this->notify('',"Scheduled successfully", 'success');
                $this->editing->updateQuietly(['changes_on_renew' => [
                    'amount' => $this->quantity,
                    'billing_period' => $this->billing_period,
                    'term' => $this->term,
                    'product_id' => $catalogitemid ?? $this->editing->catalog_item_id,
                    'catalog_item_id' => $catalogitemid ?? $this->editing->catalog_item_id,
                    ]]);
            }
        } catch (\PDOException $e) {
            $this->notify('',$e->getMessage(), 'error');
        }
        $this->showEditModal = false;
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
                    $this->editing->updateQuietly([
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
                $this->editing->updateQuietly([
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
        $details = 'Migrating ' . $subscription->name .'to MCE';
        $order = new Order();
        $order = $order->createOrder($subscription, $user, $details);

        Bus::chain([
        new CreateMigrationJob($subscription, $this->amount, $this->billing_period, $this->term, $this->newterm, $order)])
        ->catch(function (Throwable $e) use($order){
            $order->errors = ('Error migration subscription: '.$e->getMessage());
            $order->order_status_id = 3;
            $order->save();
        })->dispatch();

        $subscription->markAsDisabled();
        $this->emit('refreshTransactions');
        $this->notify('','Order Placed', 'info');
        return redirect('/order');
    }

    public function validateisEligible(Subscription $subscription){
        $this->tt = $this->subscription->validatemigration($subscription->customer, $subscription)->collect();
        if($this->subscription->product->IsNce()){
            $return = $this->subscription->getSubscription($subscription->customer, $subscription);
            $subscription->updateQuietly([
                'refundableQuantity'        => [$return['refundableQuantity']] ?? null,
                'expiration_data'           => date('Y-m-d', strtotime($return['commitmentEndDate'])),
                'CancellationAllowedUntil'  => $return['cancellationAllowedUntilDate'],
            ]);
        }
        $this->isLoading = false;
        $this->emit('refreshTransactions');
    }

    public function getSubscription(Subscription $subscription){

        $return = $this->subscription->getSubscription($subscription->customer, $subscription);

        if ($return->first() == '1000'){
            return false;
        }
        if ($return->first() == '20002'){
            return false;
        }
        if(!is_null($return->first())){
            $subscription->updateQuietly([
                'expiration_data' => date('Y-m-d', strtotime($return['commitmentEndDate'])) ?? null,
            ]);
        }
        $this->emit('refreshTransactions');
    }

    public function removeScheduled(){
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

        $country = $this->subscription->customer->country->iso_3166_2;

        try {

            $tt =  SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token)->RemoveSchedule($subscription);

            if ($tt->has('code') && $tt['code'] == 900212){
                $this->notify('',$tt['description'], 'error');
            }

            if(!$tt->contains('scheduledNextTermInstructions') ){
                $this->notify('',"Scheduled removed successfully", 'success');
                $this->editing->updateQuietly(['changes_on_renew' => null]);
            }
        } catch (\PDOException $e) {
            $this->notify('',$e->getMessage(), 'error');
        }
        $this->showEditModal = false;
    }

    public function loadOrders(){
        $orders = Order::query()->orderBy('id', 'DESC')->where('subscription_id', $this->subscription->id)->offset($this->offset)->limit($this->amount2)->get();
        $this->orders = isset($this->orders) ? $this->orders->merge($orders) : $orders;
        $this->offset += $this->amount2;
        $this->showLoadMoreButton = Order::count() > $this->offset;
    }

    public function CheckMigrationSubscription(Subscription $subscription){
        $migrations = Ncemigration::where('new_subscription_id', $subscription->id)->first();
        $tt = $this->subscription->CheckMigrationSubscription($subscription->customer, $migrations);

        $subscription->subscription_id = $tt['newCommerceSubscriptionId'];
        $subscription->expiration_data = $tt['subscriptionEndDate'] ?? null;
        $subscription->term= $tt['termDuration'];
        $subscription->save();

        $migrations->completedTime             = $tt['completedTime'];
        $migrations->newCommerceSubscriptionId = $tt['newCommerceSubscriptionId'];
        $migrations->status                    = $tt['status'];
        $migrations->save();
        $this->emit('refreshTransactions');
    }

    public function mount(){
        $this->loadOrders();
        $this->autorenew = $this->subscription->autorenew;
        $this->amount = $this->subscription->amount;
        $this->max_quantity = $this->subscription->products->where('instance_id', $this->subscription->instance_id)->first()->maximum_quantity ?? null;
        $this->status = $this->subscription->status->name;
    }

    public function disable(Subscription $subscription){
        $this->showconfirmationModal = false;
        $subscription->suspend();
        // Notification::send($subscription->customer->users->first(), new SubscriptionUpdate($subscription));
        Log::info('Status changed: Disabled'. $subscription->id);
        $this->emit('refreshTransactions');
    }

    public function enable(Subscription $subscription){
        $subscription->active();
        $this->notify('Subscription ' . $subscription->name . ' is Active, refresh page');
        // Notification::send($subscription->customer->users->first(), new SubscriptionUpdate($subscription));
        Log::info('Status changed: Enabled'. $subscription->id);
        $this->emit('refreshTransactions');
    }

    public function cancel(Subscription $subscription){
        $this->showcancelconfirmationModal = false;
        $return = $subscription->cancel($this->subscription->customer,$this->subscription);
        if($return->has('code')){
            $this->notify('','Subscription ' . $subscription->name . 'failed to update' . $return['description'] ,'error');
            Log::info('Status changed: canceled'. $subscription->id);
        }
        else{
            $this->notify('','Subscription ' . $subscription->name . ' was canceled, refresh page');
            Log::info('Status changed: canceled'. $subscription->id);
        }
        // Notification::send($subscription->customer->users->first(), new SubscriptionUpdate($subscription));
        $this->emit('refreshTransactions');

    }

    public function render(){
        $subscription = $this->subscription;
        return view('livewire.subscription.show-subscription', compact('subscription'));
    }
}
