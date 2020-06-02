    <table id="resellers" class="table" width="100%">
        <thead>
            <tr>
                <th>{{ ucwords(trans_choice('messages.company_name', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.customer', 2)) }}</th>
                <th>{{ ucwords(trans_choice('messages.country', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.city', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.action', 1)) }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($resellers as $reseller)
            @if($reseller['status'] === 'message.active')
            <tr>
                <td><a href="{{ $reseller['path'] }}">{{ $reseller['company_name'] }}</a></td>
                <td>{{ $reseller['customers'] }}</td>
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
    
    @section('scripts')
    <script type="text/javascript">
        $(document).ready( function () {
            $('#resellers').DataTable({
                "pagingType": "full_numbers",
                "order": [[ 0, "asc" ]]
            });
        } );
    </script>
    @endsection
