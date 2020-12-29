@extends('layouts.master')
@section('css')
<!-- Data table css -->

<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
@auth
@include('dashboard.home')

{{--

@if(Auth::user()->userLevel->id === 1)
@endif


@if(Auth::user()->userLevel->id === 2)
@include('provider.partials.home')
@endif

@if(Auth::user()->userLevel->id === 3)
@include('provider.partials.home')
@endif

--}}
@endauth


@endsection
