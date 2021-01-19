<div>
    @section('css')

    <!--Daterangepicker css-->
    <link href="{{URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
    <!-- Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />

    @endsection
    <div class="row row-deck">
        <div class="col-xl-4 col-md-12 col-lg-12">
            <div class="card">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-lg-12">
                        <div class="card-header">
                            <h4 class="card-title">Top 5 Resource Group cost</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="" class="table mg-b-0 text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Resource Group Name</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <body>
                                        @foreach ($top5Q as $item)
                                        <tr>
                                            <td >{{$item['resource_group']}}</td>
                                            <td> $@money($item['sum'])</td>
                                        </tr>
                                        @endforeach
                                    </body>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"> Filter</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">Resource Groups</label>
                                <select name="beast" id="select-beast" class="form-control custom-select select2">
                                    <option value="0">--Select--</option>
                                    @foreach ($resourceGroups as $key => $item)
                                    <option value={{$key}}>{{$item}}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="form-group">
                                <label class="form-label">Categories</label>
                                <select name="beast" id="select-beast1" class="form-control custom-select select2">
                                    <option value="0">--Select--</option>
                                    @foreach ($categories as $key => $item)
                                    <option value={{$key}}>{{$item}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Sub Categories</label>
                                <select name="beast" id="select-beast2" class="form-control custom-select select2">
                                    <option value="0">--Select--</option>
                                    @foreach ($subcategories as $key => $item)
                                    <option value={{$key}}>{{$item}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Region</label>
                                <select name="beast" id="select-beast3" class="form-control custom-select select2">
                                    <option value="0">--Select--</option>
                                    @foreach ($region as $key => $item)
                                    <option value={{$key}}>{{$item}}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <a class="btn btn-primary btn-block" href="#">Search</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Resources name </h4>
                    <div class="page-rightheader ml-auto d-lg-flex d-none">
                        <div class="ml-6 mb-0">
                            <input
                            wire:model="taskduedate" class="datetimepicker form-control"
                            class="form-control datepicker" placeholder="Due Date" autocomplete="off" id="daterange-btn"
                            data-provide="datepicker" data-date-autoclose="true" data-date-format="yyyy-mm-dd" data-date-today-highlight="true"
                            onchange="this.dispatchEvent(new InputEvent('input'))"
                            >
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <div class="">
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered text-wrap key-buttons">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Resource Group</th>
                                            <th>Total Cost</th>
                                            <th>Quantity</th>
                                            <th>start date</th>
                                            <th>end date</th>
                                        </tr>
                                    </thead>
                                    <body>
                                        @foreach ($reports as $item)
                                        <tr>
                                            <td >{{$item->resource_name}}</td>
                                            <td >{{$item->resource_id}}</td>
                                            <td >{{$item->resource_group}}</td>
                                            <td >$@money($item->cost)</td>
                                            <td >{{$item->quantity}}</td>
                                            <td >{{$item->usageStartTime}}</td>
                                            <td >{{$item->usageEndTime}}</td>
                                        </tr>
                                        @endforeach
                                    </body>
                                </table>
                                <div class="card-footer d-flex text-right">
                                    @if ($reports->total() >= '10')
                                    {{ $reports->links() }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js')

<!--Moment js-->
<script src="{{URL::asset('assets/plugins/moment/moment.js')}}"></script>
<!-- Daterangepicker js-->
<script src="{{URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{URL::asset('assets/js/daterange.js')}}"></script>
<!-- ECharts js -->
<script src="{{URL::asset('assets/plugins/echarts/echarts.js')}}"></script>
<!-- Chartjs js -->
<script src="{{URL::asset('assets/plugins/chart/chart.bundle.js')}}"></script>
<script src="{{URL::asset('assets/plugins/chart/utils.js')}}"></script>
<!--Morris Charts js-->
<script src="{{URL::asset('assets/plugins/morris/raphael-min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/morris/morris.js')}}"></script>
<!-- Index js-->
<script src="{{URL::asset('assets/js/index3.js')}}"></script>
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
{{-- <script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script> --}}
@endsection
</div>

