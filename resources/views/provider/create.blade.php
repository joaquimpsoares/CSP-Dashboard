@extends('layouts.master')
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')

<div class="container mt-5">
    <section class="dark-grey-text">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <h5 class="card-title">
                            {{ ucwords(trans_choice('messages.new_provider', 1)) }}
                        </h5>
                        <p class="text-muted font-weight-light">
                            @lang('A general user profile information.')
                        </p>
                    </div>
                    <div class="col-md-9">
                        <form method="POST" action="{{ route('provider.store') }}" class="col s12">
                            @csrf
                            <h1></h1>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="company_name" class="">{{ ucwords(trans_choice('messages.company_name', 1)) }}</label>
                                    <input type="text" id="company_name" name="company_name" class="form-control" value="{{ old('company_name') }}">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="nif">{{ ucwords(trans_choice('messages.nif', 1)) }}</label>
                                    <input type="text" id="nif" name="nif" class="form-control" value="{{ old('nif') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="country">{{ucwords(trans_choice('messages.country', 1))}}</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="country_id"><i class="fa fa-plane" aria-hidden="true"></i>
                                            </label>
                                        </div>

                                        <select name="country_id" class="custom-select" id="country_id" required>
                                            <option value="">Choose...</option>
                                            @foreach ($countries as $key => $country)
                                            <option value="{{$key}}">{{$country}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            {{ucwords(trans_choice('messages.Please_select_a_valid_country', 1))}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <label for="address" class="">{{ucwords(trans_choice('messages.address_1', 1))}}</label>
                            <input type="text" id="address_1" name="address_1" class="form-control mb-4" value="{{ old('address_1') }}" placeholder="1234 Main St">
                            <label for="address-2" class="">{{ucwords(trans_choice('messages.address_2', 1))}} (optional)</label>
                            <input type="text" id="address_2" name="address_2" class="form-control mb-4" value="{{ old('address_2') }}" placeholder="Appartment or numer">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <label for="address-2" class="">{{ucwords(trans_choice('messages.city', 1))}}</label>
                                    <input type="text" id="city" name="city" class="form-control mb-4" value="{{ old('city') }}">
                                </div>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <label for="zip">{{ucwords(trans_choice('messages.state', 1))}}</label>
                                    <input name="state" type="text" class="form-control" id="zip" placeholder="" value="{{ old('state') }}" required >
                                    <div class="invalid-feedback">
                                        Zip code required.
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <label for="zip">Zip</label>
                                    <input name="postal_code" type="text" class="form-control" id="zip" placeholder="" value="{{ old('postal_code') }}" required>
                                    <div class="invalid-feedback">
                                        Zip code required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h5 class="card-title">
                                @lang('User Details')
                            </h5>
                            <p class="text-muted font-weight-light">
                                @lang('A general user profile information.')
                            </p>
                        </div>
                        <div class="col-md-9">
                            @include('user.partials.details', ['edit' => false, 'profile' => false])
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h5 class="card-title">
                                @lang('Login Details')
                            </h5>
                            <p class="text-muted font-weight-light">
                                @lang('Details used for authenticating with the application.')
                            </p>
                        </div>
                        <div class="col-md-9">
                            @include('user.partials.auth', ['edit' => false])
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <button class="btn btn-primary" type="submit">{{ucwords(trans_choice('messages.create', 1))}}</button>
            </div>
        </div>
    </div>
</section>
</div>

@endsection



