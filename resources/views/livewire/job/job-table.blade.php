<div>
    <div>
        <div class="relative z-0 flex-col flex-1 overflow-y-auto">
            <div class="p-4 overflow-hidden bg-white">
                <div class="flex flex-col">
                    <div class="flex flex-col items-center justify-between lg:flex-row">
                        <div class="flex items-center">
                            <h4>Pricelists</h4>
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
                            <h4>{{ ucwords(trans_choice('messages.analytic_table', 1)) }}</h4>
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
                                <x-table.heading sortable multi-column wire:click="sortBy('queue')"          :direction="$sorts['queue'] ?? null">{{ ucwords(trans_choice('messages.name', 1)) }}</x-table.heading>
                                <x-table.heading sortable multi-column wire:click="sortBy('status')"    :direction="$sorts['status'] ?? null">{{ ucwords(trans_choice('messages.status', 1)) }}</x-table.heading>
                                <x-table.heading sortable multi-column wire:click="sortBy('exception_message')"     :direction="$sorts['exception_message'] ?? null">{{ ucwords(trans_choice('messages.error', 1)) }}</x-table.heading>
                                <x-table.heading sortable multi-column wire:click="sortBy('exception_class')"     :direction="$sorts['exception_class'] ?? null">{{ ucwords(trans_choice('messages.error_class', 1)) }}</x-table.heading>
                                <x-table.heading sortable multi-column wire:click="sortBy('started_at')"     :direction="$sorts['started_at'] ?? null">{{ ucwords(trans_choice('messages.started_at', 1)) }}</x-table.heading>
                                <x-table.heading sortable multi-column wire:click="sortBy('time_elapsed')"     :direction="$sorts['time_elapsed'] ?? null">{{ ucwords(trans_choice('messages.time_elapsed', 1)) }}</x-table.heading>
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
                                @forelse ($jobs as $transaction)
                                {{-- @dd($transaction) --}}
                                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $transaction['id'] }}">
                                    <x-table.cell class="pr-0">
                                        <x-input.checkbox wire:model="selected" value="{{ $transaction['id'] }}" ></x-input.checkbox>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <a href="{{route('priceList.show',$transaction['id'])}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                            <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                    {{-- <x-icon.cash class="text-cool-gray-400"/> --}}
                                                    {{ $transaction['queue'] }}
                                                </span>
                                            </div>
                                        </a>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <a href="{{route('priceList.show',$transaction['id'])}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                            <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                @if(!$transaction->isFinished())
                                                <div class="">
                                                </div>
                                                <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 md:mt-2 lg:mt-0">
                                                    <span>Running</span>
                                                </div>
                                                @elseif($transaction->hasSucceeded())
                                                <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 md:mt-2 lg:mt-0">
                                                    <span>Success</span>
                                                </div>
                                                @else
                                                <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 md:mt-2 lg:mt-0">
                                                    <span>Failed</span>
                                                </div>
                                                @endif
                                            </div>
                                        </a>
                                    </span>
                                </x-table.cell>

                                <x-table.cell>
                                    <a href="{{route('priceList.show',$transaction['id'])}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                {{ $transaction['exception_message'] }}
                                            </span>
                                        </div>
                                    </a>
                                </x-table.cell>
                                {{-- <x-table.cell>
                                    <a href="{{route('priceList.show',$transaction['id'])}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                {{ $transaction['exception'] }}
                                            </span>
                                        </div>
                                    </a>
                                </x-table.cell> --}}
                                <x-table.cell>
                                    <a href="{{route('priceList.show',$transaction['id'])}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                {{ $transaction['exception_class'] }}
                                            </span>
                                        </div>
                                    </a>
                                </x-table.cell>
                                <x-table.cell>
                                    <a href="{{route('priceList.show',$transaction['id'])}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                {{ $transaction['started_at'] }}
                                            </span>
                                        </div>
                                    </a>
                                </x-table.cell>
                                <x-table.cell>
                                    <a href="{{route('priceList.show',$transaction['id'])}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                {{ sprintf('%02.2f', (float) $transaction->time_elapsed) }}
                                            </span>
                                        </div>
                                    </a>
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
                        {{ $jobs->links() }}
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

                {{-- <x-button.secondary wire:click="$set('showDeleteModal', false)">Cancel</x-button.secondary>

                <x-button.primary type="submit">Delete</x-button.primary> --}}
            </x-slot>
        </x-modal.confirmation>
    </form>
    <!-- Save Transaction Modal -->
    <form wire:submit.prevent="save">
        <x-modal.dialog wire:model.defer="showEditModal">
            <x-slot name="title">Edit Transaction</x-slot>

            <x-slot name="content">
                <x-input.group for="name" label="name" :error="$errors->first('editing.name')">
                    <x-input.text wire:model="editing.name" id="name" placeholder="name" />
                </x-input.group>

                <x-input.group for="description" label="description" :error="$errors->first('editing.description')">
                    <x-input.money wire:model="editing.description" id="description" />
                </x-input.group>

                <x-input.group for="margin" label="margin" :error="$errors->first('editing.margin')">
                    <x-input.text wire:model="editing.margin" id="margin" />
                </x-input.group>
            </x-slot>

            <x-slot name="footer">

                <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" @click="open = false">
                    Save
                </button>
                <a type="button" wire:click="$set('showEditModal', false)" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" @click="open = false">
                    Cancel
                </a>

                {{-- <x-button.primary type="submit">Save</x-button.primary> --}}
            </x-slot>
        </x-modal.dialog>
    </form>
</div>

</div>
