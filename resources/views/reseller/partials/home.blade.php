@extends('layouts.master')
@section('css')
<!-- Data table css -->

<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')


<div class="row">
    {{-- <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mb-2 fs-18 text-muted">
                            Resellers
                        </div>
                        <h1 class="font-weight-bold mb-1">{{$reseller['resellers']->count()}}</h1>
                        <span class="text-primary"><i class="fa fa-arrow-up mr-1"></i> +1.4%</span>
                    </div>
                    <div class="col col-auto">
                        <div class="mx-auto chart-circle chart-circle-md chart-circle-primary mt-sm-0 mb-0" data-value="0.85" data-thickness="12" data-color="#4454c3">
                            <div class="mx-auto chart-circle-value text-center fs-20">85%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="col-xl-4 col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body">
                <svg class="card-custom-icon text-success icon-dropshadow-success" x="1008" y="1248" viewBox="0 0 24 24" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                    <path opacity=".0" d="M3.31,11 L5.51,19.01 L18.5,19 L20.7,11 L3.31,11 Z M12,17 C10.9,17 10,16.1 10,15 C10,13.9 10.9,13 12,13 C13.1,13 14,13.9 14,15 C14,16.1 13.1,17 12,17 Z"></path>
                    <path d="M22,9 L17.21,9 L12.83,2.44 C12.64,2.16 12.32,2.02 12,2.02 C11.68,2.02 11.36,2.16 11.17,2.45 L6.79,9 L2,9 C1.45,9 1,9.45 1,10 C1,10.09 1.01,10.18 1.04,10.27 L3.58,19.54 C3.81,20.38 4.58,21 5.5,21 L18.5,21 C19.42,21 20.19,20.38 20.43,19.54 L22.97,10.27 L23,10 C23,9.45 22.55,9 22,9 Z M12,4.8 L14.8,9 L9.2,9 L12,4.8 Z M18.5,19 L5.51,19.01 L3.31,11 L20.7,11 L18.5,19 Z M12,13 C10.9,13 10,13.9 10,15 C10,16.1 10.9,17 12,17 C13.1,17 14,16.1 14,15 C14,13.9 13.1,13 12,13 Z"></path>
                </svg>
                <p class=" mb-1 ">All Orders</p>
                <h2 class="mb-1 font-weight-bold">{{$countOrders}}</h2>
                {{-- <span class="mb-1 text-muted"><span class="text-danger"><i class="fa fa-caret-down  mr-1"></i> 43.2</span> than last month</span> --}}
                {{-- <div class="progress progress-sm mt-3 bg-success-transparent"> --}}
                    {{-- <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: 78%"></div> --}}
                {{-- </div> --}}
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body">
                <i class="mdi mdi-account-multiple-outline card-custom-icon icon-dropshadow-secondary text-secondary fs-60"></i>
                <p class=" mb-1 ">Customers</p>
                <h2 class="mb-1 font-weight-bold">{{$countCustomers}}</h2>
                {{-- <span class="mb-1 text-muted"><span class="text-success"><i class="fa fa-caret-up  mr-1"></i> 19.8</span> than last month</span> --}}
                {{-- <div class="progress progress-sm mt-3 bg-secondary-transparent">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary" style="width: 58%"></div>
                </div> --}}
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body">
                <i class="mdi mdi-file-outline card-custom-icon icon-dropshadow-primary text-primary fs-60"></i>
                <p class=" mb-1 ">Subscriptions</p>
                <h2 class="mb-1 font-weight-bold">{{$countSubscriptions}}</h2>
                {{-- <span class="mb-1 text-muted"><span class="text-success"><i class="fa fa-caret-up  mr-1"></i> 0.8%</span> than last month</span> --}}
                {{-- <div class="progress progress-sm mt-3 bg-primary-transparent">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: 58%"></div>
                </div> --}}
            </div>
        </div>
    </div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title ">Quick Links</h3>
        <div class="card-options">
            <a href="#" class="card-options-collapse mr-2" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
            <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
        </div>
    </div>
    <div class="card-group p-5">
        <div class="card  overflow-hidden shadow-none border border-right-0">
            <img  src="{{URL::asset('images/store/store-management.png')}}" alt="image" height="300" width="auto">
            <div class="card-body">
                <h5 class="card-title">Store</h5>
                <p class="card-text"> Use the store to purchase products on behalf of your customers, select Microsoft of Kaspersky products.</p>
            </div>
            <div class="card-footer text-right">
                <small class="text-muted"><a href="/store" class="btn btn-success btn-sm mt-3">Go to Store &#8594;</a></small>
            </div>
        </div>
        <div class="card  overflow-hidden shadow-none border border-right-0">
            <img  src="{{URL::asset('images/store/web-marketing-analytics.jpg')}}" alt="image" height="300" width="auto">
            <div class="card-body">
                <h5 class="card-title">Analytics</h5>
                <p class="card-text">Check your <Strong>Azure</Strong> analytics</p>
            </div>
            <div class="card-footer text-right">
                <small class="text-muted"><a href="#" class="btn btn-success btn-sm mt-3">Go to Analytics &#8594;</a></small>
            </div>
        </div>
        <div class="card overflow-hidden shadow-none border">
            <img  src="{{URL::asset('https://partners.kaspersky.com/s/sfsites/c/resource/KL_banner_loginMSP')}}" alt="image" height="300" width="auto">
            <div class="card-body">
                <h5 class="card-title">Kaspersky Onboard</h5>
                <p class="card-text"> If you haven't done yet,
                    please check the link to become Kaspersky Reseller once you register you'll recieve a Kaspersky Reseller Pin.</p>
                </div>
                <div class="card-footer text-right">
                    <small class="text-muted"><a href="https://www.kasperskypartners.com/?eid=registe" class="btn btn-success btn-sm mt-3">Become a Member &#8594;</a></small>
                </div>
            </div>
        </div>
    </div>




    @endsection

    @section('scripts')


    @endsection
