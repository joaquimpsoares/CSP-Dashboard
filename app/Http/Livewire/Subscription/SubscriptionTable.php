<?php

namespace App\Http\Livewire\Subscription;

use App\Subscription;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Livewire\DataTable\WithSorting;
use App\Exceptions\UpdateSubscriptionException;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;

class SubscriptionTable extends Component
{
    use WithPagination;
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $showEditModal = false; // legacy (modal)
    public $search = '';
    public $quantity = '';
    public $addons = '';
    public $tt;
    public $subscription;

    // New UI: inline collapsible edit per subscription
    public ?int $openRowId = null;

    // Policy decision shown in UI when editing a row
    public ?array $policyDecision = null;

    public $autorenew;
    public $max_quantity = '999999999';
    public $min_quantity = '1';
    public $upgradeOffers;
    public $expirationdate;
    public $upgradeOfferselected;
    public $showFilters = false;

    public $selected = [];
    public $filters = [
        'status' => '',
        'amount-min' => null,
        'amount-max' => null,
        'date-min' => null,
        'date-max' => null,
        'abouttoexpire' => null,
        'perpetual' => null,
        'nce' => null,
        'legacy' => null,
    ];

    public Subscription $editing;

    protected $listeners = ['refreshTransactions' => '$refresh'];
    public function updatingSearch(){$this->resetPage();}
    public function updatedFilters(){ $this->resetPage(); }

    public function resetFilters(){
        $this->resetPage();
        $this->reset('filters');
    }


