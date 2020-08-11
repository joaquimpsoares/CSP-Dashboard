@extends('layouts.app')

@section('content')

<style>
    
   
    
    
    /*! CSS Used from: https://www.wrappixel.com/demos/admin-templates/material-pro/assets/plugins/chartist-js/dist/chartist-init.css */
    .chartist-chart{position:relative;}
    .usage .ct-series-a .ct-line{stroke:#fff;}
    .usage .ct-series-a .ct-point{stroke-width:0px;}
    .usage .ct-series-a .ct-area{fill-opacity:0;}
    /*! CSS Used from: https://www.wrappixel.com/demos/admin-templates/material-pro/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css */
    .chartist-tooltip{position:absolute;display:inline-block;opacity:0;min-width:50px;padding:5px 10px;border-radius:5px;background:#313131;color:#fff;font-weight:500;text-align:center;pointer-events:none;z-index:1;-webkit-transition:opacity .2s linear;-moz-transition:opacity .2s linear;-o-transition:opacity .2s linear;transition:opacity .2s linear;}
    .ct-area,.ct-line{pointer-events:none;}
    /*! CSS Used from: https://www.wrappixel.com/demos/admin-templates/material-pro/assets/plugins/css-chart/css-chart.css */
    .css-bar{position:relative;display:inline-block;font-size:16px;border-radius:50%;background-color:transparent;margin-bottom:20px;-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;width:80px;height:80px;font-size:18px;}
    .css-bar:after{display:inline-block;position:absolute;top:0;left:0;border-radius:50%;text-align:center;font-weight:light;color:#a1a2a3;}
    .css-bar:after{content:attr(data-label);background-color:#fff;z-index:101;}
    .css-bar:after{width:70px;height:70px;margin-left:5px;margin-top:5px;line-height:70px;}
    .css-bar.css-bar-20{background-image:linear-gradient(90deg, #fafafa 50%, transparent 50%, transparent), linear-gradient(162deg, #7460ee 50%, #fafafa 50%, #fafafa);}
    .css-bar.css-bar-40{background-image:linear-gradient(90deg, #fafafa 50%, transparent 50%, transparent), linear-gradient(234deg, #7460ee 50%, #fafafa 50%, #fafafa);}
    .css-bar.css-bar-60{background-image:linear-gradient(306deg, #7460ee 50%, transparent 50%, transparent), linear-gradient(270deg, #7460ee 50%, #fafafa 50%, #fafafa);}
    .css-bar-primary.css-bar-40{background-image:linear-gradient(90deg, #fafafa 50%, transparent 50%, transparent), linear-gradient(234deg, #7460ee 50%, #fafafa 50%, #fafafa);}
    .css-bar-success.css-bar-20{background-image:linear-gradient(90deg, #fafafa 50%, transparent 50%, transparent), linear-gradient(162deg, #26c6da 50%, #fafafa 50%, #fafafa);}
    .css-bar-info.css-bar-20{background-image:linear-gradient(90deg, #fafafa 50%, transparent 50%, transparent), linear-gradient(162deg, #1e88e5 50%, #fafafa 50%, #fafafa);}
    .css-bar-danger.css-bar-60{background-image:linear-gradient(306deg, #fc4b6c 50%, transparent 50%, transparent), linear-gradient(270deg, #fc4b6c 50%, #fafafa 50%, #fafafa);}
    .css-bar{background-clip:content-box;}
    /*! CSS Used from: https://www.wrappixel.com/demos/admin-templates/material-pro/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css */
    
    
    
    
</style>

<link rel="stylesheet" href="https://colorlib.com/polygon/kiaalap/css/font-awesome.min.css">
<link rel="stylesheet" href="https://colorlib.com/polygon/kiaalap/style.css">


<div class="preloader" style="display: none;">
</div>
<div class="container">
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor">Dashboard</h3>
        </div>
        <div class="col-md-7 col-4 align-self-center">
            <div class="d-flex m-t-10 justify-content-end">
                <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                    <div class="chart-text m-r-10">
                        <h6 class="m-b-0"><small>THIS MONTH</small>
                        </h6>
                        <h4 class="m-t-0 text-info">$58,356
                            
                        </h4>
                    </div>
                    <div class="spark-chart">
                        <div id="monthchart"><canvas width="60" height="35" style="display: inline-block; width: 60px; height: 35px; vertical-align: top;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                    <div class="chart-text m-r-10">
                        <h6 class="m-b-0"><small>LAST MONTH</small></h6>
                        <h4 class="m-t-0 text-primary">$48,356</h4>
                    </div>
                    <div class="spark-chart">
                        <div id="lastmonthchart"><canvas width="60" height="35" style="display: inline-block; width: 60px; height: 35px; vertical-align: top;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1 col-lg-3">
            <div class="dashboard-card">
                <div class="card card-body">
                    <div class="row">
                        <div class="col p-r-0 align-self-center">
                            <h2 class="font-light m-b-0"> {{$countCustomers}} </h2>
                            <h6 class="text-muted">Customers</h6>
                        </div>
                        <div class="col text-right align-self-center">
                            <svg viewBox="0 0 36 36" class="circular-chart orange">
                                <path class="circle-bg"
                                d="M18 2.0845
                                a 15.9155 15.9155 0 0 1 0 31.831
                                a 15.9155 15.9155 0 0 1 0 -31.831"
                                />
                                <path class="circle"
                                stroke-dasharray="{{$countCustomers}}, 100"
                                d="M18 2.0845
                                a 15.9155 15.9155 0 0 1 0 31.831
                                a 15.9155 15.9155 0 0 1 0 -31.831"
                                />
                                <text x="18" y="20.35" class="percentage">{{$countCustomers/100}}%</text>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1 col-lg-3">
            <div class="dashboard-card">
                <div class="card card-body">
                    <div class="row">
                        <div class="col p-r-0 align-self-center">
                            <h2 class="font-light m-b-0">{{$countCustomers}}</h2>
                            <h6 class="text-muted">Customers</h6>
                        </div>
                        <div class="col text-right align-self-center">
                            <svg viewBox="0 0 36 36" class="circular-chart green">
                                <path class="circle-bg"
                                d="M18 2.0845
                                a 15.9155 15.9155 0 0 1 0 31.831
                                a 15.9155 15.9155 0 0 1 0 -31.831"
                                />
                                <path class="circle"
                                stroke-dasharray="{{$countCustomers}}, 100"
                                d="M18 2.0845
                                a 15.9155 15.9155 0 0 1 0 31.831
                                a 15.9155 15.9155 0 0 1 0 -31.831"
                                />
                                <text x="18" y="20.35" class="percentage">{{$countCustomers/100}}%</text>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1 col-lg-3">
            <div class="dashboard-card">
                <div class="card card-body">
                    <div class="row">
                        <div class="col p-r-0 align-self-center">
                            <h2 class="font-light m-b-0">{{$countSubscriptions}}</h2>
                            <h6 class="text-muted">subscriptions</h6>
                        </div>
                        <div class="col text-right align-self-center">
                            <svg viewBox="0 0 36 36" class="circular-chart green">
                                <path class="circle-bg"
                                d="M18 2.0845
                                a 15.9155 15.9155 0 0 1 0 31.831
                                a 15.9155 15.9155 0 0 1 0 -31.831"
                                />
                                <path class="circle"
                                stroke-dasharray="{{$countSubscriptions}}, 100"
                                d="M18 2.0845
                                a 15.9155 15.9155 0 0 1 0 31.831
                                a 15.9155 15.9155 0 0 1 0 -31.831"
                                />
                                <text x="18" y="20.35" class="percentage">{{$countSubscriptions/100}}%</text>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        {{-- <div class="col-lg-8  col-md-12">
            <div class="card_news">
                <div class="img">
                    <img src="https://partners.kaspersky.com/s/sfsites/c/resource/KL_banner_loginMSP" alt="image univers">
                </div>
                <div class="content">
                    <h3 class="title">Kaspersky Onboard</h3>
                    <p class="text">
                        If you haven't done yet, please check the link for you to obtain a Kaspersky Reseller Pin.
                    </p>
                    <div class="buttons">
                        <a href="https://www.kasperskypartners.com/?eid=registe" class="btn-continue">Continue &#8594;</a>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col-lg-4 col-md-12">
            <div class="card_news">
                <div class="img">
                    <img src="https://partners.kaspersky.com/s/sfsites/c/resource/KL_banner_loginMSP" alt="image univers">
                </div>
                <div class="content">
                    <h3 class="title">Kaspersky Onboard</h3>
                    <p class="text">
                        If you haven't done yet, 
                        please check the link to become Kaspersky Reseller once you register you'll recieve a Kaspersky Reseller Pin.
                    </p>
                    <div class="buttons">
                        {{-- <button class="btn-back">Back</button> --}}
                        <a href="https://www.kasperskypartners.com/?eid=registe"  target="_blank" class="btn-continue">Become a Member &#8594;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
            <div class="card res-mg-t-30 table-mg-t-pro-n">
                <div class="card-body">
                    <h3 class="card-title">Azure Subscriptions</h3>
                    <table class="table table-hover responsive" id="azure">
                        <thead class="thead-dark">
                            <tr>
                                <th>Company Name</th>
                                <th>Monthly Budget</th>
                                <th>Current Estimated</th>
                                <th>budget</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Company test</td>
                                <td>${{$budget}}</td>
                                <td>${{$costSum}}</td>
                                <td><ul class="country-state">
                                    <h2><span class="counter">{{round($average, 0)}}</span>%   <small></small></h2> 
                                    <div class="pull-right"><span class="counter">{{round($average, 0)}}</span>%<i class="fa fa-level-up text-danger ctn-ic-1"></i></div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success ctn-vs-4" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:100%;"> <span class="sr-only">{{round($average, 0)}} Budget</span></div>
                                    </div>
                                </ul>
                            </td>
                        </tr>
                        <tr>    
                            <td>Company test</td>
                            <td> ${{$budget}}</td>
                            <td>${{$costSum}}</td>
                            <td><ul class="country-state">
                                <h2><span class="counter">{{round($average, 0)}}</span>%   <small></small></h2> 
                                <div class="pull-right"><span class="counter">{{round($average, 0)}}</span>%<i class="fa fa-level-up text-danger ctn-ic-1"></i></div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success ctn-vs-4" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:100%;"> <span class="sr-only">{{round($average, 0)}} Budget</span></div>
                                </div>
                            </ul>
                        </td>
                    </tr>
                    <tr>    
                        <td>Company test</td>
                        <td> ${{$budget}}</td>
                        <td>${{$costSum}}</td>
                        <td><ul class="country-state">
                            <h2><span class="counter">{{round($average, 0)}}</span>%   <small></small></h2> 
                            <div class="pull-right"><span class="counter">{{round($average, 0)}}</span>%<i class="fa fa-level-up text-danger ctn-ic-1"></i></div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success ctn-vs-4" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:100%;"> <span class="sr-only">{{round($average, 0)}} Budget</span></div>
                            </div>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


@endsection

@section('scripts')


<script type="text/javascript">
    $(document).ready( function () {
        $('#azure').DataTable({
            "pagingType": "full_numbers",
            "order": [[ 0, "asc" ]]
        });
    } );
</script>

@endsection
