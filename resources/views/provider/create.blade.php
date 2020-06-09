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
                    <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.new_provider', 2)) }}</a></h4>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                            <div class="row">
                                <form method="POST" action="{{ route('provider.store') }}">
                                    @csrf
                                    <div class="section-top-border">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" name="company_name" placeholder="{{ ucwords(trans_choice('messages.company_name', 1)) }}" value="{{ old('company_name') }}" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{ ucwords(trans_choice('messages.company_name', 1)) }}'" required class="single-input">
                                                </div>
                                                {{-- <div class="md-form">
                                                    <input type="text" id="company_name" name="company_name" class="form-control" value="{{ old('company_name') }}">
                                                    <label for="company_name">{{ ucwords(trans_choice('messages.company_name', 1)) }}</label>
                                                </div> --}}
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" name="nif" placeholder="First Name" value="{{ old('nif') }}" onfocus="this.placeholder = ''" onblur="this.placeholder = 'NIF'" required class="single-input">
                                                </div>
                                                {{-- <div class="md-form">
                                                    <input type="text" id="nif" name="nif" class="form-control" value="{{ old('nif') }}">
                                                    <label for="nif">{{ ucwords(trans_choice('messages.nif', 1)) }}</label>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="status">{{ ucwords(trans_choice('messages.country', 1)) }}</label>
                                                    <div class="input-group-icon">
                                                        <div class="country" name="country">
                                                            {{-- <option selected>Choose country</option> --}}
                                                            @foreach ($countries as $country)    
                                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                                            @endforeach
                                                        </div>                                          
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" name="address_1" placeholder="{{ ucwords(trans_choice('messages.address_1', 1)) }}" value="{{ old('address_1') }}" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{ ucwords(trans_choice('messages.address_1', 1)) }}'" required class="single-input">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" name="address_2" placeholder="{{ ucwords(trans_choice('messages.address_2', 1)) }}" value="{{ old('address_2') }}" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{ ucwords(trans_choice('messages.address_2', 1)) }}'" required class="single-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="city" placeholder="{{ ucwords(trans_choice('messages.city', 1)) }}" value="{{ old('city') }}" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{ ucwords(trans_choice('messages.city', 1)) }}'" required class="single-input">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="state" placeholder="{{ ucwords(trans_choice('messages.state', 1)) }}" value="{{ old('state') }}" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{ ucwords(trans_choice('messages.state', 1)) }}'" required class="single-input">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="postal_code" placeholder="{{ ucwords(trans_choice('messages.postal_code', 1)) }}" value="{{ old('postal_code') }}" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{ ucwords(trans_choice('messages.postal_code', 1)) }}'" required class="single-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="status">{{ ucwords(trans_choice('messages.status', 1)) }}</label>
                                            <div class="form-group">
                                                <div name="status" class="status form-select" sf-validate="required">
                                                    <option selected></option>
                                                    @foreach ($statuses as $status)    
                                                    <option value="{{$status->id}}">{{ucwords(trans_choice($status->name, 1))}}</option>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group">
                                            <h3>Invite Provider</h3>
                                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <h3>Send Notification?</h3>
                                            <input type="checkbox" name="sendInvitation" value="1" class="form-control" value="{{ old('sendInvitation') }}" checked="checked">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="button is-rounded is-primary is-outlined">Create</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection


@section('scripts')

<script>
    // In your Javascript (external .js resource or <script> tag)
        $('.country').select2({
            placeholder: 'Select an option'
        });
    </script>
    <script>
        // In your Javascript (external .js resource or <script> tag)
            $('.status').select2({
                placeholder: 'Select an option'
            });
        </script>
    
    @endsection
    
