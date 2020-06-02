@extends('layouts.app')


@section('content')

{{-- @if ($subscriptions->product_id = "MS-AZR-0017G")
<a href="{{route('analytics.list')}}">Azure Analytics</a>
@endif --}}
<div class="box col-xm-12">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="view overlay">
                    <div class="panel-block">
                        <form class="form-horizontal form-bordered" method="POST" action="{{ route('subscription.update', $subscriptions->id) }}">
                            @method('PATCH')
                            @csrf
                            <div class="field-group">
                                <div class="field is-inline-block-desktop">
                                    <label class="label">Subscription Name</label>
                                    <div class="control">
                                        <input readonly="readonly" class="input" name="name" type="text" placeholder="Text input" value="{{ $subscriptions->name }}">
                                    </div>
                                    <hr>
                                    <div class="field is-inline-block-desktop">
                                        <p> <strong> Tenant Name: </strong>{{ $subscriptions->tenant_name }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="field is-inline-block-desktop">
                                    <label class="label">Amount</label>
                                    <div class="control">
                                        @if ($subscriptions->status == "1")
                                        <input readonly="readonly" class="input is-warning" name="amount" type="number" placeholder="Text input" value="{{ $subscriptions->amount }}">
                                        @else
                                        <input  class="input" name="amount" type="number" placeholder="Text input" value="{{ $subscriptions->amount }}">
                                        @endif
                                    </div>
                                </div>
                                <div class="field is-inline-block-desktop">
                                    <div class="control">
                                        <label for="nights" class="label is-small"> Billing Cycle</label>
                                        @if ($subscriptions->status == "1")
                                        <div  readonly="readonly">
                                            @else
                                            @endif
                                            <div  class="select is-info">
                                                <select name="billing_period" >
                                                    <option value="monthly" {{ $subscriptions->billing_period == "monthly" ? "selected":"" }}> Monthly</option>
                                                    <option value="annual" {{ $subscriptions->billing_period == "annual" ? "selected":"" }}> Annual</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="field is-inline-block-desktop">
                                        <div class="control">
                                            <label for="nights" class="label is-small">Subscription Status</label>
                                            <div name="status" class="select is-info">
                                                <select name="status">
                                                    <option  value="1" {{ $subscriptions->status_id == "1" ? "selected":"" }}> Active</option>
                                                    <option  value="2" {{ $subscriptions->status_id == "2" ? "selected":"" }}> Suspended</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {{-- <label class="col-md-4 col-form-label">Expiration date</label> --}}
                                        <div class="col-md-8">
                                            <p><strong>Expiration Date</strong> {{
                                                date('d-M-Y', strtotime($subscriptions->expiration_data ))}}</p>
                                            </div>
                                        </div>
                                        {{-- @if ($products->getAddons()->all() != null)
                                            <table class="table">
                                                @foreach($addons as $addon)
                                                <tr>
                                                    @if($addon->reselleeQualifications != $reselee)
                                                    <td>{{$addon->name}}</td>
                                                    <td><small>{{$addon->description}}</small></td>
                                                    <td><small>{{$addon->reselleeQualifications}}</small></td>
                                                    <td><button class="button is-primary is-small">add to cart</button></td>
                                                    @endif
                                                    @endforeach --}}
                                                    {{-- </tr>
                                                    </tr>
                                                </table>
                                                @endif --}}
                                                <br>
                                                <br>
                                                <br>
                                                <div class="control">
                                                    <div class="text-center text-md-left">
                                                        <a data-toggle="modal" data-target="#centralModalInfo" class="button is-rounded is-primary is-outlined">{{ ucwords(trans_choice('messages.update', 1)) }}</a>
                                                        <div class="modal fade" id="centralModalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                                        aria-hidden="true" data-backdrop="false">
                                                        <div class="modal-dialog modal-notify modal-info" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <p class="heading lead">Update Subscription</p>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true" class="white-text">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="text-center">
                                                                        <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
                                                                        <p>You are about to update provider {{$subscriptions->name}}</p>
                                                                        <p>Are you sure?</p>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer justify-content-center">
                                                                    <button type="submit" type="button" class="btn btn-primary">yes </button>
                                                                    <a type="button" class="btn btn-outline-primary waves-effect" data-dismiss="modal">No, thanks</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="{{ URL::previous() }}">
                                                        <span class="button is-warning is-outlined" id="update-details-btn">
                                                            {{ ucwords(trans_choice('messages.cancel', 1)) }}
                                                        </span>
                                                    </a>
                                                    @if ($subscriptions->product_id = "MS-AZR-0017G")
                                                    <a href="{{route('analytics.list')}}">
                                                        
                                                        <span class="button is-primary is-outlined" id="update-details-btn">
                                                             {{ ucwords(trans_choice('messages.azure_analytic', 1)) }}
                                                        </span></a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endsection

            @section('scripts')


            @endsection
