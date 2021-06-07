<div>
    <div x-data="{ resellerOpen: false , isOpen: false }" class="relative z-0 flex-col flex-1 overflow-y-auto">
        <div class="p-4 overflow-hidden bg-white">
            <div class="flex flex-col">
                <div class="flex flex-col items-center justify-between lg:flex-row">
                    <div class="flex items-center">
                        <h4>{{ ucwords(trans_choice('messages.azure_analytic', 2)) }}</h4>
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

                        <div>
                            <a  href="{{ route('customer.create') }}" class="px-2 py-2 ml-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="hidden w-5 h-5 lg:inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                {{ ucwords(trans_choice('messages.create', 1)) }}
                            </a>
                        </div>
                    </div>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.company_name', 1)) }}</th>
                            <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.subscription_name', 1)) }}</th>
                            <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.estimated_cost', 1)) }}</th>
                            <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.budget', 1)) }}</th>
                            <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">{{ ucwords(trans_choice('messages.budget_used%', 1)) }}<i class="mr-1 fa fa-arrow-up"></i></th>
                            <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resourceName as $index => $item)
                        <tr>
                            <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell"><a href="{{ $item->customer->format()['path'] }}">{{$item->customer['company_name']}}</a></td>
                            <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">{{$item->name}}</td>
                            @php
                            $percentage =($item->customer['markup']/100)*$item->azureresources->sum('cost');
                            $markup = $percentage+$item->azureresources->sum('cost');
                            @endphp
                            <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">{{$item->customer->country->currency_symbol}}@money($markup)</td>
                            <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">

                                @if ($editedProductIndex === $index || $editedProductField === $index . '.name')
                                <div>
                                    <input type="text"
                                    @click.away="$wire.editedProductField === '{{ $index }}.budget' ? $wire.saveBudget({{ $index }}) : null"
                                    wire:model.defer="resourceName.{{ $index }}.budget"
                                    class="mt-2 text-sm sm:text-base pl-2 pr-4 rounded-lg border w-full py-2 focus:outline-none focus:border-blue-400 {{ $errors->has('products.' . $index . '.budget') ? 'border-red-500' : 'border-gray-400' }}"
                                    />
                                </div>
                                <div class="text-red-500" wire:loading>
                                    Processing request...
                                </div>
                                @if ($errors->has('products.' . $index . '.budget'))
                                <div class="text-red-500">{{ $errors->first('products.' . $index . '.budget') }}</div>
                                @endif
                                @else
                                <div class="cursor-pointer" wire:click="editProductField({{ $index }}, 'name')">
                                    {{ $item->customer->country->currency_symbol}} {{$item->budget}}
                                </div>
                                @endif
                            </td>

                            <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">
                                @if (($item->calculated/100) < '0.50')
                                <div class="mx-auto mb-0 chart-circle chart-circle-xs chart-circle-primary mt-sm-0 icon-dropshadow-primary" data-value="{{($item->calculated/100)}}" data-thickness="5" data-color="#4454c3">
                                    @else
                                    <div class="mx-auto mb-0 chart-circle chart-circle-xs chart-circle-secondary mt-sm-0 icon-dropshadow-secondary" data-value="{{($item->calculated/100)}}" data-thickness="5" data-color="#f72d66">
                                        @endif
                                        <div class="mx-auto text-center chart-circle-value">{{(int)($item->calculated)}}%</div>
                                    </div>
                                </td>

                                <td class="px-2 py-2 text-sm font-medium text-right whitespace-nowrap">
                                    <div class="z-10">
                                        <button type="button" class="px-1 py-1 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>

                                        <div class="dropdown-menu">
                                            @if($editedProductIndex === $index || (isset($editedProductField) && (int)(explode('.',$editedProductField)[0])===$index))
                                            <a  wire:loading.attr="disabled" color="gray" wire:click.prevent="saveBudget({{$index}})" class="dropdown-item" href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                                Save Budget

                                            </a>
                                            @else
                                            <a  wire:loading.attr="disabled" color="gray" wire:click.prevent="editProduct({{$index}})" class="dropdown-item" href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                                Edit Budget

                                            </a>
                                            @endif

                                            <a class="dropdown-item" href="/analytics/details/{{$item->customer_id}}/{{$item->id}}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                </svg>
                                                View Details
                                            </a>
                                            {{-- <div class="dropdown-divider"></div>
                                            <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">
                                                {{-- <x-a color="gray" href="/analytics/update/{{$item->customer_id}}/{{$item->id}}">Update</x-a> --}}
                                                {{-- <x-a color="blue" href="/analytics/details/{{$item->customer_id}}/{{$item->id}}">View Details</x-a> --}}
                                                @if($editedProductIndex === $index || (isset($editedProductField) && (int)(explode('.',$editedProductField)[0])===$index))
                                                <x-button wire:loading.attr="disabled" color="gray" wire:click.prevent="saveBudget({{$index}})">Save Budget</x-button>
                                                @else
                                                <x-button  wire:loading.attr="disabled" color="gray" wire:click.prevent="editProduct({{$index}})">Edit Budget</x-button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="flex justify-center mt-4">
                                    {{ $resourceName->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
