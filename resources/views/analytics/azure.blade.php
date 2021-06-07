@extends('layouts.master')
@section('css')
{{-- <!-- Morris Charts css -->
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
    <link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" /> --}}
    @endsection



    @section('content')
    @include('layouts.messages')


    @livewire('azure.azure-table')

    @endsection

    @section('js')

    {{-- <!--Moment js-->
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
        <script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script> --}}
        @endsection
