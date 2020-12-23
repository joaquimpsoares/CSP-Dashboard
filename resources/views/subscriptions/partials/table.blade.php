
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ ucwords(trans_choice('messages.subscription_table', 2)) }}</h3>
        {{-- <div class="card-options">
            <div class="btn-group ml-5 mb-0">
                <button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-plus"></i> {{ ucwords(__('messages.options')) }}</button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{route('reseller.create')}}"><i class="fa fa-plus mr-2"></i>{{ ucwords(__('messages.new_reseller')) }}</a>
                    <a class="dropdown-item" href="#"><i class="fa fa-eye mr-2"></i>View all new tab</a>
                    <a class="dropdown-item" href="#"><i class="fa fa-edit mr-2"></i>Edit Page</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"><i class="fa fa-cog mr-2"></i> Settings</a>
                </div>
            </div>
        </div> --}}
    </div>
    <div class="card-body">
        <div class="table-responsive datatble-filter">
            <table id="example" class="table card-table table-vcenter border p-0">
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
                            <span class="badge badge-lg {{ $subscription->status->name == 'messages.active' ? 'badge-success' : 'badge-danger'  }}">
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
            {{-- {{ $subscriptions->links('pagination::bootstrap-4') }} --}}
        </div>
    </div>
</div>



