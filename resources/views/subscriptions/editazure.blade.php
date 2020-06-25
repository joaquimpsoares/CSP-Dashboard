@extends('layouts.app')

@section('content')

@section('styles')
@endsection

<div class="container col-xm-12">
    <div class="row">
        <div class="col-md-12   ">
            <div class="card">
                <div class="view overlay">
                    <div class="card-body">
                        <div class="panel-block">
                            <form class="form-horizontal form-bordered" method="POST" action="{{ route('subscription.update', $subscriptions->id) }}">
                                @method('PATCH')
                                @csrf
                                <div class="field-group">
                                    <div class="field is-inline-block-desktop">
                                        <h3 class="card-title">{{ ucwords(trans_choice('messages.subscription_name', 1)) }}</h3> 
                                        <div class="control">
                                            <input readonly="readonly"  name="name" type="text" placeholder="Text input" value="{{ $subscriptions->name }}">
                                        </div>
                                        <hr>
                                        <div class="field is-inline-block-desktop">
                                            <h3 class="card-title"><p>{{ ucwords(trans_choice('messages.tenant_name', 1)) }}</p></h3>
                                            {{ $subscriptions->tenant_name }}</p>
                                        </div>
                                    </div>
                                    @foreach ($products as $product)
                                    @if ($product['billing'] == "license")
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
                                    @endif
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
                                                        <p>You are about to update Subscription {{$subscriptions->name}}</p>
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
                                    
                                    <a href="{{route('analytics.list')}}">
                                        <span class="genric-btn info" id="update-details-btn">
                                            {{ ucwords(trans_choice('messages.azure_analytic', 1)) }}
                                        </span></a>
                                        
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
