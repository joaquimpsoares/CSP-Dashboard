@extends('layouts.app')


@section('content')


<div class="container">
    <section class="section team-section">
        <form  method="POST" action="{{ route('user.update', $user->id) }}" class="col s12" enctype="multipart/form-data">
            @method('patch')
            @csrf
            <div class="card bd-callout-info">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 mb-4">
                            <div class="card card-cascade cascading-admin-card user-card">
                                <div class="card-header">
                                    <div class="data float-center">
                                        <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.edit_profile', 1)) }}</a></h4>
                                    </div>
                                </div>
                                <div class="card-body card-body-cascade">
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="md-form form-sm mb-0">
                                                <label for="username" class="">{{ ucwords(trans_choice('messages.username', 1)) }}</label>
                                                <input type="text" id="username" name="username" class="form-control form-control-sm" value="{{$user->username}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="md-form form-sm mb-0">
                                                <label for="email" class="">{{ ucwords(trans_choice('messages.email', 1)) }}</label>
                                                <input type="text" id="email" name="email" class="form-control form-control-sm" value="{{$user->email}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="md-form form-sm mb-0">
                                                <label for="first_name" class="">{{ ucwords(trans_choice('messages.first_name', 1)) }}</label>
                                                <input type="text" id="first_name" name="first_name" class="form-control form-control-sm" value="{{$user->first_name}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="md-form form-sm mb-0">
                                                <label for="last_name" class="">{{ ucwords(trans_choice('messages.last_name', 1)) }}</label>
                                                <input type="text" id="last_name" name="last_name" class="form-control form-control-sm" value="{{$user->last_name}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="md-form form-sm mb-0">
                                                <label for="address" class="">{{ ucwords(trans_choice('messages.address_1', 1)) }}</label>
                                                <input type="text" id="address" name="address" class="form-control form-control-sm" value="{{$user->address}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-12">
                                            <div class="md-form form-sm mb-0">
                                                <label for="city" class="">{{ ucwords(trans_choice('messages.city', 1)) }}</label>
                                                <input type="text" id="city" name="city" class="form-control form-control-sm" value="{{$user->city}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <label for="country">{{ucwords(trans_choice('messages.country', 1))}}</label>
                                            <div class="md-form">
                                                <select name='country_id' class="country_select" id="country_id"style="width: 100%">
                                                    <option value="{{$user->country_id ?? ' ' }}" selected>{{$user->country->name ?? ' ' }}</option>
                                                    @foreach ($countries as $country)
                                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="md-form form-sm mb-0">
                                                <label for="postal_code" class="">{{ ucwords(trans_choice('messages.postal_code', 1)) }}</label>
                                                <input type="text" id="postal_code" name="postal_code" class="form-control form-control-sm" value="{{$user->postal_code}}">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="float-right">
                                        <button type="submit" class="button submit_btn right">{{ ucwords(trans_choice('messages.update', 1)) }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <div class="col-md-4 mb-4 text-center">
                            <div class="card profile-card">
                                <div class="card-header">
                                    <div class="data float-center">
                                        <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.avatar', 1)) }}</a></h4>
                                    </div>
                                </div>
                                <div class="avatar z-depth-1-half mb-4">
                                    <img src=" {{$user->avatar}} " class="rounded-circle" alt="First sample avatar image" height="250" width="250">
                                </div>
                                <div class="card-body pt-0 mt-0">
                                    <div class="custom-file">
                                        <label class="custom-file-label" for="customFileLang">Select file</label>
                                        <input type="file" name="avatar" class="custom-file-input" id="customFileLang">
                                    </div>
                                    <div class="row">
                                        <div class=" col-xs-12">
                                            <h6 class="font-weight-bold cyan-text mb-4"></h6>
                                        </div>
                                    </div>
                                    <label for="notificastions" class="font-weight-bold cyan-text mb-4">{{ ucwords(trans_choice('messages.notifications_settings', 1)) }}</label>
                                    <select name="notifications" class="custom-select" multiple>
                                        @foreach ($notifications as $key=> $item)
                                        <option value={{$item}}>{{$item}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            @switch($user->userLevel->name)
            @case('Reseller')
            <h2>{{ ucwords(trans_choice('messages.reseller_configuration', 1)) }}</h2>
            <hr>
            <div class="card bd-callout-success">
                <div class="card-body">
                    <img class="img" height="30" src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Kaspersky_Lab_logo.svg/1600px-Kaspersky_Lab_logo.svg.png" alt="">
                    <h5 class="card-title"> {{ ucwords(trans_choice('messages.kaspersky_reseller_conf', 1)) }}</h5>
                    <p class="card-text">Please add your reseller pin, if you don have one please follow the <a href="https://www.kasperskypartners.com/?eid=register">link</a> to obtain one from Kaspersky Official Site. </p>
                    <div class="col-lg-2 col-md-4">
                        <label for="pin" class="">{{ ucwords(trans_choice('messages.reseller_pin', 1)) }}</label>
                        <input type="text" id="pin" name="pin" class="form-control form-control-sm" value="{{old('pin')}}">
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="button submit_btn right">{{ ucwords(trans_choice('messages.update', 1)) }}</button>
                </div>
            </div>
            <div class="card bd-callout-success">
                <div class="card-body">
                    <img class="img" height="50" src="https://i2.wp.com/stratus.net.nz/wp-content/uploads/2018/06/Microsoft-CSP.png?resize=1160%2C334&ssl=1" alt=""> 
                    <h5 class="card-title">{{ ucwords(trans_choice('messages.microsoft_reseller_conf', 1)) }}</h5>
                    <p class="card-text">Please add your reseller Microsoft MPNID, if you don have one please follow the <a href="https://partner.microsoft.com/licensing">link</a> to obtain one from Microsoft Partner program. </p>
                    <div class="col-lg-2 col-md-4">
                        <label for="mpnid" class="">{{ ucwords(trans_choice('messages.reseller_mpnid', 1)) }}</label>
                        <input type="text" id="mpnid" name="mpnid" class="form-control form-control-sm" value="{{old('mpnid')}}">
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="button submit_btn right">{{ ucwords(trans_choice('messages.update', 1)) }}</button>
                </div>
            </div>  
            @break
            @case('Provider')
            <div class="card bd-callout-info">
                <div class="card-header">
                    <div class="data float-center">
                        <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.instance', 1)) }}</a></h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-lg-12 col-md-6">
                        @include('packages.cards')
                    </div>
                </div>
            </div>
            @break
            @default
            {{-- <h2>{{ ucwords(trans_choice('messages.reseller_configuration', 1)) }}</h2>
            <hr>
            <div class="card bd-callout-success">
                <div class="card-body">
                    <img class="img" height="30" src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Kaspersky_Lab_logo.svg/1600px-Kaspersky_Lab_logo.svg.png" alt="">
                    <h5 class="card-title"> {{ ucwords(trans_choice('messages.kaspersky_reseller_conf', 1)) }}</h5>
                    <p class="card-text">Please add your reseller pin, if you don have one please follow the <a href="https://www.kasperskypartners.com/?eid=register">link</a> to obtain one from Kaspersky Official Site. </p>
                    <div class="col-lg-2 col-md-4">
                        <label for="pin" class="">{{ ucwords(trans_choice('messages.reseller_pin', 1)) }}</label>
                        <input type="text" id="pin" name="pin" class="form-control form-control-sm" value="{{old('pin')}}">
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="button submit_btn right">{{ ucwords(trans_choice('messages.update', 1)) }}</button>
                </div>
            </div>
            <div class="card bd-callout-success">
                <div class="card-body">
                    <img class="img" height="50" src="https://i2.wp.com/stratus.net.nz/wp-content/uploads/2018/06/Microsoft-CSP.png?resize=1160%2C334&ssl=1" alt=""> 
                    <h5 class="card-title">{{ ucwords(trans_choice('messages.microsoft_reseller_conf', 1)) }}</h5>
                    <p class="card-text">Please add your reseller Microsoft MPNID, if you don have one please follow the <a href="https://partner.microsoft.com/licensing">link</a> to obtain one from Microsoft Partner program. </p>
                    <div class="col-lg-2 col-md-4">
                        <label for="mpnid" class="">{{ ucwords(trans_choice('messages.reseller_mpnid', 1)) }}</label>
                        <input type="text" id="mpnid" name="mpnid" class="form-control form-control-sm" value="{{old('mpnid')}}">
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="button submit_btn right">{{ ucwords(trans_choice('messages.update', 1)) }}</button>
                </div>
            </div>  --}}
            <div class="card bd-callout-info">
                <div class="card-header">
                    <div class="data float-center">
                        <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.instance', 1)) }}</a></h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-lg-12 col-md-6">
                        @include('packages.cards')
                    </div>
                </div>
            </div>
            @endswitch
            
        </form>
    </section>
</div>


<script>
    $(document).ready(function() {
        $('.country_select').select2();
    });
</script>
@endsection


