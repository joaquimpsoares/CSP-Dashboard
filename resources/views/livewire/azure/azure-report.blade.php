<div>
    <div class="relative bg-indigo-600">
        <div class="px-3 py-3 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="pr-16 sm:text-center sm:px-16">
                <p class="text-white font-small">
                    <span class="md:hidden">
                        We announced a new product!
                    </span>
                    <span class="hidden md:inline">
                        <p class="text-white font-small">
                            This Azure report provides access to utilization records for a time period that represents when the utilization was reported in the billing system. It provides access to the same utilization data that is used to create and calculate the reconciliation file.

                        </p>
                        <p class="text-white font-small">
                            However, it does not have knowledge of billing system reconciliation file logic. You should not expect reconciliation file summary results to match the result retrieved from this API exactly for the same time period.
                        </p>

                        <p class="text-white font-small">
                            For example, the billing system takes the same utilization data and applies lateness rules to determine what is accounted for in a reconciliation file. When a billing period closes, all usage until the end of the day that the billing period ends is included in the reconciliation file. Any late usage within the billing period that is reported within 24 hours after the billing period ends is accounted for in the next reconciliation file.
                        </p>
                    </span>
                    {{-- <span class="block sm:ml-2 sm:inline-block">
                        <a href="#" class="font-bold text-white underline"> Learn more <span aria-hidden="true">&rarr;</span></a>
                    </span> --}}
                </p>
            </div>
            {{-- <div class="absolute inset-y-0 right-0 flex items-start pt-1 pr-1 sm:pt-1 sm:pr-2 sm:items-start">
                <button type="button" class="flex p-2 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-white">
                    <span class="sr-only">Dismiss</span>
                    <!-- Heroicon name: outline/x -->
                    <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div> --}}
        </div>
    </div>
    <div class="relative z-0 flex-col flex-1 overflow-y-auto">
        <div class="p-4 overflow-hidden bg-white">
            <div class="flex flex-col">
                <div class="flex flex-col items-center justify-between lg:flex-row">
                    <div class="flex items-center">
                        <h4>Analytics Dashboard - {{$subscription->customer->company_name}}</h4>
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
                        <div>
                            <a onclick="confirm('Are you sure you want to export these Records?') || event.stopImmediatePropagation()"wire:click="exportSelected()" href="#" class="px-2 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="hidden w-5 h-5 lg:inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                                </svg>
                                {{ ucwords(trans_choice('messages.export', 1)) }}
                            </a>
                        </div>
                        <div>
                            <a wire:click="$toggle('showFilters')"href="#" class="px-2 py-2 ml-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="hidden w-5 h-5 lg:inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                            </a>
                        </div>


                    </div>
                </div>
                <!-- Top Bar -->
                {{-- <div class="flex justify-between">
                    <div class="flex w-2/4 space-x-4">
                        <x-button.link wire:click="toggleShowFilters">@if ($showFilters) Hide @endif Advanced Search...</x-button.link>
                    </div>
                </div> --}}

                <!-- Advanced Search -->
                <div>
                    @if ($showFilters)
                    <div class="relative flex p-4 rounded shadow-inner bg-cool-gray-200">
                        <div class="w-1/2 pr-2 space-y-4">
                            {{-- <x-input.group inline for="filter-status" label="Status">
                                <x-input.select wire:model="filters.status" id="filter-status">
                                    <option value="" disabled>Select Status...</option>

                                    @foreach (App\Models\Transaction::STATUSES as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group> --}}

                            {{-- <div>
                                <div class="relative">
                                    <input type="text" wire:model="taskduedate"  class="w-full pl-4 pr-10 font-medium leading-none text-gray-600 rounded-lg shadow-sm py-auto focus:outline-none focus:ring focus:ring-blue-600 focus:ring-opacity-50" placeholder="Select date"
                                    autocomplete="off" id="daterange-btn"
                                    data-provide="datepicker" data-date-autoclose="true" data-date-format="yyyy-mm-dd" data-date-today-highlight="true"
                                    onchange="this.dispatchEvent(new InputEvent('input'))"/>
                                    <div class="absolute top-0 right-0 px-3 py-2">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                            </div> --}}

                            <x-input.group inline for="filter-amount-min" label="Minimum Amount">
                                <x-input.money wire:model.lazy="filters.amount-min" id="filter-amount-min" />
                            </x-input.group>

                            <x-input.group inline for="filter-amount-max" label="Maximum Amount">
                                <x-input.money wire:model.lazy="filters.amount-max" id="filter-amount-max" />
                            </x-input.group>
                        </div>

                        <div class="w-1/2 pl-2 space-y-4">
                            <x-input.group inline for="filter-date-min" label="Minimum Date">
                                <x-input.date wire:model="filters.date-min" id="filter-date-min" placeholder="MM/DD/YYYY" />
                            </x-input.group>

                            <x-input.group inline for="filter-date-max" label="Maximum Date">
                                <x-input.date wire:model="filters.date-max" id="filter-date-max" placeholder="MM/DD/YYYY" />
                            </x-input.group>

                            <x-button wire:click="resetFilters" class="absolute bottom-0 right-0 p-4">Reset Filters</x-button>
                        </div>
                    </div>
                    @endif
                </div>


                <div class="flex-col mt-5 space-y-4">
                    <x-tableazure>
                        <x-slot name="head">
                            <x-table.heading class="w-8 pr-0">
                                <x-input.checkbox wire:model="selectPage" />
                            </x-table.heading>
                            <x-table.heading sortable multi-column wire:click="sortBy('resource_name')"     :direction="$sorts['resource_name'] ?? null">{{ ucwords(trans_choice('messages.name', 1)) }}</x-table.heading>
                            <x-table.heading sortable multi-column wire:click="sortBy('resource_group')"    :direction="$sorts['resource_group'] ?? null">{{ ucwords(trans_choice('messages.resource_group', 1)) }}</x-table.heading>
                            <x-table.heading sortable multi-column wire:click="sortBy('resource_id')"       :direction="$sorts['resource_id'] ?? null">resource_id</x-table.heading>
                            <x-table.heading sortable multi-column wire:click="sortBy('cost')"              :direction="$sorts['cost'] ?? null">{{ ucwords(trans_choice('messages.price', 1)) }}</x-table.heading>
                            <x-table.heading sortable multi-column wire:click="sortBy('rates')"             :direction="$sorts['rates'] ?? null">rates</x-table.heading>
                            <x-table.heading sortable multi-column wire:click="sortBy('quantity')"          :direction="$sorts['quantity'] ?? null">quantity</x-table.heading>
                            <x-table.heading sortable multi-column wire:click="sortBy('usageStartTime')"    :direction="$sorts['usageStartTime'] ?? null">usageStartTime</x-table.heading>
                            <x-table.heading sortable multi-column wire:click="sortBy('usageEndTime')"      :direction="$sorts['usageEndTime'] ?? null">usageEndTime</x-table.heading>
                        </x-slot>

                        <x-slot name="body">
                            @if ($selectPage)
                            <x-table.row class="bg-cool-gray-200" wire:key="row-message">
                                <x-table.cell colspan="6">
                                    @unless ($selectAll)
                                    <div>
                                        <span>You have selected <strong>{{ $reports->count() }}</strong> transactions, do you want to select all <strong>{{ $reports->total() }}</strong>?</span>
                                        <x-button.link wire:click="selectAll" class="ml-1 text-blue-600">Select All</x-button.link>
                                    </div>
                                    @else
                                    <span>You are currently selecting all <strong>{{ $reports->total() }}</strong> transactions.</span>
                                    @endif
                                </x-table.cell>
                            </x-table.row>
                            @endif
                            @forelse ($reports as $transaction)
                            <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $transaction->id }}">
                                <x-table.cell class="pr-0">
                                    <x-input.checkbox wire:model="selected" value="{{ $transaction->id }}" ></x-input.checkbox>
                                </x-table.cell>
                                <x-table.cell>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                        {{-- <x-icon.cash class="text-cool-gray-400"/> --}}
                                        {{ $transaction->resource_name }}
                                    </span>
                                </x-table.cell>
                                <x-table.cell>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                        {{ $transaction->resource_group }}
                                    </span>
                                </x-table.cell>

                                <x-table.cell>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                        {{ $transaction->resource_id }}
                                    </span>
                                </x-table.cell>
                                <x-table.cell>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                        $ @money($transaction->quantity*$transaction->prices->rates[0])
                                        USD
                                    </span>
                                </x-table.cell>
                                <x-table.cell>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                        @if(isset($transaction->subscription->customer->markup))
                                        @money($transaction->prices->rates[0]*$transaction->subscription->customer->markup)
                                        @else
                                        @money($transaction->prices->rates[0])
                                        @endif
                                    </span>
                                </x-table.cell>

                                <x-table.cell>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                        {{ $transaction->quantity }}
                                    </span>
                                </x-table.cell>

                                <x-table.cell>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                        {{date('Y-m-d', strtotime($transaction->usageStartTime))}}
                                    </span>
                                </x-table.cell>
                                <x-table.cell>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 capitalize">
                                        {{date('Y-m-d', strtotime($transaction->usageEndTime))}}
                                    </span>
                                </x-table.cell>
                            </x-table.row>
                            @empty
                            <x-table.row>
                                <x-table.cell colspan="9">
                                    <div class="flex items-center justify-center space-x-2">
                                        <x-icon.inbox class="w-8 h-8 text-cool-gray-400" />
                                        <span class="py-8 text-xl font-medium text-cool-gray-400">No resources found...</span>
                                    </div>
                                </x-table.cell>
                            </x-table.row>
                            @endforelse
                        </x-slot>
                    </x-tableazure>
                    <div>
                        {{ $reports->links() }}
                    </div>
                    {{-- <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase" wire:click="sortByColumn('resource_name')">
                                    {{ ucwords(trans_choice('messages.name', 1)) }}
                                    @if ($sortColumn == 'resource_name')
                                    <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                    @else
                                    <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase" wire:click="sortByColumn('resource_group')">
                                    {{ ucwords(trans_choice('messages.resource_group', 1)) }}
                                    @if ($sortColumn == 'resource_group')
                                    <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                    @else
                                    <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                    @endif
                                </th>

                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase" wire:click="sortByColumn('resource_location')">
                                    {{ ucwords(trans_choice('messages.region', 1)) }}
                                    @if ($sortColumn == 'resource_location')
                                    <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                    @else
                                    <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                    @endif
                                </th>

                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase" wire:click="sortByColumn('cost')">
                                    {{ ucwords(trans_choice('messages.total_cost', 1)) }}
                                    @if ($sortColumn == 'cost')
                                    <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                    @else
                                    <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase" wire:click="sortByColumn('usageStartTime')">
                                    {{ ucwords(trans_choice('messages.start_date', 1)) }}
                                    @if ($sortColumn == 'usageStartTime')
                                    <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                    @else
                                    <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase" wire:click="sortByColumn('usageEndTime')">
                                    {{ ucwords(trans_choice('messages.end_date', 1)) }}
                                    @if ($sortColumn == 'usageEndTime')
                                    <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                    @else
                                    <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                    @endif
                                </th>
                            </tr>
                            {{date('Y-m-d', strtotime($item->usageStartTime))}}                    </thead>
                            <body>
                                @foreach ($reports as $item)

                                <tr class="hover:bg-gray-100" >
                                    <td class="hidden px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">{{$item->resource_name}}</td>
                                    <td class="hidden px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">{{$item->resource_group}}</td>
                                    <td class="hidden px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">{{$item->resource_location}}</td>
                                    <td class="hidden px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">$@money($item->cost)</td>
                                    <td class="hidden px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell"></td>
                                    <td class="hidden px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">{{date('Y-m-d', strtotime($item->usageEndTime))}}</td>
                                </tr>
                                @endforeach
                            </body>
                        </table>
                        <div class="text-right card-footer d-flex">
                            @if ($reports->total() >= '10')
                            {!! $reports->render() !!}
                            @endif
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
