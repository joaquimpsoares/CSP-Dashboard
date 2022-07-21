<div>
    <div class="relative z-0 flex-col flex-1 overflow-y-auto">
        <div class="p-4 overflow-hidden bg-white">
            <div class="flex flex-col">
                <div class="flex flex-col items-center justify-between lg:flex-row">
                    <div class="flex items-center">
                        <h4>{{ ucwords(trans_choice('messages.price_list', 1)) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div class="relative z-0 flex-col flex-1 overflow-y-auto">
        <div class="p-4 overflow-hidden bg-white">
            <div class="flex flex-col">
                <div class="flex flex-col items-center justify-between lg:flex-row">
                    <div class="flex items-center">
                        <h4>{{ ucwords(trans_choice('messages.price_list_table', 1)) }}</h4>
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
                            <x-table.heading sortable multi-column wire:click="sortBy('name')"          :direction="$sorts['name'] ?? null">{{ ucwords(trans_choice('messages.name', 1)) }}</x-table.heading>
                            <x-table.heading sortable multi-column wire:click="sortBy('description')"   :direction="$sorts['description'] ?? null">{{ ucwords(trans_choice('messages.description', 1)) }}</x-table.heading>
                            <x-table.heading sortable multi-column wire:click="sortBy('provider')"      :direction="$sorts['provider'] ?? null">{{ ucwords(trans_choice('messages.provider', 1)) }}</x-table.heading>
                        </x-slot>
                        <x-slot name="body">
                            @if ($selectPage)
                            <x-table.row class="bg-cool-gray-200" wire:key="row-message">
                                <x-table.cell colspan="6">
                                    @unless ($selectAll)
                                    <div>
                                        <span>You have selected <strong>{{ $priceLists->count() }}</strong> transactions, do you want to select all <strong>{{ $priceLists->total() }}</strong>?</span>
                                        <x-button.link wire:click="selectAll" class="ml-1 text-blue-600">Select All</x-button.link>
                                    </div>
                                    @else
                                    <span>You are currently selecting all <strong>{{ $priceLists->total() }}</strong> transactions.</span>
                                    @endif
                                </x-table.cell>
                            </x-table.row>
                            @endif
                            @forelse ($priceLists as $pricelist)
                            <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $pricelist['id'] }}">
                                <x-table.cell class="pr-0">
                                    <x-input.checkbox wire:model="selected" value="{{ $pricelist['id'] }}" ></x-input.checkbox>
                                </x-table.cell>
                                <x-table.cell>
                                    <a href="{{route('priceList.show',$pricelist['id'])}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                {{ $pricelist['name'] }}
                                            </span>
                                        </div>
                                    </a>
                                </x-table.cell>
                                <x-table.cell>
                                    <a href="{{route('priceList.show',$pricelist['id'])}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                {{ $pricelist['description'] }}
                                            </span>
                                        </div>
                                    </a>
                                </x-table.cell>
                                <x-table.cell>
                                    <a href="{{route('priceList.show',$pricelist['id'])}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                {{ $pricelist->provider->company_name ?? ''}}
                                            </span>
                                        </div>
                                    </a>
                                </x-table.cell>
                                <x-table.cell>
                                    <div class="z-10">
                                        <button type="button" class="px-1 py-1 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a wire:click="edit({{ $pricelist->id }})" class="dropdown-item" href="#">
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
                                        <span class="py-8 text-xl font-medium text-cool-gray-400">No Price List found...</span>
                                    </div>
                                </x-table.cell>
                            </x-table.row>
                            @endforelse
                        </x-slot>
                    </x-tableazure>
                    <div>
                        {{ $priceLists->links() }}
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
    <form wire:submit.prevent="save">
        <x-modal.dialog wire:model.defer="showEditModal">
            <x-slot name="title">{{ ucwords(trans_choice('messages.edit', 1)) }}</x-slot>
            <x-slot name="content">

                <x-input.group for="instance_id" label="Instance" :error="$errors->first('editing.instance_id')">
                    <x-input.select wire:model="editing.instance_id" id="instance_id">
                        <option value="" >Select Column...</option>
                        @foreach ($instances as $instance)
                        <option value="{{$instance->id}}">{{ $instance->name }}</option>
                        @endforeach
                    </x-input.select>
                </x-input.group>

                <x-input.group for="name" label="{{ ucwords(trans_choice('messages.name', 1)) }}" :error="$errors->first('editing.name')">
                    <x-input.text wire:model="editing.name" id="name" placeholder="name" />
                </x-input.group>

                <x-input.group for="description" label="{{ ucwords(trans_choice('messages.description', 1)) }}" :error="$errors->first('editing.description')">
                    <x-input.text wire:model="editing.description" id="description"  placeholder="description" />
                </x-input.group>

                <x-input.group for="margin" label="{{ ucwords(trans_choice('messages.margin', 1)) }}" :error="$errors->first('editing.margin')">
                    <x-input.text wire:model="editing.margin" id="margin"  placeholder="margin" />
                </x-input.group>
            </x-slot>

            <x-slot name="footer">

                <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" @click="open = false">
                    {{ ucwords(trans_choice('messages.save', 1)) }}
                </button>
                <a type="button" wire:click="$set('showEditModal', false)" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" @click="open = false">
                    {{ ucwords(trans_choice('messages.cancel', 1)) }}
                </a>

            </x-slot>
        </x-modal.dialog>
    </form>
</div>
