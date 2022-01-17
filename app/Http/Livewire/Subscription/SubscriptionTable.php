<?php

namespace App\Http\Livewire\Subscription;

use App\Order;
use Exception;
use App\Instance;
use App\Subscription;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Exports\SubscriptionsExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use Tagydes\MicrosoftConnection\Facades\Subscription as SubscriptionFacade;
use Tagydes\MicrosoftConnection\Models\Subscription as TagydesSubscription;

class SubscriptionTable extends Component
{
    use WithPagination;
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $search = '';
    public $quantity = '';
    public $addons = '';
    public $subscription;
    public $showEditModal = false;
    public $showFilters = false;
    public $selected = [];
    public $filters = [
        'search' => '',
        'status' => '',
        'amount-min' => null,
        'amount-max' => null,
        'date-min' => null,
        'date-max' => null,
    ];

    public Subscription $editing;


    public function updatingSearch(){$this->resetPage();}
    public function updatedFilters() { $this->resetPage(); }
    public function resetFilters() { $this->reset('filters'); }

    public function rules()
    {
        $max_quantity = $this->editing->productonce->where('instance_id', $this->editing->instance_id)->first()->maximum_quantity;
        $min_quantity = $this->editing->productonce->where('instance_id', $this->editing->instance_id)->first()->minimum_quantity;

        return [
            'editing.name'              => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
            'editing.amount'            => ['required', 'integer', 'max:'.$max_quantity, 'min:'.$min_quantity],
            'editing.billing_period'    => ['required'],
            'editing.autorenew'         => ['required', 'boolean'],
            'editing.status_id'         => ['required', 'exists:statuses,id'],
        ];
    }

    public function addAddon($addon, Subscription $subscription)
    {
        $instance = Instance::where('id', $subscription->instance_id)->first();
        $subscription = new TagydesSubscription([
            'id'                => $subscription->subscription_id,
            'orderId'           => $subscription->order_id,
            'offerId'           => $addon,
            'customerId'        => $subscription->customer->microsoftTenantInfo->first()->tenant_id,
            'name'              => $subscription->name,
            'status'            => $subscription->status_id,
            'quantity'          => $this->quantity,
            'PartnerIdOnRecord' => $subscription->msrpid,
            'currency'          => $subscription->currency,
            'billingCycle'      => $subscription->billing_period,
            'created_at'        => $subscription->created_at->__toString(),
            ]);
            try {
                $order = $this->createOrderFromCart($subscription);

                foreach ($cart->products as $product)
                {
                    $order->products()->attach($product->id, [
                        'price' => $product->pivot->price,
                        'retail_price' => $product->pivot->retail_price,
                        'billing_cycle' => $product->pivot->billing_cycle,
                        'id' => Str::uuid(),
                        'quantity' => $product->pivot->quantity
                    ]);
                }

                $cart->delete();

                DB::commit();

            } catch (\PDOException $e) {
                DB::rollBack();
                return false;
            }


        return $order;
        try{
            $update = SubscriptionFacade::withCredentials($instance->external_id, $instance->external_token)->
            AddAddonToSubscription($subscription, ['quantity' => $this->quantity]);

            // $subscription->update(['amount'=> $this->quantity]);
            Log::info('License changed: '.$update);
            Log::info('License changed: '.$this->quantity);
            // $order->update(['order_status_id'=> 4]);
        } catch (Exception $e) {
            Log::info('Error Placing order to Microsoft: '.$e->getMessage());
            // $order->update(['order_status_id'=> 3]);
            return Redirect::back()->with('danger','Error Placing order to Microsoft: '.$e->getMessage());
        }

    }


    public function edit(Subscription $subscription)
    {
        $this->showEditModal    = true;
        $this->min_quantity     = $subscription->productonce->minimum_quantity;
        $this->max_quantity     = $subscription->productonce->maximum_quantity;
        $this->editing          = $subscription;
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

    public function exportSelected()
    {
        return Excel::download(new SubscriptionsExport, 'Subscriptions.xlsx');
    }

    public function deleteSelected()
    {
        $deleteCount = $this->selectedRowsQuery->count();

        $this->selectedRowsQuery->delete();

        $this->showDeleteModal = false;

        $this->notify('You\'ve deleted '.$deleteCount.' transactions');
    }

    public function getRowsQueryProperty()
    {
        $query = Subscription::query();
        $subscriptions = $query
            ->when($this->filters['status'], fn($query, $status) => $query->where('status_id', $status))
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

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.subscription.subscription-table', [
            'subscriptions' => $this->rows,
        ]);
    }
}
