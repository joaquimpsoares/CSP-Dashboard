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
                                <input wire:model="search" id="search" class="block w-full bg-white py-1.5 pl-10 pr-3 border border-gray-300 rounded-md leading-5 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500 focus:placeholder-gray-500 sm:text-sm" placeholder="Search" type="search" name="search">
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <a onclick="confirm('Are you sure you want to export these Records?') || event.stopImmediatePropagation()"wire:click="exportSelected()" href="#" class="px-2 py-2 ml-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="hidden w-5 h-5 lg:inline" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                        </svg>
                        {{ ucwords(trans_choice('messages.export', 1)) }}
                    </a>
                </div>
            </div>
        </div>
        <div class="mt-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full px-4 py-1 align-middle">
                <div class="overflow-hidden"  x-data="{selected:null}">
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
                            @forelse ($subscriptions as $key => $subscription)
                            <tr class="table-subheader hover:bg-gray-100">
                                <td class="px-2 py-2 text-sm text-gray-500 whitespace-nowrap"><a href="{{route('subscription.show', $subscription->id)}}">{{$subscription['id']}}</a></td>
                                <td class="px-2 py-2 text-sm text-gray-500 whitespace-wrap">{{$subscription->name}}</td>
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
                                <td>
                                    @can('subscription_edit')
                                    <button type="button" class="w-full px-8 py-6 text-left" @click="selected !== {{$key}} ? selected = {{$key}} : selected = null">
                                        Edit
                                    </button>
                                    @endcan
                                </td>
                            </tr>

                            <tr>
                                <div class="relative overflow-hidden transition-all duration-700 max-h-0" style="" x-ref="container1" x-bind:style="selected == {{$key}} ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : ''">
                                        <ul class="divide-y">
                                            <li>
                                                <a href="#" class="block hover:bg-gray-50">
                                                    <form class="form-horizontal form-bordered" method="POST" action="{{ route('subscription.update', $subscription->id) }}">
                                                        @method('PATCH')
                                                        @csrf
                                                        <div>
                                                            <h3 class="font-medium leading-6 text-gray-900">
                                                                {{$subscription->name}}
                                                              </h3>
                                                            <dl class="grid grid-cols-1 gap-5 mt-5 sm:grid-cols-4">
                                                                <div class="px-4 py-5 overflow-hidden sm:p-6">
                                                                    @if ($subscription->billing_type != 'usage' ?? 'software perpetual')
                                                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                                                        Amount
                                                                    </dt>
                                                                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                                                        <x-input class="relative w-full px-2 py-1 text-sm " type="number" name="amount" value="{{$subscription->amount}}"/>
                                                                            @endif
                                                                        </dd>
                                                                    </div>
                                                                    <div class="px-4 py-5 overflow-hidden sm:p-6">
                                                                        @if ($subscription->billing_type != 'usage' ?? 'software perpetual')
                                                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                                                            Billing type
                                                                        </dt>
                                                                        <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                                                            <select name="billing_period" required="required" class="relative block w-full max-w-lg px-2 py-1 text-sm border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm" id="{{ $subscription->products->first()->id }}">
                                                                                @foreach($subscription->products->first()->supported_billing_cycles as $cycle)
                                                                                <option value="{{ $cycle }}" @if($cycle == $subscription->billing_period) selected @endif>
                                                                                    {{ $cycle }}
                                                                                </option>
                                                                                @endforeach
                                                                                @endif
                                                                            </dd>
                                                                        </select>
                                                                    </div>
                                                                    <div class="px-4 py-5 overflow-hidden sm:p-6">
                                                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                                                            status
                                                                        </dt>
                                                                        <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                                                            @can('subscription_delete')
                                                                            <div name="status" class="select is-info">
                                                                                <select name="status" class="relative block w-full max-w-lg px-2 text-sm border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm">
                                                                                    <option  value="1" {{ $subscription->status_id == "1" ? "selected":"" }}> Active</option>
                                                                                    <option  value="2" {{ $subscription->status_id == "2" ? "selected":"" }}> Suspend</option>
                                                                                </select>
                                                                            </div>
                                                                            @endcan
                                                                        </dd>
                                                                    </div>
                                                                    <div class="px-4 py-5 overflow-hidden sm:p-6">
                                                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                                                            status
                                                                        </dt>
                                                                        <dd class="mt-1 text-3xl font-semibold text-gray-900">
                                                                            <div class="w-24 pt-0 mb-3">
                                                                                <button type="submit" class="px-4 py-2 mb-1 mr-1 text-xs font-bold text-white uppercase transition-all duration-150 ease-linear bg-indigo-500 rounded shadow outline-none active:bg-indigo-600 hover:shadow-md focus:outline-none" type="submit">Change</button>
                                                                            </div>
                                                                        </dd>
                                                                    </div>
                                                                </dl>
                                                            </div>
                                                        </form>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-4 card-footer">
                            {{ $subscriptions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>


