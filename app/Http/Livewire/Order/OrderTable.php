<?php

namespace App\Http\Livewire\Order;

use App\Exports\OrdersExport;
use App\Order;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class OrderTable extends Component
{
    public function exportSelected()
    {
        return Excel::download(new OrdersExport, 'Providers.xlsx');
    }
    public function render()
    {
        $orders = Order::with(['customer', 'status'])->paginate(10);

        $orders->getCollection()->map(function(Order $order){
            $order->setRawAttributes(json_decode(json_encode($order->format()), true)); // Coverts to array recursively (make helper from it?)
            return $order;
        });
        return view('livewire.order.order-table',compact('orders'));
    }
}
