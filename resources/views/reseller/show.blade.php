@extends('layouts.master')
@section('css')

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



