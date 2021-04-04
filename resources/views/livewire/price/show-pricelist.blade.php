
<div>
    <main class="relative flex-1 overflow-y-auto focus:outline-none" tabindex="-1">
        {{-- <input wire:model="priceList" type="hidden" name="" value=""> --}}
        <div class="py-8 bg-white xl:py-10">
            <div class="max-w-3xl px-4 mx-auto sm:px-6 lg:px-8 xl:max-w-full xl:grid xl:grid-cols-3">
                <div class="xl:col-span-2 xl:pr-8 xl:border-r xl:border-gray-200">
                    <div>
                        <div>
                            <div class="xl:pl-8 md:flex md:items-center md:justify-between md:space-x-4 xl:border-b xl:pb-6">
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900">{{ ucwords(trans_choice('messages.price_list', 1)) }}</h1>
                                </div>
                                <div class="flex mt-4 space-x-3 md:mt-0">
                                    <button wire:click="showModal" type="button" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <!-- Heroicon name: solid/bell -->
                                        <svg class="w-5 h-5 mr-2 -ml-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ ucwords(trans_choice('messages.add_price', 1)) }}</span>
                                    </button>
                                </div>
                            </div>
                            <aside class="mt-8 xl:hidden">
                                <h2 class="sr-only">Details</h2>
                                <div class="space-y-5">
                                    <div class="flex items-center space-x-2">
                                        <!-- Heroicon name: solid/lock-open -->
                                        <svg class="w-5 h-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                        </svg>
                                        <span class="text-sm font-medium text-green-700">{{$prices->count()}}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <!-- Heroicon name: solid/chat-alt -->
                                        <svg class="w-5 h-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                                        </svg>
                                        <span class="text-sm font-medium text-gray-900">4 comments</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <!-- Heroicon name: solid/calendar -->
                                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-sm font-medium text-gray-900">Created on <time datetime="2020-12-02">{{$priceList->created_at}}</time></span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <!-- Heroicon name: solid/calendar -->
                                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-sm font-medium text-gray-900">Created on <time datetime="2020-12-02">{{$priceList->margin}}</time></span>
                                    </div>
                                </div>
                                <div class="py-6 mt-6 space-y-8 border-t border-b border-gray-200">
                                    <div>
                                        <h2 class="text-sm font-medium text-gray-500">Assignees</h2>
                                        <ul class="mt-3 space-y-3">
                                            <li class="flex justify-start">
                                                <a href="#" class="flex items-center space-x-3">
                                                    <div class="flex-shrink-0">
                                                        <img class="w-5 h-5 rounded-full" src="https://images.unsplash.com/photo-1520785643438-5bf77931f493?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80" alt="">
                                                    </div>
                                                    <div class="text-sm font-medium text-gray-900">Eduardo Benz</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h2 class="text-sm font-medium text-gray-500">Tags</h2>
                                        <ul class="mt-2 leading-8">
                                            <li class="inline">
                                                <a href="#" class="relative inline-flex items-center rounded-full border border-gray-300 px-3 py-0.5">
                                                    <div class="absolute flex items-center justify-center flex-shrink-0">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-rose-500" aria-hidden="true"></span>
                                                    </div>
                                                    <div class="ml-3.5 text-sm font-medium text-gray-900">Bug</div>
                                                </a>
                                            </li>
                                            <li class="inline">
                                                <a href="#" class="relative inline-flex items-center rounded-full border border-gray-300 px-3 py-0.5">
                                                    <div class="absolute flex items-center justify-center flex-shrink-0">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-indigo-500" aria-hidden="true"></span>
                                                    </div>
                                                    <div class="ml-3.5 text-sm font-medium text-gray-900">Accessibility</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </aside>
                            <div class="py-3 xl:pl-4 xl:pt-6 xl:pb-0">
                                <h2 class="sr-only">Description</h2>
                                <div class="prose max-w-none">
                                    @include('priceList.partials.pricetable')
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <aside class="hidden xl:block xl:pl-10">
                    <h2 class="sr-only">Details</h2>
                    <div class="space-y-5">
                        <div class="flex items-center space-x-2">
                            <!-- Heroicon name: solid/lock-open -->
                            <svg class="w-5 h-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                            </svg>
                            <span class="text-sm font-medium text-green-700">{{$prices->count()}}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <!-- Heroicon name: solid/chat-alt -->
                            <svg class="w-5 h-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                            </svg>
                            <span class="text-sm font-medium text-gray-900"> {{$products->count()}}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <!-- Heroicon name: solid/calendar -->
                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm font-medium text-gray-900">Created on <time datetime="2020-12-02">{{$priceList->created_at}}</time></span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <!-- Heroicon name: solid/calendar -->
                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 011 1v3a1 1 0 11-2 0v-3a1 1 0 011-1zm-3 3a1 1 0 100 2h.01a1 1 0 100-2H10zm-4 1a1 1 0 011-1h.01a1 1 0 110 2H7a1 1 0 01-1-1zm1-4a1 1 0 100 2h.01a1 1 0 100-2H7zm2 1a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1zm4-4a1 1 0 100 2h.01a1 1 0 100-2H13zM9 9a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1zM7 8a1 1 0 000 2h.01a1 1 0 000-2H7z" clip-rule="evenodd" />
                            </svg>
                            <div class="@if ($editMargin) hidden @endif ">
                                <div class="flex rounded-md shadow-sm">
                                    <div class="relative flex items-stretch flex-grow focus-within:z-10">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        </div>
                                        <input wire:model="margin" type="text" name="email" id="email" @if (!$editMargin) disabled @endif class="block w-full border-gray-300 rounded-none focus:ring-indigo-500 focus:border-indigo-500 rounded-l-md sm:text-sm" placeholder="10%">
                                    </div>
                                    <button wire:click="editMargin" class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-r-md bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                        <!-- Heroicon name: solid/sort-ascending -->
                                        <span>{{ ucwords(trans_choice('messages.edit', 1)) }}</span>
                                    </button>
                                </div>
                            </div>
                            <div class="@if (!$editMargin) hidden @endif ">
                                <div class="flex rounded-md shadow-sm">
                                    <div class="relative flex items-stretch flex-grow focus-within:z-10">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        </div>
                                        <input wire:model="margin" type="text" name="email" id="email" class="block w-full border-gray-300 rounded-none focus:ring-indigo-500 focus:border-indigo-500 rounded-l-md sm:text-sm" placeholder="10%">
                                    </div>
                                    <button wire:click="saveMargin({{ $priceList->id }})"class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-r-md bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                        <!-- Heroicon name: solid/sort-ascending -->
                                        <span>{{ ucwords(trans_choice('messages.save', 1)) }}</span>
                                    </button>
                                </div>
                            </div>
                            {{-- <a wire:click="editMargin" type="button" class="@if ($editMargin) hidden @endif  relative inline-flex items-center px-4 py-2 ml-8 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="text-sm font-medium text-gray-900">{{ ucwords(trans_choice('messages.edit', 1)) }}</span>
                            </a> --}}
                        </div>
                    </div>
                    <div class="py-6 mt-6 space-y-8 border-t border-gray-200">
                        <div>
                            <h2 class="text-sm font-medium text-gray-500">Belongs To</h2>
                            <ul class="mt-3 space-y-3">
                                <li class="flex justify-start">
                                    <a href="#" class="flex items-center space-x-3">
                                        <div class="pl-4 text-sm font-medium text-gray-900">{{$priceList->provider->company_name}}</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h2 class="text-sm font-medium text-gray-500">Instance</h2>
                            <ul class="mt-3 space-y-3">
                                <li class="flex justify-start">
                                    <a href="#" class="flex items-center space-x-3">
                                        <div class="pl-4 text-sm font-medium text-gray-900">{{$priceList->instance_id}}</div>
                                    </a>
                                </li>
                                <li class="flex justify-start">
                                    <a href="#" class="flex items-center space-x-3">
                                        <div class="pl-4 text-sm font-medium text-gray-900">{{$priceList->name}}</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </main>

    <div class="@if (!$showModal) hidden @endif flex items-center justify-center fixed left-0 bottom-0 w-full h-full bg-opacity-70">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">{{ ucwords(trans_choice('messages.new_product', 1)) }}
                        </h6><button wire:click="close" aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="save">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="mb-2 col-md-12">
                                        <label for="country">{{ucwords(trans_choice('messages.select_product', 1))}}</label>
                                        <div class="mb-3 input-group">
                                            <select wire:model="sku" name="sku" class="form-control select2-show-search @error('sku') is-invalid @enderror" data-placeholder="Choose one (with searchbox)">
                                                <option value="">Choose...</option>
                                                @foreach ($products as $product)
                                                <option   value="{{$product->sku}}">{{$product->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('sku')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="price" class="">{{ ucwords(trans_choice('messages.price', 1)) }}</label>
                                        <input type="text" id="price" wire:model="price" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
                                        @error('price')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="mb-2 col-md-6">
                                        <label for="msrp">{{ ucwords(trans_choice('messages.msrp', 1)) }}</label>
                                        <input type="text" wire:model="msrp" id="msrp" name="msrp" class="form-control @error('msrp') is-invalid @enderror" value="{{ old('msrp') }}">
                                        @error('msrp')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="product_vendor" class="">{{ ucwords(trans_choice('messages.vendor', 1)) }}</label>
                                        <input type="text" wire:model="product_vendor" id="product_vendor" name="product_vendor" class="form-control @error('product_vendor') is-invalid @enderror">
                                        @error('product_vendor')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="mb-2 col-md-6">
                                        <label for="currency">{{ ucwords(trans_choice('messages.currency', 1)) }}</label>
                                        <input type="text" wire:model="currency" id="currency" name="currency" class="form-control @error('currency') is-invalid @enderror" value="{{ old('currency') }}">
                                        @error('currency')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                {{-- @include('priceList.partials.addprice') --}}
                            </div>
                            <div class="modal-footer">
                                <button wire:click="close" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- modal-wrapper-demo -->
</div>
