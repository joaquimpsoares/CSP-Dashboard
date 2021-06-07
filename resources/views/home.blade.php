@extends('layouts.master')
@section('css')
<!-- Data table css -->

<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
@auth
@include('dashboard.home')
@endauth


@endsection
