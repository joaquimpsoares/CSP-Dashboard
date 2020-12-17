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

<div class="row">
    <div class="col-lg-12">
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
                                            {{-- {{$licensesCount}} --}}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>

                    </section>
                </div>
            </div>
        </div>
    </div>
    @endsection
