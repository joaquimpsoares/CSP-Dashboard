
<div @if($customer->microsoftTenantInfo->first())  wire:init="checkQualificationStatus({{ $customer->id }}) @endif">
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>

    <!-- This example requires Tailwind CSS v2.0+ -->
    <div wire:loading wire:target="enable" class="fixed inset-x-0 bottom-0 pb-2 sm:pb-5">
        <div class="px-2 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-2 bg-indigo-600 rounded-lg shadow-lg sm:p-3">
                <div class="flex flex-wrap items-center justify-between">
                    <div class="flex items-center flex-1 w-0">
                        <span class="flex p-2 bg-indigo-800 rounded-lg">
                            <!-- Heroicon name: outline/speakerphone -->
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                            </svg>
                        </span>
                        <p class="ml-3 font-medium text-white truncate">
                            <span class="md:hidden">
                                Enabling Subscription...
                            </span>
                            <span class="hidden md:inline">
                                Enabling Subscription...
                            </span>
                        </p>
                    </div>
                    <div class="flex-shrink-0 order-2 sm:order-3 sm:ml-2">
                        <button type="button" class="flex p-2 -mr-1 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-white">
                            <span class="sr-only">Dismiss</span>
                            <!-- Heroicon name: outline/x -->
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="relative z-0 flex-col flex-1 overflow-y-auto">
        <div class="p-4 overflow-hidden bg-white">
            <div class="lg:flex lg:items-center lg:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        {{$customer->company_name}}
                    </h2>
                    <div class="flex flex-col mt-1 sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                        <div class="flex items-center mt-2 text-sm text-gray-500">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $customer->status->name == 'messages.active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'  }}  capitalize">
                                {{ ucwords(trans_choice($customer->status->name, 1)) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-4 sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
                    <div class="relative inline-block ml-3 text-left">
                    </div>
                    <div x-data="{ open: false }"   @keydown.escape.stop="open = false; focusButton()" class="relative inline-block px-3 mt-6 text-left">
                        <button type="button" class="px-4 py-2 mb-1 mr-1 text-xs font-bold text-white uppercase transition-all duration-150 ease-linear bg-indigo-500 rounded shadow outline-none active:bg-indigo-600 hover:shadow-md focus:outline-none"  x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-2" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()" x-state-description="Current:"bg-gray-100 text-gray-900", Default:"bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900"">
                            <span class="block -mt-px normal-case whitespace-no-wrap" style='margin-top: -1px; font-feature-settings: "pnum"; font-variant: proportional-nums; transition: color 0.24s ease 0s; overflow-wrap: break-word;'>
                                <span class="box-border">
                                    Actions
                                </span>
                            </span>
                        </button>
                        <div x-cloak x-show.transition="open" @click.away="open = false" class="absolute right-0 z-10 w-56 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                            <div class="py-1" role="none">
                                <a href="#" wire:click="edit({{ $customer->id }})" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-4">
                                    <x-icon.edit></x-icon.edit>
                                    {{ ucwords(trans_choice('messages.edit', 1)) }}
                                </a>
                            </div>
                            <div class="py-1" role="none">
                                @canImpersonate
                                @if(!empty($customer->format()['mainUser']))
                                <a href="{{ route('impersonate', $customer->format()['mainUser']['id']) }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-4">
                                    <x-icon.impersonate></x-icon.impersonate>
                                    {{ ucwords(trans_choice('messages.impersonate', 1)) }}
                                </a>
                                @endif
                                @endCanImpersonate
                            </div>
                            <div class="py-1" role="none">
                                @if($customer->status->name == 'messages.active')
                                <a href="#" wire:click="$toggle('showconfirmationModal')" class="block px-4 py-2 text-sm text-red-700" role="menuitem" tabindex="-1" id="menu-item-6">
                                    <x-icon.pause></x-icon.pause>
                                    {{ ucwords(trans_choice('messages.suspend', 1)) }}
                                </a>
                                @endif
                                @if($customer->status->name != 'messages.active')
                                <a href="#" wire:click="enable({{ $customer->id }})" class="block px-4 py-2 text-sm text-green-700" role="menuitem" tabindex="-1" id="menu-item-6">
                                    <x-icon.play></x-icon.play>
                                    {{ ucwords(trans_choice('messages.reactivate', 1)) }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative z-0 flex-col flex-1 overflow-y-auto">
                <!-- Start - Customer Details -->
                <div class="px-0 pt-0 mt-5 break-words border-b">
                    <div class="flex flex-col lg:flex-row">
                        <h4>{{ ucwords(trans_choice('messages.customer_details', 1)) }} </h4>
                        @if(Auth::user()->userlevel->name == "Super Admin" || Auth::user()->userlevel->name == "Provider")
                        <div class="flex items-center mb-4 ml-2 mr-2 text-gray-500">
                            @if($customer->microsoftTenantInfo->first())
                            <a href="https://partner.microsoft.com/commerce/customers/{{$customer->microsoftTenantInfo->first()->tenant_id}}/subscriptions" target="_blank" class="flex items-center text-sm text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                to partner center
                            </a>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
                <div class="grid grid-flow-col grid-cols-3 gap-4">
                    <div>
                        <div class="flex justify-between mt-4 mb-4">
                            <div class="">
                                <dl>
                                    <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.company_name', 1)) }}</dt>
                                        <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{$customer->company_name}}</dd>
                                    </div>
                                    <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.created_at', 1)) }}</dt>
                                        <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ date('j F, Y', strtotime($customer->created_at))}}</dd>
                                    </div>
                                    <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.tenant', 1)) }}</dt>
                                        @if($customer->microsoftTenantInfo->first())
                                        <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            <div class="flex items-center text-sm text-gray-500">
                                                <input id="copy_{{ $customer->microsoftTenantInfo->first()->tenant_domain }}" value="{{$customer->microsoftTenantInfo->first()->tenant_domain}}" aria-invalid="false" readonly="" placeholder="" type="text"
                                                class="relative inline-flex flex-auto px-2 py-1 m-0 font-mono text-xs leading-4 text-left no-underline whitespace-no-wrap align-middle bg-gray-100 border-0 rounded appearance-none select-auto"/>
                                                <span class="text-sm font-medium text-gray-500">
                                                    <button id="myButton" value="copy" onclick="copyToClipboard('copy_{{ $customer->microsoftTenantInfo->first()->tenant_domain }}')" class="inline-flex items-center px-2 overflow-visible font-sans text-sm font-medium text-gray-400 no-underline normal-case bg-transparent border border-0 border-gray-200 rounded-lg cursor-pointer -py-4 focus:shadow-xs focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500 hover:text-gray-600 group">
                                                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" class="transition transform stroke-current" >
                                                            <path d="M12.9975 10.7499L11.7475 10.7499C10.6429 10.7499 9.74747 11.6453 9.74747 12.7499L9.74747 21.2499C9.74747 22.3544 10.6429 23.2499 11.7475 23.2499L20.2475 23.2499C21.352 23.2499 22.2475 22.3544 22.2475 21.2499L22.2475 12.7499C22.2475 11.6453 21.352 10.7499 20.2475 10.7499L18.9975 10.7499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M17.9975 12.2499L13.9975 12.2499C13.4452 12.2499 12.9975 11.8022 12.9975 11.2499L12.9975 9.74988C12.9975 9.19759 13.4452 8.74988 13.9975 8.74988L17.9975 8.74988C18.5498 8.74988 18.9975 9.19759 18.9975 9.74988L18.9975 11.2499C18.9975 11.8022 18.5498 12.2499 17.9975 12.2499Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M13.7475 16.2499L18.2475 16.2499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M13.7475 19.2499L18.2475 19.2499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                    </button>
                                                </span>
                                            </div>
                                        </dd>
                                        @endif
                                    </div>
                                    <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.tenant_id', 1)) }}</dt>
                                        @if($customer->microsoftTenantInfo->first())
                                        <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            <div class="flex items-center text-sm text-gray-500">
                                                <input id="copy_{{ $customer->microsoftTenantInfo->first()->tenant_id }}" value="{{$customer->microsoftTenantInfo->first()->tenant_id}}" aria-invalid="false" readonly="" placeholder="" type="text"
                                                class="relative inline-flex flex-auto px-2 py-1 m-0 font-mono text-xs leading-4 text-left no-underline whitespace-no-wrap align-middle bg-gray-100 border-0 rounded appearance-none select-auto"/>
                                                <span class="text-sm font-medium text-gray-500">
                                                    <button id="myButton" value="copy" onclick="copyToClipboard('copy_{{ $customer->microsoftTenantInfo->first()->tenant_id }}')" class="inline-flex items-center px-2 overflow-visible font-sans text-sm font-medium text-gray-400 no-underline normal-case bg-transparent border border-0 border-gray-200 rounded-lg cursor-pointer -py-4 focus:shadow-xs focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500 hover:text-gray-600 group">
                                                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" class="transition transform stroke-current" >
                                                            <path d="M12.9975 10.7499L11.7475 10.7499C10.6429 10.7499 9.74747 11.6453 9.74747 12.7499L9.74747 21.2499C9.74747 22.3544 10.6429 23.2499 11.7475 23.2499L20.2475 23.2499C21.352 23.2499 22.2475 22.3544 22.2475 21.2499L22.2475 12.7499C22.2475 11.6453 21.352 10.7499 20.2475 10.7499L18.9975 10.7499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M17.9975 12.2499L13.9975 12.2499C13.4452 12.2499 12.9975 11.8022 12.9975 11.2499L12.9975 9.74988C12.9975 9.19759 13.4452 8.74988 13.9975 8.74988L17.9975 8.74988C18.5498 8.74988 18.9975 9.19759 18.9975 9.74988L18.9975 11.2499C18.9975 11.8022 18.5498 12.2499 17.9975 12.2499Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M13.7475 16.2499L18.2475 16.2499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            <path d="M13.7475 19.2499L18.2475 19.2499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </svg>
                                                    </button>
                                                </span>
                                            </div>
                                        </dd>
                                        @endif
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-2 col-start-2 row-start-1">
                        <div>
                            <div class="flex justify-between mt-4 mb-8">
                                <div class="">
                                    <dl>
                                        <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.address', 1)) }}</dt>
                                            <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{strtoupper($customer->address_1)}}</dd>
                                        </div>
                                        <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.city', 1)) }}</dt>
                                            <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{strtoupper($customer->city)}}</dd>
                                        </div>
                                        <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.country', 1)) }}</dt>
                                            <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{strtoupper($customer->country->name)}}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-3 col-start-3 row-start-1">
                        <div>
                            <div class="flex justify-between mt-4 mb-8">
                                <div class="">
                                    <dl>
                                        <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.qualification', 1)) }}</dt>
                                            <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{strtoupper($customer->qualification)}}</dd>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $customer->qualification_status == 'Approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'  }}  capitalize">
                                                {{$customer->qualification_status}}
                                            </span>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End - Customer Details -->

                <!-- Start - Customer Relationship -->
                <div class="px-0 pt-0 mt-5 break-words border-b">
                    <div class="flex flex-col lg:flex-row">
                        <div class="flex items-center">
                            <h4>{{ ucwords(trans_choice('messages.customer_relationship', 1)) }}</h4>
                        </div>
                    </div>
                </div>

                <div class="grid grid-flow-col grid-cols-2 gap-4">
                    <div>
                        <div class="flex justify-between mt-4 mb-8">
                            <div class="">
                                <dl>
                                    <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.company_name', 1)) }}</dt>
                                        <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{$customer->resellers->first()->company_name}}</dd>
                                    </div>
                                    <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.main_contact', 1)) }}</dt>
                                        <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{$customer->resellers->first()->users->first()->name}} {{$customer->resellers->first()->users->first()->last_name}}</dd>
                                    </div>
                                    <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.phone', 1)) }}</dt>
                                        <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{$customer->resellers->first()->users->first()->phone}}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="px-0 pt-0 mt-10 break-words border-b">
                        <div class="flex flex-col lg:flex-row">
                            <div class="flex items-center">
                                <h4>{{ ucwords(trans_choice('messages.subscription', 2)) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                            <div class="overflow-hidden shadow-md sm:rounded-lg">
                                <table class="min-w-full">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                {{ ucwords(trans_choice('messages.name', 2)) }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                {{ ucwords(trans_choice('messages.subscription_id', 1)) }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                {{ ucwords(trans_choice('messages.amount', 2)) }}
                                            </th><th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                {{ ucwords(trans_choice('messages.status', 2)) }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                {{ ucwords(trans_choice('messages.price', 2)) }}
                                            </th><th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                {{ ucwords(trans_choice('messages.total', 1)) }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subscriptions as $key => $subscription)
                                        <tr class="border-b hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700">
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" href="/subscription/{{$subscription->id}}">
                                                    <div class="p-0 mt-px mb-0 ml-px mr-0 pointer-events-auto">
                                                        <span class="inline font-medium text-gray-900">
                                                            {{$subscription->name ?? ''}}
                                                            <span class="inline text-gray-600">
                                                                •
                                                            </span>
                                                        </span>
                                                    </div>
                                                    <div class="p-0 mt-px mb-0 ml-px mr-0 pointer-events-auto">
                                                        <span class="inline text-xs text-gray-600">{{$subscription->product_id}}
                                                        </span>
                                                    </div>

                                                    @if($subscription->orders->first())
                                                    @if($subscription->orders->first()->orderproduct != null)
                                                    <span class="inline text-xs text-gray-600">
                                                        {{$subscription->orders->first()->orderproduct->retail_price}} {{$subscription->currency}} / {{$subscription->billing_period}}
                                                    </span>
                                                    @endif
                                                    @endif
                                                </a>
                                            </td>
                                            @if($subscription->billing_period === "one_time")
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" href="/subscription/{{$subscription->id}}">
                                                </a>
                                            </td>
                                            @else
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                <div class="flex items-center mt-2 text-sm text-gray-500">
                                                    <input id="copy_{{ $subscription->subscription_id }}" value="{{$subscription->subscription_id}}" aria-invalid="false" readonly="" placeholder="" type="text"
                                                    class="relative inline-flex flex-auto px-2 py-1 m-0 font-mono text-xs leading-4 text-left no-underline whitespace-no-wrap align-middle bg-gray-100 border-0 rounded appearance-none select-auto"/>
                                                    <span class="text-sm font-medium text-gray-500">
                                                        <button id="myButton" value="copy" onclick="copyToClipboard('copy_{{ $subscription->subscription_id }}')" class="inline-flex items-center px-2 overflow-visible font-sans text-sm font-medium text-gray-400 no-underline normal-case bg-transparent border border-0 border-gray-200 rounded-lg cursor-pointer -py-4 focus:shadow-xs focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500 hover:text-gray-600 group">
                                                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" class="transition transform stroke-current" >
                                                                <path d="M12.9975 10.7499L11.7475 10.7499C10.6429 10.7499 9.74747 11.6453 9.74747 12.7499L9.74747 21.2499C9.74747 22.3544 10.6429 23.2499 11.7475 23.2499L20.2475 23.2499C21.352 23.2499 22.2475 22.3544 22.2475 21.2499L22.2475 12.7499C22.2475 11.6453 21.352 10.7499 20.2475 10.7499L18.9975 10.7499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M17.9975 12.2499L13.9975 12.2499C13.4452 12.2499 12.9975 11.8022 12.9975 11.2499L12.9975 9.74988C12.9975 9.19759 13.4452 8.74988 13.9975 8.74988L17.9975 8.74988C18.5498 8.74988 18.9975 9.19759 18.9975 9.74988L18.9975 11.2499C18.9975 11.8022 18.5498 12.2499 17.9975 12.2499Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M13.7475 16.2499L18.2475 16.2499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M13.7475 19.2499L18.2475 19.2499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>
                                                        </button>
                                                    </span>
                                                </div>
                                            </td>
                                            @endif
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" href="/subscription/{{$subscription->id}}">
                                                    <span class="inline text-sm font-normal leading-5">
                                                        {{$subscription->amount}}
                                                    </span>
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" href="/subscription/{{$subscription->id}}">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $subscription->status->name == 'messages.active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'  }}  capitalize">
                                                        {{ ucwords(trans_choice($subscription->status->name, 1)) }}
                                                    </span>
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                @if($subscription->orders->first() != null)
                                                @if($subscription->orders->first()->orderproduct != null)
                                                <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" href="/subscription/{{$subscription->id}}">
                                                    <span class="inline text-sm font-normal leading-5">
                                                        {{number_format(($subscription->orders->first()->orderproduct->price*$subscription->amount)*($subscription->billing_period === 'annual' ? 12 : 1 ),2)}} {{$subscription->currency}} / {{$subscription->billing_period}}
                                                    </span>
                                                </a>
                                                @endif
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                @if($subscription->orders->first())
                                            @if($subscription->orders->first()->orderproduct != null)
                                            <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" href="/subscription/{{$subscription->id}}">
                                                <span class="inline text-sm font-normal leading-5">
                                                    {{number_format(($subscription->orders->first()->orderproduct->retail_price*$subscription->amount)*($subscription->billing_period === 'annual' ? 12 : 1 ),2)}} {{$subscription->currency}} / {{$subscription->billing_period}}
                                                </span>
                                            </a>
                                            @endif
                                            @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="p-0 m-0 break-words">
                    <div class="px-0 pt-0 pb-5 m-0">
                        <div class="p-0 m-0 overflow-visible bg-white rounded" style="overflow: visible; outline: 0px; overflow-wrap: break-word;">
                            <div class="px-0 pt-0 mt-10 break-words border-b">
                                <div class="flex flex-col lg:flex-row">
                                    <div class="flex items-center">
                                        <h4>{{ ucwords(trans_choice('messages.subscription', 2)) }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-4 pb-5 m-0">
                                <table class="min-w-full px-4 divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.name', 2)) }}</th>
                                            <th scope="col" class="hidden px-2 py-2 text-xs font-medium tracking-wider text-left te lg:table-cell">  {{ ucwords(trans_choice('messages.subscription_id', 1)) }}</th>
                                            <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.amount', 2)) }}</th>
                                            <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.status', 2)) }}</th>
                                            <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.price', 2)) }}</th>
                                            <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.total', 1)) }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subscriptions as $key => $subscription)
                                        <tr  class="hover:bg-gray-100">
                                            <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-wrap lg:table-cell">
                                                <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" href="/subscription/{{$subscription->id}}">
                                                    <div class="p-0 mt-px mb-0 ml-px mr-0 pointer-events-auto">
                                                        <span class="inline font-medium text-gray-900">
                                                            {{$subscription->name ?? ''}}
                                                            <span class="inline text-gray-600">
                                                                •
                                                            </span>
                                                        </span>
                                                    </div>
                                                    <div class="p-0 mt-px mb-0 ml-px mr-0 pointer-events-auto">
                                                        <span class="inline text-xs text-gray-600">{{$subscription->product_id}}
                                                        </span>
                                                    </div>

                                                    @if($subscription->orders->first())
                                                    @if($subscription->orders->first()->orderproduct != null)
                                                    <span class="inline text-xs text-gray-600">
                                                        {{$subscription->orders->first()->orderproduct->retail_price}} {{$subscription->currency}} / {{$subscription->billing_period}}
                                                    </span>
                                                    @endif
                                                    @endif
                                                </a>
                                            </td>
                                            @if($subscription->billing_period === "one_time")
                                            <th>
                                                <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" href="/subscription/{{$subscription->id}}">
                                                </a>
                                            </th>
                                            @else

                                            <td class="hidden px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">
                                                <div class="flex items-center mt-2 text-sm text-gray-500">
                                                    <input id="copy_{{ $subscription->subscription_id }}" value="{{$subscription->subscription_id}}" aria-invalid="false" readonly="" placeholder="" type="text"
                                                    class="relative inline-flex flex-auto px-2 py-1 m-0 font-mono text-xs leading-4 text-left no-underline whitespace-no-wrap align-middle bg-gray-100 border-0 rounded appearance-none select-auto"/>
                                                    <span class="text-sm font-medium text-gray-500">
                                                        <button id="myButton" value="copy" onclick="copyToClipboard('copy_{{ $subscription->subscription_id }}')" class="inline-flex items-center px-2 overflow-visible font-sans text-sm font-medium text-gray-400 no-underline normal-case bg-transparent border border-0 border-gray-200 rounded-lg cursor-pointer -py-4 focus:shadow-xs focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500 hover:text-gray-600 group">
                                                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" class="transition transform stroke-current" >
                                                                <path d="M12.9975 10.7499L11.7475 10.7499C10.6429 10.7499 9.74747 11.6453 9.74747 12.7499L9.74747 21.2499C9.74747 22.3544 10.6429 23.2499 11.7475 23.2499L20.2475 23.2499C21.352 23.2499 22.2475 22.3544 22.2475 21.2499L22.2475 12.7499C22.2475 11.6453 21.352 10.7499 20.2475 10.7499L18.9975 10.7499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M17.9975 12.2499L13.9975 12.2499C13.4452 12.2499 12.9975 11.8022 12.9975 11.2499L12.9975 9.74988C12.9975 9.19759 13.4452 8.74988 13.9975 8.74988L17.9975 8.74988C18.5498 8.74988 18.9975 9.19759 18.9975 9.74988L18.9975 11.2499C18.9975 11.8022 18.5498 12.2499 17.9975 12.2499Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M13.7475 16.2499L18.2475 16.2499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M13.7475 19.2499L18.2475 19.2499" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>
                                                        </button>
                                                    </span>
                                                </div>
                                            </span>
                                        </td>
                                        @endif
                                        <td class="px-2 py-2 text-sm font-medium text-center text-gray-900 whitespace-wrap lg:table-cell">
                                            <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" href="/subscription/{{$subscription->id}}">
                                                <span class="inline text-sm font-normal leading-5">
                                                    {{$subscription->amount}}
                                                </span>
                                            </a>
                                        </td>
                                        <td class="px-2 py-2 text-sm font-medium text-center text-gray-900 whitespace-wrap lg:table-cell">
                                            <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" href="/subscription/{{$subscription->id}}">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $subscription->status->name == 'messages.active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'  }}  capitalize">
                                                    {{ ucwords(trans_choice($subscription->status->name, 1)) }}
                                                </span>
                                            </a>
                                        </td>
                                        <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-wrap lg:table-cell">
                                            @if($subscription->orders->first() != null)
                                            @if($subscription->orders->first()->orderproduct != null)
                                            <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" href="/subscription/{{$subscription->id}}">
                                                <span class="inline text-sm font-normal leading-5">
                                                    {{number_format(($subscription->orders->first()->orderproduct->price*$subscription->amount)*($subscription->billing_period === 'annual' ? 12 : 1 ),2)}} {{$subscription->currency}} / {{$subscription->billing_period}}
                                                </span>
                                            </a>
                                            @endif
                                            @endif
                                        </td>
                                        <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-wrap lg:table-cell">
                                            @if($subscription->orders->first())
                                            @if($subscription->orders->first()->orderproduct != null)
                                            <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" href="/subscription/{{$subscription->id}}">
                                                <span class="inline text-sm font-normal leading-5">
                                                    {{number_format(($subscription->orders->first()->orderproduct->retail_price*$subscription->amount)*($subscription->billing_period === 'annual' ? 12 : 1 ),2)}} {{$subscription->currency}} / {{$subscription->billing_period}}
                                                </span>
                                            </a>
                                            @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> --}}
            </div>
            <!-- Start - Customer Users -->
            <div class="flex flex-col items-center justify-between lg:flex-row">
                <div class="flex items-center">
                    <h4>{{ ucwords(trans_choice('messages.user', 2)) }}</h4>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <a  href="{{ route('user.create') }}" class="px-2 py-2 ml-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="hidden w-5 h-5 lg:inline" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            {{ ucwords(trans_choice('messages.create', 1)) }}
                        </a>
                    </div>
                </div>
            </div>
            <table class="min-w-full px-4 divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.name', 2)) }}</th>
                        <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.email', 2)) }}</th>
                        <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.status', 2)) }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customer->users as $key => $user)
                    <tr  class="hover:bg-gray-100">
                        <td class="hidden px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">
                            <a href="{{ route('user.edit', $user) }}" class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" >
                                <div class="p-0 mt-px mb-0 ml-px mr-0 pointer-events-auto">
                                    <span class="inline font-medium text-gray-900">
                                        {{$user->name}}
                                        {{$user->last_name}}
                                    </span>
                                </div>
                            </a>
                        </td>
                        <td class="hidden px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">
                            <a href="{{ route('user.edit', $user) }}" class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" >
                                {{$user->email}}
                            </a>
                        </td>
                        <td class="hidden px-2 py-2 text-sm font-medium text-gray-900 whitespace-nowrap lg:table-cell">
                            <a href="{{ route('user.edit', $user) }}" class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" >
                                <p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 capitalize">
                                        {{ ucwords(trans_choice($user->status->name, 1)) }}
                                    </span>
                                </p>
                            </a>
                        </td>
                        <td class="px-2 py-2 text-sm font-medium text-left whitespace-nowrap">
                            <div class="z-10">
                                <button type="button" class="px-1 py-1 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="">
                                        <x-icon.edit class="text-gray-400"/> <span>{{ ucwords(trans_choice('edit', 1)) }}</span>
                                    </a>
                                    <a class="dropdown-item" href="">
                                        <x-icon.trash class="text-gray-400"/> <span>{{ ucwords(trans_choice('delete', 1)) }}</span>
                                    </a>
                                    <a class="dropdown-item" href="">
                                        <x-icon.ban class="text-gray-400"/> <span>{{ ucwords(trans_choice('disable', 1)) }}</span>
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- End - Customer Users -->
    <div>
        <!-- Save Transaction Modal -->
        <form wire:submit.prevent="save({{$customer->id}})">
            <x-modal.slideout wire:model.defer="showEditModal">
                <x-slot name="title">Edit Customer</x-slot>
                <x-slot name="content">
                    <section class="dark-grey-text">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <x-label for="company_name" class="">{{ ucwords(trans_choice('messages.company_name', 1)) }}</x-label>
                                        <x-input  wire:model="editing.company_name" type="text" id="company_name" name="company_name" class="@error('editing.company_name') is-invalid @enderror"></x-input>
                                        @error('editing.company_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="mb-2 col-md-6">
                                        <x-label for="nif">{{ ucwords(trans_choice('messages.nif', 1)) }}</x-label>
                                        <x-input wire:model="editing.nif" type="text" id="nif" name="nif" class="@error('editing.nif') is-invalid @enderror"></x-input>
                                        @error('editing.nif')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-2 col-md-12">
                                        <x-label for="country">{{ucwords(trans_choice('messages.country', 1))}}</x-label>
                                        <div class="mb-3 input-group">
                                            <select wire:model="editing.country_id" name="country_id" class="form-control @error('editing.country_id') is-invalid @enderror" sf-validate="required">
                                                <option value="{{$customer->country->name}}">{{$customer->country->name}}</option>
                                                @foreach ($countries as $key => $country)
                                                <option value="{{$country->id}}">{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('editing.country_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <x-label for="address" class="">{{ucwords(trans_choice('messages.address_1', 1))}}</x-label>
                                    <x-input wire:model="editing.address_1" type="text" id="address_1" name="address_1" class="@error('editing.address_1') is-invalid @enderror" placeholder="1234 Main St"></x-input>
                                    @error('editing.address_1')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="mb-3">
                                    <x-label for="address_2" class="">{{ucwords(trans_choice('messages.address_2', 1))}} (optional)</x-label>
                                    <x-input wire:model="editing.address_2" type="text" id="address_2" name="address_2" class="@error('editing.address_2') is-invalid @enderror" placeholder="Appartment or numer"></x-input>
                                    @error('editing.address_2')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-lg-4 col-md-6">
                                        <x-label for="city" class="">{{ucwords(trans_choice('messages.city', 1))}}</x-label>
                                        <x-input wire:model="editing.city" type="text" id="city" name="city" class=" mb-4 @error('editing.city') is-invalid @enderror"></x-input>
                                        @error('editing.city')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="mb-3 col-lg-4 col-md-6">
                                        <x-label for="state">{{ucwords(trans_choice('messages.state', 1))}}</x-label>
                                        <x-input wire:model="editing.state" name="state" type="text" class="@error('editing.state') is-invalid @enderror" id="state" placeholder=""></x-input>
                                        @error('editing.state')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                    <div class="mb-3 col-lg-4 col-md-6">
                                        <x-label for="zip">{{ucwords(trans_choice('messages.postal_code', 1))}}</x-label>
                                        <x-input wire:model="editing.postal_code" name="postal_code" type="text" class="@error('editing.postal_code') is-invalid @enderror" id="postal_code" placeholder="" required></x-input>
                                        @error('editing.postal_code')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-lg-4 col-md-6">
                                        <x-label for="country">{{ucwords(trans_choice('messages.price_list', 1))}}</x-label>
                                        <div class="mb-3 input-group">
                                            <select wire:model.debounce.500ms="editing.price_list_id" name="price_list_id" class="form-control @error('editing.price_list_id') is-invalid @enderror" sf-validate="required">
                                                @foreach ($customer->resellers->first()->availablePriceLists as $pricelist)
                                                <option value="{{$pricelist->id}}" >{{$pricelist->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('editing.price_list_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div>
                                    <div class="mb-3 col-lg-4 col-md-6">
                                        <x-label for="status">{{ ucwords(trans_choice('messages.status', 1)) }}</x-label>
                                        <select wire:model="editing.status_id" name="status" class="form-control @error('editing.status') is-invalid @enderror" sf-validate="required">
                                            <option value="{{$customer->status->id}}" selected>{{ucwords(trans_choice($customer->status->name, 1))}}</option>
                                            @foreach ($statuses  as $key => $status)
                                            <option value="{{$status->id}}">{{ucwords(trans_choice($status->name, 1))}}</option>
                                            @endforeach
                                        </select>
                                        @error('editing.status')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-lg-4 col-md-6">
                                        <x-label for="markup">{{ ucwords(trans_choice('messages.markup', 1)) }}</x-label>
                                        <div class="relative mt-1 rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">
                                                    %
                                                </span>
                                            </div>
                                            <input value="{{$customer->markup}}" wire:model="editing.markup" type="text" name="editing.marku" id="editing.markup" class="block w-full pr-12 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 pl-7 sm:text-sm" placeholder="00" aria-describedby="price-markup">
                                        </div>
                                        @error('editing.markup')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="mb-3 col-lg-4 col-md-6">
                                        <x-label for="qualification">{{ ucwords(trans_choice('messages.qualification', 1)) }}</x-label>
                                        <select wire:model="editing.qualification" name="qualification" class="form-control @error('editing.qualification') is-invalid @enderror" sf-validate="required">
                                            <option value="none" selected>--Please Select--</option>
                                            <option value="Education">Education</option>
                                        </select>
                                        @error('editing.qualification')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <hr>
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
        </div>

        <form wire:submit.prevent="disable({{$customer->id}})" wire:loading.class.delay="opacity-50">
            <x-modal.confirmation wire:model.defer="showconfirmationModal">
                <x-slot name="title">Disabling Customer</x-slot>
                <x-slot name="content">
                    <p> Are you sure you want to disable <strong class="text-red-400">{{$customer->company_name }}</strong>?</p>
                    <p> <strong>By doing so your customer's subscriptions will be put to disabled  you have 90 days until your customer can loose their information.</strong></p>
                    @foreach($customer->subscriptions as $key => $value)
                    <ul>
                        <li>
                            {{$value->name}}
                        </li>
                    </ul>
                    @endforeach
                </x-slot>
                <x-slot name="footer">
                    <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" @click="open = false">
                        {{ucwords(trans_choice('suspend', 1))}}
                    </button>
                    <a type="button" wire:click="$set('showconfirmationModal', false)" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" @click="open = false">
                        {{ucwords(trans_choice('cancel', 1))}}
                    </a>
                </x-slot>
            </x-modal.confirmation>
        </form>
    </div>
    <script>
        function copyToClipboard(subscription_id) {
            document.getElementById(subscription_id).select();
            document.execCommand('copy');
        }
    </script>
    <script>
        tippy('#myButton', {
            animation: 'fade',
            delay: [0,500],
            trigger: 'click',
            content: "Copied",
        });
    </script>
