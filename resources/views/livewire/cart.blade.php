<div class="container">
    <section class="section">
        <div class="card">
            <div class="card-body">
                @if($cart)
                <form action="{{ route('cart.checkout') }}" method="POST" >
                    @csrf
                    <input type="hidden" value="{{ $cart->token }}" name="token" />
                    <div class="row">
                        <div class="col table-responsive">
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
                                    @forelse($cart->products as $product)
                                    <tr class="product">
                                        <td>
                                            {{ $product->name }}
                                        </td>
                                        <td>
                                            {{-- @foreach ($quantity as $item) --}}
                                                
                                            <input wire:model="quantity" type="number" value="{{ $counter }}" 
                                            class="form-control" step="1" min="{{ $product->minimum_quantity }}" max="{{ $product->maximum_quantity }}" style="max-width: 10em;" required />
                                            {{-- @endforeach --}}
                                            {{-- <input type="number" value="{{ $product->pivot->quantity }}" name="{{ $product->pivot->id }}" id="quantity" class="form-control" step="1" min="{{ $product->minimum_quantity }}" max="{{ $product->maximum_quantity }}" style="max-width: 10em;" required /> --}}
                                            {{-- <livewire:cart-update :quantity="$quantity" :productspivot="$productspivot" :product="$product"/> --}}
                                        </td>
                                        <td>
                                            <select name="billing_cycle[{{ $product->pivot->id }}]" required="required" class="billing_cycle" id="{{ $product->pivot->id }}">
                                                <option value="" >{{ ucwords(__('messages.choose_one')) }}</option>
                                                @foreach($product->supported_billing_cycles as $cycle)
                                                <option value="{{ $cycle }}" @if($cycle == $product->billing_cycle) selected @endif>
                                                    {{ $cycle }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" disabled="disabled" value="{{ $product->pivot->term }} Year" class="form-control" />
                                        </td>
                                        @if(Auth::user()->userLevel->name == "Reseller")
                                        <td>{{ $product->pivot->price }}</td>
                                        @endif
                                        <td class="product-price">{{ $product->pivot->retail_price }}</td>
                                        <td class="product-line-price">
                                            {{ number_format(floatval($product->pivot->retail_price * $product->quantity), 2) }}   
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col">
                                                    <a href="{{ route('cart.remove_product', $product->pivot->id) }}"><span class="icon is-small text-danger"><i class="fas fa-trash-restore-alt"></i></span></a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6">
                                            {{  ucwords(__('messages.empty_cart')) }}
                                        </td>
                                    </tr>
                                    @endforelse   
                                </tbody>
                            </table>
                            <div class="row float-right">
                                <a href="{{ route('store.index') }}" class="btn btn-primary">
                                    {{ ucwords(__('messages.continue_shopping')) }}
                                </a>
                                <a href="{{ route('cart.clear') }}" class="btn btn-danger">
                                    {{ ucwords(__('messages.clear_cart')) }}
                                </a>
                                <button type="submit" class="btn btn-success">
                                    {{ ucwords(__('messages.checkout')) }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        &nbsp;
                    </div>
                </form>
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



