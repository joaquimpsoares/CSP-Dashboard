<div class="table-responsive nowrap">
    <table id="paginationNumbers" class="table" width="100%">
        <thead>
            <tr>
                <th>{{ ucwords(trans_choice('messages.#', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.subscription_name', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.company_name', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.quantity', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.expiration', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.billing_cycle', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.action', 1)) }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subscriptions as $subscription)
            
            {{-- @foreach ($customerSubscriptions as $subscription) --}}
            <tr class="odd gradeX">
                <td width="1%" class="f-s-600">{{$subscription['id']}}</td>
                <td>{{$subscription->name}}</td>
                <td>{{$subscription->customer->company_name}}</td>
                <td>{{$subscription->amount}}</td>
                <td>{{$subscription->expiration_data}}</td>
                <td>{{$subscription->billing_period}}</td>
                    <td class="align-middle">
                        {{-- <span class="badge badge-lg {{ $subscription->isActive() ? 'badge-success' : 'badge-danger' }}">
                            {{ trans("app.{$subscription->status}") }}
                        </span> --}}
                    </td>
                <td class="text-nowrap">
                    {{-- <a href="{{ route('subscriptions.edit', $subscription->id) }}" class="btn btn-icon edit text-warning" title="@lang('app.edit_subscription')" data-toggle="tooltip" data-placement="top">
                        <i class="fas fa-edit"></i>
                    </a> --}}
                </td>
            </tr>
            {{-- @endforeach --}}
            @endforeach
        </tbody>
    </table>
</div>