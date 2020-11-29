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
        <h4 class="page-title">{{ ucwords(trans_choice('messages.provider_table', 1)) }}</h4>
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
@auth
@include('dashboard.home')
{{--

@if(Auth::user()->userLevel->id === 1)
@endif


@if(Auth::user()->userLevel->id === 2)
@include('provider.partials.home')
@endif

@if(Auth::user()->userLevel->id === 3)
@include('provider.partials.home')
@endif

--}}
@endauth

@guest

<!--================Home Banner Area =================-->
<section class="home_banner_area">
    <div class="banner_inner d-flex align-items-center">
        <div class="container">
            <div class="banner_content row">
                <div class="col-lg-5">
                    <h3>Georgia Helmet <br />Collections!</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
                    <a class="white_bg_btn" href="#">View Collection</a>
                </div>
                <div class="col-lg-7">
                    <div class="halemet_img">
                        <img src="img/banner/helmat.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Home Banner Area =================-->
<!--================Feature Product Area =================-->
<section class="feature_product_area">
    <div class="main_box">
        <div class="container">
            <div class="row hot_product_inner">
                <div class="col-lg-6">
                    <div class="hot_p_item">
                        <img class="img-fluid" src="img/product/hot-product/hot-p-1.jpg" alt="">
                        <div class="product_text">
                            <h4>Hot Deals of <br />this Month</h4>
                            <a href="#">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hot_p_item">
                        <img class="img-fluid" src="img/product/hot-product/hot-p-2.jpg" alt="">
                        <div class="product_text">
                            <h4>Hot Deals of <br />this Month</h4>
                            <a href="#">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="feature_product_inner">
                <div class="main_title">
                    <h2>Featured Products</h2>
                    <p>Who are in extremely love with eco friendly system.</p>
                </div>
                <div class="feature_p_slider owl-carousel">
                    <div class="item">
                        <div class="f_p_item">
                            <div class="f_p_img">
                                <img class="img-fluid" src="img/product/feature-product/f-p-1.jpg" alt="">
                                <div class="p_icon">
                                    <a href="#"><i class="lnr lnr-heart"></i></a>
                                    <a href="#"><i class="lnr lnr-cart"></i></a>
                                </div>
                            </div>
                            <a href="#"><h4>Long Sleeve TShirt</h4></a>
                            <h5>$150.00</h5>
                        </div>
                    </div>
                    <div class="item">
                        <div class="f_p_item">
                            <div class="f_p_img">
                                <img class="img-fluid" src="img/product/feature-product/f-p-2.jpg" alt="">
                                <div class="p_icon">
                                    <a href="#"><i class="lnr lnr-heart"></i></a>
                                    <a href="#"><i class="lnr lnr-cart"></i></a>
                                </div>
                            </div>
                            <a href="#"><h4>Long Sleeve TShirt</h4></a>
                            <h5>$150.00</h5>
                        </div>
                    </div>
                    <div class="item">
                        <div class="f_p_item">
                            <div class="f_p_img">
                                <img class="img-fluid" src="img/product/feature-product/f-p-3.jpg" alt="">
                                <div class="p_icon">
                                    <a href="#"><i class="lnr lnr-heart"></i></a>
                                    <a href="#"><i class="lnr lnr-cart"></i></a>
                                </div>
                            </div>
                            <a href="#"><h4>Long Sleeve TShirt</h4></a>
                            <h5>$150.00</h5>
                        </div>
                    </div>
                    <div class="item">
                        <div class="f_p_item">
                            <div class="f_p_img">
                                <img class="img-fluid" src="img/product/feature-product/f-p-4.jpg" alt="">
                                <div class="p_icon">
                                    <a href="#"><i class="lnr lnr-heart"></i></a>
                                    <a href="#"><i class="lnr lnr-cart"></i></a>
                                </div>
                            </div>
                            <a href="#"><h4>Long Sleeve TShirt</h4></a>
                            <h5>$150.00</h5>
                        </div>
                    </div>
                    <div class="item">
                        <div class="f_p_item">
                            <div class="f_p_img">
                                <img class="img-fluid" src="img/product/feature-product/f-p-1.jpg" alt="">
                                <div class="p_icon">
                                    <a href="#"><i class="lnr lnr-heart"></i></a>
                                    <a href="#"><i class="lnr lnr-cart"></i></a>
                                </div>
                            </div>
                            <a href="#"><h4>Long Sleeve TShirt</h4></a>
                            <h5>$150.00</h5>
                        </div>
                    </div>
                    <div class="item">
                        <div class="f_p_item">
                            <div class="f_p_img">
                                <img class="img-fluid" src="img/product/feature-product/f-p-2.jpg" alt="">
                                <div class="p_icon">
                                    <a href="#"><i class="lnr lnr-heart"></i></a>
                                    <a href="#"><i class="lnr lnr-cart"></i></a>
                                </div>
                            </div>
                            <a href="#"><h4>Long Sleeve TShirt</h4></a>
                            <h5>$150.00</h5>
                        </div>
                    </div>
                    <div class="item">
                        <div class="f_p_item">
                            <div class="f_p_img">
                                <img class="img-fluid" src="img/product/feature-product/f-p-3.jpg" alt="">
                                <div class="p_icon">
                                    <a href="#"><i class="lnr lnr-heart"></i></a>
                                    <a href="#"><i class="lnr lnr-cart"></i></a>
                                </div>
                            </div>
                            <a href="#"><h4>Long Sleeve TShirt</h4></a>
                            <h5>$150.00</h5>
                        </div>
                    </div>
                    <div class="item">
                        <div class="f_p_item">
                            <div class="f_p_img">
                                <img class="img-fluid" src="img/product/feature-product/f-p-4.jpg" alt="">
                                <div class="p_icon">
                                    <a href="#"><i class="lnr lnr-heart"></i></a>
                                    <a href="#"><i class="lnr lnr-cart"></i></a>
                                </div>
                            </div>
                            <a href="#"><h4>Long Sleeve TShirt</h4></a>
                            <h5>$150.00</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Feature Product Area =================-->

@endguest

@endsection


@section('scripts')


@endsection
