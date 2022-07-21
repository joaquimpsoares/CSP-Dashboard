<?php

namespace App\Http\Livewire\Subscription;

use App\News;
use App\Subscription;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Livewire\DataTable\WithPerPagePagination;

class SubscriptionCostumer extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public Subscription $editing;
    public $showEditModal = false;
    public $subs;
    public $search = '';

    public $showconfirmationModal = false;
    public $max_quantity = '999999999';
    public $min_quantity = '1';
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


    public function rules(){
        return [
            'editing.name'              => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
            'editing.amount'            => ['required', 'numeric','max:'.$this->max_quantity, 'min:'.$this->min_quantity],
            'editing.billing_period'    => ['required'],
            'editing.autorenew'         => ['required', 'boolean'],
            'editing.status_id'         => ['required', 'exists:statuses,id'],
        ];
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function edit(Subscription $subs){
        $this->showEditModal = true;
        $this->min_quantity = $subs->product->minimum_quantity;
        $this->max_quantity = $subs->product->maximum_quantity;
        $this->editing      = $subs;
    }

    public function save(){

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

    public function disable(Subscription $subscription){

        $this->showconfirmationModal = false;
        $subscription->suspend();
        $this->emit('refreshTransactions');
    }

    public function enable(Subscription $subscription){
        $subscription->active();
        $this->notify('Subscription ' . $subscription->name . ' is Active, refresh page');
        // Notification::send($subscription->customer->users->first(), new SubscriptionUpdate($subscription));
        Log::info('Status changed: Enabled');
        $this->emit('refreshTransactions');
    }

    public function resetFilters(){
        $this->resetPage();
        $this->reset('filters');
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
        $news = News::orderBy('id', 'DESC')->take(2)->get();
        return view('livewire.subscription.subscription-costumer',[
            'subscriptions' => $this->rows,
        ]);
    }
}
