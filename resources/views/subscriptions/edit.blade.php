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


<div class="container col-xm-12">
    <div class="row">
        <div class="col-md-12 col-lg-8">
            <div class="card text-center">
                <div class="card-status card-status-left bg-green br-bl-7 br-tl-7"></div>

                <div class="card-header">
                    <div class="card-title">
                        {{ ucwords(trans_choice('messages.subscription', 1)) }}
                        <p>{{ $subscriptions->name }}</p>
                        <p>{{ $subscriptions->tenant_name }}</p>
                    </div>
                </div>
                <div class="card-body">
                    <form class="form-horizontal form-bordered" method="POST" action="{{ route('subscription.update', $subscriptions->id) }}">
                        @method('PATCH')
                        @csrf

                        <div class="field-group">
                            <div class="field is-inline-block-desktop">
                                <h3 class="card-title"></h3>
                                <div class="control">
                                    <input readonly="readonly"  name="name" type="text" placeholder="Text input" value="{{ $subscriptions->name }}">
                                </div>
                                <hr>
                                <div class="field is-inline-block-desktop">
                                    <h3 class="card-title"><p>{{ ucwords(trans_choice('messages.tenant_name', 1)) }}</p></h3>
                                    <p>{{ $subscriptions->tenant_name }}</p>
                                </div>
                            </div>
                            @foreach ($products as $product)
                            <hr>
                            <div class="field is-inline-block-desktop">
                                {{ ucwords(trans_choice('messages.licenses', 1)) }}
                                <div class="control">
                                    @if ($subscriptions->status == "1")
                                    <input readonly="readonly" class="input is-warning" name="amount" type="number" placeholder="Text input" value="{{ $subscriptions->amount }}">
                                    @else
                                    <input  class="input" name="amount" type="number" placeholder="Text input" value="{{ $subscriptions->amount }}">
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm">
                                <div class="control">
                                    <label for="nights" class="label is-small"> {{ ucwords(trans_choice('messages.billing_cycle', 1)) }}</label>
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
                                <div class="col-sm">
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
                            </div>
                        </div>
                        <br>
                        @foreach ($products as $product)
                        @if ($product->has_addons == true)
                        <div class="row">
                            <div class="col-sm">
                                <a class="genric-btn primary" id="bt" onclick="toggle(this)">{{ ucwords(trans_choice('messages.addon', 1))}}</a>
                                <br>
                                <div style="border:solid 5px #ddd; padding:30px; display:none;" id="cont">
                                    <h3>{{ ucwords(trans_choice('messages.addon', 1))}}</h3>
                                    <table class="table">
                                        <head>
                                            <tr>
                                                <td>{{ ucwords(trans_choice('messages.name', 1))}}</td>
                                                <td>{{ ucwords(trans_choice('messages.description', 1))}}</td>
                                                <td>{{ ucwords(trans_choice('messages.quantity', 1))}}</td>
                                            </tr>
                                        </head>
                                        @foreach($addons as $addon)
                                        <tr>
                                            <td> <p name="product_name"></p>{{$addon->name}}</td>
                                            <td><small>{{$addon->description}}</small></td>
                                            <td><input name="addonamount" id="addonamount" type="number" placeholder="Quantity" value="{{ $addon->id }}"></td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        <br>
                        <div class="control">
                            <div class="text-center text-md-left">
                                <a data-toggle="modal" data-target="#centralModalInfo" class="genric-btn primary-brand">{{ ucwords(trans_choice('messages.update', 1)) }}</a>
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
                                            <button  type="submit" type="button" class="genric-btn info waves-effect" >yes </button>
                                            <a type="button" class="genric-btn danger waves-effect" data-dismiss="modal">No, thanks</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ URL::previous() }}">
                                <span class="genric-btn danger" id="update-details-btn">
                                    {{ ucwords(trans_choice('messages.cancel', 1)) }}
                                </span>
                            </a>
                            @if ($product->billing == "usage")
                            <a href="{{route('analytics.list')}}">
                                <span class="genric-btn info" id="update-details-btn">
                                    {{ ucwords(trans_choice('messages.azure_analytic', 1)) }}
                                </span></a>
                                @endif
                            </div>
                        </div>
                    </form>
                    <a class="btn btn-primary" href="#">Go somewhere</a>
                    <div class="card-footer text-muted">
                        2 days ago
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script>
    function toggle(ele) {
        var cont = document.getElementById('cont');
        if (cont.style.display == 'block') {
            cont.style.display = 'none';

            document.getElementById(ele.id).value = 'Show DIV';
        }
        else {
            cont.style.display = 'block';
            document.getElementById(ele.id).value = 'Hide DIV';
        }
    }
</script>

<script>
    // Get the modal
    var modal = document.getElementById('centralModalInfo');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

@endsection
