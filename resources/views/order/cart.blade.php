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
<script>
    function updateCartProductItemsNumber(item){
        let tr = item.parentElement.parentElement.parentElement;

        updateCartLine(tr);
    }

    function updateCartProductCycle(item){
        let tr = item.parentElement.parentElement;

        updateCartLine(tr);
    }

    function updateCartLine(tr){
        let quantity = tr.getElementsByClassName('form-control')[0].value;

        let price = parseFloat(tr.getElementsByClassName('product-price')[0].innerHTML);

        let cycle = tr.getElementsByClassName('billing_cycle')[0].value;

        var subtotal = price * quantity;

        if(cycle === 'annual'){
            subtotal *= 12;
        }

        tr.getElementsByClassName('product-line-price')[0].innerHTML = subtotal.toFixed(2);
    }
</script>

<div class="container">
    <section class="section">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        @if($cart)
                        <form action="{{ route('cart.checkout') }}" method="POST" >
                            @csrf
                            <input type="hidden" value="{{ $cart->token }}" name="token" />
                            <div class="row">
                                <table id="example" class="table card-table table-vcenter p-0">
                                    <thead>
                                        <tr>
                                            <th>{{ ucwords(trans_choice('messages.product_name', 2)) }}</th>
                                            <th>{{ ucwords(trans_choice('messages.quantity', 2)) }}</th>
                                            <th>{{ ucwords(__('messages.billing_cycle')) }}</th>
                                            <th>{{ ucwords(__('messages.subscription_period')) }}</th>
                                            @if(Auth::user()->userLevel->name == "Reseller")
                                            <th>{{ ucwords(trans_choice('messages.price', 1)) }}</th>
                                            @endif
                                            <th>{{ ucwords(trans_choice('messages.customer_price', 1)) }}</th>
                                            <th>{{ ucwords(__('messages.subtotal')) }}</th>
                                            <th>{{ ucwords(trans_choice('messages.action', 2)) }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i = 1;
                                        @endphp
                                        @forelse($cart->products as $product)

                                        <tr class="product">
                                            <td>
                                                {{ $product->name }}
                                            </td>
                                            <td>
                                                <div class="product-quantity">
                                                    <input onchange="updateCartProductItemsNumber(this)" type="number" value="{{ $product->pivot->quantity }}" name="{{ $product->pivot->id }}" id="quantity" class="form-control" step="1"  style="max-width: 10em;" required />{{-- min="{{ $product->minimum_quantity }}" max="{{ $product->maximum_quantity }}" --}}                                                </div>
                                                </td>
                                                <td>
                                                    <select class="form-control SlectBox SumoUnder" onchange="updateCartProductCycle(this)" name="billing_cycle[{{ $product->pivot->id }}]" required="required" class="billing_cycle" id="{{ $product->pivot->id }}">
                                                        <option value="" >{{ ucwords(__('messages.choose_one')) }}</option>
                                                        @foreach($product->supported_billing_cycles as $cycle)
                                                        <option value="{{ $cycle }}" @if($cycle == $product->pivot->billing_cycle) selected @endif>
                                                           {{ucfirst($cycle) }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" disabled="disabled" value="{{ $product->term }} Year" class="form-control" />
                                                </td>
                                                @if(Auth::user()->userLevel->name == "Reseller")
                                                <td>{{ $product->pivot->price }}</td>
                                                @endif
                                                <td>{{ $product->pivot->retail_price }}</td>
                                                        <td class="product-line-price">
                                                            {{ number_format(floatval($product->pivot->retail_price * $product->pivot->quantity), 2) }}
                                                        </td>
                                                        <td>
                                                            <div class="row">
                                                                <div class="btn-group align-top">
                                                                    <a class="btn btn-sm btn-white btn-svg" href="{{ route('cart.remove_product', $product->pivot->id) }}" type="button"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M8 9h8v10H8z" opacity=".3"/><path d="M15.5 4l-1-1h-5l-1 1H5v2h14V4zM6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM8 9h8v10H8V9z"/></svg></a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        @foreach ($product->getaddons()->all() as $item)
                                                        <tr>
                                                            <td><strong>Add-on:</strong> {{$item->name}}</td>
                                                            <td>
                                                                <input class="form-control" type="number" name="amount" value="{{$item->amount}}">
                                                            </td>
                                                            @endforeach
                                                        </tr>
                                                    </tr>
                                                    @php
                                                    $i++;
                                                    @endphp
                                                    @empty
                                                    <tr>
                                                        <td colspan="6">
                                                            {{  ucwords(__('messages.empty_cart')) }}
                                                        </td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="float-sm-right">
                                            <a href="{{ route('store.index') }}" role="button" class="btn btn-primary">
                                                {{ ucwords(__('messages.continue_shopping')) }}
                                            </a>
                                            <a href="{{ route('cart.clear') }}" role="button" class="btn btn-danger">
                                                {{ ucwords(__('messages.clear_cart')) }}
                                            </a>
                                            <button type="submit" class="btn btn-success">
                                                {{ ucwords(__('messages.checkout')) }} <i class="fe fe-arrow-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        &nbsp;
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @else
                    <div class="row">
                        <div class="col">
                            {{ ucwords(__('messages.empty_cart')) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a href="{{ route('store.index') }}" class="btn btn-primary">{{ ucwords(__('messages.continue_shopping')) }}</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
</div>


<script>
    let cartLines = document.getElementsByTagName('tr');
    var counter = 0;
    for(let cartLine of cartLines){
        if(counter !== 0){
            updateCartLine(cartLine);
        }
        counter++;
    }
</script>

@endsection
