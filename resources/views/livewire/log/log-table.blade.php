<div>
    <div>
        <div class="relative z-0 flex-col flex-1 overflow-y-auto">
            <div class="p-4 overflow-hidden bg-white">
                <div class="flex flex-col">
                    <div class="flex flex-col items-center justify-between lg:flex-row">
                        <div class="flex items-center">
                            <h4>{{ ucwords(trans_choice('messages.job', 2)) }}</h4>
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
                            <h4>{{ ucwords(trans_choice('messages.job_table', 1)) }}</h4>
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
                                    <x-dropdown.item type="button" wire:click="exportSelected" class="flex items-center space-x-2">
                                        <x-icon.download class="text-gray-400"/> <span>Export</span>
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
                                {{-- <x-table.heading class="w-8 pr-0">
                                    <x-input.checkbox wire:model="selectPage" />
                                </x-table.heading> --}}
                                <x-table.heading sortable multi-column wire:click="sortBy('queue')"          :direction="$sorts['queue'] ?? null">{{ ucwords(trans_choice('messages.id', 1)) }}</x-table.heading>
                                <x-table.heading sortable multi-column wire:click="sortBy('status')"    :direction="$sorts['status'] ?? null">{{ ucwords(trans_choice('messages.type', 1)) }}</x-table.heading>
                                <x-table.heading sortable multi-column wire:click="sortBy('exception_message')"     :direction="$sorts['exception_message'] ?? null">{{ ucwords(trans_choice('messages.url', 1)) }}</x-table.heading>
                                <x-table.heading sortable multi-column wire:click="sortBy('exception_class')"     :direction="$sorts['exception_class'] ?? null">{{ ucwords(trans_choice('messages.Method', 1)) }}</x-table.heading>
                                <x-table.heading sortable multi-column wire:click="sortBy('started_at')"     :direction="$sorts['started_at'] ?? null">{{ ucwords(trans_choice('messages.Ip', 1)) }}</x-table.heading>
                                <x-table.heading sortable multi-column wire:click="sortBy('time_elapsed')"     :direction="$sorts['time_elapsed'] ?? null">{{ ucwords(trans_choice('messages.country', 1)) }}</x-table.heading>
                                <x-table.heading sortable multi-column wire:click="sortBy('time_elapsed')"     :direction="$sorts['time_elapsed'] ?? null">{{ ucwords(trans_choice('messages.User Id', 1)) }}</x-table.heading>
                                <x-table.heading sortable multi-column wire:click="sortBy('time_elapsed')"     :direction="$sorts['time_elapsed'] ?? null">{{ ucwords(trans_choice('messages.Log Time', 1)) }}</x-table.heading>
                                <x-table.heading sortable multi-column wire:click="sortBy('time_elapsed')"     :direction="$sorts['time_elapsed'] ?? null">{{ ucwords(trans_choice('messages.User Agent', 1)) }}</x-table.heading>
                            </x-slot>

                            <x-slot name="body">
                                @forelse ($logs as $transaction)
                                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $transaction['id'] }}">
                                    <x-table.cell>
                                        <a href="{{route('priceList.show',$transaction['id'])}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                            <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                    {{ $transaction->id }}
                                                </span>
                                            </div>
                                        </a>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <a href="{{route('priceList.show',$transaction['id'])}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                            <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                    {{ $transaction->subject }}
                                                </span>
                                            </div>
                                        </a>
                                    </span>
                                </x-table.cell>
                                <x-table.cell>
                                    <a href="{{route('priceList.show',$transaction['id'])}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex text-wrap items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                {{ $transaction->url }}
                                            </span>
                                        </div>
                                    </a>
                                </x-table.cell>
                                <x-table.cell>
                                    <a href="{{route('priceList.show',$transaction['id'])}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                {{ $transaction->method }}
                                            </span>
                                        </div>
                                    </a>
                                </x-table.cell>
                                <x-table.cell>
                                    <a href="{{route('priceList.show',$transaction['id'])}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                {{ $transaction->ip }}
                                            </span>
                                        </div>
                                    </a>
                                </x-table.cell>
                                <x-table.cell>
                                    <a href="{{route('priceList.show',$transaction['id'])}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                {!! geoip()->getLocation($transaction->ip)->country !!}
                                            </span>
                                        </div>
                                    </a>
                                </x-table.cell>
                                <x-table.cell>
                                    @php
                                    $user_name = App\User::where('id', $transaction->user_id)->first();
                                    @endphp
                                    <a href="{{route('priceList.show',$transaction['id'])}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                @if($user_name)
                                                {{ $user_name->name }}
                                                @endif
                                            </span>
                                        </div>
                                    </a>
                                </x-table.cell>
                                <x-table.cell>
                                    <a href="{{route('priceList.show',$transaction['id'])}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                {{ $transaction->created_at }}
                                            </span>
                                        </div>
                                    </a>
                                </x-table.cell>
                                <x-table.cell>
                                    <a href="{{route('priceList.show',$transaction['id'])}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                                {{ $transaction->agent }}
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
                        {{-- {{ $logs->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
