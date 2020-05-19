@extends('layouts.app')


@section('content')



<div class="box col-xm-12">
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
            <div class="row">
                <div class="col-md-12">
                    <div class="md-form">
                        <hr>
                        <p>{{ ucwords(trans_choice('messages.user_info', 1)) }}</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="">
                    <i class="fas fa-user fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
                    <div class="card-body">
                        <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.user_table', 1)) }}</a></h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="md-form">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered" id="customers">
                                            <thead>
                                                <tr>
                                                    <th>{{ ucwords(trans_choice('messages.avatar', 1)) }}</th>
                                                    <th>{{ ucwords(trans_choice('messages.username', 1)) }}</th>
                                                    <th>{{ ucwords(trans_choice('messages.first_name', 1)) }}</th>
                                                    <th>{{ ucwords(trans_choice('messages.last_name', 1)) }}</th>
                                                    <th>{{ ucwords(trans_choice('messages.status', 1)) }}</th>
                                                    {{-- <th>{{ ucwords(trans_choice('messages.action', 1)) }}</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $user)
                                                <tr>
                                                    <td>
                                                        <ul>
                                                            <li class="nav-item avatar">
                                                                <img src="{{$user->avatar}}" class="rounded-circle z-depth-0" alt="avatar image"  width='50' Height ='auto'>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <a href="/user/{{$user->id }}">    {{ $user['username'] }}</a>
                                                    </td>
                                                    <td>{{ $user['first_name'] }}</td>
                                                    <td>{{ $user['last_name'] }}</td>
                                                    <td>{{ ucwords(trans_choice($user->status->name, 1)) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="instance" role="tabpanel" aria-labelledby="instance-tab">
            <div class="row">
                @foreach ($provider->instances as $instance)
                <div class="col-md-2">
                    <div class="card">
                        <img class="card-img-top" src="https://img.pngio.com/microsoft-corporate-logo-guidelines-trademarks-microsoft-logo-png-2008_900.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h2 class="card-title"> <strong>{{ ucwords(trans_choice('messages.name', 1)) }}:</strong> {{$instance['name']}}</h2>
                            <p class="card-text"></p>
                            <a href=" {{ route('instances.edit', $instance->id) }}" class="button is-info is-outlined"> {{ ucwords(trans_choice('messages.edit', 1)) }}</a>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="col-md-2">
                <div class="card">
                    <img class="card-img-top" src="https://img.pngio.com/microsoft-corporate-logo-guidelines-trademarks-microsoft-logo-png-2008_900.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h2 class="card-title"><strong>{{ ucwords(trans_choice('messages.name', 1)) }}:</strong> {{ ucwords(trans_choice('messages.microsoft_instance', 1)) }}</h2>
                        <p class="card-text"></p>
                        <a href=" {{ route('instances.create', $provider->id) }}" class="button is-info is-outlined">{{ ucwords(trans_choice('messages.add_new_instance', 1)) }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


