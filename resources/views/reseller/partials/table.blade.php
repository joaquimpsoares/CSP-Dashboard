<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>


<table id="reseller" class="table display responsive nowrap"  width="100%">
    <thead>
        <tr>
            <th>{{ ucwords(trans_choice('messages.company_name', 1)) }}</th>
            <th>{{ ucwords(trans_choice('messages.customer', 2)) }}</th>
            <th>{{ ucwords(trans_choice('messages.provider', 1)) }}</th>
            <th>{{ ucwords(trans_choice('messages.country', 1)) }}</th>
            <th>{{ ucwords(trans_choice('messages.city', 1)) }}</th>
            <th>{{ ucwords(trans_choice('messages.action', 1)) }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse($resellers as $reseller)
        @if($reseller['status'] === 'message.active')
        <tr>
            {{-- {{dd($reseller['provider'])}} --}}
            <td><a href="{{ $reseller['path'] }}">{{ $reseller['company_name'] }}</a></td>
            <td>{{ $reseller['customers'] }}</td>
            <td>{{ $reseller['provider']['company_name'] }}</td>
            <td>{{ $reseller['country'] }}</td>
            <td>{{ $reseller['city'] }}</td>
            <td style="width: 150px">
                @include('partials.actions', ['model' => $reseller, 'modelo' => 'reseller'])
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

<script type="text/javascript">
    $(document).ready( function () {
        $('#reseller').DataTable({
            "pagingType": "full_numbers",
            "order": [[ 0, "asc" ]]
        });
    } );
</script>
