<div>
    <div class="p-4 overflow-hidden bg-white">
        <div class="flex flex-col">
            <div class="flex flex-col items-center justify-between lg:flex-row">
                <div class="flex items-center">
                    <h4>{{ ucwords(trans_choice('messages.price_list', 1)) }}</h4>
                </div>
            </div>
            <div class="px-0 pt-0 mt-5 break-words border-b">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-3">
                    <div class="flex items-center">
                        <h4>{{ ucwords(trans_choice('messages.price_list_details', 1)) }}</h4>
                    </div>
                    <div>
                        <button type="button" wire:click="editList({{ $priceList->id }})" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                            <x-icon.edit />
                            Edit price list
                        </button>
                    </div>
                </div>
            </div>
            <div class="grid grid-flow-col grid-cols-2 gap-4">
                <div>
                    <div class="flex justify-between mt-4 mb-4">
                        <div class="">
                            <dl>
                                <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.name', 1)) }}</dt>
                                    <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{$priceList->name}}</dd>
                                </div>
                                <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.description', 1)) }}</dt>
                                    <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ ($priceList->description)}}</dd>
                                </div>
                                <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.margin', 1)) }}</dt>
                                    <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $priceList->margin}} %</dd>
                                </div>
                                <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.created_at', 1)) }}</dt>
                                    <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ date('j F, Y', strtotime($priceList->created_at))}}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End - Customer Details -->

            <!-- Start - Customer Relationshipt -->
            <div class="px-0 pt-0 mt-5 break-words border-b">
                <div class="flex flex-col lg:flex-row">
                    <div class="flex items-center">
                        <h4>{{ ucwords(trans_choice('messages.price', 2)) }}</h4>
                    </div>
                </div>
            </div>
            <div class="p-0 m-0 mt-4 break-words">
                <div class="px-0 pt-0 pb-5 m-0">
                    <div class="p-0 m-0 overflow-visible bg-white rounded" style="overflow: visible; outline: 0px; overflow-wrap: break-word;">
                        <div class="flex flex-col items-center justify-between lg:flex-row">
                            <div class="flex items-center">
                                <h4>{{ ucwords(trans_choice('messages.table', 1)) }}</h4>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <x-input.group borderless paddingless for="perPage" label="Per Page">
                                        <x-input.select class="block w-full bg-white py-1.5 pl-10 pr-3 border border-gray-300 rounded-md leading-5 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500 focus:placeholder-gray-500 sm:text-sm" wire:model="perPage" id="perPage">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                        </x-input.select>
                                    </x-input.group>
                                </div>
                                <div>
                                    <div class="flex justify-center flex-1 lg:justify-end">
                                        <!-- Search section -->
                                        <div class="w-full max-w-lg ml-3 lg:max-w-xs">
                                            <label for="search" class="sr-only">Search</label>
                                            <div class="relative text-gray-400 focus-within:text-gray-500">
                                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                    <!-- Heroicon name: solid/search -->
                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <input wire:model="search" id="search" class="block w-full bg-white py-1.5 pl-10 pr-3 border border-gray-300 rounded-md leading-5 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500 focus:placeholder-gray-500 sm:text-sm" placeholder="Search" type="search" name="search">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-3 lg:max-w-xs">
                                    <x-dropdown label="Bulk Actions">
                                        @livewire('pricelist.import-transactions', ['priceList' => $priceList], key($priceList->id))
                                        <x-dropdown.item type="button" wire:click="exportSelected" class="flex items-center space-x-2">
                                            <x-icon.download class="text-gray-400"/> <span>{{ ucwords(trans_choice('messages.export', 1)) }}</span>
                                        </x-dropdown.item>
                                        <x-dropdown.item type="button" wire:click="$toggle('showDeleteModal')" class="flex items-center space-x-2">
                                            <x-icon.trash class="text-gray-400"/> <span>{{ ucwords(trans_choice('messages.delete', 1)) }}</span>
                                        </x-dropdown.item>
                                    </x-dropdown>
                                </div>
                                <div class="ml-3 lg:max-w-xs">
                                </div>
                                <div class="ml-3 lg:max-w-xs">
                                    <x-button.primary wire:click="create"><x-icon.plus/> {{ ucwords(trans_choice('messages.add', 1)) }}</x-button.primary>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="sm:hidden" x-description="Dropdown menu on small screens">
                                <label for="current-tab" class="sr-only">Select a tab</label>
                                <select wire:model="filters" id="current-tab" name="current-tab" class="block w-full py-2 pl-3 pr-10 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option wire:click="legacy">{{ ucwords(trans_choice('messages.legacy', 1)) }}</option>
                                    <option wire:click="perpetual">{{ ucwords(trans_choice('messages.perpetual_software', 1)) }}</option>
                                    <option wire:click="nce" >{{ ucwords(trans_choice('messages.nce', 1)) }}</option>
                                </select>
                            </div>
                            <div class="hidden sm:block" x-description="Tabs at small breakpoint and up" >
                                <nav class="flex -mb-px space-x-8" x-data="{tab: 1}">
                                    <a wire:click="resetFilters" class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === 1}" href="#" @click.prevent="tab = 1">
                                        {{ ucwords(trans_choice('messages.all', 1)) }}
                                    </a>
                                    <a href="#" wire:click="legacy" class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === 2}" href="#" @click.prevent="tab = 2" @click.prevent="tab = 2">
                                        {{ ucwords(trans_choice('messages.legacy', 1)) }}
                                    </a>
                                    <a href="#" wire:click="perpetual" class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === 3}" href="#" @click.prevent="tab = 3" @click.prevent="tab = 3">
                                        {{ ucwords(trans_choice('messages.perpetual_software', 1)) }}
                                    </a>
                                    <a href="#" wire:click="nce" class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === 5}" href="#" @click.prevent="tab = 5" @click.prevent="tab = 5">
                                        {{ ucwords(trans_choice('messages.nce', 1)) }}
                                    </a>
                                </nav>
                            </div>
                        </div>
                        <x-tableazure>
                            <x-slot name="head">
                                <x-table.heading class="w-8 pr-0">
                                    <x-input.checkbox wire:model="selectPage" />
                                </x-table.heading>
                                <x-table.heading sortable multi-column wire:click="sortBy('name')"     :direction="$sorts['name'] ?? null">{{ ucwords(trans_choice('messages.name', 1)) }}</x-table.heading>
                                <x-table.heading sortable multi-column wire:click="sortBy('product_sku')"    :direction="$sorts['product_sku'] ?? null">{{ ucwords(trans_choice('messages.sku', 1)) }}</x-table.heading>
                                <x-table.heading sortable multi-column wire:click="sortBy('currency')"    :direction="$sorts['currency'] ?? null">{{ ucwords(trans_choice('messages.currency', 1)) }}</x-table.heading>
                                <x-table.heading sortable multi-column wire:click="sortBy('price')"    :direction="$sorts['price'] ?? null">{{ ucwords(trans_choice('messages.price', 1)) }}</x-table.heading>
                                <x-table.heading sortable multi-column wire:click="sortBy('msrp')"    :direction="$sorts['msrp'] ?? null">{{ ucwords(trans_choice('messages.msrp', 1)) }}</x-table.heading>
                                <x-table.heading multi-column wire:click="sortBy('product->category')" :direction="$sorts['product']['category'] ?? null " >{{ ucwords(trans_choice('messages.available_for_purchase', 1)) }}</x-table.heading>
                            </x-slot>
                            <x-slot name="body">
                                @if ($selectPage)
                                <x-table.row class="bg-cool-gray-200" wire:key="row-message">
                                    <x-table.cell colspan="6">
                                        @unless ($selectAll)
                                        <div>
                                            <span>You have selected <strong>{{ $prices->count() }}</strong> transactions, do you want to select all <strong>{{ $prices->total() }}</strong>?</span>
                                            <x-button.link wire:click="selectAll" class="ml-1 text-blue-600">Select All</x-button.link>
                                        </div>
                                        @else
                                        <span>You are currently selecting all <strong>{{ $prices->total() }}</strong> transactions.</span>
                                        @endif
                                    </x-table.cell>
                                </x-table.row>
                                @endif
                                @forelse ($prices as $price)
                                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $price['id'] }}">
                                    <x-table.cell class="pr-0">
                                        <x-input.checkbox wire:model="selected" value="{{ $price['id'] }}" ></x-input.checkbox>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <a wire:click="edit({{ $price->id }})" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                            <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                <span wire:model="editing.name" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                    {{ $price['name'] }}
                                                </span>
                                            </div>
                                        </a>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <a wire:click="edit({{ $price->id }})" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                            <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                <span wire:model="editing.product_sku" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                    {{ $price->product_sku }}
                                                </span>
                                            </div>
                                        </a>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <a wire:click="edit({{ $price->id }})" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                            <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                <span wire:model="editing.currency" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                    {{ $price->currency }}
                                                </span>
                                            </div>
                                        </a>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <a wire:click="edit({{ $price->id }})" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                            <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                    {{ $price['price'] }} {{$price['currency']}}
                                                </div>
                                            </span>
                                        </a>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <a wire:click="edit({{ $price->id }})" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                            <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                    {{ $price['msrp'] }} {{$price['currency']}}
                                                </div>
                                            </span>
                                        </a>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <a wire:click="edit({{ $price->id }})" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                            <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                    @if($price->product->is_available_for_purchase == true)
                                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-400" x-description="Heroicon name: solid/check-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 mr-1.5 h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                      </svg>
                                                    @endif
                                                </div>
                                            </span>
                                        </a>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <x-button.link wire:click="edit({{ $price->id }})">Edit</x-button.link>
                                    </x-table.cell>
                                </x-table.row>
                                @empty
                                <x-table.row>
                                    <x-table.cell colspan="9">
                                        <div class="flex items-center justify-center space-x-2">
                                            <x-icon.inbox class="w-8 h-8 text-cool-gray-400" />
                                            <span class="py-8 text-xl font-medium text-cool-gray-400">No Prices found...</span>
                                        </div>
                                    </x-table.cell>
                                </x-table.row>
                                @endforelse
                            </x-slot>
                        </x-tableazure>
                        {{ $prices->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <!-- Delete Transactions Modal -->
        <form wire:submit.prevent="deleteSelected">
            <x-modal.confirmation wire:model.defer="showDeleteModal">
                <x-slot name="title">Delete Price</x-slot>
                <x-slot name="content">
                    <div class="py-8 text-cool-gray-700">Are you sure you? This action is irreversible.</div>
                </x-slot>
                <x-slot name="footer">
                    <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" @click="open = false">
                        {{ ucwords(trans_choice('messages.delete', 1)) }}
                    </button>
                    <a type="button" wire:click="$set('showDeleteModal', false)" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" @click="open = false">
                        {{ ucwords(trans_choice('messages.cancel', 1)) }}
                    </a>
                </x-slot>
            </x-modal.confirmation>
        </form>
        <form @if($showCreate === false) { wire:submit.prevent="save({{$priceList->id}})" } @else { wire:submit.prevent="savecreate" } @endif>
            <x-modal.slideout wire:model.defer="showEditModal">
                @if ($showCreate == false)
                <x-slot name="title">{{ ucwords(trans_choice('messages.edit_price', 1)) }}</x-slot>
                @elseif($showCreate == true)
                <x-slot name="title">{{ ucwords(trans_choice('messages.add', 1)) }}</x-slot>
                @endif
                <x-slot name="content">
                    <section class="dark-grey-text">
                        <div class="row">
                            <div class="col-md-12">
                                @if($showCreate === false)
                                <div class="row">
                                    <div class="mb-4 col-md-12">
                                        <x-label for="name" class="">{{ ucwords(trans_choice('messages.name', 1)) }}</x-label>
                                        <x-input  wire:model="editing.name" type="text" id="name" name="name" class="@error('editing.name') is-invalid @enderror"></x-input>
                                        @error('editing.name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                @else
                                <div class="row">
                                    <div class="mb-4 col-md-12">
                                        <div class="max-w-xl mx-auto overflow-hidden transition-all transform bg-white divide-y divide-gray-100 shadow-2xl rounded-xl ring-1 ring-black ring-opacity-5">
                                            <div class="relative">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="pointer-events-none absolute top-3.5 left-4 h-5 w-5 text-gray-400" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd">
                                                    </path>
                                                </svg>
                                            </div>
                                            <input wire:model.debounce.300ms="keyword" class="w-full h-12 pr-4 text-gray-800 placeholder-gray-400 bg-transparent border-0 pl-11 focus:ring-0 sm:text-sm" placeholder="Search..." id="headlessui-combobox-input-6" role="combobox" type="text" aria-expanded="true" value="se" aria-controls="headlessui-combobox-options-7"
                                            @if(isset($selectedProduct))
                                            value="{{$selectedProduct}}"
                                            @endif>
                                            @if(isset($searchproduct))
                                            <ul class="py-2 overflow-y-auto text-sm text-gray-800 max-h-72 scroll-py-2" role="listbox">
                                                @foreach ($searchproduct as $index => $item)
                                                <li wire:click="selectedProduct({{ $item->id }})"
                                                    class="px-4 py-2 cursor-default select-none hover:bg-gray-200" role="option" tabindex="-1">
                                                    {{$item->id}} - {{$item->name}}
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="row">
                                    <div class="mb-2 col-md-6">
                                        <x-label for="market">{{ ucwords(trans_choice('messages.market', 1)) }}</x-label>
                                        <x-input wire:model="editing.market" type="text" id="market" name="market" placeholder="ES" class="@error('editing.market') is-invalid @enderror"> </x-input>
                                        @error('editing.market')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="mb-2 col-md-6">
                                        <x-label for="currency">{{ ucwords(trans_choice('messages.currency', 1)) }}</x-label>
                                        <x-input wire:model="editing.currency" type="text" id="currency" name="currency" placeholder="USD" class="@error('editing.currency') is-invalid @enderror"></x-input>
                                        @error('editing.currency')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-2 col-md-6">
                                        <x-label for="term_duration">{{ ucwords(trans_choice('messages.product_term', 1)) }}</x-label>
                                        <x-input wire:model="editing.term_duration" type="text" id="term_duration" name="term_duration" placeholder="P1Y" class="@error('editing.term_duration') is-invalid @enderror"></x-input>
                                        @error('editing.term_duration')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="mb-2 col-md-6">
                                        <x-label for="billing_plan">{{ ucwords(trans_choice('messages.billing_cycle', 1)) }}</x-label>
                                        <x-input wire:model="editing.billing_plan" type="text" id="billing_plan" name="billing_plan" placeholder="Monthly"  class="@error('editing.billing_plan') is-invalid @enderror"></x-input>
                                        @error('editing.billing_plan')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-2 col-md-6">
                                        <x-label for="price">{{ ucwords(trans_choice('messages.price', 1)) }}</x-label>
                                        <x-input wire:model="editing.price" type="text" id="price" name="price" placeholder="" class="@error('editing.price') is-invalid @enderror"></x-input>
                                        @error('editing.price')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="mb-2 col-md-6">
                                        <x-label for="msrp">{{ ucwords(trans_choice('messages.msrp', 1)) }}</x-label>
                                        <x-input wire:model="editing.msrp" type="text" id="msrp" name="msrp" placeholder="" class="@error('editing.msrp') is-invalid @enderror"></x-input>
                                        @error('editing.msrp')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="mb-2 shadow-none col-md-6">
                                        <x-label for="availability">{{ ucwords(trans_choice('messages.available_for_purchase', 1)) }}</x-label>
                                        <input wire:model="isAvailable" type="checkbox" id="availability" name="isAvailable" class="block transition duration-150 ease-in-out border-indigo-300 form-checkbox sm:text-sm sm:leading-5"/>
                                        @error('editing.availability')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </x-slot>
                <x-slot name="footer">
                    <button wire:click="$set('showEditModal', false)" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ucwords(trans_choice('cancel', 1))}}
                        <button type="submit" class="inline-flex justify-center px-4 py-2 ml-4 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ucwords(trans_choice('save', 1))}}
                        </button>
                    </x-slot>
                </x-modal.slideout>
            </form>
        </div>

    @include('livewire.pricelist.partials.edit-pricelist-modal')

    <script>
        function copyToClipboard(subscription_id) {
            document.getElementById(subscription_id).select();
            document.execCommand('copy');
        }
    </script>
    </div>
</div>
