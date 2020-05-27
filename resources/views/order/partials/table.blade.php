<div class="table-responsive nowrap">
    <table id="paginationNumbers" class="table" width="100%">
        <thead>
            <tr>
                <th>{{ ucwords(trans_choice('messages.company_name', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.order_details', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.comments', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.placed_on', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.last_updated', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.status', 1)) }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $key => $order)  
            <tbody>
                <td>{{ $order->customer->company_name }}</td>
                <td> <strong>Product Name:</strong> {{$order->products[0]->name}} 
                    @foreach ($order->products as $item)
                    <strong>Quantity:</strong> {{$item->pivot->quantity}}
                    <strong>Billing Cycle</strong> {{$item->pivot->billing_cycle}}
                    <strong>Tenant Name</strong> {{$order->domain}}
                </td>
                    @endforeach
                    <td>{{ $order->status->comments }}</td>
                    <td>{{ $order->status->created_at }}</td>
                    <td>{{ $order->status->updated_at }}</td>
                    @if ($order->order_status_id==4)
                    <td>    <a class="button is-success is-rounded is-outlined is-small">{{ $order->status->name }}</a> </td>
                    @endif
                    @if ($order->order_status_id==1)
                    <td>    <a class="button is-success is-rounded is-outlined is-small">{{ $order->status->name }}</a> </td>
                    @endif
                    @if ($order->order_status_id==2)
                    <td>    <a class="button is-info is-rounded is-outlined is-loading is-small">{{ $order->status->name }}</a> </td>
                    @endif
                    @if ($order->order_status_id==3)
                    <td>    <a class="button is-danger is-rounded is-outlined is-small">{{ $order->status->name }}</a> </td>
                    @endif
                </tbody>
                @endforeach
        </tbody>
    </table>
</div>