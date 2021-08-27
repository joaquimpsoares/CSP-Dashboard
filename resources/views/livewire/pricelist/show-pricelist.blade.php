<div>
    <div class="relative z-0 flex-col flex-1 overflow-y-auto">
        <div class="p-4 overflow-hidden bg-white">
            <div class="flex flex-col items-center justify-between lg:flex-row">
                <div class="flex items-center">
                    <h4>{{ ucwords(trans_choice('messages.price_list', 1)) }}</h4>
                </div>
            </div>
            <div class="flex flex-col items-center justify-between lg:flex-row">
                <div class="flex items-center">
                    <span class="box-border">
                        {{$priceList['name']}}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <div x-data="{ open: false }"   @keydown.escape.stop="open = false; focusButton()" class="relative inline-block px-3 mt-6 text-left">
                            <button type="button" class="px-4 py-2 mb-1 mr-1 text-xs font-bold text-white uppercase transition-all duration-150 ease-linear bg-indigo-500 rounded shadow outline-none active:bg-indigo-600 hover:shadow-md focus:outline-none"  x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-2" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()" x-state-description="Current:"bg-gray-100 text-gray-900", Default:"bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900"">
                                <span class="block -mt-px normal-case whitespace-no-wrap" style='margin-top: -1px; font-feature-settings: "pnum"; font-variant: proportional-nums; transition: color 0.24s ease 0s; overflow-wrap: break-word;'>
                                    <span class="box-border">
                                        Actions
                                    </span>
                                </span>
                            </button>
                            <div  x-cloak x-show.transition="open" @click.away="open = false" class="absolute right-0 w-56 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                <div class="py-1" role="none">
                                    <a href="#" wire:click="editList({{ $priceList->id }})" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-4">{{ ucwords(trans_choice('messages.edit', 1)) }} </a>
                                </div>

                                <div class="py-1" role="none">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-32 p-0 px-4 py-2 m-0 border-r shadow-xs">
                <span class="font-bold">{{ ucwords(trans_choice('messages.subscription_started', 1)) }}</span>
                <div>
                    <span class="text-xs text-gray-500">{{ date('j F, Y', strtotime($priceList->created_at))}}</span>
                </div>
            </div>
            <!-- Start - Customer Details -->
            <div class="px-0 pt-0 mt-5 break-words border-b">
                <div class="flex flex-col lg:flex-row">
                    <div class="flex items-center">
                        <h4>{{ ucwords(trans_choice('messages.price_list_details', 1)) }}</h4>
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
            {{-- <div class="grid grid-flow-col grid-cols-2 gap-4">
                <div>
                    <div class="flex justify-between mt-4 mb-8">
                        <div class="">
                            <dl>
                                <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.company_name', 1)) }}</dt>
                                    <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{$priceList->resellers->first()->company_name}}</dd>
                                </div>
                                <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.main_contact', 1)) }}</dt>
                                    <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{$priceList->resellers->first()->users->first()->name}} {{$priceList->resellers->first()->users->first()->last_name}}</dd>
                                </div>
                                <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.phone', 1)) }}</dt>
                                    <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{$priceList->resellers->first()->users->first()->phone}}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div> --}}
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
                                                <input wire:model="filters.search" id="search" class="block w-full bg-white py-1.5 pl-10 pr-3 border border-gray-300 rounded-md leading-5 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500 focus:placeholder-gray-500 sm:text-sm" placeholder="Search" type="search" name="search">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-3 lg:max-w-xs">
                                    <x-dropdown label="Bulk Actions">
                                        <x-dropdown.item type="button" wire:click="exportSelected" class="flex items-center space-x-2">
                                            <x-icon.download class="text-gray-400"/> <span>Export</span>
                                        </x-dropdown.item>

                                        <x-dropdown.item type="button" wire:click="$toggle('showDeleteModal')" class="flex items-center space-x-2">
                                            <x-icon.trash class="text-gray-400"/> <span>Delete</span>
                                        </x-dropdown.item>
                                    </x-dropdown>
                                </div>
                                <div class="ml-3 lg:max-w-xs">
                                    @livewire('pricelist.import-transactions', ['priceList' => $priceList], key($priceList->id))
                                </div>

                                <div class="ml-3 lg:max-w-xs">
                                    <x-button.primary wire:click="create"><x-icon.plus/> Add</x-button.primary>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-4 pb-5 m-0">
                            <x-tableazure>
                                <x-slot name="head">
                                    <x-table.heading class="w-8 pr-0">
                                        <x-input.checkbox wire:model="selectPage" />
                                    </x-table.heading>
                                    <x-table.heading sortable multi-column wire:click="sortBy('name')"     :direction="$sorts['name'] ?? null">{{ ucwords(trans_choice('messages.name', 1)) }}</x-table.heading>
                                    <x-table.heading sortable multi-column wire:click="sortBy('price')"    :direction="$sorts['price'] ?? null">{{ ucwords(trans_choice('messages.price', 1)) }}</x-table.heading>
                                    <x-table.heading sortable multi-column wire:click="sortBy('msrp')"    :direction="$sorts['msrp'] ?? null">{{ ucwords(trans_choice('messages.msrp', 1)) }}</x-table.heading>
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
                                <div>
                                    {{ $prices->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <!-- Save Transaction Modal -->
            <form @if($showCreate === false) { wire:submit.prevent="save({{$priceList->id}})" } @else { wire:submit.prevent="savecreate" } @endif>
                <x-modal.slideout wire:model.defer="showEditModal">
                    <x-slot name="title">Add Price</x-slot>
                    <x-slot name="content">
                        <section class="dark-grey-text">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="mb-4 col-md-12">
                                            <x-label for="editing.product_sku" class="">{{ ucwords(trans_choice('messages.product_sku', 1)) }}</x-label>
                                            <x-input  wire:model="editing.product_sku" type="text" id="editing.sku" name="editing.product_sku" class="@error('editing.product_sku') is-invalid @enderror"></x-input>
                                            @error('editing.product_sku')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-4 col-md-12">
                                            <x-label for="name" class="">{{ ucwords(trans_choice('messages.name', 1)) }}</x-label>
                                            <x-input  wire:model="editing.name" type="text" id="name" name="name" class="@error('editing.name') is-invalid @enderror"></x-input>
                                            @error('editing.name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-2 col-md-6">
                                            <x-label for="price">{{ ucwords(trans_choice('messages.price', 1)) }}</x-label>
                                            <x-input wire:model="editing.price" type="text" id="price" name="price" class="@error('editing.price') is-invalid @enderror"></x-input>
                                            @error('editing.price')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                        <div class="mb-2 col-md-6">
                                            <x-label for="msrp">{{ ucwords(trans_choice('messages.msrp', 1)) }}</x-label>
                                            <x-input wire:model="editing.msrp" type="text" id="msrp" name="msrp" class="@error('editing.msrp') is-invalid @enderror"></x-input>
                                            @error('editing.msrp')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </x-slot>
                    <x-slot name="footer">
                        <x-a wire:click="$set('showEditModal', false)">Cancel</x-a>
                        <x-button.primary type="submit">Save</x-button.primary>
                    </x-slot>
                </x-modal.slideout>
            </form>
        </div>
    </div>
    <form wire:submit.prevent="disable({{$priceList->id}})" wire:loading.class.delay="opacity-50">
        <x-modal.confirmation wire:model.defer="showconfirmationModal">
            <x-slot name="title">Disabling Customer</x-slot>
            <x-slot name="content">
                <p> Are you sure you want to disable <strong class="text-red-400">{{$priceList->company_name }}</strong>?</p>
                <p> <strong>By doing so your customer's subscriptions will be put to disabled  you have 90 days until your customer can loose their information.</strong></p>
                {{-- @foreach($priceList->subscriptions as $key => $value)
                    <ul>
                        <li>
                            {{$value->name}}
                        </li>
                    </ul>
                    @endforeach --}}
                </x-slot>

                <x-slot name="footer">
                    <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" @click="open = false">
                        Suspend
                    </button>
                    <a type="button" wire:click="$set('showconfirmationModal', false)" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" @click="open = false">
                        Cancel
                    </a>
                </div>
            </x-slot>
        </x-modal.confirmation>
    </form>
    <!-- Delete Transactions Modal -->


    <form wire:submit.prevent="deleteSelected">
        <x-modal.confirmation wire:model.defer="showDeleteModal">
            <x-slot name="title">Delete Price</x-slot>
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
</div>
<script>
    function copyToClipboard(subscription_id) {
        document.getElementById(subscription_id).select();
        document.execCommand('copy');

    }
</script>
