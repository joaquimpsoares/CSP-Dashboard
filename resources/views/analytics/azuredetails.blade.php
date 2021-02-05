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
        <h4 class="page-title">Analytics Dashboard - {{$subscription->customer->company_name}}</h4>
    </div>
</div>
<!--End Page header-->
@endsection

@section('content')
<div class="row row-deck">
    <div class="col-xl-3 col-md-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Budget Grow</h3>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-12 mb-4 mt-sm-0">
                        <div class="mx-auto chart-circle chart-circle-primary chart-circle-lg  mt-sm-0 mb-0 donutShadow" data-value="{{$average/100}}" data-thickness="15" data-color="#4454c3">
                            <div class="mx-auto chart-circle-value text-center mb-2"><h1 class="mb-0 mt-2">{{$average}}%</h1><small>Goal</small></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h2 class="mb-0 fs-50 mt-3 counter  font-weight-bold">${{$budget}}</h2>
                        <small class="mt-1 fs-12 text-muted">Updated {{$date->azure_updated_at ?? ' '}}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-12 col-lg-6">
        <div class="card">
            <div class="card-header mb-4">
                <h3 class="card-title">Current Estimated Usage</h3>
            </div>
            <div class="p-2">
                <h5 class="pl-4 font-weight-bold mb-4">This Current Estimated Usage</h5>
                <table class="table card-table text-nowrap">
                    <tbody>
                        <tr>
                            <td>Usage</td>
                            <td class="w-3 text-right"><span class="">${{$total}}</span></td>
                        </tr>
                        <tr>
                            <td>Budget</td>
                            <td class="w-3 text-right"><span class="">${{$budget}}</span></td>
                        </tr>
                        <tr>
                            <td>Percent</td>
                            <td class="w-3 text-right"><span class="">{{$average}}%</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <i class="fas fa-chart-pie"></i>
            <div class="card-footer">
                <a href="{{route('analytics.reports',$subscription)}}" class="btn btn-lg btn-block btn-white">  Reports</a>
            </div>
            {{-- <div class="card-footer">
                <a href="{{ route('analytics.update') }}" class="btn btn-lg btn-block btn-white">Refresh Now</a>
            </div> --}}
        </div>
    </div>
    <div class="col-xl-6 col-md-12 col-lg-12">
        <div class="card">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-lg-12">
                    <div class="card-header">
                        <h4 class="card-title">Top services by cost</h4>
                    </div>
                    <div class="card-body text-center">
                        <div class="table-responsive">
                            <table id="" class="table mg-b-0 text-nowrap">
                                <thead>
                                    <tr>
                                        <th >Name</th>
                                        <th>Category</th>
                                        {{-- <th>Sub Category</th> --}}
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <body>
                                    @foreach ($resourcet5Name as $item)
                                    <tr>
                                        <td >{{$item->name}}</td>
                                        <td >{{$item->category}}</td>
                                        {{-- <td >{{$item->subcategory}}</td> --}}
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
    </div>
    <div class="col-xl-8 col-md-12 col-lg-12">
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
    </div>
    <div class="col-xl-4 col-md-12 col-lg-12">
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
            </div>
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Resources name </h4>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <div class="">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered text-wrap key-buttons">
                                <thead class="thead-dark">
                                    <tr>
                                        <th >Name</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <body>
                                    @foreach ($resourceName as $item)
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
    </div>
</div>
@endsection

<script>

    var t10Sum = {!! $top10S !!};
    var t10Category = {!! $top10C !!};

    var sum = {!! $sum !!};
    var category = {!! $category !!};

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
