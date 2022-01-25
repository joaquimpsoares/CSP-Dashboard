{{-- <div wire:poll.5s> --}}
    <div>
        <div class="relative z-0 flex-col flex-1 overflow-y-auto">
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
                    <x-tableazure>
                        <x-slot name="head">
                            <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('id')" :direction="$sorts['id'] ?? null">{{ ucwords(trans_choice('messages.#', 2)) }}</x-table.heading>
                            <x-table.heading sortable multi-column wire:click="sortBy('company_name')"  :direction="$sorts['company_name'] ?? null">{{ ucwords(trans_choice('messages.user', 1)) }}</x-table.heading>
                            <x-table.heading  wire:click="sortBy('subscriptions')"         :direction="$sorts['subscriptions'] ?? null">{{ ucwords(trans_choice('messages.company_name', 1)) }}</x-table.heading>
                            <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('details')"       :direction="$sorts['details'] ?? null">{{ ucwords(trans_choice('messages.details', 2)) }}</x-table.heading>
                            <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('status')"       :direction="$sorts['status'] ?? null">{{ ucwords(trans_choice('messages.status', 1)) }}</x-table.heading>
                            </x-slot>
                            <x-slot name="body">
                                @forelse ($orders as $value)
                                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $value['id'] }}">
                                    <x-table.cell visibility='hidden' tablecell='lg:table-cell'>
                                        <a href="#" wire:click="show({{ $value['id'] }})" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                            <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                    {{ $value['id'] }}
                                                </span>
                                            </div>
                                        </a>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <a href="#" wire:click="show({{ $value['id'] }})" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                            <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                    {{ $value->user->email }}
                                                </span>
                                            </div>
                                        </a>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <a href="#" wire:click="show({{ $value['id'] }})" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                            <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                    {{ $value->customer->company_name ?? null}}
                                                </span>
                                            </div>
                                        </a>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <a href="#" wire:click="show({{ $value['id'] }})" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                            <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                    {{ \Illuminate\Support\Str::limit($value['details'], 100, $end='...') }}
                                                </span>
                                            </div>
                                        </a>
                                    </x-table.cell>
                                    <x-table.cell>
                                        <a href="#" wire:click="show({{ $value['id'] }})" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                            <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                @if ($value['status']['id']==4)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 bg-green-100 text-green-800 capitalize">{{ $value['status']['name'] }}</span>
                                                @endif
                                                @if ($value['status']['id']==1)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 bg-green-100 text-green-800 capitalize">{{ $value['status']['name'] }}</span>
                                                @endif
                                                @if ($value['status']['id']==3)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 bg-gray-100 text-gray-800 capitalize">{{ $value['status']['name'] }}</span>
                                                @endif
                                                @if ($value['status']['id']==2)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 bg-yellow-100 text-yellow-800 capitalize">{{ $value['status']['name'] }}</span>
                                                @endif
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
                                                <a wire:click="show({{ $value['id'] }})" class="dropdown-item" href="#">
                                                    <x-icon.show></x-icon.show>
                                                    {{ ucwords(trans_choice('messages.show', 1)) }}
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
                                            <span class="py-8 text-xl font-medium text-cool-gray-400">No Order found...</span>
                                        </div>
                                    </x-table.cell>
                                </x-table.row>
                                @endforelse
                            </x-slot>
                        </x-tableazure>
                        <div>
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
            @if($order)
            <x-modal.slideout wire:model.defer="showEditModal">
                <x-slot name="title">{{ ucwords(trans_choice('messages.order', 1)) }} ID {{$order->id}}</x-slot>
                <x-slot name="content">
                    <section class="dark-grey-text">
                        <div class="row">
                            <div class="col-md-12">
                                @foreach($order->products as $key => $value)
                                <div class="space-y-24">
                                    <div class="text-sm sm:grid-rows-1 sm:grid-cols-12 sm:gap-x-6 md:gap-x-8 lg:gap-x-8">
                                        <div class="mt-6 sm:col-span-7 sm:mt-0 md:row-end-1">
                                            <h3 class="text-lg font-medium text-gray-900">
                                                <a href="#">{{$value->name}}</a>
                                            </h3>
                                            <p class="mt-1 font-medium text-gray-900">{{ ucwords(trans_choice('messages.license', 2)) }} {{ $value->orderproduct->quantity }}</p>

                                            <p class="mt-1 font-medium text-gray-900">{{ ucwords(trans_choice('messages.price', 1)) }} {{ number_format(($value->orderproduct->quantity*$value->orderproduct['retail_price']) * ($value->orderproduct['billing_cycle'] === 'annual' ? 12 : 1 ),2) }}</p>
                                            <h3 class="text-lg font-medium text-gray-900">{{ ucwords(trans_choice('messages.order_details', 2)) }}</h3>
                                            <textarea disabled name="" id="" cols="70" rows="5">{{$order->details}}</textarea>
                                        </div>
                                        <div class="sm:col-span-12 md:col-span-7">
                                            <dl class="grid grid-cols-1 py-8 border-b border-gray-200 gap-y-8 sm:grid-cols-2 sm:gap-x-6 sm:py-6 md:py-10">
                                                <div>
                                                    <dt class="font-medium text-gray-900">{{$order->customer['company_name']}}</dt>
                                                    <dd class="mt-3 text-gray-500">
                                                        <span class="block">{{$order->customer['address_1']}}</span>
                                                        <span class="block">{{$order->customer['postal_code']}}</span>
                                                        <span class="block">{{$order->customer['country']['name']}}</span>
                                                    </dd>
                                                </div>
                                                <div>
                                                    <dt class="font-medium text-gray-900">{{ ucwords(trans_choice('messages.agreement_signed', 1)) }}</dt>
                                                    <dd class="mt-3 text-gray-500">
                                                        <span class="block">{{$order->agreement_firstname}}</span>
                                                        <span class="block">{{$order->agreement_lastname}}</span>
                                                        <span class="block">{{$order->agreement_email}}</span>
                                                        <span class="block">{{$order->agreement_phone}}</span>
                                                    </dd>
                                                </div>
                                            </dl>
                                            {{-- <p class="mt-6 font-medium text-gray-900 md:mt-10">Processing on <time datetime="2021-03-24">March 24, 2021</time></p>
                                            <div class="mt-6">
                                                <div class="overflow-hidden bg-gray-200 rounded-full">
                                                    <div class="h-2 bg-indigo-600 rounded-full" style="width: calc((1 * 2 + 1) / 8 * 100%);"></div>
                                                </div>
                                                <div class="hidden grid-cols-4 mt-6 font-medium text-gray-600 sm:grid">
                                                    <div class="text-indigo-600">Order placed</div>
                                                    <div class="text-center text-indigo-600">Processing</div>
                                                    <div class="text-center">Shipped</div>
                                                    <div class="text-right">Delivered</div>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </section>
                </x-slot>
                <x-slot name="footer">
                    <button wire:click="$set('showEditModal', false)" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ucwords(trans_choice('cancel', 1))}}
                    </button>
                    {{-- <button type="submit" class="inline-flex justify-center px-4 py-2 ml-4 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ucwords(trans_choice('save', 1))}}
                    </button> --}}
                </x-slot>
            </x-modal.slideout>
            @endif
        </div>
    </div>

