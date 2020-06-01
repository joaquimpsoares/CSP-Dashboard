<div class="table-responsive nowrap">
    <table id="myTable" class="table" width="100%">
        <thead>
            <tr>
                <th>{{ ucwords(trans_choice('messages.company_name', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.country', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.state', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.city', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.action', 1)) }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
            @if($customer['status'] === 'message.active')
            <tr>
                <td>
                    <a href="{{ $customer['path'] }}">{{ $customer['company_name'] }}</a>
                </td>
                <td>{{ $customer['country'] }}</td>
                <td>{{ $customer['state'] }}</td>
                <td>{{ $customer['city'] }}</td>
                {{-- @foreach ($reseller as $item)
                <td>{{ $item->company_name }} </td>
                @endforeach --}}
                {{-- @endif --}}
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

<script>
    $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>