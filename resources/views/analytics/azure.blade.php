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
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Azure analytics</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-vcenter text-nowrap mb-0 border">
                        <thead>
                            <tr>
                                <th>{{ ucwords(trans_choice('messages.company_name', 1)) }}</th>
                                <th>{{ ucwords(trans_choice('messages.subscription_name', 1)) }}</th>
                                <th>{{ ucwords(trans_choice('messages.estimated_cost', 1)) }}</th>
                                <th>{{ ucwords(trans_choice('messages.budget', 1)) }}</th>
                                <th class="text-center">{{ ucwords(trans_choice('messages.budget_used%', 1)) }}<i class="fa fa-arrow-up mr-1"></i></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($resourceName as $item)
                            <tr>
                                <td class="d-flex"><a href="{{ $item->customer->format()['path'] }}">{{$item->customer['company_name']}}</a></td>
                                <td>{{$item->name}}</td>
                                @php
                                $percentage =($item->customer['markup']/100)*$item->azureresources->sum('cost');
                                $markup = $percentage+$item->azureresources->sum('cost');
                                @endphp
                                <td>${{$markup}}</td>
                                <td>${{$item->budget}}</td>
                                <td>
                                    @if (($item->calculated/100) < '0.50')
                                    <div class="mx-auto chart-circle chart-circle-xs chart-circle-primary mt-sm-0 mb-0 icon-dropshadow-primary" data-value="{{($item->calculated/100)}}" data-thickness="5" data-color="#4454c3">
                                        @else
                                        <div class="mx-auto chart-circle chart-circle-xs chart-circle-secondary mt-sm-0 mb-0 icon-dropshadow-secondary" data-value="{{($item->calculated/100)}}" data-thickness="5" data-color="#f72d66">
                                            @endif
                                            <div class="mx-auto chart-circle-value text-center">{{(int)($item->calculated)}}%</div>
                                        </div>
                                    </td>
                                    <td>
                                        <a class="btn btn-white btn-sm" href="/analytics/details/{{$item->customer_id}}/{{$item->id}}">View Details</a>
                                        <a class="btn btn-white btn-sm" href="/analytics/update/{{$item->customer_id}}/{{$item->id}}">Update</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="card-footer d-flex text-right">
                            @if ($resourceName->total() >= '10')
                            {!! $resourceName->render() !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @endsection

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
