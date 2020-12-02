<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ ucwords(trans_choice('messages.subscription_table', 2)) }}</h3>
        <div class="card-options">
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
        </div>
    </div>
    <div class="card-body">
        <div class="">
            <div class="table-responsive">
                <table id="example4" class="table card-table table-vcenter text-nowrap border p-0">
                    <thead>
                        <tr>
                            <th>{{ ucwords(trans_choice('messages.#', 1)) }}</th>
                            <th>{{ ucwords(trans_choice('messages.subscription_name', 1)) }}</th>
                            <th>{{ ucwords(trans_choice('messages.company_name', 1)) }}</th>
                            <th>{{ ucwords(trans_choice('messages.quantity', 1)) }}</th>
                            <th>{{ ucwords(trans_choice('messages.expiration', 1)) }}</th>
                            <th>{{ ucwords(trans_choice('messages.billing_cycle', 1)) }}</th>
                            <th>{{ ucwords(trans_choice('messages.status', 1)) }}</th>
                            <th>{{ ucwords(trans_choice('messages.action', 1)) }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subscriptions as $subscription)
                        <tr class="table-subheader">
                            <td width="1%" class="f-s-600"><a href="{{route('subscription.show', $subscription->id)}}">{{$subscription['id']}}</a></td>
                            <td>{{$subscription->name}}</td>
                            <td>{{$subscription->customer->company_name}}</td>
                            <td>{{$subscription->amount}}</td>
                            <td>{{$subscription->expiration_data}}</td>
                            <td>{{$subscription->billing_period}}</td>
                            <td class="align-middle">
                                <span class="badge badge-lg {{ $subscription->status->name = '  ' ? 'badge-success' : 'badge-danger' }}">
                                    {{ ucwords(trans_choice('messages.active', 1)) }}
                                </span>
                            </td>
                            <td class="text-nowrap">
                            </td>
                        </tr>
                        @empty
                        @endforelse
                        <tr style="display:none">
                            <td colspan="9">
                                <div class="">
                                    <div class="panel panel-primary receipts-inline-table border-0">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <table class="table detail-transaction">
                                                    <tbody>
                                                        <tr>
                                                            <th>{{ ucwords(trans_choice('messages.subscription_name', 1)) }}</th>
                                                            <th>{{ ucwords(trans_choice('messages.quantity', 1)) }}</th>
                                                            <th>{{ ucwords(trans_choice('messages.billing_cycle', 1)) }}</th>
                                                            <th>{{ ucwords(trans_choice('messages.status', 1)) }}</th>
                                                            <th>{{ ucwords(trans_choice('messages.action', 1)) }}</th>
                                                        </tr>
                                                        @forelse ($subscriptions as $subscription)
                                                        <tr class="last-product">
                                                            <td>{{$subscription->name}}</td>
                                                            <td>
                                                                <input class="form-control" type="text" name="amount" value="{{$subscription->amount}}">
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <select id="my-select" class="custom-select" name="">
                                                                        <option>{{$subscription->billing_period}}</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td class="align-middle">
                                                                <span class="badge badge-lg {{ $subscription->status->name = '  ' ? 'badge-success' : 'badge-danger' }}">
                                                                    {{ ucwords(trans_choice('messages.active', 1)) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <button type="submit">Change</button>
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@section('js')
<!-- Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/js/datatables.js')}}"></script>
<!-- Select2 js -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
@endsection

