<div wire:poll.5s>
    <div x-data="{ resellerOpen: false , isOpen: false }" class="relative z-0 flex-col flex-1 overflow-y-auto">
        <div class="p-4 overflow-hidden bg-white">
            <div class="flex flex-col">
                <div class="flex flex-col items-center justify-between lg:flex-row">
                    <div class="flex items-center">
                        <h4>{{ ucwords(trans_choice('messages.order_table', 2)) }}</h4>
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
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th scope="col" class="hidden px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase lg:table-cell">{{ ucwords(trans_choice('messages.#', 1)) }}</th>
                            <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.user', 1)) }}</th>
                            <th scope="col" class="hidden px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase lg:table-cell">{{ ucwords(trans_choice('messages.company_name', 1)) }}</th>
                            <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase ">{{ ucwords(trans_choice('messages.details', 1)) }}</th>
                            <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase lg:table-cell">{{ ucwords(trans_choice('messages.amount', 1)) }}</th>
                            <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.cost', 1)) }}</th>
                            <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase lg:table-cell">{{ ucwords(trans_choice('messages.status', 1)) }}</th>
                            <th scope="col" class="hidden px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase lg:table-cell">{{ ucwords(trans_choice('messages.created_at', 1)) }}</th>
                            <th scope="col" class="hidden px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase lg:table-cell">{{ ucwords(trans_choice('messages.updated_at', 1)) }}</th>
                            <th scope="col" class="relative hidden px-2 py-2"><span class="sr-only">{{ ucwords(trans_choice('messages.action', 1)) }}</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr class="hover:bg-gray-100" >
                            <td class="hidden px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">{{ $order['id'] }}</td>
                            <td class="px-2 py-2 text-xs font-medium text-gray-900 whitespace-nowrap lg:table-cell">{{ $order['avatar']['email'] }}</td>
                            @if ($order['customer'])
                            <td class="px-2 py-2 text-xs text-gray-500 whitespace-wrap">{{  $order['customer']['company_name'] }}</td>
                            @else
                            <td></td>
                            @endif
                            <td class="hidden px-2 py-2 text-xs text-gray-500 break-words whitespace-wrap lg:table-cell">{{ \Illuminate\Support\Str::limit($order['details'], 100, $end='...') }}</td>
                            @if ($order['orderproducts'])
                            <td class="px-2 py-2 text-xs text-gray-500 whitespace-nowrap">{{ $order['orderproducts']['quantity'] }} </td>
                            @else
                            <td></td>
                            @endif
                            @if ($order['orderproducts'])
                            <td class="px-2 py-2 text-xs text-gray-500 whitespace-nowrap">{{ number_format(($order['orderproducts']['quantity']*$order['orderproducts']['retail_price']) * ($order['orderproducts']['billing_cycle'] === 'annual' ? 12 : 1 ),2) }} </td>
                            @else
                            <td></td>
                            @endif
                            @if ($order['status']['id']==4)
                            <td class="px-2 py-2 text-xs text-gray-500 whitespace-nowrap lg:table-cell">
                                <p><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 capitalize">{{ $order['status']['name'] }}</span></p>
                            </td>
                            @endif
                            @if ($order['status']['id']==1)
                            <td class="px-2 py-2 text-xs text-gray-500 whitespace-nowrap lg:table-cell">
                                <p><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 capitalize">{{ $order['status']['name'] }}</span></p>
                            </td>
                            @endif
                            @if ($order['status']['id']==2)
                            <td class="px-2 py-2 text-xs text-gray-500 whitespace-nowrap lg:table-cell">
                                <p><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 capitalize">{{ $order['status']['name'] }}</span></p>
                            </td>
                            @endif
                            @if ($order['status']['id']==3)
                            <td class="px-2 py-2 text-xs text-gray-500 whitespace-nowrap lg:table-cell">
                                <p><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 capitalize">{{ $order['status']['name'] }}</span></p>
                            </td>
                            @endif
                            <td class="hidden px-2 py-2 text-xs text-gray-500 whitespace-nowrap lg:table-cell">{{ $order['created_at'] }}</td>
                            <td class="hidden px-2 py-2 text-xs text-gray-500 whitespace-nowrap lg:table-cell">{{ $order['updated_at'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">Empty</td>
                        </tr>
                        @endforelse
                        <!-- More people... -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="mt-4 card-footer">
    {{ $orders->links() }}
</div>
</div>
