@extends('layouts.app')


@section('content')


<div class="container col-xm-12">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light btn rgba-blue-light active" id="home-tab-md" data-toggle="tab" href="#home-md" role="tab" aria-controls="home-md"
            aria-selected="true">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light" id="customer-tab-md" data-toggle="tab" href="#customer-md" role="tab" aria-controls="customer-md"
            aria-selected="false">{{ ucwords(trans_choice('messages.customer', 2)) }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light" id="subscription-tab-md" data-toggle="tab" href="#subscription-md" role="tab" aria-controls="subscription-md"
            aria-selected="false">{{ ucwords(trans_choice('messages.subscription', 2)) }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light" id="profile-tab-md" data-toggle="tab" href="#profile-md" role="tab" aria-controls="profile-md"
            aria-selected="false">{{ ucwords(trans_choice('messages.account', 1)) }}</a>
        </li>
    </ul>
    <div class="tab-content pt-5" id="myTabContentMD">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            @include('reseller.partials.home', ['subscriptions' => $subscriptions])
        </div>
        <div class="tab-pane fade" id="subscription-md" role="tabpanel" aria-labelledby="subscription-tab-md">
            <div class="container col-xm-12">
                @include('subscriptions.partials.row', ['subscriptions' => $subscriptions])
            </div>
        </div>
        <div class="tab-pane fade" id="profile-md" role="tabpanel" aria-labelledby="profile-tab-md">
            <div class="container col-xm-12">
                @include('reseller.partials.details')
                @include('user.partials.table', ['users' => $users] )
            </div>
        </div>
        <div class="tab-pane fade" id="customer-md" role="tabpanel" aria-labelledby="customer-tab-md">
            <div class="container col-xm-12">
                @include('customer.partials.table', ['customers' => $customers])
            </div>
        </div>
    </div>
</div>


@endsection



