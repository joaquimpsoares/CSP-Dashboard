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
                                    <x-input type="text" id="name" name="name" value="{{ $price->name }}"></x-input>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="product_sku">{{ ucwords(trans_choice('messages.product_sku', 1)) }}</label>
                                    <x-input type="text" id="product_sku" name="product_sku" value="{{ $price->product_sku }}"></x-input>
                                </div>
                            </div>
                            <label for="product_vendor" class="">{{ucwords(trans_choice('messages.vendor', 1))}}</label>
                            <x-input type="text" id="product_vendor" name="product_vendor" value="{{ $price->product_vendor }}" placeholder="1234 Main St"></x-input>
                            <div class="row mt-4">
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <label for="price" class="">{{ucwords(trans_choice('messages.price', 1))}}</label>
                                    <x-input type="text" id="price" name="price" value="{{ $price->price }}"></x-input>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <label for="msrp">{{ucwords(trans_choice('messages.retail_price', 1))}}</label>
                                    <x-input name="msrp" type="text" id="msrp" placeholder="" value="{{ $price->msrp }}" required ></x-input>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <label for="currency">{{ucwords(trans_choice('messages.currency', 1))}}</label>
                                    <x-input name="currency" type="text" id="currency" autocomplete="family-name" placeholder="" value="{{ $price->currency }}" required></x-input>
                                </div>
                            </div>
                            <div class="px-4 py-3  text-right sm:px-6">
                                <x-button href="{{route('price.update',$price)}}">{{ucwords(trans_choice('messages.update', 1))}}</x-button>
                              </div>
                        </form>

                        <div class="card-footer">
                            <div class="row">
                                {{-- @if($updateMode)
                                @include('livewire.price.updateprice')
                                @else --}}
                                <table class="table table-light">
                                    <thead class="thead-light">
                                        <tr>
                                            {{-- <th>{{ucwords(trans_choice('messages.tier_name', 1))}}<x-input wire:model="name" type="text" id="tier_name" placeholder="" required></x-input></th>
                                            <th>{{ucwords(trans_choice('messages.sku', 1))}}<x-input wire:model="product_sku" type="text" id="tier_product_sku" placeholder="" required></x-input></th>
                                            <th>{{ucwords(trans_choice('messages.min_quantity', 1))}}<x-input wire:model="min_quantity" type="number" id="min_quantity" placeholder="" required></x-input></th>
                                            <th>{{ucwords(trans_choice('messages.max_quantity', 1))}}<x-input wire:model="max_quantity" type="number" id="max_quantity" placeholder="" required></x-input></th>
                                            <th>{{ucwords(trans_choice('messages.price', 1))}}<x-input wire:model="priceU" type="number" id="price" placeholder="" required></x-input></th>
                                            <th>{{ucwords(trans_choice('messages.msrp', 1))}}<x-input wire:model="msrp" type="number" id="msrp" placeholder="" required></x-input></th>
                                            <th><a type="button" wire:click="addpriceTier" class="btn btn-info addrow">+</a></th> --}}
                                        </tr>
                                    </thead>
                                    {{-- @endif --}}
                                    <tbody>
                                        @forelse ($price->tiers as $tier)
                                        {{-- <tr>
                                            <td>
                                                <x-input name="tier_name" disabled type="text" id="   " placeholder="" value="{{ $tier->name }}" required></x-input>
                                                @error('tier_name')  <span class="text-danger">{{ $message }}</span>@enderror
                                            </td>
                                            <td>
                                                <x-input name="product_sku" disabled {{ $errors->has('product_sku') ? ' border-red-500' : 'border-gray-200' }} type="text" id="product_sku" placeholder="" value="{{ $tier->product_sku }}" required></x-input>
                                                @error('product_sku') <span class="text-danger">{{ $message }}</span>@enderror
                                            </td>
                                            <td>
                                                <x-input name="min_quantity" disabled type="number" id="min_quantity" placeholder="" value="{{ $tier->min_quantity }}" required></x-input>
                                            </td>
                                            <td>
                                                <x-input name="max_quantity" disabled type="number" id="max_quantity" placeholder="" value="{{ $tier->max_quantity }}" required></x-input>
                                            </td>
                                            <td>
                                                <x-input name="price" disabled {{ $errors->has('price') ? ' border-red-500' : 'border-gray-200' }} type="number" id="price" placeholder="" value="{{ $tier->price }}" required></x-input>
                                                @error('price') <span class="text-danger">{{ $message }}</span>@enderror
                                            </td>
                                            <td>
                                                <x-input name="msrp" disabled type="number" id="msrp" placeholder="" value="{{ $tier->msrp }}" required></x-input>
                                            </td>
                                            <td>
                                                <button wire:click="removepriceTier({{ $tier->id }})" class="btn btn-danger remove">-</button>
                                            </td>
                                            <td>
                                                <div class="col-lg-4 mb-4">
                                                    <x-button  wire:click="edit({{ $tier->id }})" class="button submit_btn right" type="submit">{{ucwords(trans_choice('messages.edit', 1))}}</x-button>
                                                </div>
                                            </td>
                                            </tr>--}}
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
