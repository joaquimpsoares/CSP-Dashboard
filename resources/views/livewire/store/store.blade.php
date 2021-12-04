<div>
    <main class="px-4 mx-auto sm:px-6 lg:px-8"  x-data="{'layout': 'grid'}">
        <div class="relative flex items-baseline justify-between pt-24 pb-6 border-b border-gray-200">
            <div class="text-sm font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                <div class="w-full max-w-lg ml-3 lg:max-w-xs">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative text-gray-400 focus-within:text-gray-500">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input wire:model="search" id="search" class="block w-full bg-white py-1.5 pl-10 pr-3 border border-gray-300 rounded-md leading-5 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500 focus:placeholder-gray-500 sm:text-sm" placeholder="Search" type="search" name="search">
                    </div>
                </div>
            </div>
            <div class="flex items-center col-span-5 sm:col-span-3">

                <button type="button" class="p-2 ml-4 -m-2 text-gray-400 sm:ml-6 hover:text-gray-500 "  x-on:click="layout = 'grid'" x-bind:class="{'active': layout === 'grid'}" id="grid">
                    <span class="sr-only">View grid</span>
                    <svg class="w-5 h-5" aria-hidden="true" x-description="Heroicon name: solid/view-grid" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                </button>
                <button type="button" class="p-2 ml-4 -m-2 text-gray-400 sm:ml-6 hover:text-gray-500 " x-on:click="layout = 'list'" x-bind:class="{'active': layout === 'list'}" id="list">
                    <span class="sr-only">View list</span>
                    <svg class="w-5 h-5" aria-hidden="true" x-description="Heroicon name: solid/view-grid" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
                <button type="button" wire:click="$set('showmobilefilter', true)" class="p-2 ml-4 -m-2 text-gray-400 sm:ml-6 hover:text-gray-500 lg:hidden"  @click="open = true">
                    <span class="sr-only">Filters</span>
                    <svg class="w-5 h-5" aria-hidden="true" x-description="Heroicon name: solid/filter" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
        <section aria-labelledby="products-heading" class="pt-6 pb-24">
            <h2 id="products-heading" class="sr-only">Products</h2>
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-x-8 gap-y-10">
                <!-- Filters -->
                <form class="hidden lg:block">
                    <ul role="list" class="pb-6 space-y-4 text-sm font-medium text-gray-900 border-gray-200">

                        <h3 class="sr-only">{{ ucwords(trans_choice('messages.categories', 1)) }}</h3>
                        <x-input.group inline for="filter-status" label="Category">
                            <x-input.select wire:model="filters.category" id="filter-status">
                                <option value="">Select Category...</option>
                                @foreach ($categories as $value => $label)
                                <option value="{{ $label }}">{{ $label }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>
                    </ul>

                    <h3 class="sr-only">{{ ucwords(trans_choice('messages.product_type', 1)) }}</h3>
                    <ul role="list" class="pb-6 space-y-4 text-sm font-medium text-gray-900 border-b border-gray-200">
                        <x-input.group inline for="filter-status" label="Product Type">
                            <x-input.select wire:model="filters.producttype" id="filter-status">
                                <option value="">Select Type...</option>
                                @foreach ($producttype as $value => $label)
                                <option value="{{ $label }}">{{ $label }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>
                    </ul>
                    <div class="pt-6" x-description="Filter section, show/hide based on section state." id="filter-section-0" x-show="open" style="display: none;">
                        <label class="text-base font-medium text-gray-900">Plugins</label>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="flex items-center" x-data="{ on: false }">
                                    <button type="button" wire:model="filters.plugins" value="false"
                                    class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out bg-gray-200 border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" role="switch" aria-checked="false"
                                    x-ref="switch" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'bg-indigo-600': on, 'bg-gray-200': !(on) }" aria-labelledby="annual-billing-label" :aria-checked="on.toString()" @click="on = !on">
                                        <span aria-hidden="true" class="inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-0 bg-white rounded-full shadow pointer-events-none ring-0" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'translate-x-5': on, 'translate-x-0': !(on) }"></span>
                                    </button>
                                    <span class="ml-3" id="annual-billing-label" @click="on = !on; $refs.switch.focus()">
                                        <span class="text-sm font-medium text-gray-900">Plugins </span>
                                        {{-- <span class="text-sm text-gray-500">(Save 10%)</span> --}}
                                    </span>
                                </div>
                                @dump($filters)
                                {{-- <input id="filter-Plugins-0" wire:model="filters.plugins" name="color[]"  type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="filter-Plugins-0" class="ml-3 text-sm text-gray-600">
                                    Plugins
                                </label>
                                <input id="filter-Plugins-1" wire:model="filters.notplugins" name="color[]"  type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="filter-Plugins-1" class="ml-3 text-sm text-gray-600">
                                    not Plugins
                                </label> --}}
                            </div>
                        </div>

                        <label class="text-base font-medium text-gray-900">Trial</label>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input id="filter-Trial-0" wire:model="filters.trial" name="color[]"  type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="filter-Trial-0" class="ml-3 text-sm text-gray-600">
                                    Trial
                                </label>
                            </div>
                        </div>
                        <label class="mt-3 font-medium text-gray-900 mt-3text-base">Select Term</label>
                        @foreach ($terms as $index => $item)
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input id="{{$index}}" wire:model="filters.terms" name="color[]" value="{{$item}}" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="{{$index}}" class="ml-3 text-sm text-gray-600">
                                    {{$item}}
                                </label>
                            </div>
                        </div>
                        @endforeach
                        <label class="mt-3 text-base font-medium text-gray-900">Select Billing Cycle</label>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input id="filter-Annual-0" wire:model="filters.billing" name="color[]" value="annual" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="filter-Annual-0" class="ml-3 text-sm text-gray-600">
                                    {{ ucwords(trans_choice('messages.annual', 1)) }}
                                </label>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input id="filter-Monthly-0" wire:model="filters.billing" name="color[]" value="monthly" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <label for="filter-Monthly-0" class="ml-3 text-sm text-gray-600">
                                    {{ ucwords(trans_choice('messages.monthly', 1)) }}
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Product grid -->
                <div class="lg:col-span-3">
                    <!-- Replace with your content -->
                    <div tabindex="0" class="focus:outline-none"  x-show="layout === 'grid'" x-cloak>
                        <div class="container py-2 mx-auto" >
                            <div class="flex flex-wrap items-center justify-center lg:justify-between">
                                <!-- Card 1 -->
                                @forelse($prices as $index => $price)
                                {{-- <a href="#" wire:click="showDetails({{ $price->related_product->id }})" class="block mr-3 no-underline hover:bg-gray-50"> --}}
                                    <div tabindex="{{$index}}" class="mt-8 overflow-hidden transition duration-500 ease-in-out transform rounded-lg shadow-lg cursor-pointer hover:-translate-y-5 hover:shadow-2xl h-90 w-90 md:w-80">
                                        <div>
                                            <img alt="person capturing an image" src="data:image/png;base64,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" tabindex="0" class="w-full focus:outline-none h-44" />
                                        </div>
                                        <div class="bg-white">
                                            <div class="flex items-center justify-between px-4 pt-4">
                                                <div>
                                                    @if($price->related_product->is_addon ==true)
                                                    <x-icon.addon ></x-icon.addon>
                                                    @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" tabindex="{{$index}}" class="focus:outline-none" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M9 4h6a2 2 0 0 1 2 2v14l-5-3l-5 3v-14a2 2 0 0 1 2 -2"></path>
                                                    </svg>
                                                </div>
                                                <input wire:model="search" type="text" name="email" id="email" class="block w-full pl-10 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 rounded-l-md sm:text-sm" placeholder="Microsoft 365 Essentials...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ml-2">
                                        <select wire:model="vendor" name="vendor" class="block w-full py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="">-- Select vendor --</option>
                                            @foreach($vendors as $option)
                                            <option value="{{ $option }}">{{ Str::ucfirst($option) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="ml-2">
                                        <select wire:model="category" name="category" class="block w-full py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="">-- Select category --</option>
                                            @foreach($categories as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <ul  class="grid max-w-lg gap-5 mx-auto mt-12 lg:grid-cols-4 lg:max-w-none">
                                    @forelse($prices as $price)
                                    <div class="flex flex-col overflow-hidden rounded-lg shadow-lg">
                                        <button  wire:click="showDetails({{ $price->related_product->id }})" class="focus:outline-none">
                                            <figure  class="px-4">
                                                <img src="https://cdn.worldvectorlogo.com/logos/microsoft.svg" alt="" class="h-64 ml-auto mr-auto" />
                                            </figure>
                                        </button>
                                        <div class="flex flex-col justify-between flex-1 p-6 -mt-20 ">
                                            <div class="flex flex-col p-4 bg-blue-500 rounded-lg opacity-90">
                                                <div>
                                                    <h5 class="font-bold leading-none text-white md:text-xl">
                                                        {{ $price->related_product->name }}
                                                    </h5>
                                                    <div class="inline-flex flex-1 pt-2 items-justify ">
                                                        <span class="leading-none text-justify text-gray-100 md:text-xs">{{ str_limit($price->related_product->description, 250) }}</span>
                                                    </div>
                                                </div>
                                                <div class="flex items-center flex-1 pt-6">
                                                    <div>
                                                        @if(Auth::user()->userLevel->name == "Reseller")
                                                        <div class="text-sm font-bold text-white">
                                                            Reseller
                                                            <p class="inline text-sm font-normal text-white">
                                                                {{ $price->price }}
                                                            </p>
                                                        </div>
                                                        @endif
                                                        <div class="text-sm font-bold text-white">
                                                            Price
                                                            <p class="inline text-sm font-normal text-white">
                                                                {{ $price->msrp }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <button  wire:click="addToCart({{ $price->related_product->id }})" class="flex inline p-2 ml-auto text-white transition duration-300 bg-gray-800 rounded-full hover:bg-gray-500 hover:text-purple-900 hover:shadow-xl focus:outline-none">
                                                        <svg class="w-4 h-4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                    </button>
                                                </div>
                                                {{-- @endforeach --}}
                                            </div>
                                        </div>
                                    </div>

                                    @empty
                                    No products found
                                    @endforelse
                                </ul>
                                <div class="flex justify-center mt-4">
                                    {!! $prices->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<div class="@if (!$showModal) hidden @endif flex items-center justify-center fixed left-0 bottom-0 w-full h-full bg-gray-800 bg-opacity-50">
    <div class="w-1/2 bg-white rounded-lg">
        <div class="flex flex-col items-start p-4">
            <div class="flex items-center w-full pb-4 border-b">
                <div class="text-lg font-medium text-gray-900">Product details
                </div>
                <svg wire:click="close"
                class="w-6 h-6 ml-auto text-gray-700 cursor-pointer fill-current"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                <path
                d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"/>
            </svg>
        </div>
        {{-- @if($details == null) --}}
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    {{$productName}}
                </h3>
                <p class="max-w-2xl mt-1 text-sm text-gray-500">
                    {{$productSku}}
                </p>
            </div>
            <div class="px-4 py-5 border-t border-gray-200 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Price
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{$productMSRP}}
                        </dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Description
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{$productDescription}}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>




