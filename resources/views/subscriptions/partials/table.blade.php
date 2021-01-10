<div class="col-xl-12 col-lg-7">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ ucwords(trans_choice('messages.subscription_table', 2)) }}</h3>
        </div>
        <div class="p-5">
            <form action="" method="GET" id="users-form" class="pb-2 mb-3 border-bottom-light">
                <div class="row">
                    <div class="col">
                        <div class="input-group custom-search-form">
                            <input type="text"
                            class="form-control input-solid"
                            name="search"
                            value="{{ Request::get('search') }}"
                            placeholder="@lang('Search for subscriptions...')">
                            <span class="input-group-append">
                                @if (Request::has('search') && Request::get('search') != '')
                                <a href="{{ route('subscription.index') }}"
                                class="btn btn-light d-flex align-items-center text-muted"
                                role="button">
                                <i class="fa fa-times"></i>
                            </a>
                            @endif
                        </span>
                    </div>
                </div>
                <div class="col">
                    <div class="input-group custom-search-form">
                        <input type="text"
                        class="form-control input-solid"
                        name="customer"
                        value="{{ Request::get('customer') }}"
                        placeholder="@lang('Search for customers name...')">
                        <span class="input-group-append">
                            @if (Request::has('customer') && Request::get('customer') != '')
                            <a href="{{ route('subscription.index') }}"
                            class="btn btn-light d-flex align-items-center text-muted"
                            role="button">
                            <i class="fa fa-times"></i>
                        </a>
                        @endif
                    </span>
                </div>
            </div>
            <div class="col">
                <button class="btn btn-primary" type="submit" id="search-users-btn">
                    <i class="fa fa-search"></i>
                    search
                </button>
            </div>
        </form>
    </div>
</div>



<div class="card-body table-responsive p-0 mx-313 scroll-3">
    <table class="table card-table table-vcenter text-nowrap table-borderedless border-0 inde4-table">
        <thead>
            <tr>
                <th>{{ ucwords(trans_choice('messages.#', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.subscription_name', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.company_name', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.quantity', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.expiration', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.billing_cycle', 1)) }}</th>
                <th>{{ ucwords(trans_choice('messages.status', 1)) }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($subscriptions as $subscription)
            <tr class="table-subheader">
                <td width="1%" class="f-s-600"><a href="{{route('subscription.show', $subscription->id)}}">{{$subscription['id']}}</a></td>
                <td>{{$subscription->name}}</td>
                <td>{{$subscription->customer->company_name}}</td>
                @if ($subscription->products->first()->billing === 'usage')
                <td></td>
                @else
                <td>{{$subscription->amount}}</td>
                @endif
                <td>{{$subscription->expiration_data}}</td>
                <td>{{$subscription->billing_period}}</td>
                <td class="align-middle">
                    <span class="badge badge-lg {{ $subscription->status->name == 'messages.active' ? 'badge badge-success badge-pill' : 'badge badge-danger badge-pill'  }}">
                        {{ ucwords(trans_choice($subscription->status->name, 1)) }}
                    </span>
                </td>
            </tr>
            <tr style="display:none">
                <td colspan="9">
                    <div class="">
                        <div class="panel panel-primary receipts-inline-table border-0">
                            <div class="panel-body tabs-menu-body p-0 border-0">
                                <div class="tab-content">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th>{{ ucwords(trans_choice('messages.subscription_name', 1)) }}</th>
                                                <th>{{ ucwords(trans_choice('messages.quantity', 1)) }}</th>
                                                <th>{{ ucwords(trans_choice('messages.billing_cycle', 1)) }}</th>
                                                <th>{{ ucwords(trans_choice('messages.status', 1)) }}</th>
                                                <th>{{ ucwords(trans_choice('messages.action', 1)) }}</th>
                                            </tr>
                                            <tr class="last-product">
                                                <form class="form-horizontal form-bordered" method="POST" action="{{ route('subscription.update', $subscription->id) }}">
                                                    @method('PATCH')
                                                    <td>{{$subscription->name}}</td>
                                                    @if ($subscription->products->first()->billing === 'usage')
                                                    <td></td>
                                                    @else
                                                    @csrf
                                                    <td>
                                                        <input class="form-control" type="number" name="amount" value="{{$subscription->amount}}">
                                                    </td>
                                                    @endif
                                                    <td>
                                                        <select name="billing_period" required="required" class="form-control SlectBox SumoUnder" id="{{ $subscription->products->first()->id }}">
                                                            @foreach($subscription->products->first()->supported_billing_cycles as $cycle)
                                                            <option value="{{ $cycle }}" @if($cycle == $subscription->billing_period) selected @endif>
                                                                {{ $cycle }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div name="status" class="select is-info">
                                                            <select name="status" class="form-control SlectBox SumoUnder">
                                                                <option  value="1" {{ $subscription->status_id == "1" ? "selected":"" }}> Active</option>
                                                                <option  value="2" {{ $subscription->status_id == "2" ? "selected":"" }}> Suspended</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td><button type="submit" class="btn btn-primary" type="submit">Change</button></td>
                                                    @foreach ($subscription->products->first()->getaddons()->all() as $item)
                                                    <tr>
                                                        <td><strong>Add-on:</strong> {{$item->name}}</td>
                                                        <td><input class="form-control" type="number" name="amount_addon" value="{{$item->amount}}"></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    @endforeach
                                                </form>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            @endforelse
            <div class="col">
                <span class="float-right">
                </span>
            </div>
        </tbody>
    </table>
</div>
<div class="card-footer d-flex text-right">
    @if ($subscriptions->total() >= '10')
    {!! $subscriptions->render() !!}
    @endif
</div>
</div>


@section('scripts')
<script>
    $("#status").change(function () {
        $("#users-form").submit();
    });
</script>
@stop
