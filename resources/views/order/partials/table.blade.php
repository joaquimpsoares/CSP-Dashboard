<div class="container col-xm-12">
    <section class="dark-grey-text">
        <table class="table table-hover responsive" id="order">
            <thead class="thead-dark">
                <tr>
                    <th>{{ ucwords(trans_choice('messages.avatar', 1)) }}</th>
                    <th>{{ ucwords(trans_choice('messages.company_name', 1)) }}</th>
                    <th>{{ ucwords(trans_choice('messages.order_details', 1)) }}</th>
                    <th>{{ ucwords(trans_choice('messages.comments', 1)) }}</th>
                    <th>{{ ucwords(trans_choice('messages.placed_on', 1)) }}</th>
                    <th>{{ ucwords(trans_choice('messages.last_updated', 1)) }}</th>
                    <th>{{ ucwords(trans_choice('messages.status', 1)) }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)  
                <tr>
                    <td><img src="{{$order->user->avatar}}" alt="" width="50"></td>
                    <td>{{ $order->customer->company_name }}</td>
                    <td>{{ $order->details }}</td>
                    <td>{{ $order->status->comments }}</td>
                    <td>{{ $order->status->created_at }}</td>
                    <td>{{ $order->status->updated_at }}</td>
                    
                    @if ($order->order_status_id==4)
                    <td>    
                        <p><span class="badge badge-primary">{{ $order->status->name }}</span></p>
                    </td>
                    @endif
                    @if ($order->order_status_id==1)
                    <td>    
                        <p><span class="badge badge-info">{{ $order->status->name }}</span></p>
                    </td>
                    @endif
                    @if ($order->order_status_id==2)
                    <td>    
                        <p><span class="badge badge-success">{{ $order->status->name }}</span></p>
                    </td>
                    @endif
                    @if ($order->order_status_id==3)
                    <td>
                        <p><span class="badge badge-warning">{{ $order->status->name }}</span></p>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</div>




<script type="text/javascript">
    $(document).ready( function () {
        $('#order').DataTable({
            "pagingType": "full_numbers",
            "order": [[ 0, "asc" ]]
        });
    } );
</script>
{{-- <table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th></th>
            <th>Product Name:</th>
            <th>Quantity</th>
            <th>Billing Cycle</th>
            <th>Tenant Name</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td>{{$item['name']}}</td>
            <td>{{$item->pivot->quantity}}</td>
            <td>{{$item->pivot->billing_cycle}}</td>
            <td>{{$order->domain}}</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th>#</th>
        </tr>
    </tfoot>
</table> --}}
{{-- @foreach ($order->products as $item)
    <hr>
    <strong>Product Name:</strong> {{$item['name']}} <br>
    <strong>Quantity:</strong> {{$item->pivot->quantity}} <br>
    <strong>Billing Cycle</strong> {{$item->pivot->billing_cycle}} <br>
    <strong>Tenant Name</strong> {{$order->domain}} <br>
    @endforeach --}}
    {{-- </td> --}}