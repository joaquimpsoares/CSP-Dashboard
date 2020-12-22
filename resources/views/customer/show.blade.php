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

<section>
    @include('customer.partials.details')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <h1 class="mb-4 mt-1 h5 text-center font-weight-bold"></h1>
                <section id="services" class="services section-bg">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Summary for customer {{$customer->company_name}}</h2>
                        </div>
                    </div>
                    <div class="row row-deck">
                        @if(!@empty($serviceCosts))
                        <div class="col-xl-8 col-lg-5 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">
                                        Current Estimated Costs
                                    </div>
                                </div>
                                <div class="card-body">
                                    <dl class="row col-sm-">
                                        <dd class="col-sm-6">
                                            <strong>Billing Start date</strong> <br>
                                            <strong>Billing End date</strong> <br>
                                            <strong>Pretax Total</strong> <br>
                                            <strong>Tax Total</strong> <br>
                                            <strong>After Total</strong> <br>
                                        </dd>
                                        <dd class="col-sm-4">
                                            {{date('d-m-Y', strtotime($serviceCosts->billingStartDate))}} <br>
                                            {{date('d-m-Y', strtotime($costs->billingEndDate))}} <br>
                                            {{number_format($costs->pretaxTotal, 2)}}{{$costs->currencySymbol}} <br>
                                            {{number_format($costs->tax, 2)}}{{$costs->currencySymbol}} <br>
                                            {{number_format($costs->afterTaxTotal, 2)}}{{$costs->currencySymbol}} <br>
                                        </dd>
                                    </dl>
                                    <a class="btn btn-primary" href="\customer\serviceCostsLineitems\{{$customer->id}}">See Details</a>
                                </div>
                                <div class="card-footer text-muted">
                                    Estimation of costs retrieve directly from Microsoft
                                </div>
                            </div>

                            @endif
                        </div>
                        <div class="col-xl-4 col-lg-5 col-md-12">                                <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    Active Subscriptions
                                </div>
                            </div>
                            <div class="card-body">
                                <dl class="row col-sm-12">
                                    <dd class="col-sm-8">
                                        <strong> Subscriptions </strong><br>
                                        <strong>Total Licenses</strong>
                                    </dd>
                                    <dd class="col-sm-4">
                                        {{$customer->subscriptions->count()}} <br>
                                        {{$licensesCount}}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ ucwords(trans_choice('messages.user_table', 1)) }}</h3>
            <div class="card-options">
                <div class="btn-group ml-5 mb-0">
                    <button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-plus"></i> {{ ucwords(__('messages.options')) }}</button>
                    <div class="dropdown-menu">
                        @if(Auth::user()->userLevel->id === 4)
                        <a class="dropdown-item" href="{{route('user.create')}}"><i class="fa fa-plus mr-2"></i>{{ ucwords(__('messages.new_user')) }}</a>
                        @endif
                        <a class="dropdown-item" href="{{route('invite')}}" >{{ ucwords(trans_choice('messages.invite', 2)) }}</a>
                    </div>
                </div>
            </div>
        </div>
        @include('user.partials.table', ['users' => $users] )
    </div>
</section>

{{-- <br>
    <br>
    <br> --}}
    {{-- <ul class="nav nav-pills md-tabs" id="myTabMD" role="tablist">
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light active" id="home-tab-md" data-toggle="tab" href="#home-md" role="tab" aria-controls="home-md"
            aria-selected="true">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light" id="contact-tab-md" data-toggle="tab" href="#contact-md" role="tab" aria-controls="contact-md"
            aria-selected="false">{{ ucwords(trans_choice('messages.subscription', 2)) }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light" id="profile-tab-md" data-toggle="tab" href="#profile-md" role="tab" aria-controls="profile-md"
            aria-selected="false">{{ ucwords(trans_choice('messages.account', 1)) }}</a>
        </li>
    </ul>
    <div class="tab-content pt-5" id="myTabContentMD">
        <div class="tab-pane fade show active" id="home-md" role="tabpanel" aria-labelledby="home-tab-md">
            <div class="card">
                <div class="card-body">
                    <h1 class="mb-4 mt-1 h5 text-center font-weight-bold"></h1>
                    <section id="services" class="services section-bg">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Summary for customer {{$customer->company_name}}</h2>
                            </div>
                        </div>
                        <div class="row row-deck">
                            @if(!@empty($serviceCosts))
                            <div class="col-xl-8 col-lg-5 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">
                                            Current Estimated Costs
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <dl class="row col-sm-">
                                            <dd class="col-sm-6">
                                                <strong>Billing Start date</strong> <br>
                                                <strong>Billing End date</strong> <br>
                                                <strong>Pretax Total</strong> <br>
                                                <strong>Tax Total</strong> <br>
                                                <strong>After Total</strong> <br>
                                            </dd>
                                            <dd class="col-sm-4">
                                                {{date('d-m-Y', strtotime($serviceCosts->billingStartDate))}} <br>
                                                {{date('d-m-Y', strtotime($costs->billingEndDate))}} <br>
                                                {{number_format($costs->pretaxTotal, 2)}}{{$costs->currencySymbol}} <br>
                                                {{number_format($costs->tax, 2)}}{{$costs->currencySymbol}} <br>
                                                {{number_format($costs->afterTaxTotal, 2)}}{{$costs->currencySymbol}} <br>
                                            </dd>
                                        </dl>
                                        <a class="btn btn-primary" href="\customer\serviceCostsLineitems\{{$customer->id}}">See Details</a>
                                    </div>
                                    <div class="card-footer text-muted">
                                        Estimation of costs retrieve directly from Microsoft
                                    </div>
                                </div>

                                @endif
                            </div>
                            <div class="col-xl-4 col-lg-5 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">
                                            Active Subscriptions
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <dl class="row col-sm-12">
                                            <dd class="col-sm-8">
                                                <strong> Subscriptions </strong><br>
                                                <strong>Total Licenses</strong>
                                            </dd>
                                            <dd class="col-sm-4">
                                                {{$customer->subscriptions->count()}} <br>
                                                {{$licensesCount}}
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>

                        </section>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="contact-md" role="tabpanel" aria-labelledby="contact-tab-md">
                @include('subscriptions.partials.table', ['subscriptions' => $subscriptions])
            </div>
        </div> --}}
        {{-- <div class="tab-pane fade" id="profile-md" role="tabpanel" aria-labelledby="profile-tab-md"> --}}

            {{-- </div> --}}
        </div>
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
    <script src="{{URL::asset('assets/js/formelementadvnced.js')}}"></script>
    <script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
    <script src="{{URL::asset('assets/js/file-upload.js')}}"></script>
    @endsection
