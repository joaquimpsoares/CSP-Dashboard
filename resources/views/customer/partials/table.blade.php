<section class="dark-grey-text">
    <div class="card">
        <div class="card-body">
            <table id="customer" class="table display responsive nowrap" width="100%">
                <thead>
                    <tr>
                        <th>{{ ucwords(trans_choice('messages.company_name', 1)) }}</th>
                        <th>{{ ucwords(trans_choice('messages.reseller', 2)) }}</th>
                        <th>{{ ucwords(trans_choice('messages.subscription', 2)) }}</th>
                        <th>{{ ucwords(trans_choice('messages.state', 1)) }}</th>
                        <th>{{ ucwords(trans_choice('messages.city', 1)) }}</th>
                        <th>{{ ucwords(trans_choice('messages.action', 1)) }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    @if($customer['status'] === 'message.active')
                    <tr>
                        <td><a href="{{ $customer['path'] }}">{{ $customer['company_name'] }}</a></td>
                        <td>{{ $customer['reseller']['company_name'] }}</td>
                        <td>{{ $customer['subscriptions'] }}</td>
                        <td>{{ $customer['state'] }}</td>
                        <td>{{ $customer['city'] }}</td>
                        <td style="width: 150px">
                            @include('partials.actions', ['model' => $customer, 'modelo' => 'customer'])
                        </td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="5">Empty</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $('#customer').DataTable();
    } );
</script>