
<section class="dark-grey-text">
    <table class="table table-hover responsive" id="providers">
        <thead class="thead-dark">
            <tr>
                <th>{{ ucwords(trans_choice('messages.company_name', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.reseller', 2)) }}</th>
                
                <th>{{ ucwords(trans_choice('messages.country', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.city', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.action', 1)) }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($providers as $provider)
            @if($provider['status'] === 'message.active')
            <tr>
                <td><a href="{{ $provider['path'] }}">{{ $provider['company_name'] }}</a></td>
                <td> {{$provider['resellers']->count()}} </td>
                <td>{{ $provider['country'] }}</td>
                <td>{{ $provider['city'] }}</td>
                <td style="width: 150px">
                    @include('partials.actions', ['model' => $provider, 'modelo' => 'provider'])
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
</section>

<script type="text/javascript">
    $(document).ready( function () {
        $('#providers').DataTable({
            "pagingType": "full_numbers",
            "order": [[ 0, "asc" ]]
        });
    } );
</script>
