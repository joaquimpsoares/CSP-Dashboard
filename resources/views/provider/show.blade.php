@extends('layouts.app')


@section('content')
<div class="box col-xm-12">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
            aria-selected="true">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
            aria-selected="false">{{ ucwords(trans_choice('messages.reseller', 2)) }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact"
            aria-selected="false">{{ ucwords(trans_choice('messages.customer', 2)) }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light" id="subscription-tab" data-toggle="tab" href="#subscription" role="tab" aria-controls="subscription"
            aria-selected="false">{{ ucwords(trans_choice('messages.subscription', 2)) }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light" id="account-tab" data-toggle="tab" href="#account" role="tab" aria-controls="account"
            aria-selected="false">{{ ucwords(trans_choice('messages.account', 2)) }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light" id="instance-tab" data-toggle="tab" href="#instance" role="tab" aria-controls="instance"
            aria-selected="false">{{ ucwords(trans_choice('messages.instance', 2)) }}</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="box col-xm-12">
            wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack
            lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard
            locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify
            squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie
            etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog
            stumptown. Pitchfork sustainable tofu synth chambray yr.
            </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="box col-xm-12">
            @include('reseller.partials.table', ['resellers' => $resellers])
            </div>
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <div class="box col-xm-12">
            @include('customer.partials.table', ['customers' => $customers])
            </div>
        </div>
        <div class="tab-pane fade" id="subscription" role="tabpanel" aria-labelledby="subscription-tab">
            wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack
            lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard
            locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings gentrify
            squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles pitchfork biodiesel fixie
            etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of them, vinyl craft beer blog
            stumptown. Pitchfork sustainable tofu synth chambray yr.
        </div>
        <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">
            <div class="box col-xm-12">
            @include('provider.partials.details')
            </div>
        </div>
        <div class="tab-pane fade" id="instance" role="tabpanel" aria-labelledby="instance-tab">
            <div class="row">
                <div class="col-md-2">
                    <div class="card">
                        <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Others/images/43.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h2 class="card-title">
                                <a href="{{ "instance/" . $instance->id}}">{{$instance->provider}}</a></h2>
                            <p class="card-text">
                               <strong>Instance Name:</strong> {{$instance->name}}
                            </p>
                            <a href=" {{ "instance/" . $instance->id}}" class="button is-info is-outlined">
                                View
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
    
    
