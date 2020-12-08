@extends('layouts.master')

@section('content')

<section>
    @include('customer.partials.details')

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
        <div class="tab-pane fade" id="contact-md" role="tabpanel" aria-labelledby="contact-tab-md">
            @include('subscriptions.partials.table', ['subscriptions' => $subscriptions])
        </div>
        <div class="tab-pane fade" id="profile-md" role="tabpanel" aria-labelledby="profile-tab-md">
            <div class="container col-xm-12">
                @include('user.partials.table', ['users' => $users] )
            </div>
        </div>
    </div> --}}
</div>
</section>



@endsection


