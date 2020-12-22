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

@section('content')
{{-- @dd($user); --}}

<section class="section team-section">
    <form  method="POST" action="{{ route('user.update', $user->id) }}" class="col s12" enctype="multipart/form-data">
        @method('patch')
        @csrf
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
                                        <input type="text" id="username" name="username" class="form-control form-control" value="{{$user->username}}">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="md-form form-sm mb-0">
                                        <label for="email" class="">{{ ucwords(trans_choice('messages.email', 1)) }}</label>
                                        <input type="text" id="email" name="email" class="form-control form-control" value="{{$user->email}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="md-form form-sm mb-0">
                                        <label for="name" class="">{{ ucwords(trans_choice('messages.name', 1)) }}</label>
                                        <input type="text" id="name" name="name" class="form-control form-control" value="{{$user->name}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="md-form form-sm mb-0">
                                        <label for="last_name" class="">{{ ucwords(trans_choice('messages.last_name', 1)) }}</label>
                                        <input type="text" id="last_name" name="last_name" class="form-control form-control" value="{{$user->last_name}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="md-form form-sm mb-0">
                                        <label for="address" class="">{{ ucwords(trans_choice('messages.address_1', 1)) }}</label>
                                        <input type="text" id="address" name="address" class="form-control form-control" value="{{$user->address}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-12">
                                    <div class="md-form form-sm mb-0">
                                        <label for="city" class="">{{ ucwords(trans_choice('messages.city', 1)) }}</label>
                                        <input type="text" id="city" name="city" class="form-control form-control" value="{{$user->city}}">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label for="country">{{ucwords(trans_choice('messages.country', 1))}}</label>
                                        <select name="country_id" id="country_id" class="form-control  SlectBox" sf-validate="required" required>
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
                                        <input type="text" id="postal_code" name="postal_code" class="form-control form-control" value="{{$user->postal_code}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Users Roles</label>
                                <select class="form-control SlectBox" data-placeholder="Choose Browser" multiple>
                                    <option value="{{$user->roles->first()->id ?? ' ' }}" selected>{{$user->roles->first()->name ?? ' ' }}</option>
                                    @foreach ($roles as $role)
                                    <option value={{$role->id}}>
                                        {{$role->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <br>
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary">{{ ucwords(trans_choice('messages.update', 1)) }}</button>
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
                        <div class="user-pic">
                            <img alt="User Avatar" class="rounded-circle  mr-2" src="{{$user->avatar}}">
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
                        </div>
                    </div>
                    @include('user.partials.updatepass')
                </div>
            </div>
        </div>
    </form>
</section>

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
{{-- <script src="{{URL::asset('assets/js/formelementadvnced.js')}}"></script> --}}
{{-- <script src="{{URL::asset('assets/js/form-elements.js')}}"></script> --}}
{{-- <script src="{{URL::asset('assets/js/file-upload.js')}}"></script> --}}
@endsection


{{-- @switch($user->userLevel->name)
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
                <input type="text" id="pin" name="pin" class="form-control form-control" value="{{old('pin')}}">
            </div>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ ucwords(trans_choice('messages.update', 1)) }}</button>
        </div>
    </div>
    <div class="card bd-callout-success">
        <div class="card-body">
            <img class="img" height="50" src="https://i2.wp.com/stratus.net.nz/wp-content/uploads/2018/06/Microsoft-CSP.png?resize=1160%2C334&ssl=1" alt="">
            <h5 class="card-title">{{ ucwords(trans_choice('messages.microsoft_reseller_conf', 1)) }}</h5>
            <p class="card-text">Please add your reseller Microsoft MPNID, if you don have one please follow the <a href="https://partner.microsoft.com/licensing">link</a> to obtain one from Microsoft Partner program. </p>
            <div class="col-lg-2 col-md-4">
                <label for="mpnid" class="">{{ ucwords(trans_choice('messages.reseller_mpnid', 1)) }}</label>
                <input type="text" id="mpnid" name="mpnid" class="form-control form-control" value="{{old('mpnid')}}">
            </div>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ ucwords(trans_choice('messages.update', 1)) }}</button>
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
    <h2>{{ ucwords(trans_choice('messages.reseller_configuration', 1)) }}</h2>
    <hr>
    <div class="card bd-callout-success">
        <div class="card-body">
            <img class="img" height="30" src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/Kaspersky_Lab_logo.svg/1600px-Kaspersky_Lab_logo.svg.png" alt="">
            <h5 class="card-title"> {{ ucwords(trans_choice('messages.kaspersky_reseller_conf', 1)) }}</h5>
            <p class="card-text">Please add your reseller pin, if you don have one please follow the <a href="https://www.kasperskypartners.com/?eid=register">link</a> to obtain one from Kaspersky Official Site. </p>
            <div class="col-lg-2 col-md-4">
                <label for="pin" class="">{{ ucwords(trans_choice('messages.reseller_pin', 1)) }}</label>
                <input type="text" id="pin" name="pin" class="form-control form-control" value="{{old('pin')}}">
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
                <input type="text" id="mpnid" name="mpnid" class="form-control form-control" value="{{old('mpnid')}}">
            </div>
        </div>
        <div class="text-right">
            <button type="submit" class="button submit_btn right">{{ ucwords(trans_choice('messages.update', 1)) }}</button>
        </div>
    </div>
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
    @endswitch --}}
