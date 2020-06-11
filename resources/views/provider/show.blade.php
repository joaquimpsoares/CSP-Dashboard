@extends('layouts.app')


@section('content')

<div class="container">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{ ucwords(trans_choice('messages.reseller', 2)) }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">{{ ucwords(trans_choice('messages.customer', 2)) }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light" id="subscription-tab" data-toggle="tab" href="#subscription" role="tab" aria-controls="subscription" aria-selected="false">{{ ucwords(trans_choice('messages.subscription', 2)) }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light" id="account-tab" data-toggle="tab" href="#account" role="tab" aria-controls="account" aria-selected="false">{{ ucwords(trans_choice('messages.account', 2)) }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light" id="instance-tab" data-toggle="tab" href="#instance" role="tab" aria-controls="instance"  aria-selected="false">{{ ucwords(trans_choice('messages.packages', 2)) }}</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="container col-xm-12">
                @include('reseller.partials.table', ['resellers' => $resellers])
            </div>
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <div class="container col-xm-12">
                @include('customer.partials.table', ['customers' => $customers])
            </div>
        </div>
        <div class="tab-pane fade" id="subscription" role="tabpanel" aria-labelledby="subscription-tab">
            <div class="container col-xm-12">
                @include('subscriptions.partials.table', ['subscriptions' => $subscriptions])
            </div>
        </div>
        <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">
            <div class="container col-xm-12">
                @include('provider.partials.details')
            </div>
        </div>
        <div class="tab-pane fade" id="instance" role="tabpanel" aria-labelledby="instance-tab">
            <div class="container col-xm-12">
                @include('packages.cards')
            </div>
        </div>
    </div>
</div>




@endsection


