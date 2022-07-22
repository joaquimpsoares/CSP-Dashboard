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

@section('content')
@php
$percentage =($subscription->customer->markup/100)*$subscription->azureresources->sum('cost');
$markup = $percentage+$subscription->azureresources->sum('cost');
@endphp

<div class="relative z-0 flex-col flex-1 overflow-y-auto">
    <div class="p-4 overflow-hidden bg-white">
        {{-- <div class="flex flex-col">
            <div class="flex flex-col items-center justify-between lg:flex-row"> --}}
                <div class="flex items-center">
                    <h4>Analytics Dashboard - {{$subscription->customer->company_name}}</h4>
                </div>

                <div class="row row-deck">
                    <div class="col-xl-3 col-md-12 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ ucwords(trans_choice('messages.budget_grow', 1)) }}</h3>
                                {{-- <div class="ml-20">
                                    <button type="button" class="inline-flex items-center px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm ml-30 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ ucwords(trans_choice('messages.change_budget', 1)) }}
                                    </button>
                                </div> --}}
                            </div>
                            <div class="card-body">
                                <div class="text-center row">
                                    <div class="mb-4 col-md-12 mt-sm-0">
                                        <div class="mx-auto mb-0 chart-circle chart-circle-primary chart-circle-lg mt-sm-0 donutShadow" data-value="{{$average/100}}" data-thickness="15" data-color="#4454c3">
                                            <div class="mx-auto mb-2 text-center chart-circle-value"><h1 class="mt-2 mb-0">{{$average}}%</h1><small>{{ ucwords(trans_choice('messages.goal', 1)) }}</small></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h2 class="mt-3 mb-0 fs-50 counter font-weight-bold">${{$budget}}</h2>
                                        <small class="mt-1 fs-12 text-muted">{{ ucwords(trans_choice('messages.updated', 1)) }} {{$date->azure_updated_at ?? ' '}}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-12 col-lg-6">
                        <div class="card">
                            <div class="mb-4 card-header">
                                <h3 class="card-title">{{ ucwords(trans_choice('messages.current_estimated_usage', 1)) }}</h3>
                            </div>
                            <div class="p-2">
                                <h5 class="pl-4 mb-4 font-weight-bold">{{ ucwords(trans_choice('messages.current_estimated_usage', 1)) }}</h5>
                                <table class="table card-table text-nowrap">
                                    <tbody>
                                        <tr>
                                            <td>{{ ucwords(trans_choice('messages.usage', 1)) }}</td>
                                            <td class="w-3 text-right"><span class="">{{$subscription->customer->country->currency_symbol}}@money($markup)
                                            </span></td>
                                        </tr>
                                        <tr>
                                            <td>{{ ucwords(trans_choice('messages.budget', 1)) }}</td>
                                            <td class="w-3 text-right"><span class="">{{$subscription->customer->country->currency_symbol}}{{$budget}}</span></td>
                                        </tr>
                                        <tr>
                                            <td>{{ ucwords(trans_choice('messages.percentage', 1)) }}</td>
                                            <td class="w-3 text-right"><span class="">{{$average}}%</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <i class="fas fa-chart-pie"></i>
                            <div class="card-footer">
                                <a href="{{route('analytics.reports',$subscription)}}" class="inline-flex items-center block px-4 py-2 text-base font-medium text-center text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">  Reports</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-lg-12">
                                    <div class="card-header">
                                        <h4 class="card-title">{{ ucwords(trans_choice('messages.top_service_by_costs', 1)) }}</h4>
                                    </div>
                                    <div class="text-center card-body">
                                        <div class="table-responsive">
                                            <table id="" class="table mg-b-0 text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>{{ ucwords(trans_choice('messages.name', 1)) }}</th>
                                                        <th>{{ ucwords(trans_choice('messages.category', 1)) }}</th>
                                                        <th>{{ ucwords(trans_choice('messages.total', 1)) }}</th>
                                                    </tr>
                                                </thead>
                                                <body>
                                                    @foreach ($resourcet5Name as $item)
                                                    @php
                                                    $percentage =($subscription->customer->markup/100)*$item->sum;
                                                    $markup = $percentage+$item->sum;
                                                    @endphp
                                                    <tr>
                                                        <td >{{$item->name}}</td>
                                                        <td >{{$item->category}}</td>
                                                        <td >{{$subscription->customer->country->currency_symbol}}@money($markup)</td>
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
                                        <h4 class="card-title"><i class="fab fa-chart-pie"></i> {{ ucwords(trans_choice('messages.top_10_resources', 1)) }}</h4>
                                    </div>
                                    <div class="text-center card-body">
                                        <div id="myfirstchart" class="BarChartShadow" style="height: 285px;"></div>
                                        <div class="mt-5 row">
                                            <div class="text-center col">
                                                <span class="float-right text-muted"><div class="float-left w-3 h-3 mt-1 mr-1 bg-primary br-3"></div> {{ ucwords(trans_choice('messages.value', 1)) }}</span>
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
                                <h3 class="card-title">{{ ucwords(trans_choice('messages.top_10_resources', 1)) }}</h3>
                            </div>
                            <div class="mx-auto text-center card-body">
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
                                <h4 class="card-title">{{ ucwords(trans_choice('messages.resource_names', 1)) }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="card-body">
                                    <div class="">
                                        <div class="table-responsive">
                                            <table id="example" class="table table-bordered text-wrap key-buttons">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th >{{ ucwords(trans_choice('messages.name', 1)) }}</th>
                                                        <th>{{ ucwords(trans_choice('messages.category', 1)) }}</th>
                                                        <th>{{ ucwords(trans_choice('messages.sub_category', 1)) }}</th>
                                                        <th>{{ ucwords(trans_choice('messages.top_10_resources', 1)) }}</th>
                                                    </tr>
                                                </thead>
                                                <body>
                                                    @foreach ($resourceName as $item)
                                                    @php
                                                    $percentage =($subscription->customer->markup/100)*$item->sum;
                                                    $markup = $percentage+$item->sum;
                                                    @endphp
                                                    <tr>
                                                        <td >{{$item->name}}</td>
                                                        <td >{{$item->category}}</td>
                                                        <td >{{$item->subcategory}}</td>
                                                        <td >{{$subscription->customer->country->currency_symbol}}@money($markup)</td>
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
