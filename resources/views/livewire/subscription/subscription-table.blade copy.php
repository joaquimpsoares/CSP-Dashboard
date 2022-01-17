<div x-data="{ resellerOpen: false , isOpen: false }" class="relative z-0 flex-col flex-1 overflow-y-auto">
    <div class="p-4 overflow-hidden bg-white">
        <div class="flex flex-col items-center justify-between lg:flex-row">
            <div class="flex items-center">
                <h4>{{ ucwords(trans_choice('messages.subscription_table', 2)) }}</h4>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex justify-center flex-1 lg:justify-end">
                        <!-- Search section -->
                        <div class="w-full max-w-lg lg:max-w-xs">
                            <label for="search" class="sr-only">Search</label>
                            <div class="relative text-gray-400 focus-within:text-gray-500">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <!-- Heroicon name: solid/search -->
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input wire:model="search" id="search" class="block w-full bg-white py-1.5 pl-10 pr-3 border border-gray-300 rounded-md leading-5 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 focus:placeholder-gray-500 sm:text-sm" placeholder="Search" type="search" name="search">
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <a wire:click="$toggle('showFilters')"href="#" class="px-2 py-2 ml-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="hidden w-5 h-5 lg:inline" viewBox="0 0 20 20" fill="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                    </a>
                </div>
                <div>
                    <a onclick="confirm('Are you sure you want to export these Records?') || event.stopImmediatePropagation()"wire:click="exportSelected()" href="#" class="px-2 py-2 ml-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="hidden w-5 h-5 lg:inline" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                        </svg>
                        {{ ucwords(trans_choice('messages.export', 1)) }}
                    </a>
                </div>

            </div>
        </div>
        <div>
            @if ($showFilters)
            <div class="relative flex p-4 mt-3 bg-indigo-100 rounded shadow-inner">
                <div class="w-1/2 pr-2 space-y-4">
                    <x-input.group inline for="filter-status" label="Status">
                        <x-input.select wire:model="filters.status" id="filter-status">
                            <option value="" disabled>Select Status...</option>

                            @foreach (App\Subscription::STATUSES as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>
                    <x-input.group inline for="filter-date-min" label="Expiration Date">
                        <x-input.date wire:model="filters.date-min" id="filter-date-min" placeholder="YYYY/MM/DD" />
                    </x-input.group>

                    <x-input.group inline for="filter-date-max" label="Expiration Date">
                        <x-input.date wire:model="filters.date-max" id="filter-date-max" placeholder="YYYY/MM/DD" />
                    </x-input.group>
                </div>

                <div class="w-1/2 pl-2 space-y-4">

                    <x-button.link wire:click="resetFilters" class="absolute bottom-0 right-0 p-4">Reset Filters</x-button.link>
                </div>
            </div>
            @endif
        </div>
        <div class="mt-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full px-4 py-1 align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.#', 1)) }}</th>
                                <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.subscription_name', 1)) }}</th>
                                <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.company_name', 1)) }}</th>
                                <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.quantity', 1)) }}</th>
                                <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.expiration', 1)) }}</th>
                                <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.billing_cycle', 1)) }}</th>
                                <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.status', 1)) }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($subscriptions as $subscription)
                            <tr class="table-subheader hover:bg-gray-100">
                                <td class="px-2 py-2 text-sm text-gray-500 whitespace-nowrap"><a href="{{route('subscription.show', $subscription->id)}}">{{$subscription['id']}}</a></td>
                                <td class="px-2 py-2 text-sm text-gray-500 whitespace-wrap">{{$subscription->name}}
                                    @if($subscription->autorenew == 0)
                                    <span class="flex-shrink-0 inline-block px-2 py-0.5 text-red-800 text-xs font-medium bg-red-100 rounded-full">{{ ucwords(trans_choice('messages.no_autorenew', 1)) }}</span>
                                    @endif
                                </td>

                                <td class="px-2 py-2 text-sm text-gray-500 whitespace-wrap">{{$subscription->customer->company_name}}</td>
                                @if ($subscription->billing_type === 'usage' )
                                <td></td>
                                @else
                                <td class="px-2 py-2 text-sm text-gray-500 whitespace-wrap">{{$subscription->amount}}</td>
                                @endif
                                <td class="px-2 py-2 text-sm text-gray-500 whitespace-wrap">{{$subscription->expiration_data}}</td>
                                <td class="px-2 py-2 text-sm text-gray-500 whitespace-wrap">{{$subscription->billing_period}}</td>
                                <td class="px-2 py-2 text-sm text-gray-500 whitespace-wrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $subscription->status->name == 'messages.active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'  }}  capitalize">
                                        {{ ucwords(trans_choice($subscription->status->name, 1)) }}
                                    </span>
                                </td>
                            </td>
                        </tr>
                        {{-- @dd($subscription->products->first()->id) --}}

                        @can('subscription_edit')
                        <tr style="display:none" class=" hover:bg-gray-100">
                            <td colspan="9">
                                <div class="">
                                    <div class="border-0 panel panel-primary receipts-inline-table">
                                        <div class="p-0 border-0 panel-body tabs-menu-body">
                                            <div class="tab-content">
                                                <table  class="min-w-full mr-2 bg-indigo-100 divide-y divide-gray-200 ">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="col" class="hidden px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase lg:table-cell">{{ ucwords(trans_choice('messages.subscription_name', 1)) }}</th>
                                                            <th scope="col" class="hidden px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase lg:table-cell">{{ ucwords(trans_choice('messages.quantity', 1)) }}</th>
                                                            <th scope="col" class="hidden px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase lg:table-cell">{{ ucwords(trans_choice('messages.billing_cycle', 1)) }}</th>
                                                            <th scope="col" class="hidden px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase lg:table-cell">{{ ucwords(trans_choice('messages.status', 1)) }}</th>
                                                            <th scope="col" class="hidden px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase lg:table-cell">{{ ucwords(trans_choice('messages.action', 1)) }}</th>
                                                        </tr>
                                                        <tr class="mr-13 last-product">
                                                            <form class="form-horizontal form-bordered" method="POST" action="{{ route('subscription.update', $subscription->id) }}">
                                                                @method('PATCH')
                                                                <td class="px-2 py-2 text-sm text-gray-500 whitespace-wrap">{{$subscription->name}}</td>
                                                                @if ($subscription->billing_type === 'usage' ?? 'software perpetual')
                                                                <td></td>
                                                                @else
                                                                @csrf
                                                                <td>
                                                                    <div class="w-16 pt-0 mb-3">
                                                                        <x-input class="relative w-full px-2 py-1 text-sm " type="number" name="amount" value="{{$subscription->amount}}"/>
                                                                        </div>
                                                                    </td>
                                                                    @endif
                                                                    <td>
                                                                        {{-- <div class="w-24 pt-0 mb-3">
                                                                            @if ($subscription->billing_type != 'software')
                                                                            <select name="billing_period" required="required" id="{{ $subscription->products->first()->id ?? null}}" class="relative block w-full max-w-lg px-2 py-1 text-sm border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm" >
                                                                                @foreach($subscription->products->first()->supported_billing_cycles as $cycle)
                                                                                <option value="{{ $cycle }}" @if($cycle == $subscription->billing_period) selected @endif>
                                                                                    {{ $cycle }}
                                                                                </option>
                                                                                @endforeach
                                                                            </select>
                                                                            @endif
                                                                        </div> --}}
                                                                    </td>
                                                                    <td class="align-middle">
                                                                        <div class="w-24 pt-0 mb-3">
                                                                            @can('subscription_delete')
                                                                            <div name="status" class="select is-info">
                                                                                <select name="status" class="relative block w-full max-w-lg px-2 py-1 text-sm border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm">
                                                                                    <option  value="1" {{ $subscription->status_id == "1" ? "selected":"" }}> Active</option>
                                                                                    <option  value="2" {{ $subscription->status_id == "2" ? "selected":"" }}> Suspend</option>
                                                                                </select>
                                                                            </div>
                                                                            @endcan
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="inline w-24 pt-0 mb-3">
                                                                            <button type="submit" class="px-4 py-2 mb-1 mr-1 text-xs font-bold text-white uppercase transition-all duration-150 ease-linear bg-indigo-500 rounded shadow outline-none active:bg-indigo-600 hover:shadow-md focus:outline-none" name="scheduled" value="false">Change</button>

                                                                            {{-- @if($subscription->product->productType === 'OnlineServicesNCE' && $subscription->autorenew === 1)
                                                                            <button type="submit" class="px-4 py-2 mb-1 mr-1 text-xs font-bold text-white uppercase transition-all duration-150 ease-linear bg-indigo-800 rounded shadow outline-none active:bg-indigo-600 hover:shadow-md focus:outline-none" name="scheduled" value="true">Change on next renew</button>
                                                                            @endif --}}
                                                                        </div>
                                                                    </td>
                                                                    @if ($subscription->billing_type != 'software')
                                                                        {{-- @foreach ($subscription->products->first()->getaddons()->all() as $item)
                                                                        <tr>
                                                                            <td class="px-2 py-2 text-sm text-gray-500 whitespace-wrap"><strong>Add-on:</strong> {{$item->name}}</td>
                                                                            <td>
                                                                                <div class="w-16 pt-0 mb-3">
                                                                                    <x-input class="relative w-full px-2 py-1 text-sm " type="number" name="amount_addon" value="{{$item->amount}}"/>
                                                                                    </div>
                                                                                </td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>

                                                                            </form>
                                                                        </tr>
                                                                        @endforeach --}}
                                                                    @endif
                                                                </form>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endcan
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4 card-footer">
                        @if ($subscriptions->total() >= '10')
                        {{ $subscriptions->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


