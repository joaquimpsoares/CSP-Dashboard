<div>
    @php
        $needsTenant = false;
        $cm = auth()->user()?->cart;
        if ($cm && $cm->products) {
            foreach ($cm->products as $p) {
                $v = strtolower($p->vendor ?? '');
                if ($v === 'microsoft' || $v === 'microsoft corporation') { $needsTenant = true; break; }
            }
        }
    @endphp

    <main class="p-6" x-data="{'layout': 'grid'}">

        {{-- Microsoft tenant notice --}}
        @if($needsTenant)
            <div class="mb-4 rounded-2xl border border-primary-200 bg-primary-50 px-4 py-3 text-sm text-primary-800">
                <span class="font-semibold">Microsoft products require tenant verification during checkout.</span>
                <span class="ml-1 text-primary-700">You'll be prompted to verify your tenant before completing the purchase.</span>
            </div>
        @endif

        {{-- Price list banner --}}
        @if($resolvedPriceListName)
            <div class="mb-4 flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800">
                <span>
                    <svg class="inline-block mr-1.5 h-4 w-4 text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14.25l6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.908-2.185a48.507 48.507 0 0111.186 0c1.1.128 1.907 1.077 1.907 2.185z" /></svg>
                    <span class="font-medium">Price list:</span> {{ $resolvedPriceListName }}
                </span>
                <button type="button" wire:click="openRequestModal"
                    class="inline-flex items-center gap-1.5 rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-primary-500/30">
                    <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    Request product
                </button>
            </div>
        @else
            <div class="mb-4 flex items-center justify-between rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                <span>
                    <svg class="inline-block mr-1.5 h-4 w-4 text-amber-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>
                    No active price list is assigned to your account. Contact your provider to get started.
                </span>
                <button type="button" wire:click="openRequestModal"
                    class="inline-flex items-center gap-1.5 rounded-lg border border-amber-300 bg-white px-3 py-1.5 text-xs font-semibold text-amber-700 shadow-sm hover:bg-amber-50 focus:outline-none focus:ring-2 focus:ring-amber-500/30">
                    <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    Request product
                </button>
            </div>
        @endif

        <div class="relative flex items-baseline justify-between pt-8 pb-6 border-b border-slate-200">

            <div class="text-sm font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                <div class="w-full max-w-lg ml-3 lg:max-w-xs">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative text-gray-400 focus-within:text-gray-500">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input wire:model.live="search" id="search" class="block w-full rounded-lg border border-slate-300 bg-white py-2 pl-10 pr-3 text-sm text-slate-900 placeholder-slate-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" placeholder="Search products" type="search" name="search">
                    </div>
                </div>
            </div>
            <div class="flex items-center col-span-5 sm:col-span-3">
                <x-input.group borderless paddingless for="perPage" label="Per Page">
                    <x-input.select class="block w-full bg-white py-1.5 pl-10 pr-3 border-gray-300 rounded-md focus:placeholder-gray-500 sm:text-sm" wire:model="perPage" id="perPage">
                        <option value="12">12</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </x-input.select>
                </x-input.group>

                <button type="button" class="p-2 ml-4 -m-2 text-gray-400 sm:ml-6 hover:text-gray-500 "  x-on:click="layout = 'grid'" x-bind:class="{'active': layout === 'grid'}" id="grid">
                    <span class="sr-only">View grid</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                </button>
                <button type="button" class="p-2 ml-4 -m-2 text-gray-400 sm:ml-6 hover:text-gray-500 " x-on:click="layout = 'list'" x-bind:class="{'active': layout === 'list'}" id="list">
                    <span class="sr-only">View list</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
                <button type="button" wire:click="$set('showmobilefilter', true)" class="p-2 ml-4 -m-2 text-gray-400 sm:ml-6 hover:text-gray-500 lg:hidden"  @click="open = true">
                    <span class="sr-only">Filters</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
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
                                @foreach ($category as $value => $label)
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
                    <div class="pt-6" id="filter-section-0" x-show="open" style="display: none;">
                        <label class="text-base font-medium text-gray-900">Plugins</label>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input id="filter-Plugins-0" wire:model="filters.plugins" name="color[]"  type="checkbox" class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                                <label for="filter-Plugins-0" class="ml-3 text-sm text-gray-600">
                                    Plugins
                                </label>
                            </div>
                        </div>
                        <label class="text-base font-medium text-gray-900">Trial</label>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input id="filter-Trial-0" wire:model="filters.trial" name="color[]"  type="checkbox" class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                                <label for="filter-Trial-0" class="ml-3 text-sm text-gray-600">
                                    Trial
                                </label>
                            </div>
                        </div>
                        <label class="mt-3 font-medium text-gray-900 mt-3text-base">Select Term</label>
                        @foreach ($terms as $index => $item)
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input id="{{$index}}" wire:model="filters.terms" name="color[]" value="{{$item}}" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                                <label for="{{$index}}" class="ml-3 text-sm text-gray-600">
                                    {{$item}}
                                </label>
                            </div>
                        </div>
                        @endforeach
                        <label class="mt-3 text-base font-medium text-gray-900">Select Billing Cycle</label>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input id="filter-Annual-0" wire:model="filters.billing" name="color[]" value="annual" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                                <label for="filter-Annual-0" class="ml-3 text-sm text-gray-600">
                                    {{ ucwords(trans_choice('messages.annual', 1)) }}
                                </label>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input id="filter-Monthly-0" wire:model="filters.billing" name="color[]" value="monthly" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                                <label for="filter-Monthly-0" class="ml-3 text-sm text-gray-600">
                                    {{ ucwords(trans_choice('messages.monthly', 1)) }}
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Product grid -->
                <div class="lg:col-span-3">
                    <!-- Grid layout -->
                    <div tabindex="0" class="focus:outline-none"  x-show="layout === 'grid'" x-cloak>
                        <div class="container py-2 mx-auto" >
                            <div class="flex flex-wrap items-center justify-center lg:justify-between">
                                @forelse($prices as $index => $item)
                                <div tabindex="{{$index}}" class="mt-8 overflow-hidden transition duration-500 ease-in-out transform rounded-lg shadow-lg cursor-pointer hover:-translate-y-5 hover:shadow-2xl h-90 w-90 md:w-80">
                                    <img alt="{{ $item->product?->name ?? $item->title }}" src="data:image/png;base64,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" tabindex="0" class="w-full focus:outline-none h-44" />
                                    <div class="bg-white">
                                        <div class="flex items-center justify-between px-4 pt-4">
                                            <div>
                                                @if($item->product?->is_addon)
                                                <x-icon.addon></x-icon.addon>
                                                @else
                                                <svg xmlns="http://www.w3.org/2000/svg" tabindex="{{$index}}" class="focus:outline-none" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M9 4h6a2 2 0 0 1 2 2v14l-5-3l-5 3v-14a2 2 0 0 1 2 -2"></path>
                                                </svg>
                                                @endif
                                            </div>
                                            <div class="bg-primary-600 py-1.5 px-6 rounded-lg">
                                                @if($item->category ?? $item->product?->category)
                                                <p tabindex="{{$index}}" class="text-xs text-white focus:outline-none">#{{ $item->category ?? $item->product?->category }}</p>
                                                @endif
                                                @if($item->product_type ?? $item->product?->productType)
                                                <p tabindex="{{$index}}" class="text-xs text-white focus:outline-none">#{{ $item->product_type ?? $item->product?->productType }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="p-4">
                                            <div class="flex items-center">
                                                <h2 tabindex="{{$index}}" class="text-lg font-semibold focus:outline-none">{{ $item->product?->name ?? $item->title }}</h2>
                                            </div>
                                            <p tabindex="{{$index}}" class="mt-2 text-xs text-gray-600 focus:outline-none">
                                                {{ \Illuminate\Support\Str::limit($item->product?->description, 90, '...') }}
                                                <span class="mt-2 text-xs text-gray-600 cursor-pointer focus:outline-none" wire:click="showDetails({{ $item->id }})">Read More...</span>
                                            </p>
                                            <div class="flex mt-4">
                                                @if($item->term_duration)
                                                <div>
                                                    <p tabindex="{{$index}}" class="px-2 py-1 text-xs text-gray-600 bg-gray-200 focus:outline-none">{{ $item->term_duration }}</p>
                                                </div>
                                                <div class="pl-2">
                                                    <p tabindex="{{$index}}" class="px-2 py-1 text-xs text-gray-600 bg-gray-200 focus:outline-none">{{ $item->billing_cycle }}</p>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="flex items-center justify-between py-4">
                                                @if(Auth::user()->userLevel->name == "Reseller")
                                                <div class="pl-3">
                                                    <p tabindex="{{$index}}" class="relative text-sm font-semibold ">
                                                        {{ ucwords(trans_choice('messages.price', 1)) }}
                                                    </p>
                                                    <p tabindex="{{$index}}" class="relative text-sm font-semibold ">
                                                        {{ $item->currency }} @money($item->msrp)
                                                    </p>
                                                </div>
                                                @endif
                                                <div class="pl-3">
                                                    <p tabindex="{{$index}}" class="relative text-sm font-semibold ">
                                                        {{ ucwords(trans_choice('messages.reseller', 1)) }}
                                                    </p>
                                                    <p tabindex="{{$index}}" class="relative text-sm font-semibold ">
                                                        {{ $item->currency }} @money($item->price)
                                                    </p>
                                                </div>
                                                <button tabindex="{{$index}}" wire:click="addToCart({{ $item->id }})" class="inline-flex items-center justify-center rounded-full bg-primary-600 p-2 text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                                                    <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="w-full py-16 flex flex-col items-center justify-center text-center text-gray-500">
                                    <svg class="h-10 w-10 mb-3 text-slate-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
                                    <p class="text-sm font-semibold text-slate-900">No products found</p>
                                    <p class="text-sm text-slate-500 mt-1">Try adjusting your filters, or request a product from your provider.</p>
                                    <button type="button" wire:click="openRequestModal" class="mt-4 inline-flex items-center gap-1.5 rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                                        Request a product
                                    </button>
                                </div>
                                @endforelse
                            </div>
                            <div class="flex justify-center mt-4">
                                {{ $prices->links() }}
                            </div>
                        </div>
                    </div>

                    <!-- List layout -->
                    <div class="" x-show="layout === 'list'" x-cloak>
                        <div class="mr-3 overflow-hidden bg-white shadow sm:rounded-md">
                            <ul role="list" class="mr-3 divide-y divide-gray-200">
                                @forelse($prices as $item)
                                <li>
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-semibold text-primary-700 truncate">
                                                {{ $item->product?->name ?? $item->title }}
                                            </p>
                                            <div class="flex flex-shrink-0 ml-2 text-white">
                                                @if($item->category ?? $item->product?->category)
                                                <span class="px-2 py-1 m-1 bg-primary-600 rounded-lg">
                                                    #{{ $item->category ?? $item->product?->category }}
                                                </span>
                                                @endif
                                                @if($item->product_type ?? $item->product?->productType)
                                                <span class="px-2 py-1 m-1 bg-primary-600 rounded-lg">
                                                    #{{ $item->product_type ?? $item->product?->productType }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <p class="top-0 mb-0 text-xs font-medium text-gray-800">
                                            {{ $item->sku ?? $item->product?->sku }}
                                        </p>
                                        <div class="mt-0 sm:flex sm:justify-between">
                                            <div class="sm:flex">
                                                <p class="flex items-center text-sm text-gray-500">
                                                    {{ \Illuminate\Support\Str::limit($item->product?->description, 150, '...') }}
                                                </p>
                                                <a wire:click="showDetails({{ $item->id }})" class="flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6 cursor-pointer">
                                                    Read More
                                                </a>
                                            </div>
                                            <div class="flex items-center mt-2 text-sm text-gray-500 sm:mt-0">
                                                @if(Auth::user()->userLevel->name == "Reseller")
                                                <div class="pl-3">
                                                    <div class="font-medium">
                                                        {{ ucwords(trans_choice('messages.reseller', 1)) }}
                                                    </div>
                                                    <div class="text-sm text-gray-600">
                                                        {{ $item->currency }} @money($item->msrp)
                                                    </div>
                                                </div>
                                                @endif
                                                <div class="pl-3">
                                                    <div class="font-medium">
                                                        {{ ucwords(trans_choice('messages.price', 1)) }}
                                                    </div>
                                                    <div class="text-sm text-gray-600">
                                                        {{ $item->currency }} @money($item->price)
                                                    </div>
                                                </div>
                                                <div class="pl-3">
                                                    <div class="text-sm text-gray-600">
                                                        <button wire:click="addToCart({{ $item->id }})" class="inline-flex items-center justify-center rounded-full bg-primary-600 p-2 text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                                                            <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @empty
                                <li class="px-4 py-16 text-center text-sm text-gray-500">No products found.</li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="flex justify-center mt-4">
                            {{ $prices->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile filter dialog -->
            @if ($showmobilefilter == true)
            <div x-data="{ open: true }" @keydown.window.escape="open = false">
                <div x-show="open" class="fixed inset-0 z-40 flex lg:hidden" x-ref="dialog" aria-modal="true" style="display: none;">
                    <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black bg-opacity-25" @click="open = false" aria-hidden="true" style="display: none;"></div>
                    <div x-show="open" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="relative flex flex-col w-full h-full max-w-xs py-4 pb-12 ml-auto overflow-y-auto bg-white shadow-xl" style="display: none;">
                        <div class="flex items-center justify-between px-4">
                            <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                            <button type="button" class="flex items-center justify-center w-10 h-10 p-2 -mr-2 text-gray-400 bg-white rounded-md" wire:click="$set('showmobilefilter', false)" @click="open = false">
                                <span class="sr-only">Close menu</span>
                                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <!-- Filters -->
                        <form class="p-4 mt-4 border-t border-gray-200">
                            <div x-data="{dropdownMenu: false}" class="block">
                                <x-input.select wire:model="filters.category" id="filter-status">
                                    <option value="">Select Category...</option>
                                    @foreach ($category as $value => $label)
                                    <option value="{{ $label }}">{{ $label }}</option>
                                    @endforeach
                                </x-input.select>
                            </div>
                            <h3 class="sr-only">{{ ucwords(trans_choice('messages.categories', 1)) }}</h3>
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
                            <div class="pt-6" id="filter-section-0" x-show="open" style="display: none;">
                                <label class="text-base font-medium text-gray-900">Plugins</label>
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <input id="filter-Plugins-0" wire:model="filters.plugins" name="color[]"  type="checkbox" class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                                        <label for="filter-Plugins-0" class="ml-3 text-sm text-gray-600">Plugins</label>
                                    </div>
                                </div>
                                <label class="text-base font-medium text-gray-900">Trial</label>
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <input id="filter-Trial-0" wire:model="filters.trial" name="color[]"  type="checkbox" class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                                        <label for="filter-Trial-0" class="ml-3 text-sm text-gray-600">Trial</label>
                                    </div>
                                </div>
                                <label class="mt-3 font-medium text-gray-900 mt-3text-base">Select Term</label>
                                @foreach ($terms as $index => $item)
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <input id="mobile-term-{{$index}}" wire:model="filters.terms" name="color[]" value="{{$item}}" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                                        <label for="mobile-term-{{$index}}" class="ml-3 text-sm text-gray-600">{{$item}}</label>
                                    </div>
                                </div>
                                @endforeach
                                <label class="mt-3 text-base font-medium text-gray-900">Select Billing Cycle</label>
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <input id="filter-Annual-0" wire:model="filters.billing" name="color[]" value="annual" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                                        <label for="filter-Annual-0" class="ml-3 text-sm text-gray-600">{{ ucwords(trans_choice('messages.annual', 1)) }}</label>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <input id="filter-Monthly-0" wire:model="filters.billing" name="color[]" value="monthly" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                                        <label for="filter-Monthly-0" class="ml-3 text-sm text-gray-600">{{ ucwords(trans_choice('messages.monthly', 1)) }}</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            {{-- Product detail panel --}}
            @if ($showproductdetails === true)
            <div x-data="{ open: true }" @keydown.window.escape="open = false" x-cloak>
                <div x-show="open" class="fixed inset-0 z-10 overflow-y-auto" x-ref="dialog" aria-modal="true">
                    <div class="flex min-h-screen text-center md:block md:px-2 lg:px-4" style="font-size: 0;">
                        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 hidden transition-opacity bg-gray-500 bg-opacity-75 md:block" @click="open = false" aria-hidden="true"></div>
                        <span class="hidden md:inline-block md:align-middle md:h-screen" aria-hidden="true">&#8203;</span>
                        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 md:translate-y-0 md:scale-95" x-transition:enter-end="opacity-100 translate-y-0 md:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 md:scale-100" x-transition:leave-end="opacity-0 translate-y-4 md:translate-y-0 md:scale-95" class="flex w-full text-base text-left transition transform md:inline-block md:max-w-2xl md:px-4 md:my-8 md:align-middle lg:max-w-4xl">
                            <div class="relative flex items-center w-full px-4 pb-8 overflow-hidden bg-white shadow-2xl pt-14 sm:px-6 sm:pt-8 md:p-6 lg:p-8">
                                <button type="button" wire:click="$set('showproductdetails', false)" @click="open = false" class="absolute text-gray-400 top-4 right-4 hover:text-gray-500 sm:top-8 sm:right-6 md:top-6 md:right-6 lg:top-8 lg:right-8">
                                    <span class="sr-only">Close</span>
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                                <div class="grid items-start w-full grid-cols-1 gap-y-8 gap-x-6 sm:grid-cols-12 lg:gap-x-8">
                                    <div class="sm:col-span-4 lg:col-span-5">
                                        <div class="overflow-hidden bg-gray-100 rounded-lg aspect-w-1 aspect-h-1">
                                            <img src="data:image/png;base64,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" alt="Product image" class="object-cover object-center">
                                        </div>
                                    </div>
                                    <div class="sm:col-span-8 lg:col-span-7">
                                        <h2 class="text-2xl font-extrabold text-gray-900 sm:pr-12">{{ $productName }}</h2>
                                        <h2 class="text-xs font-extrabold text-gray-900 sm:pr-12">{{ $productSku }}</h2>
                                        <section aria-labelledby="information-heading" class="mt-3">
                                            <h3 id="information-heading" class="sr-only">Product information</h3>
                                            <p class="text-2xl text-gray-900">MSRP {{ $msrp }}</p>
                                            @if(Auth::user()->userLevel->name == "Reseller")
                                            <p class="text-2xl text-gray-900">{{ ucwords(trans_choice('messages.reseller', 1)) }} {{ $retail }}</p>
                                            @endif
                                            <div class="mt-6">
                                                <h4 class="sr-only">Description</h4>
                                                <p class="text-sm text-gray-700">{{ $productDescription }}</p>
                                            </div>
                                        </section>
                                        <section aria-labelledby="options-heading" class="mt-6">
                                            <h3 id="options-heading" class="sr-only">Product options</h3>
                                            @if($price)
                                            <div class="mt-6">
                                                <button wire:click="addToCart({{ $price->id }})" class="flex items-center justify-center w-full rounded-lg bg-primary-600 px-8 py-3 text-base font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">Add to cart</button>
                                            </div>
                                            @endif
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </section>
    </main>

    {{-- ── Request product modal ────────────────────────────────────────────── --}}
    @if($showRequestModal)
    <div x-data="{ open: @entangle('showRequestModal').live }" x-cloak>
        <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
            {{-- Backdrop --}}
            <div x-show="open"
                 x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
                 wire:click="closeRequestModal" @click="$wire.closeRequestModal()">
            </div>

            <div class="relative min-h-screen flex items-center justify-center p-4">
                <div x-show="open"
                     x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                     class="relative w-full max-w-lg rounded-2xl bg-white shadow-xl">

                    {{-- Header --}}
                    <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                        <h3 class="text-base font-semibold text-slate-900">Request a product</h3>
                        <button type="button" wire:click="closeRequestModal" @click="$wire.closeRequestModal()" class="rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    {{-- Body --}}
                    <div class="px-6 py-5 space-y-4">
                        <p class="text-sm text-slate-600">Can't find what you need? Let your provider know and they'll add it to your price list.</p>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Product name <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="requestProductName" placeholder="e.g. Microsoft 365 Business Premium"
                                   class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                            @error('requestProductName') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">SKU / Product ID <span class="text-slate-400 font-normal">(optional)</span></label>
                            <input type="text" wire:model="requestProductSku" placeholder="e.g. CFQ7TTC0LH18:0001"
                                   class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                        </div>

                        @if(!empty($requestResellerOptions) && count($requestResellerOptions) > 1)
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Send request to reseller</label>
                            <select wire:model="requestResellerId"
                                    class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                @foreach($requestResellerOptions as $opt)
                                    <option value="{{ $opt['id'] }}">{{ $opt['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Notes <span class="text-slate-400 font-normal">(optional)</span></label>
                            <textarea wire:model="requestNotes" rows="3" placeholder="Any additional context…"
                                      class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Urgency</label>
                            <select wire:model="requestUrgency"
                                    class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                <option value="low">Low — nice to have</option>
                                <option value="normal" selected>Normal</option>
                                <option value="high">High — blocking a deal</option>
                            </select>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="flex items-center justify-end gap-3 border-t border-slate-200 px-6 py-4">
                        <button type="button" wire:click="closeRequestModal" @click="$wire.closeRequestModal()"
                                class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">
                            Cancel
                        </button>
                        <button type="button" wire:click="submitProductRequest"
                                class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                            Submit request
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
