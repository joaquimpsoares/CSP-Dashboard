<div>
    <div class="row">
        <div class="col-md-3">
            <legend><h3>{{ ucwords(trans_choice('messages.filter', 1)) }}</h3></legend>				
            @foreach ($categories as $category)
            <div class="form-check">
                <input wire:model="categories" class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                {{$category->category}}
            </div>
            @endforeach
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-3">
                    <form method="GET" action="{{ route('store.index') }}" style="padding-top: 15px;">
                        @if (isset($filters['name']))
                        <input type="hidden" name="name" value="{{ $filters['name']}}" />
                        @endif
                        @if (isset($filters['vendor']))
                        <input wire:model="categories" type="hidden" name="vendor" value="{{ $filters['vendor']}}" />
                        @endif
                        <div class="input-group mb-3">
                            <select name="quantity" class="custom-select " id="quantity">
                                <option {{ (!isset($filters['quantity'])) ? 'selected' : ( isset($filters['quantity']) && $filters['quantity'] === '12' ) ? 'selected' : ''  }}>12</option>
                                <option {{ ( isset($filters['quantity']) && $filters['quantity'] === '24' ) ? 'selected' : '' }}>24</option>
                                <option {{ ( isset($filters['quantity']) && $filters['quantity'] === '36' ) ? 'selected' : '' }}>36</option>
                            </select>
                            {{-- <div class="input-group-append">
                                <button class="input-group-text" type="submit" for="quantity">{{ ucwords(__('messages.apply_filter')) }}</button>
                            </div> --}}
                        </div>
                        <input type="hidden" name="search" value="1" />
                    </form>
                </div>
            </div>
            
            <input wire:model="search" class="form-control" type="text" placeholder="Search products/sku..."/>
            <div class="row">
                @foreach($products as $product)
                <div class="product-card">
                    @if (	 $product->category == "Trial")
                    <div class="badge">{{$product->category}}</div>
                    @endif
                    @if (	 $product->category == "Education")
                    <div class="badge">{{$product->category}}</div>
                    @endif
                    <div class="product-tumb">
                        <img src="{{ asset('images/vendors/' . $product->vendor . '.png') }}"  title="{{ $product->name }}" class="img-fuid" style="max-width: 120px;max-height: 120px;" />
                    </div>
                    <div class="product-details">
                        <span class="product-catagory">{{ $product->category }}</span>
                        <h4><a href="">{{ $product->name }}</a></h4>
                        <p class="text">{{ str_limit($product->description, 150) }}</p>
                        <div class="product-bottom-details">
                            {{-- <div class="product-price"><small></small>{{ $product->price->msrp}}$</div> --}}
                            <div class="product-links">
                                <form method="POST" action="{{ route('cart.add_to_cart') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                    <button type="submit" ><i class="fa fa-shopping-cart"></i></a></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <span class="float-right">
                        {{ $products->links() }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
    
