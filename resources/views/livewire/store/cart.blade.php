<div>
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
                                    <table class="table table-stripd ">
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
                                                        <div class="input-group">
                                                            <span class="input-group-prepend">
                                                                <button wire:click="remove.{{$product->pivot->quantity}}" class="btn btn-primary" type="button">-</button>
                                                            </span>
                                                            <input wire:model.defer="qty.{{ $product->pivot->id }}"  value="{{ $product->pivot->quantity }}" name="{{ $product->pivot->id }}" type="text" class="form-control" placeholder="Search for...">
                                                            {{-- <input wire:model.defer="qty.{{ $product->pivot->id }}" type="text" value="{{ $product->pivot->quantity }}" name="{{ $product->pivot->id }}" id="quantity" class="form-control" step="1"   required />min="{{ $product->minimum_quantity }}" max="{{ $product->maximum_quantity }}"                                                </div> --}}
                                                            <span class="input-group-append">
                                                            <button wire:click="add.{{$product->pivot->quantity}}" class="btn btn-primary" type="button">+</button>
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <select wire:model.defer="billing.[{{ $product->pivot->id }}]" name="billing_cycle[{{ $product->pivot->id }}]" required="required" class="billing_cycle form-control select2 custom-select" id="{{ $product->pivot->id }}" data-placeholder="Choose one">
                                                            {{-- <select name="billing_cycle[{{ $product->pivot->id }}]" required="required" class="billing_cycle" id="{{ $product->pivot->id }}"> --}}
                                                                <option value="" selected>{{ ucwords(__('messages.choose_one')) }}  </option>
                                                                @foreach($product->supported_billing_cycles as $cycle)
                                                                <option value="{{ $cycle }}" @if($cycle == $product->pivot->billing_cycle)  @endif>
                                                                    {{ $cycle }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            {{-- @dump($billing) --}}
                                                        </td>
                                                        <td>
                                                            <input type="text" disabled="disabled" value="{{ $product->term }} Year" class="form-control" />
                                                        </td>
                                                        @if(Auth::user()->userLevel->name == "Reseller")
                                                        <td>{{ $product->pivot->price }}</td>
                                                        @endif
                                                        <td class="product-price">{{ $product->pivot->retail_price }}</td>
                                                        <td class="product-line-price" wire:model="subtotal.{{$product->pivot->retail_price}}">
                                                            {{ number_format(floatval($product->pivot->retail_price * $product->pivot->quantity), 2) }}
                                                        </td>
                                                        <td>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <a href="{{ route('cart.remove_product', $product->pivot->id) }}"><span class="icon is-small text-danger"><i class="fas fa-trash-restore-alt"></i></span></a>
                                                                </div>
                                                            </div>
                                                        </td>
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
                                        <div class="float-right ">
                                            <a href="{{ route('store.index') }}" class="mt-2 btn btn-info"><i class="fe fe-arrow-left"></i> {{ ucwords(__('messages.continue_shopping')) }}</a>
                                            <a href="{{ route('cart.clear') }}" class="mt-2 btn btn-primary">{{ ucwords(__('messages.clear_cart')) }}</a>
                                            <button type="submit"  class="mt-2 btn btn-secondary">{{ ucwords(__('messages.checkout')) }} <i class="fe fe-arrow-right"></i></a>
                                            </div>
                                            {{-- <div class="float-sm-right">
                                                <a href="{{ route('store.index') }}" role="button" class="btn btn-primary">
                                                    {{ ucwords(__('messages.continue_shopping')) }}
                                                </a>
                                                <a href="{{ route('cart.clear') }}" role="button" class="btn btn-danger">
                                                    {{ ucwords(__('messages.clear_cart')) }}
                                                </a>
                                                <button type="submit" class="btn btn-success">
                                                    {{ ucwords(__('messages.checkout')) }}
                                                </button>
                                            </div> --}}
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

</div>
