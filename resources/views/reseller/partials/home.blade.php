@extends('layouts.master')
@section('css')
<!-- Data table css -->

<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        {{-- <h4 class="page-title">{{ ucwords(trans_choice('messages.reseller_table', 1)) }}</h4> --}}
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#" class="d-flex"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/><path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/></svg><span class="breadcrumb-icon"> Home</span></a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item"><a href="#">Blog</a></li>
            <li class="breadcrumb-item active" aria-current="page">Blog 01</li>
        </ol>
    </div>
</div>
<!--End Page header-->
@endsection
@section('content')


<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mb-2 fs-18 text-muted">
                            Resellers
                        </div>
                        {{-- <h1 class="font-weight-bold mb-1">{{$reseller['resellers']->count()}}</h1> --}}
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
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mb-2 fs-18 text-muted">
                            Customers
                        </div>
                        <h1 class="font-weight-bold mb-1">{{$countCustomers}}</h1>
                        <span class="text-success"><i class="fa fa-arrow-up mr-1"></i> +1.8%</span>
                    </div>
                    <div class="col col-auto">
                        <div class="mx-auto chart-circle chart-circle-md chart-circle-success mt-sm-0 mb-0" data-value="0.60" data-thickness="12" data-color="#2dce89">
                            <div class="mx-auto chart-circle-value text-center fs-20">60%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mb-2 fs-18 text-muted">
                            Subscriptions
                        </div>
                        <h1 class="font-weight-bold mb-1">{{$countSubscriptions}}</h1>
                        <span class="text-danger"><i class="fa fa-arrow-down mr-1"></i> -2.4%</span>
                    </div>
                    <div class="col col-auto">
                        <div class="mx-auto chart-circle chart-circle-md chart-circle-secondary mt-sm-0 mb-0" data-value="0.45" data-thickness="12" data-color="#f7346b">
                            <div class="mx-auto chart-circle-value text-center fs-20">25%</div>
                        </div>
                    </div>
                </div>
            </div>
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
