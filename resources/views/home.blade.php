@extends('layouts.app')

@section('content')
<script src="http://www.amcharts.com/lib/3/amcharts.js" type="text/javascript"></script>
<script src="http://www.amcharts.com/lib/3/pie.js" type="text/javascript"></script>
<script src="http://www.amcharts.com/lib/3/ammap_amcharts_extension.js" type="text/javascript"></script>
<script src="http://www.amcharts.com/lib/maps/js/worldLow.js" type="text/javascript"></script>



@section('content')

<nav class="breadcrumb" aria-label="breadcrumbs">
    <ul>
        {{-- <li><a href="#">Home</a></li>
        <li><a href="#">Documentation</a></li>
        <li><a href="#">Components</a></li> --}}
        <li class="is-active"><a href="#" aria-current="page">Dashboard</a></li>
    </ul>
</nav>


<!-- Main container -->
<div></div>
<nav class="level">
    <!-- Left side -->
    <div class="level-left">
        {{-- <h3 class="title is-3">Welcome Back {{ auth()->user()->first()->first_name }}!!</h3> --}}
    </div>
    <!-- Right side -->
    <div class="level-right">
    </div>
    <div class="dropdown is-hoverable ">
        <div class="dropdown-trigger">
            <button class="button is-info " aria-haspopup="true" aria-controls="dropdown-menu4">
                <span class="icon is-small">
                    <i class="fas fa-plus" aria-hidden="true"></i>
                </span>
                <span>@lang('app.create_new')</span>
            </button>
        </div>
        <div class="dropdown-menu" id="dropdown-menu4" role="menu">
            <div class="dropdown-content">
                {{-- <div class="dropdown-item">
                    <a href="{{route('reseller.create')}}" class="dropdown-item">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        @lang('app.create_reseller')
                    </a>
                    <a href="{{route('customer.create')}}" class="dropdown-item">
                        <i class="fa fa-building" aria-hidden="true"></i>
                        @lang('app.create_customer')
                    </a>
                </div> --}}
            </div>
        </div>
    </div>
</nav>

<!-- begin banner -->

<div class="box">
    <section class="section">
        <div class="container">

            <div class="columns">
                <div class="column is-3">
                    <figure class="image">
                        <img src="images\kindpng_1952989.png">
                    </figure>
                </div>
                <div class="column is-3">
                    <h4 class="title is-spaced is-4">Create Branch Offices</h4>
                    <p class="subtitle is-6">Assign Customers to your branch offices, this customers are only available to the users you assign the right to.</p><a href="/docs/1.0/reseller-manual#Branch-Offices">Read more</a>
                </div>
                <div class="column is-3">
                    <h4 class="title is-spaced is-4">Control</h4>
                    <p class="subtitle is-6">You can control before all the options</p><a href="#">Read more</a>
                </div>
                <div class="column is-3">
                    <h4 class="title is-spaced is-4">Speed</h4>
                    <p class="subtitle is-6">Unimaginable transfer speed thanks to middle-out compression.</p><a href="#">Read more</a>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- End banner -->

<div class="columns">
    <div class="column auto">
        <div class="box">
            <div class="heading">Resellers</div>
            {{-- <div class="title">{{ number_format($stats['resellersCount']) }}</div> --}}
            <div class="level">
                <div class="level-item">
                    <div class="">
                        <div class="heading">Sales $</div>
                        <div class="title is-5">250,000</div>
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
            <div class="heading">Total Customers</div>
            {{-- <div class="title"> {{ number_format($stats['customersCount']) }} </div> --}}
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
    <div class="column">
        <div class="box">
            <div class="heading">Total Subscritpions</div>
            {{-- <div class="title">{{ number_format($stats['subscriptionsCount']) }}&uarr;</div> --}}
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
            <div class="heading">Subscriptions About to Expire</div>
            {{-- <div class="title">{{ number_format($stats['subscriptionsCount']) }}</div> --}}
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

<div class="columns is-multiline">
    <div class="column is-6">
        <div class="panel">
            <p class="panel-heading">
                Customers Created: Daily
            </p>
            <div class="panel-block">
                <canvas id="chart_1" width="650" height="350"></canvas>
            </figure>
        </div>
    </div>
</div>
<div class="column is-6">
    <div class="panel">
        <p class="panel-heading">
            Resellers Created: Daily
        </p>
        <div class="panel-block">
            <figure class="image is-16x9">
                <canvas id="chart_0" width="650" height="350"></canvas>
            </figure>
        </div>
    </div>
</div>
<div class="column is-6">
    <div class="panel">
        <p class="panel-heading">
            Something
        </p>
        <div class="panel-block">
            <div style="width: 100%; height: 362px; position: relative;">
                <div id="chartdiv" style="width: 200px; height: 150px; position: absolute; bottom: 0; right: 0; z-index: 100;"></div>
                <div id="mapdiv" style="width: 100%; height: 362px; position: absolute; top: 0; left: 0;"></div>
            </div>
        </div>
    </div>
</div>
<div class="column is-6">
    <div class="panel">
        <p class="panel-heading">
            Something Else
        </p>
        <div class="panel-block">
            <figure class="image is-16x9">
                <img src="https://placehold.it/1280x720">
            </figure>
        </div>
    </div>
</div>

@endsection

