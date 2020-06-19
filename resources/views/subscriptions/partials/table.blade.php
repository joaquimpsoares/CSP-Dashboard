
<div class="container col-xm-12">
    <section class="dark-grey-text">
        <table class="table table-hover " id="subscriptions">
            <thead class="thead-dark">
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
    </section>
</div>

<script type="text/javascript">
    $(document).ready( function () {
        $('#subscriptions').DataTable({
            "pagingType": "full_numbers",
            "order": [[ 0, "asc" ]]
        });
    } );
</script>