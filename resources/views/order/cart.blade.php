@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col">
        <h2>{{ ucwords(__('messages.products_list')) }}</h2>
    </div>
</div>

@if(Session::has('cart'))

<div class="row">
    <div class="col table-responsive">
        <table class="table table-stripd ">
            <thead>
                <tr>
                    <th>{{ ucwords(trans_choice('messages.product_name', 2)) }}</th>
                    <th>{{ ucwords(trans_choice('messages.quantity', 2)) }}</th>
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
                $products = Session::get('cart')->items;
                @endphp
                @foreach($products as $product)
                <tr class="product">
                    <td>
                        {{ $product['item']->name }}
                    </td>
                    <td>

                        <div class="col">
                            <div class="product-quantity">
                                <input type="number" value="{{ $product['quantity'] }}" name="{{ $product['item']->id }}" id="quantity" class="form-control" step="1" min="{{$product['item']['minimum_quantity']}}" max="{{$product['item']['maximum_quantity']}}" style="max-width: 10em;" required />
                            </div>
                        </div>
                    </td>
                    @if(Auth::user()->userLevel->name == "Reseller")
                    <td>{{ $product['price']->price }}</td>
                    @endif
                    <td class="product-price">{{ $product['price']->msrp }}</td>
                    <td class="product-line-price">
                        
                            {{ number_format(floatval($product['price']->msrp * $product['quantity']), 2) }}
                        
                    </td>
                    <td>
                        <div class="row">
                            <div class="col">
                                <a href="{{ route('cart.remove_product', $product['item']->id) }}"><span class="icon is-small text-danger"><i class="fas fa-trash-restore-alt"></i></span></a>
                            </div>
                        </div>
                    </td>

                </tr>
                @endforeach        
            </tbody>
            
        </table>
        <div class="row">
            <a href="{{ route('products.index') }}" class="btn btn-primary">{{ ucwords(__('messages.continue_shopping')) }}</a>
            <a href="{{ route('cart.clear') }}" class="btn btn-danger">{{ ucwords(__('messages.clear_cart')) }}</a>
            <button class="btn btn-success">{{ ucwords(__('messages.checkout')) }}</button>
        </div>
    </div>
</div>

@else

<div class="row">
    <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
        <h2>No Items in Cart!</h2>
    </div>
</div>

@endif
@endsection

@section('scripts')
<script>
    $(document).ready(function() { 
        $('.product-quantity input').change( function() {
            updateProductQuantity(this);

        });

    });

    function updateProductQuantity(item) {
        $.get( "/order/product/" + item.name + "/quantity/" + item.value, function() {
            //action begining
        })
        .done(function(data) {
            updateProductSubTotal(item);
        })
        .fail(function(data) {
            console.log(data);
            // some error
        });
    }

    function updateProductSubTotal(item) {
        var productRow = $(item).parent().parent().parent().parent();
        var price = parseFloat(productRow.children('.product-price').text());
        var quantity = item.value;
        var linePrice = price * quantity;
                
        productRow.children('.product-line-price').each(function () {
            
            $(this).text(linePrice.toFixed(2));
            
        });

    }

    function recalculateCart()
    {
        return true;
    }
</script>
@endsection