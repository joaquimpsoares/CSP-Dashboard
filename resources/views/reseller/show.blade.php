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

@section('content')

<!--/app header-->
<div class="main-proifle">
    <div class="row">
        <div class="col-lg-3">
            <div class="box-widget widget-user">
                <div class="widget-user-image   ">
                    <div class="ml-sm-4 mt-4">
                        {{-- <h4 class="pro-user-username mb-3 font-weight-bold">John Thomson <i class="fa fa-check-circle text-success"></i></h4> --}}
                        <div class="d-flex mb-1">
                            <div class="media-icon bg-danger-transparent text-danger mr-3 mt-1">
                                <i class="fa fa-briefcase"></i>
                            </div>
                            <div class="media-body">
                                <small class="text-muted">{{ucwords(trans_choice('messages.company_name', 1))}} </small>
                                <div class="font-weight-bold">
                                    {{$reseller->company_name}}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mb-1">
                            <div class="media-icon bg-info-transparent text-info mr-3 mt-1">
                                <i class="fa fa-map"></i>
                            </div>
                            <div class="media-body">
                                <small class="text-muted">{{ucwords(trans_choice('messages.address_1', 1))}} </small>
                                <div class="font-weight-bold">
                                    {{$reseller->address_1}} <br>
                                    {{$reseller->city}}, {{$reseller->state}}, {{$reseller->postal_code}}
                                    {{$reseller->country->name}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="d-flex">
                <div class="media-icon bg-warning-transparent text-warning mr-3 mt-1">
                    <i class="fa fa-slack"></i>
                </div>
                <div class="media-body">
                    <small class="text-muted">{{ ucwords(trans_choice('messages.mpnid', 1)) }} </small>
                    <div class="font-weight-bold">
                        {{$reseller->mpnid}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-md-auto">
            <div class="text-lg-right mt-4 mt-lg-0">
                {{-- @dd($reseller->format()['mainUser']) --}}
                @canImpersonate
                @if(!empty($reseller->format()['mainUser']))
                <a class="btn btn-white" href="{{ route('impersonate', $reseller->format()['mainUser']['id']) }}"><i class="fa fa-user-secret"></i>{{ ucwords(trans_choice('messages.impersonate', 1)) }}</a>
                {{-- <a href="#" class="btn btn-white"><i class="fa fa-user-secret"></i> {{ ucwords(trans_choice('messages.impersonate', 1)) }}</a> --}}
                @endif
                @endCanImpersonate
                <a href="{{$reseller->format()['path']}}/edit" class="btn btn-primary">{{ ucwords(trans_choice('messages.edit_reseller', 1)) }} </a>
            </div>
        </div>
        <div class="col-lg-12 col-md-auto">
            <div class="mt-5">
                <div class="main-profile-contact-list row">
                    <div class="media col-sm-4">
                        <div class="media-icon bg-light text-primary mr-3 mt-1">
                            <i class="fa fa-users fs-18"></i>
                        </div>
                        <div class="media-body">
                            <small class="text-muted">{{ ucwords(trans_choice('messages.customer', 2)) }}</small>
                            <div class="font-weight-bold fs-25">
                                {{$customers->count()}}
                            </div>
                        </div>
                    </div>
                    <div class="media col-sm-4">
                        <div class="media-icon bg-light text-primary mr-3 mt-1">
                            <i class="fa fa-connectdevelop fs-18"></i>
                        </div>
                        <div class="media-body">
                            <small class="text-muted">{{ ucwords(trans_choice('messages.subscription', 2)) }}</small>
                            <div class="font-weight-bold fs-25">
                                {{$subscriptions->count()}}
                            </div>
                        </div>
                    </div>
                    <div class="media col-sm-4">
                        <div class="media-icon bg-light text-primary mr-3 mt-1">
                            <i class="fa fa-feed fs-18"></i>
                        </div>
                        <div class="media-body">
                            <small class="text-muted">{{ ucwords(trans_choice('messages.order', 2)) }}</small>
                            <div class="font-weight-bold fs-25">
                                {{$reseller->orders}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="profile-cover">
        <div class="wideget-user-tab">
            <div class="tab-menu-heading p-0">
                <div class="tabs-menu1 px-3">
                    <ul class="nav">
                        <li><a href="#tab-7" class="active" data-toggle="tab">{{ ucwords(trans_choice('messages.details', 2)) }}</a></li>
                        <li><a href="#tab-8" data-toggle="tab" class="">{{ ucwords(trans_choice('messages.customer', 2)) }}</a></li>
                        <li><a href="#tab-9" data-toggle="tab" class="">{{ ucwords(trans_choice('messages.subscription', 2)) }}</a></li>
                        <li><a href="#tab-10" data-toggle="tab" class="">{{ ucwords(trans_choice('messages.user', 2)) }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div><!-- /.profile-cover -->
</div>
<!-- Row -->
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="border-0">
            <div class="tab-content">
                <div class="tab-pane active"  id="tab-7">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Details</h5>
                            <p class="card-text">Content</p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab-8">
                    @include('customer.partials.table', ['customers' => $customers])
                </div>
                <div class="tab-pane" id="tab-9">
                    @include('subscriptions.partials.table', ['subscriptions' => $subscriptions])
                </div>

                <div class="tab-pane" id="tab-10">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ ucwords(trans_choice('messages.user_table', 2)) }}</h3>
                            <div class="card-options">
                                <div class="btn-group ml-5 mb-0">
                                    <button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-plus"></i> {{ ucwords(__('messages.options')) }}</button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{route('user.create')}}"><i class="fa fa-plus mr-2"></i>{{ ucwords(__('messages.new_user')) }}</a>
                                        {{-- <a class="dropdown-item" href="#"><i class="fa fa-eye mr-2"></i>View all new tab</a>
                                        <a class="dropdown-item" href="#"><i class="fa fa-edit mr-2"></i>Edit Page</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#"><i class="fa fa-cog mr-2"></i> Settings</a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @include('user.partials.table', ['users' => $users])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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


