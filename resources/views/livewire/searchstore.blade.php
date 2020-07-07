<section class="section">
    <div class="row">
        <livewire:filterstore/>
        <div class="col-md-10">
            <div class="row">
                <div class="col-3">
                    <form method="GET" action="{{route('store.index')}}" style="padding-top: 15px;">
                        @if (isset($filters['name']))
                        <input type="hidden" name="name" value="{{ $filters['name']}}" />
                        @endif
                        @if (isset($filters['vendor']))
                        <input  type="hidden" name="vendor" value="{{ $filters['vendor']}}" />
                        @endif
                        
                    </form>
                </div>
            </div>
            <div class="row">
                <input wire:model="search" class="form-control" type="text" placeholder="Search products/sku..."/>
                @if (!empty($prices))
                @foreach($prices as $product)
                <div class="product-card">
                    @if ($product->product->category == "Trial")
                    <div class="badge1">{{$product->product->category}}</div>
                    @endif
                    @if ($product->product->category == "Education")
                    <div class="badge1">{{$product->product->category}}</div>
                    @endif
                    <div class="absolute product-tumb">
                        <img src="{{ asset('images/vendors/' . $product->product->vendor . '.png') }}"  title="{{ $product->name }}" class="img-fuid" style="max-width: 120px;max-height: 120px;" />
                    </div>
                    <div class="product-details">
                        <span class="product-category">{{ $product->product->sku }}</span>
                        <h4><a href="">{{ $product->name }}</a></h4>
                        <p class="text">{{ str_limit($product->product->description, 150) }}</p>
                        <div class="product-bottom-details">
                            @if(Auth::user()->userLevel->name == "Reseller")
                            <div class="product-price"><small>{{ $product->price}}$</small>{{ $product->msrp}}$</div>
                            @else
                            <div class="product-price"><small></small>{{ $product->msrp}}$</div>
                            @endif
                            <div class="product-links">
                                <form method="POST" action="{{ route('cart.add_to_cart') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->product['id']}}">
                                    <button type="submit" ><i class="fa fa-shopping-cart"></i></a></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            <div class="row">
                @if (!$prices)
                <h2><strong>{{ ucwords(trans_choice('messages.no_priceList', 1)) }}</strong></h2>
                @endif
                <hr>
                <div class="col">
                    <span class="float-right">
                        {{ $prices->links() }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>
