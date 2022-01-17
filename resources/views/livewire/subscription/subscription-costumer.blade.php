<div>
    <main class="max-w-2xl px-4 py-24 mx-auto sm:px-6 lg:max-w-7xl lg:px-8" aria-labelledby="order-history-heading">
        <div class="max-w-xl">
            <h1 id="order-history-heading" class="text-3xl font-extrabold tracking-tight text-gray-900">{{ ucwords(trans_choice('messages.subscription', 2)) }}</h1>
            {{-- <p class="mt-2 text-sm text-gray-500">Check the status of recent orders, manage returns, and discover similar products.</p> --}}
        </div>

        <div class="grid grid-cols-1 mt-16 gap-x-6 gap-y-10 sm:grid-cols-2 sm:gap-y-16 lg:grid-cols-3 lg:gap-x-8 xl:grid-cols-2">
            @foreach($subscriptions as $key => $subscription)
            <div class="relative group">
                <div class="bg-white border-t border-b border-gray-200 shadow-sm sm:rounded-lg sm:border">
                    <h3 class="sr-only">Order placed on <time datetime="2020-12-22">Dec 22, 2020</time></h3>

                    <div class="flex items-center p-4 border-b border-gray-200 sm:p-6 sm:grid sm:grid-cols-4 sm:gap-x-6">
                        <dl class="grid flex-1 grid-cols-2 text-sm gap-x-6 sm:col-span-3 sm:grid-cols-5 lg:col-span-5">
                            <div class="hidden sm:block">
                                <dt class="font-medium text-gray-900">{{ ucwords(trans_choice('messages.id', 2)) }}</dt>
                                <dd class="mt-1 text-gray-500">
                                    {{$subscription->id}}
                                </dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-900">{{ ucwords(trans_choice('messages.expiration', 2)) }}</dt>
                                <dd class="mt-1 text-gray-500">
                                    <time datetime="2020-12-22">{{$subscription->expiration_data}}</time>
                                </dd>
                            </div>
                            <div>
                                <dt class="font-medium text-gray-900">{{ ucwords(trans_choice('messages.amount', 2)) }}</dt>
                                <dd class="mt-1 text-gray-500">
                                    <time datetime="2020-12-22">{{$subscription->amount}}</time>
                                </dd>
                            </div>
                            <div class="hidden sm:block">
                                <dt class="font-medium text-gray-900">{{ ucwords(trans_choice('messages.billing_cycle', 2)) }}</dt>
                                <dd class="mt-1 text-gray-500">
                                    <time datetime="2020-12-22">{{$subscription->billing_period}}</time>
                                </dd>
                            </div>
                            @if($subscription->products->first()->term)
                            <div class="hidden sm:block">
                                <dt class="font-medium text-gray-900">{{ ucwords(trans_choice('messages.product_term', 1)) }}</dt>
                                <dd class="mt-1 text-gray-500">
                                    <time datetime="2020-12-22">{{$subscription->products->first()->term}}</time>
                                </dd>
                            </div>
                            @endif
                        </dl>
                        <div>
                            <button type="button"  class="px-1 py-1 text-sm font-medium text-gray-700 rounded-md lg:hidden hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg class="w-6 h-6" x-description="Heroicon name: outline/dots-vertical" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                </svg>
                            </button>
                            <div class="dropdown-menu">
                                <a wire:click="edit({{ $subscription->id }})" href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-4">
                                    <x-icon.edit></x-icon.edit>
                                    {{ ucwords(trans_choice('edit', 1)) }}
                                </a>
                                </div>
                            </div>
                        </div>

                        <!-- Products -->
                        <h4 class="sr-only">Items</h4>
                        <ul role="list" class="divide-y divide-gray-200">
                            <li class="p-4 sm:p-6">
                                <div class="flex items-center sm:items-start">
                                    {{-- <div class="flex-shrink-0 w-20 h-20 overflow-hidden bg-gray-200 rounded-lg sm:w-40 sm:h-40">
                                        <img src="https://tailwindui.com/img/ecommerce-images/order-history-page-03-product-03.jpg" alt="Garment bag with two layers of grey and tan zipper pouches for folded shirts and pants." class="object-cover object-center w-full h-full">
                                    </div> --}}
                                    <div class="flex-1 ml-6 text-sm">
                                        <div class="font-medium text-gray-900 sm:flex sm:justify-between">
                                            <h5>
                                                {{$subscription->name}}
                                            </h5>
                                        </div>
                                        <p class="mt-1 text-xs sm:mt-0">
                                            {{$subscription->subscription_id}}
                                        </p>
                                        <p class="hidden text-gray-500 sm:block sm:mt-2">
                                            {{$subscription->product->description}}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-6 sm:flex sm:justify-between">
                                    <div class="flex items-center">

                                        <svg class="w-5 h-5 @if($subscription->status == '1') text-green-500 @else text-red-500 @endif"    x-description="Heroicon name: solid/check-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>

                                        <p class="ml-2 text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.created_at', 1)) }} <time datetime="2021-01-05">{{$subscription->created_at}}</time></p>
                                    </div>

                                    <div class="flex items-center pt-4 mt-6 space-x-4 text-sm font-medium border-t border-gray-200 divide-x divide-gray-200 sm:mt-0 sm:ml-4 sm:border-none sm:pt-0">
                                        <div class="hidden lg:col-span-2 lg:flex lg:items-center lg:justify-end lg:space-x-4">
                                            {{-- <a wire:click="edit({{ $subscription->id }})" href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-4">
                                                <x-icon.edit></x-icon.edit>
                                                {{ ucwords(trans_choice('edit', 1)) }}
                                            </a> --}}
                                            <a href="#"  wire:click="edit({{ $subscription->id }})"   class="flex items-center justify-center bg-white py-2 px-2.5 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <x-icon.edit></x-icon.edit>
                                                {{ ucwords(trans_choice('edit', 1)) }}
                                                <span class="sr-only">AT48441546</span>
                                            </a>
                                            <a href="#" class="flex items-center justify-center bg-white py-2 px-2.5 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <span>View Invoice</span>
                                                <span class="sr-only">for order AT48441546</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
                @endforeach
                {{-- wire:click="changeAmount($event.target.value, '{{$subscription->id}}')" --}}
                <!-- Save Transaction Modal  -->
                <div>
                    @if($editing)
                    <form wire:submit.prevent="save({{$subscription->id}})" class="flex flex-col h-full bg-white divide-y divide-gray-200 shadow-xl">
                        <x-modal.slideout wire:model.defer="showEditModal">
                            <x-slot name="title">{{ ucwords(trans_choice('messages.edit_subscription', 1)) }}
                            </x-slot>
                            <x-slot name="content">
                                <section wire:loading.class.delay="opacity-50" class="dark-grey-text">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="mb-4 col-md-6">
                                                    <x-label for="name" class="">{{ ucwords(trans_choice('messages.name', 1)) }}</x-label>
                                                    <x-input  wire:model="editing.name" type="text" id="name" name="name" class="@error('editing.name') is-invalid @enderror"></x-input>
                                                    @error('editing.name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                </div>
                                                <div class="mb-2 col-md-6">
                                                    <x-label for="editing.amount">{{ ucwords(trans_choice('messages.amount', 1)) }}</x-label>
                                                    <x-input wire:model="editing.amount" type="number" id="editing.amount" name="editing.amount" class="@error('editing.amount') is-invalid @enderror"></x-input>
                                                    @error('editing.amount')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                    <p class="mt-2 text-xs text-gray-500">
                                                       Max: {{$max_quantity-$editing['amount']}}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mt-2 mb-2 col-md-12">
                                                    <x-label for="billing_period">{{ucwords(trans_choice('messages.billing_cycle', 1))}}</x-label>
                                                    <div class="mb-3 input-group">
                                                        @if ($subscription->billing_type != 'software')
                                                        <select wire:model="editing.billing_period" name="billing_period" class="form-control @error('editing.billing_period') is-invalid @enderror" sf-validate="required">
                                                            <option value="{{$editing->billing_period}}">{{$subscription->billing_period}}</option>
                                                            @foreach($subscription->products->first()->supported_billing_cycles as $cycle)
                                                            <option value="{{ $cycle }}" @if($cycle == $subscription->billing_period) selected @endif>
                                                                {{ $cycle }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        @error('editing.billing_period')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mt-2 mb-2 col-md-12">
                                                    <x-label for="billing_period">{{ucwords(trans_choice('messages.autorenew', 1))}}</x-label>
                                                    <div class="mb-3 input-group">
                                                        <x-input.checkbox wire:model="editing.autorenew" ></x-input.checkbox>
                                                        @error('editing.billing_period')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <x-label for="status">{{ ucwords(trans_choice('messages.status', 1)) }}</x-label>
                                                    <div class="form-group">
                                                        @can('subscription_delete')
                                                        <div name="status" class="select is-info">
                                                            <select wire:model="editing.status_id" name="status" class="form-control @error('editing.status') is-invalid @enderror" sf-validate="required">
                                                                <option  value="1" {{ $subscription->status_id == "1" ? "selected":"" }}> {{ucwords(trans_choice('messages.active', 1))}}</option>
                                                                <option  value="2" {{ $subscription->status_id == "2" ? "selected":"" }}> {{ucwords(trans_choice('messages.suspend', 1))}}</option>
                                                            </select>
                                                            @error('editing.status')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                        </div>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="max-w-xl mx-auto bg-white border border-gray-200" x-data="{selected:null}">
                                        <ul class="shadow-box">
                                            <li class="relative border-b border-gray-200">
                                                <button type="button" class="w-full px-8 py-6 text-left" @click="selected !== 1 ? selected = 1 : selected = null">
                                                    <div class="flex items-center justify-between">
                                                        <span>Addons</span>
                                                        <span class="ico-plus">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                </button>
                                                <div class="relative overflow-hidden transition-all duration-700 max-h-0" style="" x-ref="container1" x-bind:style="selected == 1 ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : ''">
                                                    <div class="p-6">
                                                        @if ($subscription->billing_type != 'software')
                                                        @foreach ($subscription->products->first()->getaddons()->all() as $item)
                                                        <tr>
                                                            <td class="px-2 py-2 text-sm text-gray-500 whitespace-wrap"><strong>Add-on:</strong> {{$item->name}}</td>
                                                            <div class="w-56 pt-0 mb-3">
                                                                <div>
                                                                    <div class="flex mt-1 rounded-md shadow-sm">
                                                                        <div class="relative flex items-stretch flex-grow focus-within:z-10">
                                                                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                                            </div>
                                                                            <input  value="{{$item->amount}}" class="block w-full pl-10 border-gray-300 rounded-none focus:ring-indigo-500 focus:border-indigo-500 rounded-l-md sm:text-sm" type="number" name="amount_addon">
                                                                        </div>
                                                                        <button class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-r-md bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                                                            <span>{{$item->unitType}}</span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </tr>
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </section>
                            </x-slot>
                            <x-slot name="footer">
                                <button  wire:loading.class.delay="opacity-50" wire:click="$set('showEditModal', false)" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ucwords(trans_choice('cancel', 1))}}
                                </button>
                                <button wire:loading.class.delay="opacity-50" type="submit" class="inline-flex justify-center px-4 py-2 ml-4 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ucwords(trans_choice('save', 1))}}
                                </button>
                            </x-slot>
                        </x-modal.slideout>
                    </form>
                    @endif
                </div>

            </div>
        </div>
    </main>
</div>
