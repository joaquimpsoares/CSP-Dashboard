@extends('layouts.master')
@section('css')
<!---jvectormap css-->
<link href="{{URL::asset('assets/plugins/jvectormap/jqvmap.css')}}" rel="stylesheet" />
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<!--Daterangepicker css-->
<link href="{{URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
@endsection

@section('content')

@if($cart)

<section class="product_description_area">
    <div class="container">
        <section class="section">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col">
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home">{{ ucwords(trans_choice('messages.customer', 1)) }}</a>
                                                </li>
                                                @if($hasTenant)
                                                <li class="nav-item">
                                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#">{{ ucwords(trans_choice('messages.tenant', 1)) }}</a>
                                                </li>
                                                @endif
                                                <li class="nav-item">
                                                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#">{{ ucwords(trans_choice('messages.review', 1)) }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-content pt-4">
                                        @if(Auth::user()->userLevel->name !== config('app.customer'))
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <hr>
                                                <h5>
                                                    Create new customer for this purchase</label>
                                                </h5>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createCustomer">
                                                    {{ ucwords(trans_choice('messages.new_customer', 1)) }}
                                                </button>
                                                <hr>

                                                <!-- Modal -->
                                                <div class="modal fade" id="createCustomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"aria-hidden="true" data-backdrop="false">
                                                    <form method="POST" action="{{ route('cart.customer.store') }}" class="col s12" id="createCustomer">
                                                        @csrf
                                                        <div class="modal-dialog modal-notify modal-info" role="document">
                                                            <div class="modal-content">
                                                                <input type="hidden" name="cart" value="{{ $cart->token }}">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        {{ ucwords(trans_choice('messages.new_customer', 1)) }}
                                                                    </h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    @include('partials.messages')
                                                                    @include('order.partials.create_customer')
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <form action="{{ route('cart.add_customer') }}" method="post">
                                                    @csrf
                                                    <div class="row">
                                                        <input type="hidden" name="cart" value="{{ $cart->token }}">
                                                        <div class="col">
                                                            <hr>
                                                            <h5>
                                                                Select existing customer for this purchase</label>
                                                            </h5>
                                                            <select class="form-control SlectBox SumoUnder" name="customer_id" >
                                                                @foreach($customers as $customer)
                                                                <option value="{{ $customer['id'] }}" @if($cart->customer && $cart->customer->id == $customer['id']) selected="selected" @endif>{{ $customer['company_name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <div class="float-sm-right">
                                                        <div class="col-sm-6">
                                                            <button class="btn btn-secondary">{{ ucwords(trans_choice('messages.next', 1)) }} <i class="fe fe-arrow-right"></i></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        @else
                                        Customer already selected

                                        <form action="{{ route('cart.add_customer') }}" method="post">
                                            <div class="row">
                                                @csrf
                                                <input type="hidden" name="cart" value="{{ $cart->token }}">
                                                <input type="hidden" name="customer_id" value="{{ Auth::user()->customer->id }}">
                                            </div>

                                            <div class="float-sm-right">
                                                <div class="col-sm-6">
                                                    <button class="main_btn">{{ ucwords(trans_choice('messages.next', 1)) }}</button>
                                                </div>
                                            </div>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                                @include('order.partials.side')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@else

@endif




@endsection

@section('scripts')
<script>
    $('#createCustomer').on('shown.bs.modal', function() {
        //$('#myInput').trigger('focus')
    })
</script>
@endsection
