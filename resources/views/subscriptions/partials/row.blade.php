<div class="container col-xm-12">
    <section class="dark-grey-text">
        <table class="table table-hover" id="reseller">
            <thead class="thead-dark">
                <tr>
                    <th class="text-nowrap">@lang('#')</th>
                    <th class="text-nowrap">@lang('Subscription Name')</th>
                    <th class="text-nowrap">{{ ucwords(trans_choice('messages.company_name', 2)) }}</th>
                    <th class="text-nowrap">{{ ucwords(trans_choice('messages.quantity', 1)) }}</th>
                    <th class="text-nowrap">{{ ucwords(trans_choice('messages.expiration_date', 2)) }}</th>
                    <th class="text-nowrap">{{ ucwords(trans_choice('messages.status', 1)) }}</th>
                    <th class="text-nowrap">{{ ucwords(trans_choice('messages.billing_cycle', 2)) }}</th>
                    <th class="text-center min-width-150">{{ ucwords(trans_choice('messages.action', 2)) }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscriptions as $subscription)
                {{dd($subscriptionPurching )}}
                <tr class="odd gradeX">
                    <td width="1%" class="f-s-600">{{$subscription['id']}}</td>
                    <td>{{$subscription->name}}</td>
                    <td>{{$subscription->customer->company_name}}</td>
                    <td>{{$subscription->amount}}</td>
                    <td>{{$subscription->expiration_data}}</td>
                    <td class="align-middle">
                        <span class="badge badge-lg {{ $subscription->isActive() ? 'badge-success' : 'badge-danger' }}">
                            {{ trans("app.{$subscription->status}") }}
                        </span>
                    </td>
                    <td>{{$subscription->billing_period}}</td>
                    <td class="text-nowrap">
                        {{-- <a href="{{ route('subscriptions.edit', $subscription->id) }}" class="btn btn-icon edit text-warning" title="@lang('app.edit_subscription')" data-toggle="tooltip" data-placement="top">
                            <i class="fas fa-edit"></i>
                        </a> --}}
                    </td>
                </tr> 
                @empty
                <tr>
                    <td colspan="15">Empty</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </section>
</div>