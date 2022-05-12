@extends('layouts.master')
@section('css')
<!---jvectormap css-->
<link href="{{URL::asset('assets/plugins/jvectormap/jqvmap.css')}}" rel="stylesheet" />
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<!--Daterangepicker css-->
@endsection

@section('content')

@if($cart)
@php
$totalPrice = null;
@endphp
<section class="product_description_area">
    <div class="container">
        <div class="align-self-center">
            <div class="row justify-content-center">
                <div class="col">
                    <div class="card">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link" href="#home" onclick="event.preventDefault(); document.getElementById('changeCustomer').submit();">{{ ucwords(trans_choice('messages.customer', 1)) }}</a>
                                                <form id="changeCustomer" method="post" action="{{ route('cart.change.customer') }}">
                                                    @csrf
                                                    <input type="hidden" name="cart" value="{{ $cart->token }}" />
                                                </form>
                                            </li>
                                            @if($hasTenant)
                                            <li class="nav-item">
                                                <a class="nav-link"href="#" onclick="event.preventDefault(); document.getElementById('changeTenant').submit();">{{ ucwords(trans_choice('messages.tenant', 1)) }}</a>
                                                <form id="changeTenant" method="post" action="{{ route('cart.change.tenant') }}">
                                                    @csrf
                                                    <input type="hidden" name="cart" value="{{ $cart->token }}" />
                                                </form>
                                            </li>
                                            @endif
                                            <li class="nav-item">
                                                <a class="nav-link active" id="contact-tab" data-toggle="tab" href="#">{{ ucwords(trans_choice('messages.review', 1)) }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="pt-4 tab-content">
                                    <div class="card-body">
                                        <H1></H1>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="printableArea">
                                                    <div class="overflow-hidden card">
                                                        <div class="card-status bg-primary"></div>
                                                        <div class="card-body">
                                                            <h2 class="text-muted font-weight-bold">{{ ucwords(trans_choice('messages.please_review_details', 1)) }}</h2>
                                                            <div class="">
                                                                <h5 class="mb-1">Hi <strong>{{Auth::user()->name}}</strong>,</h5>
                                                                This is the details for the order placed for customer <strong> {{$cart->customer->company_name}} </strong>
                                                            </div>
                                                            <div class="dropdown-divider"></div>
                                                            <div class="pt-4 row">
                                                                <div class="col-sm-6 ">
                                                                    <h3 class="text-muted font-weight-bold">{{ ucwords(trans_choice('messages.customer', 1)) }}</span><br></h3>
                                                                    <dl class="row">
                                                                        <dd class="col-sm-3">
                                                                            <p><b>{{ ucwords(trans_choice('messages.address_1', 1)) }}</b></p>
                                                                            <p><b>{{ ucwords(trans_choice('messages.city', 1)) }}</b></p>
                                                                            <p><b>{{ ucwords(trans_choice('messages.postal_code', 1)) }}</b></p>
                                                                            <p><b>{{ ucwords(trans_choice('messages.country', 1)) }}</b></p>
                                                                        </dd>
                                                                        <dd class="col-sm-8">
                                                                            <p>{{ $cart->customer->address_1 }}</p>
                                                                            <p>{{ $cart->customer->city }}</p>
                                                                            <p>{{ $cart->customer->postal_code }}</p>
                                                                            <p>{{ $cart->customer->country->name }}</p>
                                                                        </dd>
                                                                    </dl>
                                                                </div>

                                                                <div class="col-sm-6">
                                                                    <h3 class="text-muted font-weight-bold">{{ ucwords(trans_choice('messages.agreement_signed', 1)) }}</span><br></h3>
                                                                    <dl class="row">
                                                                        <dd class="col-sm-3">
                                                                            <p><b>{{ ucwords(trans_choice('messages.name', 1)) }}</b></p>
                                                                            <p><b>{{ ucwords(trans_choice('messages.last_name', 1)) }}</b></p>
                                                                            <p><b>{{ ucwords(trans_choice('messages.email', 1)) }}</b></p>
                                                                            <p><b>{{ ucwords(trans_choice('messages.phone_number', 1)) }}</b></p>
                                                                        </dd>
                                                                        <dd class="col-sm-8">
                                                                            <p>{{ $cart->agreement_firstname }}</p>
                                                                            <p>{{ $cart->agreement_lastname }}</p>
                                                                            <p>{{ $cart->agreement_email }}</p>
                                                                            <p>{{ $cart->agreement_phone }}</p>
                                                                        </dd>
                                                                    </dl>
                                                                </div>
                                                            </div>
                                                            <div class="dropdown-divider"></div>

                                                            <h3 class="text-muted font-weight-bold">{{ ucwords(trans_choice('messages.order_details', 1)) }}</span><br></h3>

                                                            <div class="table-responsive push">
                                                                <table class="table table-bordered table-hover text-nowrap">
                                                                    <tr class="">
                                                                        <th class="text-center " style="width: 1%"></th>
                                                                        <th>Product</th>
                                                                        <th class="text-center" style="width: 1%">Qnty</th>
                                                                        <th class="text-right" style="width: 1%">Unit Price</th>
                                                                        <th class="text-right" style="width: 1%">Amount</th>
                                                                    </tr>
                                                                    @foreach($cart->products as $product)
                                                                    <tr>
                                                                        <td class="text-center">1</td>
                                                                        <td>
                                                                            <p class="mb-1 font-weight-semibold">{{ $product->name }} - Billing Cycle ({{$product->pivot->billing_cycle}}) </p>
                                                                            <div class="text-muted">{{ $product->sku }}</div>
                                                                        </td>
                                                                        <td class="text-center">{{$product->pivot->quantity}}</td>
                                                                        <td class="text-right">{{$product->pivot->retail_price}}</td>
                                                                        <td class="text-right">@php
                                                                            if($product->pivot->billing_cycle == 'annual'){
                                                                                $price = floatval($product->pivot->retail_price * $product->pivot->quantity * 12);
                                                                                echo "$ " . number_format($price, 2);
                                                                                $totalPrice+=$price;
                                                                            }else{
                                                                                $price = floatval($product->pivot->retail_price * $product->pivot->quantity);
                                                                                echo "$ " . number_format($price, 2);
                                                                                $totalPrice+=$price;
                                                                            }
                                                                            @endphp</td>
                                                                        </tr>
                                                                        @endforeach

                                                                        <tr>
                                                                            <td colspan="4" class="mb-0 text-right font-weight-bold text-uppercase h4">Total Order</td>
                                                                            <td class="mb-0 text-right font-weight-bold h4"> $ {{ number_format(floatval($totalPrice), 2) }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="5" class="text-right">
                                                                                @if(!app('impersonate')->isImpersonating() && Auth::user()->customer && !Auth::user()->customer->direct_buy)
                                                                                    <a class="btn btn-primary" href="{{ route('order.save_order_for_verification', ['token' => $cart->token]) }}" > {{ ucwords(trans_choice('messages.place_order', 1)) }} <i class="si si-paper-plane"> </i></a>
                                                                                @else
                                                                                    <a class="btn btn-primary" href="{{ route('order.place_order', ['token' => $cart->token]) }}" > {{ ucwords(trans_choice('messages.place_order', 1)) }} <i class="si si-paper-plane"> </i></a>
                                                                                @endif
                                                                                {{-- <button type="button" class="btn btn-primary" onClick="javascript:window.print();"><i class="si si-wallet"></i> Pay Invoice</button> --}}
                                                                                {{-- <button type="button" class="btn btn-secondary" onClick="javascript:window.send();"><i class="si si-paper-plane"></i> Send Invoice</button> --}}
                                                                                <button type="button" class="btn btn-info" onClick="printDiv('printableArea');"><i class="si si-printer"></i> Print Invoice</button>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <p class="text-center text-muted">After order place it can take up to 1 hour for the suscription to be available on Microsoft!</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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



<script>
    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
@endsection

@section('scripts')


@endsection
