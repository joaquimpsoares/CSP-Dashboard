@extends('layouts.master')
@section('css')

    <link href="{{URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
    <!-- Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />

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

    @livewire('azure.azure-report', ['subscription' => $subscription])

    @endsection
    {{-- <script>

        var t10Sum = {!! $top10Q !!};

    </script> --}}

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
