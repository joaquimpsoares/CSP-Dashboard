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
                    <th>{{ ucwords(trans_choice('messages.action', 2)) }}</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $products = Session::get('cart')->items;
                @endphp
                @foreach($products as $product)
                    <tr>
                        <td>
                            {{ $product['item']->name }}
                        </td>
                        <td>
                            <input type="number" value="{{ $product['quantity'] }}" name="quantity" id="quantity" class="form-control" step="1" min="{{$product['item']['minimum_quantity']}}" max="{{$product['item']['maximum_quantity']}}" style="max-width: 10em;" required />
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
            <tfoot>
                <tr>
                    <td colspan="3" align="right">
                        <a href="{{ route('products.index') }}" class="btn btn-primary">{{ ucwords(__('messages.continue_shopping')) }}</a>
                        <a href="{{ route('cart.clear') }}" class="btn btn-danger">{{ ucwords(__('messages.clear_cart')) }}</a>
                        <button class="btn btn-success">{{ ucwords(__('messages.checkout')) }}</button>
                    </td>
                </tr>
            </tfoot>
        </table>
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
