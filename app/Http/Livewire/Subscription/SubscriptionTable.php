<?php

namespace App\Http\Livewire\Subscription;

use App\Subscription;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Exports\SubscriptionsExport;
use Maatwebsite\Excel\Facades\Excel;
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

    public $search = '';
    public $quantity = '';
    public $addons = '';
    public $tt;
    public $subscription;

    public $autorenew;
    public $max_quantity = '999999999';
    public $min_quantity = '1';
    public $upgradeOffers;
    public $expirationdate;
    public $upgradeOfferselected;
    public $showEditModal = false;
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

    public function edit(Subscription $subscription){
        $this->subscription     = $subscription;
        $this->showEditModal    = true;
        $this->min_quantity     = $subscription->productonce->minimum_quantity;
        $this->max_quantity     = $subscription->productonce->maximum_quantity;
        $this->editing          = $subscription;
    }

    public function save(){

        $this->showEditModal = false;
        DB::beginTransaction();
        $before = $this->subscription->amount;

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
