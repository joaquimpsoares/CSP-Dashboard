@extends('layouts.app')


@section('content')


<div class="container col-xm-12">
    <ul class="nav nav-pills md-tabs" id="myTabMD" role="tablist">
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light active" id="home-tab-md" data-toggle="tab" href="#home-md" role="tab" aria-controls="home-md"
            aria-selected="true">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light" id="contact-tab-md" data-toggle="tab" href="#contact-md" role="tab" aria-controls="contact-md"
            aria-selected="false">{{ ucwords(trans_choice('messages.subscription', 2)) }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light" id="profile-tab-md" data-toggle="tab" href="#profile-md" role="tab" aria-controls="profile-md"
            aria-selected="false">{{ ucwords(trans_choice('messages.account', 1)) }}</a>
        </li>
    </ul>
    <div class="tab-content pt-5" id="myTabContentMD">
        <div class="tab-pane fade show active" id="home-md" role="tabpanel" aria-labelledby="home-tab-md">
        </div>
        <div class="tab-pane fade" id="contact-md" role="tabpanel" aria-labelledby="contact-tab-md">
            <div class="container col-xm-12">
                @include('subscriptions.partials.table', ['subscriptions' => $subscriptions])
            </div>
        </div>            
        <div class="tab-pane fade" id="profile-md" role="tabpanel" aria-labelledby="profile-tab-md">
            <div class="container col-xm-12">
                @include('customer.partials.details')
                @include('user.partials.table', ['users' => $users] )
            </div>
        </div>
    </div>
</div>



@endsection


