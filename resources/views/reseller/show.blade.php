@extends('layouts.app')


@section('content')


<div class="box col-xm-12">
    
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            
            <a class="nav-link btn rgba-blue-light btn rgba-blue-light active" id="home-tab-md" data-toggle="tab" href="#home-md" role="tab" aria-controls="home-md"
            aria-selected="true">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light" id="customer-tab-md" data-toggle="tab" href="#customer-md" role="tab" aria-controls="customer-md"
            aria-selected="false">{{ ucwords(trans_choice('messages.customer', 2)) }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light" id="subscription-tab-md" data-toggle="tab" href="#subscription-md" role="tab" aria-controls="subscription-md"
            aria-selected="false">{{ ucwords(trans_choice('messages.subscription', 2)) }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light" id="profile-tab-md" data-toggle="tab" href="#profile-md" role="tab" aria-controls="profile-md"
            aria-selected="false">{{ ucwords(trans_choice('messages.account', 1)) }}</a>
        </li>
    </ul>
    <div class="tab-content card pt-5" id="myTabContentMD">
        <div class="tab-pane fade show active" id="home-md" role="tabpanel" aria-labelledby="home-tab-md">
            <div class="section">
                <div class="columns">
                    <main class="column">
                        <div class="level">
                            <div class="level-left">
                                <div class="level-item">
                                    <div class="title">Dashboard</div>
                                </div>
                            </div>
                            {{-- <div class="level-right">
                                <div class="level-item">
                                    <button type="button" class="button is-small">
                                        March 8, 2017 - April 6, 2017
                                    </button>
                                </div>
                            </div> --}}
                        </div>
                        
                        <div class="columns is-multiline">
                            <div class="column">
                                <div class="box">
                                    <div class="heading">Top Seller Total</div>
                                    <div class="title">56,950</div>
                                    <div class="level">
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Sales $</div>                                                <div class="title is-5">250,000</div>
                                            </div>
                                        </div>
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Overall $</div>
                                                <div class="title is-5">750,000</div>
                                            </div>
                                        </div>
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Sales %</div>
                                                <div class="title is-5">25%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="box">
                                    <div class="heading">Revenue / Expenses</div>
                                    <div class="title">55% / 45%</div>
                                    <div class="level">
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Rev Prod $</div>
                                                <div class="title is-5">30%</div>
                                            </div>
                                        </div>
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Rev Serv $</div>
                                                <div class="title is-5">25%</div>
                                            </div>
                                        </div>
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Exp %</div>
                                                <div class="title is-5">45%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <
                            <div class="column">
                                <div class="box">
                                    <div class="heading">Feedback Activity</div>
                                    <div class="title">78% &uarr;</div>
                                    <div class="level">
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Positive</div>
                                                <div class="title is-5">1560</div>
                                            </div>
                                        </div>
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Negative</div>
                                                <div class="title is-5">368</div>
                                            </div>
                                        </div>
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Pos/Neg %</div>
                                                <div class="title is-5">77% / 23%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="box">
                                    <div class="heading">Orders / Returns</div>
                                    <div class="title">75% / 25%</div>
                                    <div class="level">
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Orders $</div>
                                                <div class="title is-5">425,000</div>
                                            </div>
                                        </div>
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Returns $</div>
                                                <div class="title is-5">106,250</div>
                                            </div>
                                        </div>
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Success %</div>
                                                <div class="title is-5">+ 28,5%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="subscription-md" role="tabpanel" aria-labelledby="subscription-tab-md">
                <div class="box col-xm-12">
                    @include('subscriptions.partials.row', ['subscriptions' => $subscriptions])
                </div>
            </div>
            <div class="tab-pane fade" id="profile-md" role="tabpanel" aria-labelledby="profile-tab-md">
                @include('reseller.partials.details')
            </div>
            <div class="tab-pane fade" id="customer-md" role="tabpanel" aria-labelledby="customer-tab-md">
                <div class="box col-xm-12">
                    @include('customer.partials.table', ['customers' => $customers])
                </div>
            </div>
        </div>
    </div>
    
    
    @endsection
    
    
    
