
<table id="order" class="display responsive nowrap" width="100%">
    <thead>
        <tr>
            <th></th>
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
        <tbody>
            <td><img src="{{$order->user->avatar}}" alt="" width="50"></td>
            <td>{{ $order->customer->company_name }}</td>
            <td>
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
                @foreach ($order->products as $item)
                <hr>
                <strong>Product Name:</strong> {{$item['name']}} <br>
                <strong>Quantity:</strong> {{$item->pivot->quantity}} <br>
                <strong>Billing Cycle</strong> {{$item->pivot->billing_cycle}} <br>
                <strong>Tenant Name</strong> {{$order->domain}} <br>
                @endforeach
            </td>
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

<script>

$(document).ready(function() {
    $('#order').DataTable( {
        responsive: {
            details: {
                renderer: function ( api, rowIdx, columns ) {
                    var data = $.map( columns, function ( col, i ) {
                        return col.hidden ?
                            '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                '<td>'+col.title+':'+'</td> '+
                                '<td>'+col.data+'</td>'+
                            '</tr>' :
                            '';
                    } ).join('');
 
                    return data ?
                        $('<table/>').append( data ) :
                        false;
                }
            }
        }
    } );
} );
</script>
