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

    public function resendtoMicrosoft(Order $order){
        if($order->status->id == 3 || $order->status->id == 1){
            $order->markAsRunning();
            $order->sendToMicrosoft();
            $this->notify('','Order Resent to Microsoft Successfully','success');
        }
    }

    public function markCompleted(Order $order){
        $order->markAsCompleted();
        $this->notify('','Order changed status to Completed','success');
    }

    public function markFailed(Order $order){
        $order->markAsFailed();
        $this->notify('','Order changed status to Failed','success');
    }



    public function getRowsQueryProperty()
    {
        $query = Order::query();
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



    public function getRowsProperty(){
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
//         $stripe = new \Stripe\StripeClient(
//             'sk_test_UOBjZFg9i8X3VZ5BsSKV6z1R00Gv19nybH'
//           );
//         $tt =  $stripe->accounts->create([
//             'type' => 'express',
//             'country' => 'PT',
//             'email' => 'jenny.rosen2@example.com',
//             'capabilities' => [
//               'card_payments' => ['requested' => true],
//               'transfers' => ['requested' => true],
//             ],
//             'business_type' => 'company',
//           ]);
// dd($tt->id);

        return view('livewire.order.order-table', [
            'orders' => $this->rows,
        ])->extends('layouts.master');
    }
}
