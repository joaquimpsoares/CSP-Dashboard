@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection

<section class="dark-grey-text">
    <div class="">
        <div class="table-responsive">
            <table id="example1" class="table table-bordered text-nowrap key-buttons">
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
                    {{-- $order) --}}
                    <tr>
                        <td><img src="{{$order['avatar']['avatar']}}" alt="" width="50"></td>
                        @if (!@empty($order['customer']->company_name))
                        <td>{{ $order['customer']->company_name }}</td>
                        @else
                        <td></td>
                        @endif
                        <td>{{ $order['details'] }}</td>
                        <td>{{ $order['comments'] }}</td>
                        <td>{{ $order['created_at'] }}</td>
                        <td>{{ $order['updated_at'] }}</td>
                        @if ($order['status']['id']==4)
                        <td>
                            <p><span class="badge badge-primary">{{ $order['status']['name'] }}</span></p>
                        </td>
                        @endif
                        @if ($order['status']['id']==1)
                        <td>
                            <p><span class="badge badge-info">{{ $order['status']['name'] }}</span></p>
                        </td>
                        @endif
                        @if ($order['status']['id']==2)
                        <td>
                            <p><span class="badge badge-success">{{ $order['status']['name'] }}</span></p>
                        </td>
                        @endif
                        @if ($order['status']['id']==3)
                        <td>
                            <p><span class="badge badge-warning">{{ $order['status']['name'] }}</span></p>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
