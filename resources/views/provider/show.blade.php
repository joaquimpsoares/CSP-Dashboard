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

@include('provider.partials.home', ['subscriptions' => $subscriptions])




<div class="row row-deck">
    <div class="col-xl-4 col-lg-5 col-md-12">
        @include('provider.partials.details')
    </div>

    <div class="col-xl-8 col-lg-7 col-md-12">
        @include('reseller.partials.table', ['resellers' => $resellers])
    </div>

</div>
<div class="col-xl-12 co-llg-12 col-md-12">
    <div class="responsive">
        @include('customer.partials.table', ['customers' => $customers])
    </div>
</div>
<div class="col-xl-12 co-llg-12 col-md-12">
    @include('subscriptions.partials.table', ['subscriptions' => $subscriptions])
</div>
<div class="col-xl-12 co-llg-12 col-md-12">
    @include('user.partials.table', ['users' => $users] )
</div>

<div class="col-xl-12 co-llg-12 col-md-12">
    <div class="container col-xm-12">
        @include('packages.cards')
    </div>
</div>




@endsection


