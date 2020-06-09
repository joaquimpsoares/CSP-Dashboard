@extends('layouts.app')


@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<div class="container">
    <section class="section">
        <div class="card">
            <div class="">
                <i class="fab fa-product-hunt fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
                <div class="card-body">
                    <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.new_reseller', 2)) }}</a></h4>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="row">
                                {{-- <form method="POST" action="{{ route('reseller.store') }}" class="col s12"> --}}
                                    @csrf
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <div class="md-form">
                                                <input type="text" id="company_name" name="company_name" class="form-control" value="{{ old('company_name') }}">
                                                <label for="company_name">{{ ucwords(trans_choice('messages.company_name', 1)) }}</label>
                                            </div>
                                        </div>
                                        <div class="input-field col s4">
                                            <div class="md-form">
                                                <input type="text" id="nif" name="nif" class="form-control" value="{{ old('nif') }}">
                                                <label for="nif">{{ ucwords(trans_choice('messages.nif', 1)) }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s4">    
                                            <select class="js-example-basic-multiple" name="states[]" multiple="multiple">
                                                <option value="AL">Alabama</option>
                                                  ...
                                                <option value="WY">Wyoming</option>
                                              {{-- </select>                                        
                                            <label for="country_id">{{ ucwords(trans_choice('messages.country', 1)) }}</label>
                                            <select name="country_id" class=" js-example-basic-single browser-default custom-select">
                                                <option selected>Open to select country</option>
                                                @foreach ($countries as $country)    
                                                <option value="{{$country->id}}">{{$country->name}}</option>
                                                @endforeach
                                            </select> --}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <div class="md-form">
                                                <input type="text" id="address_1" name="address_1" class="form-control" value="{{ old('address_1') }}">
                                                <label for="address_1">{{ ucwords(trans_choice('messages.address_1', 1)) }}</label>
                                            </div>
                                        </div>
                                        <div class="input-field col s4">
                                            <div class="md-form">
                                                <input type="text" id="address_2" name="address_2" class="form-control" value="{{ old('address_2') }}">
                                                <label for="address_2">{{ ucwords(trans_choice('messages.address_2', 1)) }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <div class="md-form">
                                                <input type="text" id="city" name="city" class="form-control" value="{{ old('city') }}">
                                                <label for="city">{{ ucwords(trans_choice('messages.city', 1)) }}</label>
                                            </div>
                                        </div>
                                        <div class="input-field col s4">
                                            <div class="md-form">
                                                <input type="text" id="state" name="state" class="form-control" value="{{ old('state') }}">
                                                <label for="state">{{ ucwords(trans_choice('messages.state', 1)) }}</label>
                                            </div>
                                        </div>
                                        <div class="input-field col s4">
                                            <div class="md-form">
                                                <input type="text" id="postal_code" name="postal_code" class="form-control" value="{{ old('postal_code') }}">
                                                <label for="postal_code">{{ ucwords(trans_choice('messages.postal_code', 1)) }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <label for="status">{{ ucwords(trans_choice('messages.status', 1)) }}</label>
                                            <select name="status" class="browser-default custom-select">
                                                <option selected></option>
                                                @foreach ($statuses as $status)    
                                                <option value="{{$status->id}}">{{ucwords(trans_choice($status->name, 1))}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <h3>Invite Provider</h3>
                                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <h3>Send Notification?</h3>
                                            <input type="checkbox" name="sendInvitation" value="1" class="form-control" value="{{ old('sendInvitation') }}" checked="checked">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="button btn btn-primary">Create</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>


@endsection


@section('scripts')

<script>
$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>
@endsection

