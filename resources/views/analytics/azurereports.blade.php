@extends('layouts.master')
@section('css')
<!-- Morris Charts css -->
<link href="{{URL::asset('assets/plugins/morris/morris.css')}}" rel="stylesheet" />
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<!--Daterangepicker css-->
<link href="{{URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('page-header')
<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">Analytics Dashboard</h4>
    </div>
</div>
<!--End Page header-->
@endsection

@section('content')
{{-- <div class="row">
    <div class="col-xl-6 col-md-12 col-lg-12">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-7 col-md-12 col-lg-6">
                        <div class="d-block card-header border-0 text-center px-0">
                            <h3 class="text-center mb-4">Congratulations <b>John!</b></h3>
                            <small>You have reached Page Views</small>
                        </div>
                        <div class="row text-center">
                            <div class="col-md-12">
                                <h2 class="mb-0 fs-40 counter font-weight-bold">10M</h2>
                                <h6 class="mt-4 text-white-50">You have done 100% reached target today.</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-md-12 col-lg-6">
                        <img class="mx-auto text-center w-90 analytics-img" src="{{URL::asset('assets/images/photos/award.png')}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="row row-deck">
    {{-- <div class="col-xl-3 col-md-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Budget Grow</h3>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-12 mb-4 mt-sm-0">
                        <div class="mx-auto chart-circle chart-circle-primary chart-circle-lg  mt-sm-0 mb-0 donutShadow" data-value="" data-thickness="15" data-color="#4454c3">
                            <div class="mx-auto chart-circle-value text-center mb-2"><h1 class="mb-0 mt-2"></h1><small>Goal</small></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h2 class="mb-0 fs-50 mt-3 counter  font-weight-bold"></h2>
                        <span class=" fs-12 text-muted"><span class="text-danger mr-1"><i class="fe fe-arrow-down ml-1"></i>0.82%</span> since last week</span>
                        <p class="mt-5 mb-2 text-muted">It is a long established fact that a ayout. </p>
                        <small class="mt-1 fs-12 text-muted">Updated</small>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="col-xl-3 col-md-12 col-lg-6"> --}}
        {{-- <div class="card">
            <div class="card-header mb-4">
                <h3 class="card-title">Current Estimated Usage</h3>
            </div>
            <div class="p-2">
                <h5 class="pl-4 font-weight-bold mb-4">This Current Estimated Usage</h5>
                <table class="table card-table text-nowrap">
                    <tbody>
                        <tr>
                            <td>Usage</td>
                            <td class="w-3 text-right"><span class="">$/span></td>
                            </tr>
                            <tr>
                                <td>Budget</td>
                                <td class="w-3 text-right"><span class="">$</span></td>
                            </tr>
                            <tr>
                                <td>Percent</td>
                                <td class="w-3 text-right"><span class="">%</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <i class="fas fa-chart-pie"></i>
                <div class="card-footer">
                    <a href="#" class="btn btn-lg btn-block btn-white">  Reports</a>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div> --}}
        {{-- <div class="col-xl-6 col-md-12 col-lg-12">
            <div class="card">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-lg-12">
                        <div class="card-header">
                            <h4 class="card-title">Top services by cost</h4>
                            <div class="page-rightheader ml-auto d-lg-flex d-none">
                                <div class="ml-5 mb-0">
                                    <a class="btn btn-white date-range-btn" href="#" id="daterange-btn">
                                        <svg class="header-icon2 mr-3" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                                            <path d="M5 8h14V6H5z" opacity=".3"/><path d="M7 11h2v2H7zm12-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2zm-4 3h2v2h-2zm-4 0h2v2h-2z"/>
                                        </svg> <span>Select Date
                                            <i class="fa fa-caret-down"></i></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <div class="table-responsive">
                                    <table id="" class="table mg-b-0 text-nowrap">
                                        <thead>
                                            <tr>
                                                <th >Name</th>
                                                <th>Category</th>
                                                <th>Sub Category</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <body>
                                            @foreach ( as $item)
                                            <tr>
                                                <td >{{$item->name}}</td>
                                                <td >{{$item->category}}</td>
                                                <td >{{$item->subcategory}}</td>
                                                <td >${{$item->sum}}</td>
                                            </tr>
                                            @endforeach
                                        </body>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Resources name </h4>
                        <div class="page-rightheader ml-auto d-lg-flex d-none">
                            <div class="ml-5 mb-0">
                                <a class="btn btn-white date-range-btn" href="#" id="daterange-btn1">
                                    <svg class="header-icon2 mr-3" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                                        <path d="M5 8h14V6H5z" opacity=".3"/><path d="M7 11h2v2H7zm12-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2zm-4 3h2v2h-2zm-4 0h2v2h-2z"/>
                                    </svg> <span>Select Date
                                        <i class="fa fa-caret-down"></i></span>
                                    </a>
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
                                                    <th>start date</th>
                                                    <th>end date</th>
                                                </tr>
                                            </thead>
                                            <body>
                                                @foreach ($reports as $item)
                                                {{-- @dd($item) --}}
                                                <tr>
                                                    <td >{{$item->resource_name}}</td>
                                                    <td >{{$item->resource_category}}</td>
                                                    <td >{{$item->resource_group}}</td>
                                                    <td >${{$item->sum}}</td>
                                                    <td >{{$item->usageStartTime}}</td>
                                                    <td >{{$item->usageEndTime}}</td>
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
                {{-- <div class="col-xl-8 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-lg-12">
                                <div class="card-header">
                                    <h4 class="card-title"><i class="fab fa-chart-pie"></i> Top 10 Resouces</h4>
                                </div>
                                <div class="card-body text-center">
                                    <div id="myfirstchart" class="BarChartShadow" style="height: 285px;"></div>
                                    <div class="row mt-5">
                                        <div class="col text-center">
                                            <span class="text-muted float-right"><div class="w-3 h-3 bg-primary br-3 mr-1 mt-1 float-left"></div> Value</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="col-xl-4 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Top 10 Resouces</h3>
                        </div>
                        <div class="card-body text-center mx-auto">
                            <div class="overflow-hidden">
                                <canvas class="canvasDoughnut" height="240" width="310"></canvas>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row no-gutters">
                                <div class="col text-center">
                                    @php
                                    $query = collect($query)
                                    @endphp
                                    @foreach ($top10q as $key => $item)
                                    <span class="text-muted float-left"><div class="w-4 h-3 bg-success br-3 mr-1 mt-1 float-left"></div> {{$item['category']}}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}


            </div>

        </div>

        @endsection

        <script>


        </script>
        @section('js')

        <!--Moment js-->
        <script src="{{URL::asset('assets/plugins/moment/moment.js')}}"></script>
        <!-- Daterangepicker js-->
        <script src="{{URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
        <script src="{{URL::asset('assets/js/daterange.js')}}"></script>
        <!--Chart js -->
        <script src="{{URL::asset('assets/plugins/chart/chart.min.js')}}"></script>
        <script src="{{URL::asset('assets/plugins/chart/chart.extension.js')}}"></script>
        <!-- ECharts js-->
        <script src="{{URL::asset('assets/plugins/echarts/echarts.js')}}"></script>
        <script src="{{URL::asset('assets/js/index2.js')}}"></script>

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
