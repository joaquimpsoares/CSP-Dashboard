<div class="table-responsive">
    <table class="table table-striped table-bordered" id="resellers">
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
            @forelse($resellers as $reseller)
            @if($reseller['status'] === 'message.active')
            <tr>
                <td>
                    <a href="{{ $reseller['path'] }}">{{ $reseller['company_name'] }}</a>
                </td>
                <td>
                    {{ $reseller['country'] }}
                </td>
                <td>{{ $reseller['state'] }}</td>
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
</div>