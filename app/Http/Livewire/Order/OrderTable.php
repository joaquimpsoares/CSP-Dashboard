<?php

namespace App\Http\Livewire\Order;

use App\Order;
use Livewire\Component;
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

        $orders = $query->orderBy('id', 'DESC')
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
        return view('livewire.order.order-table', [
            'orders' => $this->rows,
        ]);
    }
}
