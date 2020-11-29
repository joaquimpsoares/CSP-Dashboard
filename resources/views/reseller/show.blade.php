@extends('layouts.master')
@section('css')

@endsection
@section('page-header')
<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">{{ ucwords(trans_choice('messages.new_provider', 1)) }}</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#" class="d-flex"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/><path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/></svg><span class="breadcrumb-icon"> Home</span></a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item"><a href="#">Blog</a></li>
            <li class="breadcrumb-item active" aria-current="page">Blog 01</li>
        </ol>
    </div>
</div>
<!--End Page header-->
@endsection
@section('content')

@include('reseller.partials.home', ['subscriptions' => $subscriptions])
<div class="row">
    <div class="col-lg-3">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                {{-- @include('provider.partials.details') --}}
                {{-- @include('reseller.partials.details') --}}
            </div>
        </div>
    </div>
{{-- <div class="container col-xm-12"> --}}

    @include('subscriptions.partials.table', ['subscriptions' => $subscriptions])
    <div class="tab-content pt-5" id="myTabContentMD">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        </div>
        <div class="tab-pane fade" id="subscription-md" role="tabpanel" aria-labelledby="subscription-tab-md">
            <div class="container col-xm-12">
            </div>
        </div>
        <div class="tab-pane fade" id="profile-md" role="tabpanel" aria-labelledby="profile-tab-md">
            <div class="container col-xm-12">
                {{-- @include('user.partials.table', ['users' => $users] ) --}}
            </div>
        </div>
        <div class="tab-pane fade" id="customer-md" role="tabpanel" aria-labelledby="customer-tab-md">
            <div class="container col-xm-12">
                {{-- @include('customer.partials.table', ['customers' => $customers]) --}}
            </div>
        </div>
    </div>
</div>


@endsection



