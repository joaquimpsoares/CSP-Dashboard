@extends('layouts.master')
@section('css')
<!-- Select2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<!-- File Uploads css -->
<link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
<!-- Time picker css -->
<link href="{{URL::asset('assets/plugins/time-picker/jquery.timepicker.css')}}" rel="stylesheet" />
<!-- Date Picker css -->
<link href="{{URL::asset('assets/plugins/date-picker/date-picker.css')}}" rel="stylesheet" />
<!-- File Uploads css-->
 <link href="{{URL::asset('assets/plugins/fileupload/css/fileupload.css')}}" rel="stylesheet" type="text/css" />
<!--Mutipleselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/multipleselect/multiple-select.css')}}">
<!--Sumoselect css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">
<!--intlTelInput css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/intl-tel-input-master/intlTelInput.css')}}">
<!--Jquerytransfer css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/jQuerytransfer/jquery.transfer.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/jQuerytransfer/icon_font/icon_font.css')}}">
<!--multi css-->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/multi/multi.min.css')}}">
@endsection
<style>
    .no-spin::-webkit-inner-spin-button, .no-spin::-webkit-outer-spin-button {
    -webkit-appearance: none !important;
    margin: 0 !important;
}

.no-spin {
    -moz-appearance:textfield !important;
}
</style>
@section('content')

<div class="container mt-5">
    <section class="dark-grey-text">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form method="POST" action="{{ route('reseller.store') }}" class="col s12">
                            @csrf
                            <h1>{{ ucwords(trans_choice('messages.new_reseller', 1)) }}</h1>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="company_name" class="">{{ ucwords(trans_choice('messages.company_name', 1)) }}</label>
                                    <input type="text" id="company_name" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}" >
                                    @error('company_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
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
                                        <select name="country_id" class="search-box" id="country_id" required>
                                            <option value="">Choose...</option>
                                            @foreach ($countries as $country)
                                            <option value="{{$country->id}}">{{$country->name}}</option>
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
                            <div class="row">
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <label for="address-2" class="">{{ucwords(trans_choice('messages.mpnid', 1))}}</label>
                                    <input type="number" id="mpnid" name="mpnid" class="form-control mb-4 no-spin" min="4" value="{{ old('mpnid') }}">
                                </div>
                            </div>
                            <hr>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">@</span>
                                </div>
                                <input name="email" type="text" class="form-control py-0" aria-describedby="basic-addon1" value="{{ old('email') }}" placeholder="youremail@example.com">
                            </div>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <input name="username" type="text" class="form-control py-0" aria-describedby="basic-addon1" value="{{ old('username') }}" placeholder="Username (Optional)">
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="status">{{ ucwords(trans_choice('messages.status', 1)) }}</label>
                                    <div class="form-group">
                                        <select name="status_id" class="custom-select" sf-validate="required">
                                            @foreach ($statuses as $status)
                                            <option value="{{$status->id}}">{{ucwords(trans_choice($status->name, 1))}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
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
<!--Select2 js -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
<!-- Timepicker js -->
<script src="{{URL::asset('assets/plugins/time-picker/jquery.timepicker.js')}}"></script>
<script src="{{URL::asset('assets/plugins/time-picker/toggles.min.js')}}"></script>
<!-- Datepicker js -->
<script src="{{URL::asset('assets/plugins/date-picker/date-picker.js')}}"></script>
<script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>
<script src="{{URL::asset('assets/plugins/input-mask/jquery.maskedinput.js')}}"></script>
<!--File-Uploads Js-->
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>
<!-- File uploads js -->
<script src="{{URL::asset('assets/plugins/fileupload/js/dropify.js')}}"></script>
<script src="{{URL::asset('assets/js/filupload.js')}}"></script>
<!-- Multiple select js -->
<script src="{{URL::asset('assets/plugins/multipleselect/multiple-select.js')}}"></script>
<script src="{{URL::asset('assets/plugins/multipleselect/multi-select.js')}}"></script>
<!--Sumoselect js-->
<script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>
<!--intlTelInput js-->
<script src="{{URL::asset('assets/plugins/intl-tel-input-master/intlTelInput.js')}}"></script>
<script src="{{URL::asset('assets/plugins/intl-tel-input-master/country-select.js')}}"></script>
<script src="{{URL::asset('assets/plugins/intl-tel-input-master/utils.js')}}"></script>
<!--jquery transfer js-->
<script src="{{URL::asset('assets/plugins/jQuerytransfer/jquery.transfer.js')}}"></script>
<!--multi js-->
<script src="{{URL::asset('assets/plugins/multi/multi.min.js')}}"></script>
<!-- Form Advanced Element -->
<script src="{{URL::asset('assets/js/formelementadvnced.js')}}"></script>
<script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
<script src="{{URL::asset('assets/js/file-upload.js')}}"></script>
@endsection

