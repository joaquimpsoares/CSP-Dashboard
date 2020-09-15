<div class="container col-xm-12">
    <section class="dark-grey-text">
        <table class="table table-hover responsive" id="customer">
            <thead class="thead-dark">
                <tr>
                    <th>{{ ucwords(trans_choice('messages.#', 1)) }}</th>
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
                {{-- @if($customer['status'] === 'messages.active') --}}
                <tr>
                    <td width="3%" class="f-s-600"><a href="{{ $customer['path'] }}">{{ $customer['id'] }}</a></td>
                    <td><a href="{{ $customer['path'] }}">{{ $customer['company_name'] }}</a></td>
                    <td>{{ $customer['reseller']['company_name'] }}</td>
                    <td>{{ $customer['subscriptions'] }}</td>
                    <td>{{ $customer['state'] }}</td>
                    <td>{{ $customer['city'] }}</td>
                    <td style="width: 150px">
                        @include('partials.actions', ['model' => $customer, 'modelo' => 'customer'])
                    </td>
                </tr>
                {{-- @endif --}}
                @empty
                <tr>
                    <td colspan="5">Empty</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </section>
</div>

<script type="text/javascript">
    $(document).ready( function () {
        $('#customer').DataTable({
            "pagingType": "full_numbers",
            "order": [[ 0, "asc" ]]
        });
    } );
</script>