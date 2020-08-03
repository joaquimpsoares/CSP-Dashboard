<div>
    <section class="dark-grey-text">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form method="POST" action="{{ route('price.update', $price) }}" class="col s12">
                            @method('PATCH')
                            @csrf              
                            <h1>{{ ucwords(trans_choice('messages.edit_price', 1)) }}</h1>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="name" class="">{{ ucwords(trans_choice('messages.name', 1)) }}</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{ $price->name }}">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="product_sku">{{ ucwords(trans_choice('messages.product_sku', 1)) }}</label>
                                    <input type="text" id="product_sku" name="product_sku" class="form-control" value="{{ $price->product_sku }}">
                                </div>
                            </div>
                            <label for="product_vendor" class="">{{ucwords(trans_choice('messages.vendor', 1))}}</label>
                            <input type="text" id="product_vendor" name="product_vendor" class="form-control mb-4" value="{{ $price->product_vendor }}" placeholder="1234 Main St">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <label for="price" class="">{{ucwords(trans_choice('messages.price', 1))}}</label>
                                    <input type="text" id="price" name="price" class="form-control mb-4" value="{{ $price->price }}">
                                </div>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <label for="msrp">{{ucwords(trans_choice('messages.retail_price', 1))}}</label>
                                    <input name="msrp" type="text" class="form-control" id="msrp" placeholder="" value="{{ $price->msrp }}" required >
                                </div>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <label for="currency">{{ucwords(trans_choice('messages.currency', 1))}}</label>
                                    <input name="currency" type="text" class="form-control" id="currency" placeholder="" value="{{ $price->currency }}" required>
                                </div>
                            </div>
                            <div class="col-lg-4 mb-4">
                            <button href="{{route('price.update',$price)}}" class="button submit_btn right" type="submit">{{ucwords(trans_choice('messages.update', 1))}}</button>
                            </div>
                        </form>
                        
                        <div class="card-footer">
                            <div class="row">                                            
                                @if($updateMode)
                                @include('livewire.price.updateprice')
                                @else
                                <table class="table table-light">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>{{ucwords(trans_choice('messages.tier_name', 1))}}<input wire:model="name" type="text" class="form-control" id="tier_name" placeholder="" required></th>
                                            <th>{{ucwords(trans_choice('messages.sku', 1))}}<input wire:model="product_sku" type="text" class="form-control" id="tier_product_sku" placeholder="" required></th>
                                            <th>{{ucwords(trans_choice('messages.min_quantity', 1))}}<input wire:model="min_quantity" type="number" class="form-control" id="min_quantity" placeholder="" required></th>
                                            <th>{{ucwords(trans_choice('messages.max_quantity', 1))}}<input wire:model="max_quantity" type="number" class="form-control" id="max_quantity" placeholder="" required></th>
                                            <th>{{ucwords(trans_choice('messages.price', 1))}}<input wire:model="priceU" type="number" class="form-control" id="price" placeholder="" required></th>
                                            <th>{{ucwords(trans_choice('messages.msrp', 1))}}<input wire:model="msrp" type="number" class="form-control" id="msrp" placeholder="" required></th>
                                            <th><a type="button" wire:click="addpriceTier" class="btn btn-info addrow">+</a></th>
                                        </tr>
                                    </thead>
                                    @endif
                                    <tbody>
                                        @forelse ($price->tiers as $tier)
                                        <tr>
                                            <td>
                                                <input name="tier_name" disabled type="text" class="form-control" id="   " placeholder="" value="{{ $tier->name }}" required>
                                                @error('tier_name')  <span class="text-danger">{{ $message }}</span>@enderror
                                            </td>
                                            <td>
                                                <input name="product_sku" disabled {{ $errors->has('product_sku') ? ' border-red-500' : 'border-gray-200' }} type="text" class="form-control" id="product_sku" placeholder="" value="{{ $tier->product_sku }}" required>
                                                @error('product_sku') <span class="text-danger">{{ $message }}</span>@enderror
                                            </td>
                                            <td><input name="min_quantity" disabled type="number" class="form-control" id="min_quantity" placeholder="" value="{{ $tier->min_quantity }}" required></td>
                                            <td><input name="max_quantity" disabled type="number" class="form-control" id="max_quantity" placeholder="" value="{{ $tier->max_quantity }}" required></td>
                                            <td>
                                                <input name="price" disabled {{ $errors->has('price') ? ' border-red-500' : 'border-gray-200' }} type="number" class="form-control" id="price" placeholder="" value="{{ $tier->price }}" required>
                                                @error('price') <span class="text-danger">{{ $message }}</span>@enderror
                                            </td>
                                            <td><input name="msrp" disabled type="number" class="form-control" id="msrp" placeholder="" value="{{ $tier->msrp }}" required></td>
                                            <td><button wire:click="removepriceTier({{ $tier->id }})" class="btn btn-danger remove">-</button></td>
                                            <td>    
                                                <div class="col-lg-4 mb-4">
                                                    <button  wire:click="edit({{ $tier->id }})" class="button submit_btn right" type="submit">{{ucwords(trans_choice('messages.edit', 1))}}</button>
                                                </div></td>
                                            </tr>
                                            @empty
                                            <tr class="text-center">
                                                <td colspan="8" class="py-3 italic">No data</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
