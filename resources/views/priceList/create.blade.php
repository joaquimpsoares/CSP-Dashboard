@extends('layouts.master')
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
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
                                    <input type="text" disabled id="description" name="description" class="form-control" value="{{old('name')}}">
                                </div>
                                <div class="form-group">
                                    <label for="my-select">Text</label>
                                    <select id="my-select" class="custom-select" name="">
                                        @foreach (Auth::User()->provider->instances as $item)

                                        <option>{{$item}}</option>
                                        @endforeach
                                    </select>
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
                            <div class="form-group">
                                <label for="my-select">{{ ucwords(trans_choice('messages.instance', 1)) }}</label>
                                <select name="instance" id="my-select" class="custom-select" name="">
                                    @foreach (Auth::User()->provider->instances as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="text-center text-md-left">
                        @if (Auth::user()->userLevel->name == 'Reseller')
                        @else
                        <a data-toggle="modal" data-target="#centralModalInfo" class="btn btn-primary">{{ ucwords(trans_choice('messages.create', 1)) }}</a>
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
                                            <i class="fa fa-check fa-4x mb-3 animated rotateIn"></i>
                                            <p>Are you sure?</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="submit" class="btn btn-primary">yes </button>
                                        <a type="button" class="btn btn-secondary" data-dismiss="modal">No, thanks</a>
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
