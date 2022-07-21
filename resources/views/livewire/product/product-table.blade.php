<div>
    <div class="relative z-0 flex-col flex-1 overflow-y-auto">
        <div class="p-4 overflow-hidden bg-white">
            <div class="flex flex-col">
                <div class="flex flex-col items-center justify-between lg:flex-row">
                    <div class="flex items-center">
                        <h4>{{ ucwords(trans_choice('messages.product', 1)) }}</h4>
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
                                        <input wire:model="filters.search" id="search" class="block w-full bg-white py-1.5 pl-10 pr-3 border border-gray-300 rounded-md leading-5 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500 focus:placeholder-gray-500 sm:text-sm" placeholder="Search" type="search" name="search">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ml-3 lg:max-w-xs">
                            <x-dropdown label="Bulk Actions">
                                <x-dropdown.item type="button" wire:click="import" class="flex items-center space-x-2">
                                    <x-icon.upload class="text-gray-400"/> <span>{{ ucwords(trans_choice('messages.import', 1)) }}</span>
                                </x-dropdown.item>
                                <x-dropdown.item type="button" wire:click="exportSelected" class="flex items-center space-x-2">
                                    <x-icon.download class="text-gray-400"/> <span>{{ ucwords(trans_choice('messages.export', 1)) }}</span>
                                </x-dropdown.item>

                                <x-dropdown.item type="button" wire:click="$toggle('showDeleteModal')" class="flex items-center space-x-2">
                                    <x-icon.trash class="text-gray-400"/> <span>{{ ucwords(trans_choice('messages.delete', 1)) }}</span>
                                </x-dropdown.item>
                            </x-dropdown>
                        </div>
                        <div class="ml-3 lg:max-w-xs">
                            <x-button.primary wire:click="create"><x-icon.plus/> New</x-button.primary>
                        </div>
                    </div>
                </div>
                <div class="flex-col mt-5 space-y-4">
                    <x-tableazure>
                        <x-slot name="head">
                            <x-table.heading class="w-8 pr-0">
                                <x-input.checkbox wire:model="selectPage" />
                            </x-table.heading>
                            <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('id')" :direction="$sorts['id'] ?? null">{{ ucwords(trans_choice('messages.id', 2)) }}</x-table.heading>
                            <x-table.heading sortable multi-column wire:click="sortBy('name')" :direction="$sorts['name'] ?? null">{{ ucwords(trans_choice('messages.name', 1)) }}</x-table.heading>
                            <x-table.heading sortable multi-column wire:click="sortBy('sku')"  :direction="$sorts['sku'] ?? null">{{ ucwords(trans_choice('messages.sku', 1)) }}</x-table.heading>
                            <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('productType')" :direction="$sorts['productType'] ?? null">{{ ucwords(trans_choice('messages.productType', 1)) }}</x-table.heading>
                            <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('category')"  :direction="$sorts['category'] ?? null">{{ ucwords(trans_choice('messages.category', 2)) }}</x-table.heading>
                            <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('vendor')"  :direction="$sorts['vendor'] ?? null">{{ ucwords(trans_choice('messages.vendor', 2)) }}</x-table.heading>
                            <x-table.heading sortable multi-column wire:click="sortBy('is_available_for_purchase')"    :direction="$sorts['is_available_for_purchase'] ?? null">{{ ucwords(trans_choice('messages.available_for_purchase', 1)) }}</x-table.heading>
                            <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('created_at')"  :direction="$sorts['created_at'] ?? null">{{ ucwords(trans_choice('messages.created_at', 2)) }}</x-table.heading>
                        </x-slot>
                        <x-slot name="body">
                            @if ($selectPage)
                            <x-table.row class="bg-cool-gray-200" wire:key="row-message">
                                <x-table.cell colspan="10">
                                    @unless ($selectAll)
                                    <div>
                                        <span>You have selected <strong>{{ $products->count() }}</strong> transactions, do you want to select all <strong>{{ $products->total() }}</strong>?</span>
                                        <x-button.link wire:click="selectAll" class="ml-1 text-blue-600">Select All</x-button.link>
                                    </div>
                                    @else
                                    <span>You are currently selecting all <strong>{{ $products->total() }}</strong> transactions.</span>
                                    @endif
                                </x-table.cell>
                            </x-table.row>
                            @endif
                            @forelse ($products as $product)
                            <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $product['id'] }}">
                                <x-table.cell class="pr-0">
                                    <x-input.checkbox wire:model="selected" value="{{ $product['id'] }}" ></x-input.checkbox>
                                </x-table.cell>
                                <x-table.cell visibility='hidden' tablecell='lg:table-cell'>
                                    <a wire:click="edit({{ $product->id }})" href="#" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                {{ $product['id'] }}
                                            </span>
                                        </div>
                                    </a>
                                </x-table.cell>
                                <x-table.cell>
                                    <a wire:click="edit({{ $product->id }})" href="#" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                {{ $product->name ?? ''}}
                                            </span>
                                        </div>
                                    </a>
                                </x-table.cell>
                                <x-table.cell>
                                    <a wire:click="edit({{ $product->id }})" href="#" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                {{ $product['sku'] }}
                                            </span>
                                        </a>
                                    </span>
                                </x-table.cell>
                                <x-table.cell  visibility='hidden' tablecell='lg:table-cell'>
                                    <a wire:click="edit({{ $product->id }})" href="#" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                {{ $product['productType'] }}
                                            </span>
                                        </a>
                                    </span>
                                </x-table.cell>
                                <x-table.cell  visibility='hidden' tablecell='lg:table-cell'>
                                    <a wire:click="edit({{ $product->id }})" href="#" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                {{ $product['category'] }}
                                            </span>
                                        </a>
                                    </span>
                                </x-table.cell>
                                <x-table.cell  visibility='hidden' tablecell='lg:table-cell'>
                                    <a wire:click="edit({{ $product->id }})" href="#" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                {{ $product['vendor'] }}
                                            </span>
                                        </a>
                                    </span>
                                </x-table.cell>
                                <x-table.cell>
                                    <a wire:click="edit({{ $product->id }})" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                @if($product->is_available_for_purchase == true)
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
                                <x-table.cell  visibility='hidden' tablecell='lg:table-cell'>
                                    <a wire:click="edit({{ $product->id }})" href="#" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                {{ $product['created_at'] }}
                                            </span>
                                        </a>
                                    </span>
                                </x-table.cell>
                                <x-table.cell>
                                    <div class="z-10">
                                        <button type="button" class="px-1 py-1 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a wire:click="edit({{ $product->id }})" class="dropdown-item" href="#">
                                                <x-icon.edit></x-icon.edit>
                                                {{ ucwords(trans_choice('messages.edit', 1)) }}
                                            </a>
                                        </div>
                                    </div>
                                </x-table.cell>
                            </x-table.row>
                            @empty
                            <x-table.row>
                                <x-table.cell colspan="9">
                                    <div class="flex items-center justify-center space-x-2">
                                        <x-icon.inbox class="w-8 h-8 text-cool-gray-400" />
                                        <span class="py-8 text-xl font-medium text-cool-gray-400">No Product found...</span>
                                    </div>
                                </x-table.cell>
                            </x-table.row>
                            @endforelse
                        </x-slot>
                    </x-tableazure>
                    <div>
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Transactions Modal -->
    <form wire:submit.prevent="deleteSelected">
        <x-modal.confirmation wire:model.defer="showDeleteModal">
            <x-slot name="title">Delete Transaction</x-slot>
            <x-slot name="content">
                <div class="py-8 text-cool-gray-700">Are you sure you? This action is irreversible.</div>
            </x-slot>
            <x-slot name="footer">
                <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" @click="open = false">
                    Delete
                </button>
                <a type="button" wire:click="$set('showDeleteModal', false)" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" @click="open = false">
                    Cancel
                </a>
            </x-slot>
        </x-modal.confirmation>
    </form>
    <!-- Save Transaction Modal -->
    <form wire:submit.prevent="importproducts">
        <x-modal.dialog wire:model.defer="showImportModal">
            <x-slot name="title">{{ ucwords(trans_choice('messages.import_products', 1)) }}</x-slot>
            <x-slot name="content">
                <x-input.group for="status" label="Select Type of import" >
                    <fieldset class="border-t border-b border-gray-200">
                        <legend class="sr-only">import types</legend>
                        <div class="divide-y divide-gray-200">
                            <div class="relative flex items-start py-4">
                                <div class="flex-1 min-w-0 text-sm">
                                    <label for="comments" class="font-medium text-gray-700">{{ ucwords(trans_choice('messages.license', 2)) }}</label>
                                    <p id="comments-description" class="text-gray-500">{{ ucwords(trans_choice('messages.microsoft_licenses', 1)) }}</p>
                                </div>
                                <div class="flex items-center h-5 ml-3">
                                    <input wire:model="license" id="comments" aria-describedby="comments-description" name="comments" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                </div>
                            </div>
                            <div>
                                <div class="relative flex items-start py-4">
                                    <div class="flex-1 min-w-0 text-sm">
                                        <label for="candidates" class="font-medium text-gray-700">{{ ucwords(trans_choice('messages.perpetual_software', 1)) }}</label>
                                        <p id="candidates-description" class="text-gray-500">{{ ucwords(trans_choice('messages.microsoft_perpetual_licenses', 1)) }}</p>
                                    </div>
                                    <div class="flex items-center h-5 ml-3">
                                        <input wire:model="perpetual" id="candidates" aria-describedby="candidates-description" name="candidates" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </x-input.group>
            </x-slot>
            <x-slot name="footer">
                <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" @click="open = false">
                    {{ ucwords(trans_choice('messages.import', 1)) }}
                </button>
                <a type="button" wire:click="$set('showImportModal', false)" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" @click="open = false">
                    {{ ucwords(trans_choice('messages.cancel', 1)) }}
                </a>
            </x-slot>
        </x-modal.dialog>
    </form>
    <div>
        <!-- Save Transaction Modal -->
        @if($showEditModal == true)
        <form wire:submit.prevent="save({{$product->id}})">
            <x-modal.slideout wire:model.defer="showEditModal">
                <x-slot name="title">Edit Product</x-slot>
                <x-slot name="content">
                    <section class="dark-grey-text">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <x-label for="name" class="">{{ ucwords(trans_choice('messages.name', 1)) }}</x-label>
                                        <x-input  wire:model="editing.name" type="text" id="name" name="name" class="@error('editing.name') is-invalid @enderror"></x-input>
                                        @error('editing.name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="mb-2 col-md-6">
                                        <x-label for="vendor">{{ ucwords(trans_choice('messages.vendor', 1)) }}</x-label>
                                        <x-input wire:model="editing.vendor" type="text" id="vendor" name="vendor" class="@error('editing.vendor') is-invalid @enderror"></x-input>
                                        @error('editing.vendor')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-2 col-md-12">
                                        <x-label for="country">{{ucwords(trans_choice('messages.description', 1))}}</x-label>
                                        <div class="mb-3 input-group">
                                            <textarea wire:model="editing.description" id="description" placeholder="description" rows="2"
                                            class="flex-1 block w-full min-w-0 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                            @error('editing.description')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-lg-4 col-md-6">
                                        <x-label for="sku" class="">{{ucwords(trans_choice('messages.sku', 1))}}</x-label>
                                        <x-input wire:model="editing.sku" type="text" id="sku" name="sku" class=" mb-4 @error('editing.sku') is-invalid @enderror"></x-input>
                                        @error('editing.sku')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="mb-3 col-lg-4 col-md-6">
                                        <x-label for="catalog_item_id">{{ucwords(trans_choice('messages.product_catalog_item_id', 1))}}</x-label>
                                        <x-input wire:model="editing.catalog_item_id" name="catalog_item_id" type="text" class="@error('editing.catalog_item_id') is-invalid @enderror" id="catalog_item_id" placeholder=""></x-input>
                                        @error('editing.catalog_item_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="mb-3 col-lg-4 col-md-6">
                                        <x-label for="productType">{{ucwords(trans_choice('messages.productType', 1))}}</x-label>
                                        <x-input wire:model="editing.productType" name="productType" type="text" class="@error('editing.productType') is-invalid @enderror" id="productType" placeholder=""></x-input>
                                        @error('editing.postal_code')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-lg-4 col-md-6">
                                        <x-label for="minimum_quantity" class="">{{ucwords(trans_choice('messages.product_mininum', 1))}}</x-label>
                                        <x-input wire:model="editing.minimum_quantity" type="text" id="minimum_quantity" name="minimum_quantity" class=" mb-4 @error('editing.minimum_quantity') is-invalid @enderror"></x-input>
                                        @error('editing.minimum_quantity')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="mb-3 col-lg-4 col-md-6">
                                        <x-label for="maximum_quantity">{{ucwords(trans_choice('messages.product_maximum', 1))}}</x-label>
                                        <x-input wire:model="editing.maximum_quantity" name="maximum_quantity" type="text" class="@error('editing.maximum_quantity') is-invalid @enderror" id="maximum_quantity" placeholder=""></x-input>
                                        @error('editing.maximum_quantity')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="mb-3 col-lg-4 col-md-6">
                                        <x-label for="limit">{{ucwords(trans_choice('messages.limit', 1))}}</x-label>
                                        <x-input wire:model="editing.limit" name="limit" type="text" class="@error('editing.limit') is-invalid @enderror" id="limit" placeholder=""></x-input>
                                        @error('editing.limit')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <x-label for="supported_billing_cycles" class="">{{ucwords(trans_choice('messages.product_billing_cycle', 1))}}</x-label>
                                    <x-input wire:model="editing.supported_billing_cycles" type="text" id="supported_billing_cycles" name="supported_billing_cycles" class="@error('editing.supported_billing_cycles') is-invalid @enderror" placeholder="1234 Main St"></x-input>
                                    @error('editing.supported_billing_cycles')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="row">
                                    @if($editing['terms'])
                                    @foreach ($editing['terms'] as $item)
                                    <div class="mb-3 col-lg-4 col-md-6">

                                        <x-label for="terms" class="">{{ucwords(trans_choice('messages.product_term', 1))}}</x-label>
                                        <x-input  type="text" id="terms" name="terms" class="@error('editing.terms') is-invalid @enderror" value="{{$item['duration']}}"></x-input>
                                    </div>
                                    @error('editing.terms')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    <div class="mb-3 col-lg-4 col-md-6">

                                        <x-label for="terms" class="">{{ucwords(trans_choice('messages.name', 1))}}</x-label>
                                        <x-input  type="text" id="terms" name="terms" class="@error('editing.terms') is-invalid @enderror" value="{{$item['description']}}"></x-input>
                                    </div>
                                    @error('editing.terms')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    <div class="mb-3 col-lg-4 col-md-6">
                                        <x-label for="terms" class="">{{ucwords(trans_choice('messages.product_billing_cycle', 1))}}</x-label>
                                        <x-input  type="text" id="terms" name="terms" class="@error('editing.terms') is-invalid @enderror" value="{{$item['billingCycle']}}"></x-input>
                                        @error('editing.terms')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror

                                    </div>
                                    @endforeach
                                    @endif
                                </div>


                                <div class="row">
                                    <div class="mb-3 col-lg-4 col-md-6">
                                        <x-label for="city" class="">{{ucwords(trans_choice('messages.product_reseller_qualification', 1))}}</x-label>
                                        <x-input wire:model="editing.resellee_qualifications" type="text" id="resellee_qualifications" name="resellee_qualifications" class=" mb-4 @error('editing.resellee_qualifications') is-invalid @enderror"></x-input>
                                        @error('editing.resellee_qualifications')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-4 col-lg-4 col-md-6">
                                        {{-- <div class="mb-3 input-group">
                                            <div>
                                                <x-label for="country">{{ucwords(trans_choice('messages.price_list', 1))}}</x-label>
                                                <div class="mb-3 input-group">
                                                    price_list_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                </div>
                                                <label for="editing.markup" class="block text-sm font-medium text-gray-700">{{ ucwords(trans_choice('messages.markup', 1)) }}</label>
                                                <div class="relative mt-1 rounded-md shadow-sm">
                                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm">
                                                            %
                                                        </span>
                                                    </div>
                                                    <input value="{{$product->markup}}" wire:model="editing.markup" type="text" name="editing.marku" id="editing.markup" class="block w-full pr-12 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 pl-7 sm:text-sm" placeholder="00" aria-describedby="price-markup">
                                                </div>
                                                @error('editing.markup')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div> --}}
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-2 shadow-none col-md-6">
                                                <x-label for="availability">{{ ucwords(trans_choice('messages.available_for_purchase', 1)) }}</x-label>
                                                <input wire:model="isAvailable" type="checkbox" id="availability" name="isAvailable" class="block transition duration-150 ease-in-out border-indigo-300 form-checkbox sm:text-sm sm:leading-5"/>
                                                @error('editing.availability')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-slot>
                    <x-slot name="footer">
                        <button wire:click="$set('showEditModal', false)" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ucwords(trans_choice('cancel', 1))}}
                        </button>
                        <button type="submit" class="inline-flex justify-center px-4 py-2 ml-4 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ucwords(trans_choice('save', 1))}}
                        </button>
                    </x-slot>
                </x-modal.slideout>
            </form>
            @endif
        </div>
    </div>
</div>
