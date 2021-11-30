<div>
    @if($subscription->autorenew == 0 && $subscription->status_id == 1)
    <div class="px-4 py-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="p-4 border-l-4 border-yellow-400 bg-yellow-50">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-yellow-400" x-description="Heroicon name: solid/exclamation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            This subscription is set not to auto renew.
                        </p>
                        <p class="text-xs text-yellow-700"> On the {{$subscription->expiration_data}} will be automatically suspended. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if($subscription->products->isNotEmpty())
    @if($subscription->products->where('instance_id', $subscription->instance_id)->first()->upgrade_target_offers != null)
    <div class="px-4 py-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="p-4 border-l-4 border-yellow-400 bg-yellow-50">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-yellow-400" x-description="Heroicon name: solid/exclamation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            This subscription has available upgrades:
                        </p>
                        @foreach($subscription->products->where('instance_id', $subscription->instance_id)->first()->getUpgradeProducts()->all() as $key => $value)
                        <p class="text-xs text-yellow-700"> {{$value->name}}
                        </p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif
    <div class="relative z-0 flex-col flex-1 overflow-y-auto">
        <div class="p-4 overflow-hidden bg-white">
            <div class="flex flex-col items-center justify-between lg:flex-row">
                <div class="flex items-center">
                    <h4>{{ ucwords(trans_choice('messages.subscription', 1)) }}</h4>
                </div>
            </div>
            <div class="flex flex-col items-center justify-between lg:flex-row">
                <div class="flex items-center">
                    <span class="box-border">{{$subscription->customer->company_name}}
                        <span class="text-xl font-normal text-gray-600">on</span>
                        <span class="text-xl font-normal">{{$subscription->name}}</span>
                        <span wire:model="status" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $status == 'messages.active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'  }}  capitalize">
                            {{ ucwords(trans_choice($status, 1)) }}
                        </span>
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <div x-data="{ open: false }"   @keydown.escape.stop="open = false; focusButton()" @click.away="onClickAway($event)" class="relative inline-block px-3 mt-6 text-left">
                            <button type="button" class="px-4 py-2 mb-1 mr-1 text-xs font-bold text-white uppercase transition-all duration-150 ease-linear bg-indigo-500 rounded shadow outline-none active:bg-indigo-600 hover:shadow-md focus:outline-none"  x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-2" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()" x-state-description="Current:"bg-gray-100 text-gray-900", Default:"bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900"">
                                <span class="block -mt-px normal-case whitespace-no-wrap" style='margin-top: -1px; font-feature-settings: "pnum"; font-variant: proportional-nums; transition: color 0.24s ease 0s; overflow-wrap: break-word;'>
                                    <span class="box-border">
                                        {{ ucwords(trans_choice('actions', 1)) }}
                                    </span>
                                </span>
                            </button>
                            <div  x-cloak x-show.transition="open" @click.away="open = false" class="absolute right-0 w-56 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                @if($status != 'messages.canceled')
                                <div class="py-1" role="none">
                                    <a wire:click="edit({{ $subscription->id }})" href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-4">
                                        <x-icon.edit></x-icon.edit>
                                        {{ ucwords(trans_choice('edit', 1)) }}
                                    </a>
                                </div>
                                @endif
                                <div class="py-1" role="none">
                                    @if($status == 'messages.active')
                                    <button wire:click="$toggle('showconfirmationModal')" class="block px-4 py-2 text-sm text-yellow-500" role="menuitem" tabindex="-1" id="menu-item-6">
                                        <x-icon.pause></x-icon.pause>
                                        {{ ucwords(trans_choice('suspend', 1)) }}
                                    </button>
                                    @endif
                                    @if($status != 'messages.canceled')
                                    @if($subscription->status->name != 'messages.active')
                                    <button wire:click="enable({{$subscription->id}})" class="block px-4 py-2 text-sm text-green-700" role="menuitem" tabindex="-1" id="menu-item-6">
                                        <x-icon.play></x-icon.play>
                                        {{ ucwords(trans_choice('enable', 1)) }}
                                    </button>
                                    @endif
                                    @endif
                                    @if($subscription->productnce)
                                    @if($subscription->productnce->IsNCE())
                                    @if($status == 'messages.active')
                                    <button wire:click="$toggle('showcancelconfirmationModal')" class="block px-4 py-2 text-sm text-red-700" role="menuitem" tabindex="-1" id="menu-item-6">
                                        <x-icon.trash></x-icon.trash>
                                        {{ ucwords(trans_choice('cancel', 1)) }}
                                    </button>
                                    @endif
                                    @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-32 p-0 px-1 py-2 m-0 border-r shadow-xs">
                <span class="font-bold">{{ ucwords(trans_choice('messages.subscription_started', 1)) }}</span>
                <div>
                    <span class="text-xs text-gray-500">{{$subscription->created_at}}</span>
                </div>
            </div>

            <div class="px-0 pt-0 mt-10 break-words border-b">
                <div class="flex flex-col lg:flex-row">
                    <div class="flex items-center">
                        <h4>{{ ucwords(trans_choice('messages.subscription_details', 1)) }}</h4>
                    </div>
                </div>
            </div>
            <div class="grid grid-flow-col grid-cols-2 gap-4">
                <div class="mt-4 mb-8">
                    <dl class="">
                        <div class="py-1 sm:py-1 sm:grid sm:grid-cols-5 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.customer', 1)) }}</dt>
                            <dd class="mt-1 text-gray-900 text-xm sm:mt-0 sm:col-span-1">
                                <a href="{{$subscription->customer->format()['path']}}" class="box-border flex p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline focus:shadow-xs focus:no-underline" style="outline: none; font-variant: proportional-nums; overflow-wrap: break-word;">
                                    <div class="box-border relative flex flex-row items-baseline p-0 m-0" style="position: relative; outline: 0px; font-variant: proportional-nums; overflow-wrap: break-word;">
                                        <div class="box-border flex-none p-0 m-0" style="line-height: 20px; font-size: 14px; flex: 0 0 auto; outline: 0px; font-variant: proportional-nums; overflow-wrap: break-word;"></div>
                                        <div class="box-border flex flex-row items-baseline justify-start flex-auto p-0 m-0" style="line-height: 0px; flex: 1 1 auto; outline: 0px; font-variant: proportional-nums; overflow-wrap: break-word;">
                                            <span class="box-border block -mt-px font-medium whitespace-no-wrap hover:text-indigo-900 focus:text-indigo-900" style='margin-top: -1px; font-feature-settings: "pnum"; font-variant: proportional-nums; overflow-wrap: break-word;'>
                                                <div class="box-border p-0 m-0 pointer-events-none" style="pointer-events: none; outline: 0px; font-variant: proportional-nums; overflow-wrap: break-word;">
                                                    <div class="box-border flex flex-row flex-no-wrap items-center justify-start p-0 mb-0 mr-0 -mt-2 -ml-2" style="margin-left: -8px; margin-top: -8px; outline: 0px; font-variant: proportional-nums; overflow-wrap: break-word;">
                                                        <div class="box-border p-0 mt-2 mb-0 ml-2 mr-0 pointer-events-auto" style="pointer-events: auto; outline: 0px; font-variant: proportional-nums; overflow-wrap: break-word;">
                                                            <div aria-hidden="true" class="box-border flex p-0 m-0 bg-no-repeat" style="outline: 0px; font-variant: proportional-nums; overflow-wrap: break-word;">
                                                                <svg aria-hidden="true"  class="box-border" height="12" width="12" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" style="fill: currentcolor; font-variant: proportional-nums; overflow-wrap: break-word;">
                                                                    <path d="M8 11a5.698 5.698 0 0 0 3.9-1.537l1.76.66A3.608 3.608 0 0 1 16 13.5V15a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1v-1.5c0-1.504.933-2.85 2.34-3.378l1.76-.66A5.698 5.698 0 0 0 8 11zM7.804 0h.392a3.5 3.5 0 0 1 3.488 3.79l-.164 1.971a3.532 3.532 0 0 1-7.04 0l-.164-1.97A3.5 3.5 0 0 1 7.804 0z" fill-rule="evenodd" class="box-border" style="font-variant: proportional-nums; overflow-wrap: break-word;"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="box-border p-0 mt-2 mb-0 ml-2 mr-0 pointer-events-auto" style="pointer-events: auto; outline: 0px; font-variant: proportional-nums; overflow-wrap: break-word;">
                                                            <span class="flex-1 w-0 ml-2 text-sm text-gray-900 truncate">
                                                                {{$subscription->customer->company_name}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </dd>
                        </div>
                        <div class="py-1 sm:py-1 sm:grid sm:grid-cols-5 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.created_at', 1)) }}</dt>
                            <dd class="mt-1 text-blue-900 underline text-xm sm:mt-0 sm:col-span-2">{{$subscription->created_at->format('j F, Y')}}</dd>
                        </div>
                        <div class="py-1 sm:py-1 sm:grid sm:grid-cols-5 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.subscription_period', 1)) }}</dt>
                            <dd class="mt-1 text-xm sm:mt-0 sm:col-span-2">
                                <span class="text-blue-900 underline">
                                    {{$subscription->created_at->format('j F, Y')}}
                                </span>
                                <span>
                                    to
                                </span>
                                <span class="text-blue-900 underline ">
                                    {{date('j F, Y', strtotime($subscription->expiration_data))}}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
                <div class="mt-4 mb-8">
                    <dl class="">
                        <div class="py-1 sm:py-1 sm:grid sm:grid-cols-5 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.billing_cycle', 1)) }}</dt>
                            <dd class="mt-1 text-gray-900 text-xm sm:mt-0 sm:col-span-1">
                                {{strtoupper($subscription->billing_period)}}
                            </dd>
                        </div>
                        <div class="py-1 sm:py-1 sm:grid sm:grid-cols-5 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.tenant', 1)) }}</dt>
                            <dd class="mt-1 text-xm sm:mt-0 sm:col-span-2">
                                <div class="relative flex items-center mt-0">
                                    <input id="copy_{{ $subscription->tenant_name }}" value="{{$subscription->tenant_name}}" aria-invalid="false" readonly="" placeholder="" type="text"
                                    class="relative inline-flex flex-auto px-2 py-1 m-0 font-mono text-xs leading-4 text-left no-underline whitespace-no-wrap align-middle bg-gray-100 border-0 rounded appearance-none select-auto"/>
                                    <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
                                        <button value="copy" onclick="copyToClipboard('copy_{{ $subscription->tenant_name }}')" class="inline-flex items-center border border-gray-200 px-2 text-sm font-sans font-medium text-gray-400 inline overflow-visible no-underline normal-case bg-transparent border-0 cursor-pointer focus:shadow-xs rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500 text-gray-400 hover:text-gray-600 group ml-2.5">
                                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" class="transition transform stroke-current" >
                                                <path d="M12.9975 10.7499L11.7475 10.7499C10.6429 10.7499 9.74747 11.6453 9.74747 12.7499L9.74747 21.2499C9.74747 22.3544 10.6429 23.2499 11.7475 23.2499L20.2475 23.2499C21.352 23.2499 22.2475 22.3544 22.2475 21.2499L22.2475 12.7499C22.2475 11.6453 21.352 10.7499 20.2475 10.7499L18.9975 10.7499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M17.9975 12.2499L13.9975 12.2499C13.4452 12.2499 12.9975 11.8022 12.9975 11.2499L12.9975 9.74988C12.9975 9.19759 13.4452 8.74988 13.9975 8.74988L17.9975 8.74988C18.5498 8.74988 18.9975 9.19759 18.9975 9.74988L18.9975 11.2499C18.9975 11.8022 18.5498 12.2499 17.9975 12.2499Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M13.7475 16.2499L18.2475 16.2499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M13.7475 19.2499L18.2475 19.2499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </dd>
                        </div>
                        <div class="py-1 sm:py-1 sm:grid sm:grid-cols-5 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.tenant_id', 1)) }}</dt>
                            <dd class="mt-1 text-xm sm:mt-0 sm:col-span-2">

                                <div class="relative flex items-center mt-0">
                                    <input aria-invalid="false" readonly="" placeholder="" type="text" id="copy_{{ $subscription->customer->microsoftTenantInfo->first()->tenant_id }}"
                                    value="{{$subscription->customer->microsoftTenantInfo->first()->tenant_id}}"
                                    class="relative inline-flex flex-auto px-2 py-1 m-0 font-mono text-xs leading-4 text-left no-underline whitespace-no-wrap align-middle bg-gray-100 border-0 rounded appearance-none select-auto"/>
                                    <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
                                        <button value="copy" onclick="copyToClipboard('copy_{{ $subscription->customer->microsoftTenantInfo->first()->tenant_id }}')" class="inline-flex items-center border border-gray-200 px-2 font-medium text-gray-400 overflow-visible  normal-case bg-transparent  cursor-pointer focus:shadow-xs focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500  font-mono text-xs leading-4 text-left no-underline whitespace-no-wrap align-middle bg-gray-100  rounded appearance-none select-auto  hover:text-gray-600 group ml-2.5">
                                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" class="transition transform stroke-current" >
                                                <path d="M12.9975 10.7499L11.7475 10.7499C10.6429 10.7499 9.74747 11.6453 9.74747 12.7499L9.74747 21.2499C9.74747 22.3544 10.6429 23.2499 11.7475 23.2499L20.2475 23.2499C21.352 23.2499 22.2475 22.3544 22.2475 21.2499L22.2475 12.7499C22.2475 11.6453 21.352 10.7499 20.2475 10.7499L18.9975 10.7499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M17.9975 12.2499L13.9975 12.2499C13.4452 12.2499 12.9975 11.8022 12.9975 11.2499L12.9975 9.74988C12.9975 9.19759 13.4452 8.74988 13.9975 8.74988L17.9975 8.74988C18.5498 8.74988 18.9975 9.19759 18.9975 9.74988L18.9975 11.2499C18.9975 11.8022 18.5498 12.2499 17.9975 12.2499Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M13.7475 16.2499L18.2475 16.2499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                <path d="M13.7475 19.2499L18.2475 19.2499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
            <div class="p-0 m-0 break-words">
                <div class="px-0 pt-0 pb-5 m-0">
                    <div class="p-0 m-0 overflow-visible bg-white rounded" style="overflow: visible; outline: 0px; overflow-wrap: break-word;">
                        <div class="px-0 pt-0 mt-10 break-words border-b">
                            <div class="flex flex-col lg:flex-row">
                                <div class="flex items-center">
                                    <h4>{{ ucwords(trans_choice('messages.price', 2)) }}</h4>
                                </div>
                            </div>
                        </div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.product', 2)) }}</th>
                                    <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.subscription_id', 1)) }}</th>
                                    <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.amount', 2)) }}</th>
                                    <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.total', 1)) }}</th>
                                </tr>
                            </thead>
                            <tbody class="box-border" style="overflow-wrap: break-word;">
                                <tr class="table-subheader hover:bg-gray-100">
                                    <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">
                                        <div class="p-0 mt-px mb-0 ml-px mr-0 pointer-events-auto">
                                            <span class="inline font-medium text-gray-900">
                                                {{$subscription->products->first()->name ?? ''}}
                                                <span class="inline text-gray-600">
                                                    •
                                                </span>
                                                {{$subscription->product_id}}
                                            </span>
                                        </div>
                                        @if($subscription->order->first())
                                        <span class="inline text-xs text-gray-600">
                                            {{$subscription->order->first()->orderproduct->retail_price}} {{$subscription->currency}} / {{$subscription->billing_period}}
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">
                                        <div class="relative flex items-center mt-0">
                                            <input aria-invalid="false" readonly="" placeholder="" type="text" id="copy_{{ $subscription->subscription_id }}"
                                            value="{{$subscription->subscription_id}}"
                                            class="relative inline-flex flex-auto w-1 px-2 py-1 m-0 font-mono text-xs leading-4 text-left no-underline whitespace-no-wrap align-middle bg-gray-100 border-0 rounded appearance-none select-auto group"/>
                                            <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
                                                <button value="copy" onclick="copyToClipboard('copy_{{ $subscription->subscription_id }}')" class="inline-flex items-center border border-gray-200 px-2 font-medium text-gray-400 overflow-visible  normal-case bg-transparent  cursor-pointer focus:shadow-xs focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500  font-mono text-xs leading-4 text-left no-underline whitespace-no-wrap align-middle bg-gray-100  rounded appearance-none select-auto  hover:text-gray-600 group ml-2.5">
                                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" class="transition transform stroke-current" >
                                                        <path d="M12.9975 10.7499L11.7475 10.7499C10.6429 10.7499 9.74747 11.6453 9.74747 12.7499L9.74747 21.2499C9.74747 22.3544 10.6429 23.2499 11.7475 23.2499L20.2475 23.2499C21.352 23.2499 22.2475 22.3544 22.2475 21.2499L22.2475 12.7499C22.2475 11.6453 21.352 10.7499 20.2475 10.7499L18.9975 10.7499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M17.9975 12.2499L13.9975 12.2499C13.4452 12.2499 12.9975 11.8022 12.9975 11.2499L12.9975 9.74988C12.9975 9.19759 13.4452 8.74988 13.9975 8.74988L17.9975 8.74988C18.5498 8.74988 18.9975 9.19759 18.9975 9.74988L18.9975 11.2499C18.9975 11.8022 18.5498 12.2499 17.9975 12.2499Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M13.7475 16.2499L18.2475 16.2499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M13.7475 19.2499L18.2475 19.2499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 text-sm text-gray-500 whitespace-nowrap">
                                        <span class="inline text-sm font-normal leading-5">
                                            {{$subscription->amount}}
                                        </span>
                                    </td>
                                    <td class="px-2 py-2 text-sm text-gray-500 whitespace-nowrap">
                                        @if($subscription->order->first())
                                        <span class="inline text-sm font-normal leading-5">
                                            {{number_format(($subscription->order->first()->orderproduct->retail_price*$subscription->amount)*($subscription->billing_period === 'annual' ? 12 : 1 ),2)}} {{$subscription->currency}} / {{$subscription->billing_period}}
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                                @foreach($subscription->addons as $key => $value)
                                <tr class=" hover:bg-gray-100">
                                    <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">
                                        <div class="p-0 mt-px mb-0 ml-px mr-0 pointer-events-auto">
                                            <span class="inline font-medium text-gray-900">
                                                <strong>Addon:</strong> {{$value->name}}
                                                <span class="inline text-gray-600">
                                                    •
                                                </span>
                                                {{$value->product_id}}
                                            </span>
                                        </div>
                                        @if($subscription->order->first())
                                        <span class="inline text-xs text-gray-600">
                                            {{$subscription->order->first()->orderproduct->retail_price}} {{$subscription->currency}} / {{$subscription->billing_period}}
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">
                                        <div class="relative flex items-center mt-0">
                                            <input aria-invalid="false" readonly="" placeholder="" type="text" id="copy_{{ $subscription->subscription_id }}"
                                            value="{{$subscription->subscription_id}}"
                                            class="relative inline-flex flex-auto w-1 px-2 py-1 m-0 font-mono text-xs leading-4 text-left no-underline whitespace-no-wrap align-middle bg-gray-100 border-0 rounded appearance-none select-auto group"/>
                                            <div class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
                                                <button value="copy" onclick="copyToClipboard('copy_{{ $subscription->subscription_id }}')" class="inline-flex items-center border border-gray-200 px-2 font-medium text-gray-400 overflow-visible  normal-case bg-transparent  cursor-pointer focus:shadow-xs focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500  font-mono text-xs leading-4 text-left no-underline whitespace-no-wrap align-middle bg-gray-100  rounded appearance-none select-auto  hover:text-gray-600 group ml-2.5">
                                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" class="transition transform stroke-current" >
                                                        <path d="M12.9975 10.7499L11.7475 10.7499C10.6429 10.7499 9.74747 11.6453 9.74747 12.7499L9.74747 21.2499C9.74747 22.3544 10.6429 23.2499 11.7475 23.2499L20.2475 23.2499C21.352 23.2499 22.2475 22.3544 22.2475 21.2499L22.2475 12.7499C22.2475 11.6453 21.352 10.7499 20.2475 10.7499L18.9975 10.7499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M17.9975 12.2499L13.9975 12.2499C13.4452 12.2499 12.9975 11.8022 12.9975 11.2499L12.9975 9.74988C12.9975 9.19759 13.4452 8.74988 13.9975 8.74988L17.9975 8.74988C18.5498 8.74988 18.9975 9.19759 18.9975 9.74988L18.9975 11.2499C18.9975 11.8022 18.5498 12.2499 17.9975 12.2499Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M13.7475 16.2499L18.2475 16.2499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        <path d="M13.7475 19.2499L18.2475 19.2499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 text-sm text-gray-500 whitespace-nowrap">
                                        <span class="inline text-sm font-normal leading-5">
                                            {{$value->amount}}
                                        </span>
                                    </td>
                                    <td class="px-2 py-2 text-sm text-gray-500 whitespace-nowrap">
                                        @if($subscription->order->first())
                                        <span class="inline text-sm font-normal leading-5">
                                            {{number_format(($subscription->order->first()->orderproduct->retail_price*$subscription->amount)*($subscription->billing_period === 'annual' ? 12 : 1 ),2)}} {{$subscription->currency}} / {{$subscription->billing_period}}
                                        </span>
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="px-0 pt-0 pb-5 m-0 text-blue-900 break-words">
                    <div class="p-0 m-0 overflow-visible break-words bg-white rounded" style="overflow: visible; outline: 0px; overflow-wrap: break-word;">
                        <div class="px-0 pt-0 mt-10 break-words border-b">
                            <div class="flex flex-col lg:flex-row">
                                <div class="flex items-center">
                                    <h4>{{ ucwords(trans_choice('messages.order', 1)) }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="p-0 m-0">
                            <div class="p-0 m-0">
                                <table class="w-full max-w-full border-collapse" style="border-spacing: 0px; overflow-wrap: break-word;">
                                    <thead class="box-border" style="overflow-wrap: break-word;">
                                        <tr class="h-full text-gray-700" style="overflow-wrap: break-word;"></tr>
                                    </thead>
                                    <tbody class="box-border" style="overflow-wrap: break-word;">
                                        @foreach ($subscription->order as $item)
                                        <tr class="h-full text-gray-700 cursor-pointer hover:bg-gray-100 focus:bg-gray-100" style="overflow-wrap: break-word;">
                                            <td class="w-auto h-px p-0 m-0 text-left whitespace-normal align-top shadow-xs" style="height: 1px; outline: 0px; word-break: break-word; overflow-wrap: break-word;">
                                                <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" href="/events/evt_1IxJAJLscCqGLLUxQpoFVLpD">
                                                    <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                        <span class="inline text-sm font-normal leading-5">
                                                            <span class="box-border" style="font-variant: proportional-nums; word-break: break-word; overflow-wrap: break-word;">
                                                                {{$item->user->name}} {{$item->user->last_name}} / {{$item->details, 'LIKE', '%'.$subscription->name.'%'}}
                                                            </span>
                                                        </span>
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="w-px h-px p-0 m-0 text-right whitespace-normal align-top shadow-xs" style="height: 1px; outline: 0px; word-break: break-word; overflow-wrap: break-word;">
                                                <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" href="/events/evt_1IxJAJLscCqGLLUxQpoFVLpD">
                                                    <div class="h-full p-2 m-0 overflow-auto">
                                                        <span class="inline text-sm font-normal leading-5">
                                                        </span>
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="w-px h-px p-0 m-0 text-right text-gray-500 align-top shadow-xs whitespace-nowrap">
                                                <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" href="/events/evt_1IxJAJLscCqGLLUxQpoFVLpD">
                                                    <div class="h-full py-2 pl-2 pr-1 m-0">
                                                        <span class="inline text-sm font-normal leading-5 text-gray-600">
                                                            <span class="box-border">{{$item->created_at}}</span>
                                                        </span>
                                                    </div>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <a class="font-medium text-indigo-600 no-underline bg-transparent cursor-pointer hover:text-gray-900 hover:no-underline focus:shadow-xs" href="/events?related_object=sub_JDdMJBanJrIVHp">
                                <div class="text-gray-900" style="overflow-wrap: break-word;">
                                    <span class="box-border" style="overflow-wrap: break-word;">
                                        View more events
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form wire:submit.prevent="disable({{$subscription->id}})">
        <x-modal.confirmation wire:model.defer="showconfirmationModal">
            <x-slot name="title">Disabling Subscription</x-slot>
            <x-slot name="content">
                Are you sure you want to suspend this subscription? By doing so you have 90 days to re-activate the subscription.
            </x-slot>
            <x-slot name="footer">
                <button wire:click="$set('showEditModal', false)" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ucwords(trans_choice('messages.cancel', 1))}}
                </button>
                <button type="submit" class="inline-flex justify-center px-4 py-2 ml-4 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ucwords(trans_choice('messages.suspend', 1))}}
                </button>
            </x-slot>
        </x-modal.confirmation>
    </form>
    <form wire:submit.prevent="cancel({{$subscription->id}})">
        <x-modal.confirmation wire:model.defer="showcancelconfirmationModal">

            <x-slot name="title">Canceling Subscription</x-slot>

            <x-slot name="content">
                Are you sure you want to cancel this subscription? all data will be deleted from this subscription.
            </x-slot>

            <x-slot name="footer">
                <button wire:click="$set('showEditModal', false)" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ucwords(trans_choice('messages.cancel', 1))}}
                </button>
                <button type="submit" class="inline-flex justify-center px-4 py-2 ml-4 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ucwords(trans_choice('messages.confirm', 1))}}
                </button>
            </x-slot>
        </x-modal.confirmation>
    </form>
    <!-- Save Transaction Modal -->
    <div>
        @if($editing)
        <form wire:submit.prevent="save({{$subscription->id}})" class="flex flex-col h-full bg-white divide-y divide-gray-200 shadow-xl">
            <x-modal.slideout wire:model.defer="showEditModal">
                <x-slot name="title">{{ ucwords(trans_choice('messages.edit_subscription', 1)) }}</x-slot>
                <x-slot name="content">
                    <section class="dark-grey-text">
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
                                                <option value="{{$subscription->billing_period}}">{{$subscription->billing_period}}</option>
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
                    <button wire:click="$set('showEditModal', false)" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ucwords(trans_choice('cancel', 1))}}
                    </button>
                    <button type="submit" class="inline-flex justify-center px-4 py-2 ml-4 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ucwords(trans_choice('save', 1))}}
                    </button>
                </x-slot>
            </x-modal.slideout>
        </form>
        @endif
    </div>

</div>
<script>
    function copyToClipboard(subscription_id) {
        document.getElementById(subscription_id).select();
        document.execCommand('copy');
    }
</script>

