<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>


<table id="subscriptions" class="table display responsive nowrap" width="100%">
        <thead>
            <tr>
                <th>{{ ucwords(trans_choice('messages.#', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.subscription_name', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.company_name', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.quantity', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.expiration', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.billing_cycle', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.status', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.action', 1)) }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subscriptions as $subscription)
            <tr class="odd gradeX">
                <td width="1%" class="f-s-600"><a href="{{route('subscription.show', $subscription->id)}}">{{$subscription['id']}}</a></td>
                <td>{{$subscription->name}}</td>
                <td>{{$subscription->customer->company_name}}</td>
                <td>{{$subscription->amount}}</td>
                <td>{{$subscription->expiration_data}}</td>
                <td>{{$subscription->billing_period}}</td>
                <td class="align-middle">
                    <span class="badge badge-lg {{ $subscription->status->name = '  ' ? 'badge-success' : 'badge-danger' }}">
                        {{ ucwords(trans_choice('messages.active', 1)) }}
                    </span>
                </td>
                <td class="text-nowrap">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <script type="text/javascript">
        $(document).ready( function () {
            $('#subscriptions').DataTable({
                "pagingType": "full_numbers",
                "order": [[ 0, "asc" ]]
            });
        } );
    </script>