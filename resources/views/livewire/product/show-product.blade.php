<div>
    <div class="relative z-0 flex-col flex-1 overflow-y-auto">
        <div class="p-4 overflow-hidden bg-white">
            <div class="flex flex-col items-center justify-between lg:flex-row">
                <div class="flex items-center">
                    <h4>{{ ucwords(trans_choice('messages.customer', 1)) }}</h4>
                </div>
            </div>
            <div class="flex flex-col items-center justify-between lg:flex-row">
                <div class="flex items-center">
                    {{-- <span class="box-border">{{$product->company_name}}
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->status->name == 'messages.active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'  }}  capitalize">
                            {{ ucwords(trans_choice($product->status->name, 1)) }}
                        </span> --}}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <div x-data="{ open: false }"   @keydown.escape.stop="open = false; focusButton()" class="relative inline-block px-3 mt-6 text-left">
                            <button type="button" class="px-4 py-2 mb-1 mr-1 text-xs font-bold text-white uppercase transition-all duration-150 ease-linear bg-indigo-500 rounded shadow outline-none active:bg-indigo-600 hover:shadow-md focus:outline-none"  x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-2" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()" x-state-description="Current:"bg-gray-100 text-gray-900", Default:"bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900"">
                                <span class="block -mt-px normal-case whitespace-no-wrap" style='margin-top: -1px; font-feature-settings: "pnum"; font-variant: proportional-nums; transition: color 0.24s ease 0s; overflow-wrap: break-word;'>
                                    <span class="box-border">
                                        Actions
                                    </span>
                                </span>
                            </button>
                            <div  x-cloak x-show.transition="open" @click.away="open = false" class="absolute right-0 w-56 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                <div class="py-1" role="none">
                                    <a href="#" wire:click="edit({{ $product->id }})" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-4">
                                        <x-icon.edit></x-icon.edit>
                                        {{ ucwords(trans_choice('messages.edit', 1)) }}
                                    </a>
                                </div>
                                <div class="py-1" role="none">
                                    {{-- @canImpersonate
                                    @if(!empty($product->format()['mainUser']))
                                    <a href="{{ route('impersonate', $product->format()['mainUser']['id']) }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-4">
                                        <x-icon.impersonate></x-icon.impersonate>
                                        {{ ucwords(trans_choice('messages.impersonate', 1)) }}
                                    </a>
                                    @endif
                                    @endCanImpersonate --}}
                                </div>
                                <div class="py-1" role="none">
                                    {{-- @if($product->status->name == 'messages.active')
                                    <a href="#" wire:click="$toggle('showconfirmationModal')" class="block px-4 py-2 text-sm text-red-700" role="menuitem" tabindex="-1" id="menu-item-6">
                                        <x-icon.pause></x-icon.pause>
                                        {{ ucwords(trans_choice('messages.suspend', 1)) }}
                                    </a>
                                    @endif
                                    @if($product->status->name != 'messages.active')
                                    <a href="#" wire:click="enable({{ $product->id }})" class="block px-4 py-2 text-sm text-green-700" role="menuitem" tabindex="-1" id="menu-item-6">
                                        <x-icon.play></x-icon.play>
                                        {{ ucwords(trans_choice('messages.reactivate', 1)) }}
                                    </a>
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-32 p-0 px-4 py-2 m-0 border-r shadow-xs">
                <span class="font-bold">{{ ucwords(trans_choice('messages.subscription_started', 1)) }}</span>
                <div>
                    <span class="text-xs text-gray-500">{{ date('j F, Y', strtotime($product->created_at))}}</span>
                </div>
            </div>
            <!-- Start - Customer Details -->
            <div class="px-0 pt-0 mt-5 break-words border-b">
                <div class="flex flex-col lg:flex-row">
                    <div class="flex items-center">
                        <h4>{{ ucwords(trans_choice('messages.customer_details', 1)) }}</h4>
                    </div>
                </div>
            </div>
            <div class="grid grid-flow-col grid-cols-2 gap-4">
                <div>
                    <div class="flex justify-between mt-4 mb-4">
                        <div class="">
                            <dl>
                                <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.company_name', 1)) }}</dt>
                                    <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{$product->company_name}}</dd>
                                </div>
                                <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.created_at', 1)) }}</dt>
                                    <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ date('j F, Y', strtotime($product->created_at))}}</dd>
                                </div>
                                <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.tenant', 1)) }}</dt>
                                    {{-- @if($product->microsoftTenantInfo->first())
                                    <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <button value="copy" onclick="copyToClipboard('copy_{{ $product->microsoftTenantInfo->first()->tenant_domain }}')" class="inline-flex p-0 -mt-1 -mb-px -ml-1 overflow-visible no-underline normal-case bg-transparent border-0 cursor-pointer focus:shadow-xs" type="button">
                                            <div class="relative flex flex-row-reverse items-baseline p-0 m-0">
                                                <div class="flex flex-row-reverse items-baseline justify-start flex-auto p-0 m-0">
                                                    <div aria-hidden="true" class="flex p-0 my-0 ml-1 mr-0 text-gray-600">
                                                        <svg aria-hidden="true" class="box-border" height="12" width="12" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7 5h2a3 3 0 0 0 3-3 2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2 3 3 0 0 0 3 3zM6 2a2 2 0 1 1 4 0 1 1 0 0 1-1 1H7a1 1 0 0 1-1-1z" fill-rule="evenodd" class="box-border"></path>
                                                        </svg>
                                                    </div>
                                                    <span >
                                                        <input id="copy_{{ $product->microsoftTenantInfo->first()->tenant_domain ?? ''}}" value="{{ strtoupper($product->microsoftTenantInfo->first()->tenant_domain) }}" class="inline w-48 mr-1 font-mono text-xs font-normal" />
                                                    </span>
                                                </div>
                                            </div>
                                        </button>
                                    </dd>
                                    @endif --}}
                                </div>
                                <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.tenant_id', 1)) }}</dt>
                                    {{-- @if($product->microsoftTenantInfo->first())
                                    <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <button value="copy" onclick="copyToClipboard('copy_{{ $product->microsoftTenantInfo->first()->tenant_id }}')" class="inline-flex p-0 -mt-1 -mb-px -ml-1 overflow-visible no-underline normal-case bg-transparent border-0 cursor-pointer focus:shadow-xs" type="button">
                                            <div class="relative flex flex-row-reverse items-baseline p-0 m-0">
                                                <div class="flex flex-row-reverse items-baseline justify-start flex-auto p-0 m-0">
                                                    <div aria-hidden="true" class="flex p-0 my-0 ml-1 mr-0 text-gray-600">
                                                        <svg aria-hidden="true" class="box-border" height="12" width="12" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7 5h2a3 3 0 0 0 3-3 2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2 3 3 0 0 0 3 3zM6 2a2 2 0 1 1 4 0 1 1 0 0 1-1 1H7a1 1 0 0 1-1-1z" fill-rule="evenodd" class="box-border"></path>
                                                        </svg>
                                                    </div>
                                                    <span >
                                                        <input id="copy_{{ $product->microsoftTenantInfo->first()->tenant_id ?? ''}}" value="{{ strtoupper($product->microsoftTenantInfo->first()->tenant_id) }}" class="inline w-48 mr-1 font-mono text-xs font-normal" />
                                                    </span>
                                                </div>
                                            </div>
                                        </button>
                                    </dd>
                                    @endif --}}
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
                                        <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{strtoupper($product->address_1)}}</dd>
                                    </div>
                                    <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.city', 1)) }}</dt>
                                        <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{strtoupper($product->city)}}</dd>
                                    </div>
                                    <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.country', 1)) }}</dt>
                                        {{-- <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{strtoupper($product->country->name)}}</dd> --}}
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End - Customer Details -->

            <!-- Start - Customer Relationshipt -->
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
                                {{-- <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.company_name', 1)) }}</dt>
                                    <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{$product->resellers->first()->company_name}}</dd>
                                </div>
                                <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.main_contact', 1)) }}</dt>
                                    <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{$product->resellers->first()->users->first()->name}} {{$product->resellers->first()->users->first()->last_name}}</dd>
                                </div>
                                <div class="py-1 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.phone', 1)) }}</dt>
                                    <dd class="text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{$product->resellers->first()->users->first()->phone}}</dd>
                                </div> --}}
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-0 m-0 break-words">
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
                                        <th scope="col" class="hidden px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase lg:table-cell">{{ ucwords(trans_choice('messages.subscription_id', 1)) }}</th>
                                        <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.amount', 2)) }}</th>
                                        <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.price', 2)) }}</th>
                                        <th scope="col" class="px-2 py-2 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">{{ ucwords(trans_choice('messages.total', 1)) }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach($subscriptions as $key => $subscription)
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

                                                @if($subscription->order->first())
                                                @if($subscription->order->first()->orderproduct)
                                                <span class="inline text-xs text-gray-600">
                                                    {{$subscription->order->first()->orderproduct->retail_price}} {{$subscription->currency}} / {{$subscription->billing_period}}
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
                                            {{-- <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" href="/subscription/{{$subscription->id}}"> --}}
                                                {{-- <span class="inline font-medium text-gray-900">
                                                    <input id="copy_{{ $subscription->subscription_id }}" aria-invalid="false" readonly="" placeholder="" type="text" class="relative inline-flex flex-auto px-2 py-1 m-0 font-mono text-xs leading-4 text-left no-underline whitespace-no-wrap align-middle bg-gray-100 border-0 rounded appearance-none select-auto w-76" value="{{$subscription->subscription_id}}" />
                                                </span>
                                                <span class="inline font-medium text-gray-900">
                                                    <button value="copy" onclick="copyToClipboard('copy_{{ $subscription->subscription_id }}')" >
                                                        <div class="relative flex flex-row items-baseline w-full p-0 m-0">
                                                            <div class="flex-none p-0 m-0">
                                                            </div>
                                                            <div class="flex flex-row items-baseline justify-center flex-auto w-full p-0 m-0">
                                                                <div class="px-px py-0 m-0">
                                                                    <div aria-hidden="true" class="flex p-0 mx-0 mb-0 -mt-px text-gray-700">
                                                                        <svg aria-hidden="true" class="box-border" height="12" width="12" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" style="fill: currentcolor; font-variant: tabular-nums; line-height: 0px; overflow-wrap: break-word;">
                                                                            <path d="M7 5h2a3 3 0 0 0 3-3 2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2 3 3 0 0 0 3 3zM6 2a2 2 0 1 1 4 0 1 1 0 0 1-1 1H7a1 1 0 0 1-1-1z" fill-rule="evenodd" class="box-border"></path>
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                                <span class="absolute block w-px h-px -mt-px overflow-hidden normal-case whitespace-no-wrap">
                                                                    <span class="box-border">Copy to clipboard</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </button>
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
                                                @if($subscription->order->first())
                                                <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" href="/subscription/{{$subscription->id}}">
                                                    <span class="inline text-sm font-normal leading-5">
                                                        {{number_format(($subscription->order->first()->orderproduct->price*$subscription->amount)*($subscription->billing_period === 'annual' ? 12 : 1 ),2)}} {{$subscription->currency}} / {{$subscription->billing_period}}
                                                    </span>
                                                    @endif
                                                </a>
                                            </td>
                                            <td class="px-2 py-2 text-sm font-medium text-gray-900 whitespace-wrap lg:table-cell">
                                                @if($subscription->order->first())
                                                <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" href="/subscription/{{$subscription->id}}">
                                                    <span class="inline text-sm font-normal leading-5">
                                                        {{number_format(($subscription->order->first()->orderproduct->retail_price*$subscription->amount)*($subscription->billing_period === 'annual' ? 12 : 1 ),2)}} {{$subscription->currency}} / {{$subscription->billing_period}}
                                                    </span>
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
                        {{-- @foreach($product->users as $key => $user)
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
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
        <!-- End - Customer Users -->
        <div>
            <!-- Save Transaction Modal -->
            {{-- <form wire:submit.prevent="save({{$product->id}})">
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
                                                    <option value="{{$product->country->name}}">{{$product->country->name}}</option>
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
                                        <div class="mb-4 col-lg-4 col-md-6">
                                            <div class="mb-3 input-group">
                                                <div>
                                                    <x-label for="country">{{ucwords(trans_choice('messages.price_list', 1))}}</x-label>
                                                    <div class="mb-3 input-group">
price_list_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                        </div>
                                                        <label for="editing.markup" class="block text-sm font-medium text-gray-700">{{ ucwords(trans_choice('messages.markup', 1)) }}</label>
                                                        <div class="relative mt-1 rounded-md shadow-sm">
                                                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                                <span class="text-gray-500 sm:text-sm">
                                                                    %
                                                                </span>
                                                            </div>
                                                            <input value="{{$product->markup}}" wire:model="editing.markup" type="text" name="editing.marku" id="editing.markup" class="block w-full pr-12 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 pl-7 sm:text-sm" placeholder="00" aria-describedby="price-markup">
                                                        </div>
                                                        @error('editing.markup')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <x-label for="status">{{ ucwords(trans_choice('messages.status', 1)) }}</x-label>
                                                    <div class="form-group">
                                                        <select wire:model="editing.status_id" name="status" class="form-control @error('editing.status') is-invalid @enderror" sf-validate="required">
                                                            <option value="{{$product->status->id}}" selected>{{ucwords(trans_choice($product->status->name, 1))}}</option>
                                                            @foreach ($statuses  as $key => $status)
                                                            <option value="{{$status->id}}">{{ucwords(trans_choice($status->name, 1))}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('editing.status')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
            </div>
            <form wire:submit.prevent="disable({{$product->id}})" wire:loading.class.delay="opacity-50">
                <x-modal.confirmation wire:model.defer="showconfirmationModal">
                    <x-slot name="title">Disabling Customer</x-slot>
                    <x-slot name="content">
                        <p> Are you sure you want to disable <strong class="text-red-400">{{$product->company_name }}</strong>?</p>
                        <p> <strong>By doing so your customer's subscriptions will be put to disabled  you have 90 days until your customer can loose their information.</strong></p>
                        @foreach($product->subscriptions as $key => $value)
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
                    </div>
                </x-slot>

            </x-modal.confirmation>
        </form> --}}
    </div>
    <script>
        function copyToClipboard(subscription_id) {
            document.getElementById(subscription_id).select();
            document.execCommand('copy');
        }
    </script>