    public function rules(){
        if ($this->subscription->productonce){
            $max_quantity = $this->subscription->productonce->where('instance_id', $this->subscription->instance_id)->first()->maximum_quantity;
            $min_quantity = $this->subscription->productonce->where('instance_id', $this->subscription->instance_id)->first()->minimum_quantity;
        }else{
            $max_quantity = 1;
            $min_quantity = 1;
        }
        if($this->subscription->productonce != null){
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

    public function edit(Subscription $subscription)
    {
        // Inline edit (collapsible): keep one active editing model.
        $this->subscription = $subscription;
        $this->editing = $subscription;
        $this->policyDecision = null;

        $this->min_quantity = $subscription->productonce?->minimum_quantity ?? 1;
        $this->max_quantity = $subscription->productonce?->maximum_quantity ?? 1;

        $this->openRowId = (int) $subscription->id;
        $this->showEditModal = false;

        $this->evaluatePolicy();
    }

    public function closeEdit(): void
    {
        $this->openRowId = null;
        $this->showEditModal = false;
        $this->policyDecision = null;
    }

    public function updatedEditingAmount(): void
    {
        $this->evaluatePolicy();
    }

    public function updatedEditingBillingPeriod(): void
    {
        $this->evaluatePolicy();
    }

    public function updatedEditingTerm(): void
    {
        $this->evaluatePolicy();
    }

    private function evaluatePolicy(): void
    {
        if (!$this->editing?->id) {
            $this->policyDecision = null;
            return;
        }

        // Only enforce NCE guardrails when the product is NCE.
        if (!$this->editing->productonce || !$this->editing->productonce->IsNCE()) {
            $this->policyDecision = ['allowed' => true, 'mode' => 'immediate', 'reason_message' => null];
            return;
        }

        // Determine which field(s) changed and choose the most restrictive type.
        // billing/term always schedule; quantity may be immediate or scheduled.
        $original = $this->editing->getOriginal();
        $billingChanged = ($this->editing->billing_period ?? null) !== ($original['billing_period'] ?? null);
        $termChanged    = ($this->editing->term ?? null) !== ($original['term'] ?? null);
        $quantityChanged = (int) ($this->editing->amount ?? 0) !== (int) ($original['amount'] ?? 0);

        // Decide change type: billing > term > quantity (most to least restrictive)
        if ($billingChanged) {
            $changeRequest = [
                'type'              => 'billing',
                'new_billing_cycle' => (string) $this->editing->billing_period,
            ];
        } elseif ($termChanged) {
            $changeRequest = [
                'type'              => 'term',
                'new_term_duration' => (string) $this->editing->term,
            ];
        } else {
            $changeRequest = [
                'type'         => 'quantity',
                'new_quantity' => (int) $this->editing->amount,
            ];
        }

        try {
            $pc = $this->editing->getSubscription($this->editing->customer, $this->editing);
            $pcArr = $pc instanceof \Illuminate\Support\Collection ? $pc->toArray() : (is_array($pc) ? $pc : []);

            /** @var \App\Services\MicrosoftCsp\Policies\NceSubscriptionPolicy $policy */
            $policy = app(\App\Services\MicrosoftCsp\Policies\NceSubscriptionPolicy::class);

            $this->policyDecision = $policy->evaluate($this->editing, $pcArr, $changeRequest);
        } catch (\Throwable $e) {
            // Conservative default: schedule.
            $this->policyDecision = [
                'allowed'       => true,
                'mode'          => 'schedule',
                'reason_code'   => 'PC_FETCH_FAILED',
                'reason_message'=> 'Unable to confirm change window. Schedule for renewal instead.',
            ];
        }
    }

    public function scheduleForRenewal(): void
    {
        if (!$this->editing?->id) {
            return;
        }

        // Use the payload recommended by the policy decision when available;
        // fall back to deriving it from the editing model's current state.
        $payload     = $this->policyDecision['suggested_action']['payload'] ?? [];
        $changeType  = $this->policyDecision['suggested_action']['type'] ?? 'quantity';

        if (empty($payload)) {
            // Derive payload from what the user changed.
            $original        = $this->editing->getOriginal();
            $billingChanged  = ($this->editing->billing_period ?? null) !== ($original['billing_period'] ?? null);
            $termChanged     = ($this->editing->term ?? null) !== ($original['term'] ?? null);

            if ($billingChanged) {
                $changeType = 'billing';
                $payload    = ['billingCycle' => (string) $this->editing->billing_period];
            } elseif ($termChanged) {
                $changeType = 'term';
                $payload    = ['termDuration' => (string) $this->editing->term];
            } else {
                $changeType = 'quantity';
                $payload    = ['quantity' => (int) $this->editing->amount];
            }
        }

        try {
            $scheduler   = app(\App\Services\MicrosoftCsp\ScheduledChangesService::class);
            $apiResponse = $scheduler->schedule($this->editing, $payload);

            \App\Models\SubscriptionScheduledChange::create([
                'subscription_id'      => $this->editing->id,
                'provider_id'          => $this->editing->provider_id ?? null,
                'customer_id'          => $this->editing->customer_id ?? null,
                'pc_subscription_id'   => $this->editing->subscription_id,
                'type'                 => $changeType,
                'payload'              => $payload,
                'status'               => 'pending',
                'effective_date'       => $this->editing->expiration_data ?? null,
                'requested_by_user_id' => auth()->id(),
                'requested_by_email'   => auth()->user()?->email,
                'policy_decision'      => $this->policyDecision,
                'api_response'         => $apiResponse,
            ]);

            $this->notify('', 'Scheduled for renewal', 'success');
            $this->closeEdit();
        } catch (\Throwable $e) {
            $this->notify('', 'Scheduling failed: ' . $e->getMessage(), 'error');
        }
    }

    public function save(){

        // Enforce NCE quantity guardrails before applying changes.
        if (($this->policyDecision['mode'] ?? null) === 'schedule') {
            $this->notify('', $this->policyDecision['reason_message'] ?? 'This change must be scheduled for renewal.', 'error');
            return;
        }
        if (($this->policyDecision['mode'] ?? null) === 'blocked') {
            $this->notify('', $this->policyDecision['reason_message'] ?? 'This change is blocked.', 'error');
            return;
        }

        $this->showEditModal = false;
        $before = $this->editing->getOriginal('amount');
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
                $update =$this->editing->changeAmount($this->editing->amount, $this->editing->autorenew, $before);
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
                $this->editing->update([
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

        $this->showEditModal = false;
        $fields = collect($this->editing->getChanges())->except(['updated_at','refundableQuantity','expiration_data','CancellationAllowedUntil']);
        $this->notify('You\'ve updated '.  $fields .' Subscription');
        $this->emit('refreshTransactions');
        $this->closeEdit();
    }

    public function exportSelected(){
        return response()->streamDownload(function () {
        echo $this->selectedRowsQuery->toCsv();
        }, 'Subscriptions.csv');
    }

    public function deleteSelected(){
        $deleteCount = $this->selectedRowsQuery->count();
        $this->selectedRowsQuery->delete();
        $this->showDeleteModal = false;
        $this->notify('You\'ve deleted '.$deleteCount.' transactions');
    }

    public function legacy(){
        $this->resetFilters();
        $this->filters['legacy'] = true;
        $this->expirationdate = $this->filters['abouttoexpire'];
    }

    public function expiration(){
        $this->resetFilters();
        $this->filters['abouttoexpire'] = 30;
    }

    public function perpetual(){
        $this->resetFilters();
        $this->filters['perpetual'] = true;
    }

    public function nce(){
        $this->resetFilters();
        $this->filters['nce'] = true;
    }

    public function getRowsQueryProperty(){
        $query = Subscription::query();
        $subscriptions = $query
            ->when($this->filters['status'], fn($query, $status) => $query->where('status_id', $status))
            ->when($this->filters['perpetual'], fn($query) => $query->whereHas('productonce', function(Builder $query){
                    $query->where('is_perpetual', true);
                }))
            ->when($this->filters['nce'], fn($query) => $query->whereHas('productonce', function(Builder $query){
                $query->where('productType', 'OnlineServicesNCE');
            }))
            ->when($this->filters['legacy'], fn($query) => $query->whereHas('productonce', function(Builder $query){
                $query->where('productType', 'Legacy');
            }))
            ->when($this->filters['abouttoexpire'], fn($query)
            => $query->where('expiration_data', '<=', Carbon::now()->subDays($this->expirationdate)->toDateTimeString()))
            ->when($this->filters['date-min'], fn($query, $date) => $query->where('expiration_data', '>=', Carbon::parse($date)))
            ->when($this->filters['date-max'], fn($query, $date) => $query->where('expiration_data', '<=', Carbon::parse($date)))
            ->where(function ($q)  {
                $q->where('name', "like", "%{$this->search}%");
                $q->orWhere('id', 'like', "%{$this->search}%");
                $q->orWhere('billing_period', 'like', "%{$this->search}%");
                $q->orwhereHas('customer', function(Builder $q){
                    $q->where('company_name', 'like', "%{$this->search}%");
                });
            });
            return $this->applySorting($subscriptions);
    }

    public function getRowsProperty(){
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render(){

        return view('livewire.subscription.subscription-table', [
            'subscriptions' => $this->rows,
        ]);
    }
}
