@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ ucwords(trans_choice('messages.customer_table', 1)) }}</h3>
        <div class="card-options">
            <div class="btn-group ml-5 mb-0">
                <button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-plus"></i> {{ ucwords(__('messages.options')) }}</button>
                <div class="dropdown-menu">
                    @if(Auth::user()->userLevel->id === 4)
                    <a class="dropdown-item" href="{{route('customer.create')}}"><i class="fa fa-plus mr-2"></i>{{ ucwords(__('messages.new_customer')) }}</a>
                    @endif
                    {{-- <a class="dropdown-item" href="#"><i class="fa fa-eye mr-2"></i>View all new tab</a>
                    <a class="dropdown-item" href="#"><i class="fa fa-edit mr-2"></i>Edit Page</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"><i class="fa fa-cog mr-2"></i> Settings</a> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="">
            <div class="table-responsive">
                <table id="example" class="table table-bordered key-buttons">
                    {{-- <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.customer_table', 1)) }}</a></h4> --}}
                    <thead >
                        <tr>
                            <th>{{ ucwords(trans_choice('messages.#', 1)) }}</th>
                            <th>{{ ucwords(trans_choice('messages.company_name', 1)) }}</th>
                            <th>{{ ucwords(trans_choice('messages.reseller', 2)) }}</th>
                            <th>{{ ucwords(trans_choice('messages.subscription', 2)) }}</th>
                            <th>{{ ucwords(trans_choice('messages.created_at', 1)) }}</th>
                            <th>{{ ucwords(trans_choice('messages.action', 1)) }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                        {{-- @if($customer['status'] === 'messages.active') --}}
                        <tr>
                            <td width="3%" class="f-s-600"><a href="{{ $customer['path'] }}">{{ $customer['id'] }}</a></td>
                            <td><a href="{{ $customer['path'] }}">{{ $customer['company_name'] }}</a></td>
                            <td>{{ $customer['reseller']['company_name'] }}</td>
                            <td>{{ $customer['subscriptions'] }}</td>
                            <td>{{ $customer['created_at'] }}</td>
                            <td style="width: 150px">
                                @include('partials.actions', ['model' => $customer, 'modelo' => 'customer'])
                            </td>
                        </tr>
                        {{-- @endif --}}
                        @empty
                        <tr>
                            <td colspan="5">Empty</td>
                        </tr>
                        @endforelse
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
