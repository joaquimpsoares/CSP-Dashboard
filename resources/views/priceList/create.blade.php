@extends('layouts.master')
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">{{ ucwords(trans_choice('messages.customer_table', 1)) }}</h4>
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

    <div class="container">
        <div class="section">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form method="POST" action="{{ route('priceList.storePriceList') }}" class="col s12">
                                @method('POST')
                                @csrf
                                <h1>{{ ucwords(trans_choice('messages.create_pricelist', 1)) }}</h1>
                                @if (Auth::user()->userLevel->name == 'Reseller')
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="name"  class="">{{ ucwords(trans_choice('messages.name', 1)) }}</label>
                                        <input type="text" disabled id="name" name="name" class="form-control" value="{{old('name')}}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="description">{{ ucwords(trans_choice('messages.description', 1)) }}</label>
                                        <input type="text" disabled id="description" name="description   " class="form-control" value="{{old('name')}}">
                                    </div>
                                </div>
                                @else
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="name" class="">{{ ucwords(trans_choice('messages.name', 1)) }}</label>
                                        <input type="text" id="name" name="name" class="form-control" value="{{old('name')}}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="description">{{ ucwords(trans_choice('messages.description', 1)) }}</label>
                                        <input type="text" id="description" name="description" class="form-control" value="{{old('name')}}">
                                    </div>
                                </div>
                                @endif
                            {{-- </form> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="text-center text-md-left">
                        @if (Auth::user()->userLevel->name == 'Reseller')
                        @else
                        <a data-toggle="modal" data-target="#centralModalInfo" class="genric-btn primary">{{ ucwords(trans_choice('messages.create', 1)) }}</a>
                        @endif
                        <div class="modal fade" id="centralModalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"aria-hidden="true" data-backdrop="false">
                            <div class="modal-dialog modal-notify modal-info" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <p class="heading lead">{{ ucwords(trans_choice('messages.are_you_sure', 1)) }}</p>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true" class="white-text">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-center">
                                            <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
                                            <p>Are you sure?</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="submit" class="btn submit_btn">yes </button>
                                        <a type="button" class="genric-btn primary" data-dismiss="modal">No, thanks</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @endsection
