@extends('layouts.app')

<style>
    .card {
        background-color: #fff;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;
        border-radius: 4px;
        -moz-box-shadow: 0 3px 1px -2px rgba(0,0,0,.2), 0 2px 2px 0 rgba(0,0,0,.14), 0 1px 5px 0 rgba(0,0,0,.12);
        -webkit-box-shadow: 0 3px 1px -2px rgba(0,0,0,.2), 0 2px 2px 0 rgba(0,0,0,.14), 0 1px 5px 0 rgba(0,0,0,.12);
        box-shadow: 0 3px 1px -2px rgba(0,0,0,.2), 0 2px 2px 0 rgba(0,0,0,.14), 0 1px 5px 0 rgba(0,0,0,.12);
        color: rgba(0,0,0,.87);
        margin: 8px;
        min-width: 290px;
        overflow: hidden;
        position: relative;
    }
    .card::after {
        clear: both;
    }
    .card::after, .card::before {
        content: "";
        display: block;
    }
    
    .optional-header {
        min-height: 40px;
        padding: 16px;
        position: relative;
    }
</style>

@section('content')





<div class="container col-xm-12">
    <ul class="nav nav-pills md-tabs" id="myTabMD" role="tablist">
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
                        <div class="container">
                            
                            <div class="section-title">
                                <h2>Summary for customer {{$customer->company_name}}</h2>
                                <hr>
                                {{-- <p>We include the following services, this way you focus on the most important, your customers!!</p> --}}
                            </div>
                            <div class="row">
                                
                                <div class="col-lg-6 col-md-6">
                                    <div class="card bd-callout-warning">
                                        <div class="icon"><i class="las la-basketball-ball" style="color: #ff689b;"></i></div>
                                        <strong><h4>Current Estimated Costs</h4></strong> <br>
                                        {{-- <p class="product-details">Subscriptions {{$customer->subscriptions->count()}}</p>
                                        <p class="product-details">Total Licenses {{$licensesCount}}</p> --}}
                                        @if(!@empty($costs))
                                        <dl class="row col-sm-">
                                            <dd class="col-sm-6">
                                                <strong>Billing Start date</strong> <br>
                                                <strong>Billing End date</strong> <br>
                                                <strong>Pretax Total</strong> <br>
                                                <strong>Tax Total</strong> <br>
                                                <strong>After Total</strong> <br>                      
                                                {{-- <small>{{ $product->name }}</small> --}}
                                            </dd>
                                            <dd class="col-sm-4">
                                                {{date('d-m-Y', strtotime($costs->billingStartDate))}} <br>
                                                {{date('d-m-Y', strtotime($costs->billingEndDate))}} <br>
                                                {{number_format($costs->pretaxTotal, 2)}}{{$costs->currencySymbol}} <br>
                                                {{number_format($costs->tax, 2)}}{{$costs->currencySymbol}} <br>
                                                {{number_format($costs->afterTaxTotal, 2)}}{{$costs->currencySymbol}} <br>                        
                                            </dd>
                                        </dl>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6" data-wow-delay="0.1s">
                                    <div class="card bd-callout-warning">
                                        <div class="icon"><i class="las la-file-alt" style="color: #3fcdc7;"></i></div>
                                        <strong><h4>Active Subscriptions</h4></strong> <br>
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
                            </section>
                            
                            <dl class="row">
                                <dt class="col-sm-8">
                                    {{-- Total --}}
                                </dt>
                                <dt class="col-sm-4">
                                    {{-- $ {{ number_format(floatval($totalPrice), 2) }} --}}
                                </dt>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="contact-md" role="tabpanel" aria-labelledby="contact-tab-md">
                    <div class="container col-xm-12">
                        @include('subscriptions.partials.table', ['subscriptions' => $subscriptions])
                    </div>
                </div>            
                <div class="tab-pane fade" id="profile-md" role="tabpanel" aria-labelledby="profile-tab-md">
                    <div class="container col-xm-12">
                        @include('customer.partials.details')
                        @include('user.partials.table', ['users' => $users] )
                    </div>
                </div>
            </div>
        </div>
        
        
        
        @endsection
        
        
