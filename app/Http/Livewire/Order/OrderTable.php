<?php

namespace App\Http\Livewire\Order;

use App\Order;
use Livewire\Component;
use Stripe\StripeClient;
use Livewire\WithPagination;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;

class OrderTable extends Component
{
    use WithPerPagePagination, WithSorting, WithBulkActions, WithCachedRows;

    public $search = '';
    public $order;
    public $showEditModal = false;

    public function updatingSearch(){$this->resetPage();}


    public function exportSelected()
    {
        return Excel::download(new OrdersExport, 'Orders.xlsx');
    }

    public function show(Order $order)
    {
        $this->order = $order;
        $this->showEditModal = true;
    }

    public function getRowsQueryProperty()
    {
        $query = Order::query()->orderBy('id', 'DESC');

        $orders = $query
        ->where(function ($q)  {
            $q->where('details', "like", "%{$this->search}%");
            $q->orWhere('id', 'like', "%{$this->search}%");
            $q->orwhereHas('customer', function(Builder $q){
                $q->where('company_name', 'like', "%{$this->search}%");
            });
        })->
        with(['customer', 'status', 'orderproduct', 'products']);

        return $this->applySorting($orders);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }
    public function render()
    {
        $stripe = new \Stripe\StripeClient(
            'sk_test_UOBjZFg9i8X3VZ5BsSKV6z1R00Gv19nybH'
          );
        $tt =  $stripe->accounts->create([
            'type' => 'custom',
            'country' => 'US',
            'email' => 'jenny.rosen@example.com',
            'capabilities' => [
              'card_payments' => ['requested' => true],
              'transfers' => ['requested' => true],
            ],
            'business_type' => 'company',
          ]);
dd($tt);

        
        return view('livewire.order.order-table', [
            'orders' => $this->rows,
        ]);
    }
}
