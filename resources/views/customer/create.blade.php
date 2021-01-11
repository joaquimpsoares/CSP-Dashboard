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
                    <div class="col-lg-12">
                        <form method="POST" action="{{ route('customer.store') }}" class="col s12">
                            @csrf
                            <h1>{{ ucwords(trans_choice('messages.new_customer', 1)) }}</h1>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="company_name" class="">{{ ucwords(trans_choice('messages.company_name', 1)) }}</label>
                                    <input type="text" id="company_name" name="company_name" class="form-control  @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}">
                                    @error('company_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="nif">{{ ucwords(trans_choice('messages.nif', 1)) }}</label>
                                    <input type="text" id="nif" name="nif" class="form-control @error('nif') is-invalid @enderror" value="{{ old('nif') }}">
                                    @error('nif')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="country">{{ucwords(trans_choice('messages.country', 1))}}</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="country_id"><i class="fa fa-plane" aria-hidden="true"></i></label>
                                        </div>
                                        <select name="country_id" class="country_select @error('country_id') is-invalid @enderror" id="country_id" style="width: 95%" required>
                                            <option value="">Choose...</option>
                                            @foreach ($countries as $key => $country)
                                            <option value="{{$key}}">{{$country}}</option>
                                            @endforeach
                                        </select>
                                        @error('country_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                            </div>
                            <label for="address_1" class="">{{ucwords(trans_choice('messages.address_1', 1))}}</label>
                            <input type="text" id="address_1" name="address_1" class="form-control mb-4 @error('address_1') is-invalid @enderror" value="{{ old('address_1') }}" placeholder="1234 Main St">
                            @error('address_1')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            <label for="address_2" class="">{{ucwords(trans_choice('messages.address_2', 1))}} (optional)</label>
                            <input type="text" id="address_2" name="address_2" class="form-control mb-4 @error('address_2') is-invalid @enderror" value="{{ old('address_2') }}" placeholder="Appartment or numer">
                            @error('company_namaddress_2e')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                            <div class="row">
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <label for="city" class="">{{ucwords(trans_choice('messages.city', 1))}}</label>
                                    <input type="text" id="city" name="city" class="form-control mb-4 @error('city') is-invalid @enderror" value="{{ old('city') }}">
                                    @error('city')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <label for="state">{{ucwords(trans_choice('messages.state', 1))}}</label>
                                    <input name="state" type="text" class="form-control @error('state') is-invalid @enderror" id="state" placeholder="" value="{{ old('state') }}" required >
                                    @error('state')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <label for="postal_code">Zip</label>
                                    <input name="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror" id="postal_code" placeholder="" value="{{ old('postal_code') }}" required>
                                    @error('postal_code')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
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
@section('js')

@endsection
