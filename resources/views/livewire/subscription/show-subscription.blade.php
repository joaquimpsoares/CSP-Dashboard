<div wire:init="getSubscription({{ $subscription->id }})">
    @if($subscription->IsMigrated() )
    @if($subscription->productonce->IsNCE() )
    <div wire:init="CheckMigrationSubscription({{ $subscription->id }})">
        @endif
        @endif
        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <script src="https://unpkg.com/tippy.js@6"></script>
        @if($subscription->autorenew == 0 && $subscription->status_id == 1)
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="relative z-10 mt-2 ml-2 mr-2 bg-indigo-600 rounded">
            <div class="px-3 py-2 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="pr-16 sm:text-center sm:px-16">
                    <p class="mt-3 font-medium text-white">
                        <span class="md:hidden">
                            This subscription will expire on the {{$subscription->expiration_data}}
                        </span>
                        <span class="hidden md:inline">
                            This subscription will expire on the {{$subscription->expiration_data}} it will be automatically suspended.
                        </span>
                    </p>
                </div>
            </div>
        </div>
        @endif
        <div wire:init="validateisEligible({{ $subscription->id }})">
            <div class="relative z-0 flex-col flex-1 overflow-y-auto">
                <div class="p-4 overflow-hidden bg-white">
                    <div class="lg:flex lg:items-center lg:justify-between">
                        <div class="flex-1 min-w-0">
                            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                                {{$subscription->name}}
                            </h2>
                            <div class="flex flex-col mt-1 sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                                <div class="flex items-center mt-2 text-sm text-gray-500">
                                    <span wire:model="status" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $status == 'messages.active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'  }}  capitalize">
                                        {{ ucwords(trans_choice($status, 1)) }}
                                    </span>
                                </div>
                                @if($subscription->IsMigrated() )
                                <div class="flex items-center mt-2 text-sm text-gray-500">
                                    <span wire:model="status" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 capitalize">
                                        {{ ucwords(trans_choice('migrated', 2)) }}
                                    </span>
                                </div>
                                @endif
                                @if($subscription->product->IsNce())
                                <div class="flex items-center mt-2 text-sm text-gray-500">
                                    <span class="flex-shrink-0 inline-block px-2 py-0.5 ml-1 text-gray-600 text-xs font-medium bg-blue-300 rounded-full">{{ ucwords(trans_choice('messages.nce', 1)) }}</span>
                                </div>
                                @endif
                                @if($subscription->product->IsPerpetual())
                                <div class="flex items-center mt-2 text-sm text-gray-500">
                                    <span class="flex-shrink-0 inline-block px-2 py-0.5 ml-1 text-gray-600 text-xs font-medium bg-blue-300 rounded-full">{{ ucwords(trans_choice('messages.perpetual_software', 1)) }}</span>
                                </div>
                                @endif
                                <div class="flex items-center mt-2 text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" x-description="Heroicon name: solid/calendar" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ ucwords(trans_choice('expire', 2)) }} {{$subscription->expiration_data}}
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-4 sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:justify-start">
                            <div class="relative inline-block ml-3 text-left">
                            </div>
                            <div x-data="{ open: false }"   @keydown.escape.stop="open = false; focusButton()" @click.away="onClickAway($event)" class="relative inline-block px-3 mt-6 text-left">
                                <button type="button" class="px-4 py-2 mb-1 mr-1 text-xs font-bold text-white uppercase transition-all duration-150 ease-linear bg-indigo-500 rounded shadow outline-none active:bg-indigo-600 hover:shadow-md focus:outline-none"  x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-2" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()" x-state-description="Current:"bg-gray-100 text-gray-900", Default:"bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900"">
                                    <span class="block -mt-px normal-case whitespace-no-wrap" style='margin-top: -1px; font-feature-settings: "pnum"; font-variant: proportional-nums; transition: color 0.24s ease 0s; overflow-wrap: break-word;'>
                                        <span class="box-border">
                                            {{ ucwords(trans_choice('actions', 1)) }}
                                        </span>
                                    </span>
                                </button>
                                <div  x-cloak x-show.transition="open" @click.away="open = false" class="absolute right-0 z-10 w-56 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                    @if($status != 'messages.canceled' && $status != 'messages.inactive' && !$subscription->product->IsPerpetual())
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
                                        @if($subscription->productonce->IsNCE() || $subscription->product->IsPerpetual())
                                        @if($status == 'messages.active')
                                        <button wire:click="$toggle('showcancelconfirmationModal', 'checkCancelationWindow')" class="block px-4 py-2 text-sm text-red-700" role="menuitem" tabindex="-1" id="menu-item-6">
                                            <x-icon.stop></x-icon.stop>
                                            {{ ucwords(trans_choice('cancel', 1)) }}
                                        </button>
                                        @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($subscription->migration)
                    <button wire:click="CheckMigrationSubscription({{$subscription->id}})" type="button" class="inline-flex items-center px-4 py-2 text-sm font-semibold leading-6 text-white bg-indigo-500 rounded-md shadow" >
                        Check migration
                    </button>
                    @endif
                    @if($subscription->status->id == 1)

                    @if($subscription->billing_type == 'license')
                    @if (!$subscription->productonce->isNCE())
                    <div class="px-0 pt-0 mt-10 break-words border-b">
                        <div class="flex flex-col lg:flex-row">
                            <div class="flex items-center">
                                <h4>Migrate Subscription to NCE </h4>
                            </div>
                        </div>
                    </div>
                    <form wire:submit.prevent="migrateToMCE({{$subscription->id}},{{Auth::user()}})">
                        <div class="grid grid-flow-col grid-cols-2 gap-4">
                            <div class="mt-4 mb-8">
                                <div class="w-auto p-0 m-0">
                                    @if($isLoading == true)
                                    <button type="button" class="inline-flex items-center px-4 py-2 text-sm font-semibold leading-6 text-white bg-indigo-500 rounded-md shadow cursor-wait" disabled="">
                                        <svg class="w-5 h-5 mr-3 -ml-1 text-white motion-reduce:hidden animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Checking migration...
                                    </button>
                                    @else
                                    @if($subscription->productonce->is_perpetual == false)
                                    @if($tt->has('isEligible') ?? $tt['isEligible'] == true)
                                    <div class=" focus:border-transparent">
                                        <a href="https://docs.microsoft.com/en-us/partner-center/migrate-subscriptions-to-new-commerce#ineligible-subscriptions" target="_blank" class="box-border p-0 leading-5 text-blue-700 no-underline bg-transparent cursor-pointer focus:border-transparent focus:text-blue-700 hover:text-blue-900 hover:underline" style="min-width: 0px; overflow: initial;">
                                            Learn more about migrating subscriptions
                                        </a>
                                        <div class="bg-white ">
                                            <ul class="">
                                                <li class="relative " x-data="{selected:null}">
                                                    <button type="button" class="inline-flex items-center px-4 py-2 mt-3 text-sm font-semibold leading-6 text-white bg-indigo-500 rounded-md shadow cursor-wait"" @click="selected !== 1 ? selected = 1 : selected = null">
                                                        <div class="ml-3 text-base text-white">
                                                            Migrate to New Commerce Experience
                                                        </div>
                                                    </button>
                                                    <div class="relative overflow-hidden transition-all duration-700 max-h-0" style="" x-ref="container1" x-bind:style="selected == 1 ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : ''">
                                                        <div class="p-6">
                                                            <section class="dark-grey-text">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            <div class="mb-2 col-md-4">
                                                                                <x-label for="editing.amount">{{ ucwords(trans_choice('messages.amount', 1)) }}</x-label>
                                                                                <p class="mt-2 text-xs text-gray-500">
                                                                                    <strong>current Seats:</strong>
                                                                                    {{$subscription->amount}}
                                                                                </p>
                                                                                <x-input wire:model="amount" type="number" id="amount" class="@error('amount') is-invalid @enderror">{{$subscription->amount}}</x-input>
                                                                                @error('amount')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="mt-2 mb-2 col-md-4">
                                                                                <x-label for="term">{{ucwords(trans_choice('messages.product_term', 1))}}</x-label>
                                                                                <p class="mt-2 text-xs text-gray-500">
                                                                                    <strong>Current Term:</strong>
                                                                                    {{$subscription->term}}
                                                                                </p>
                                                                                <select wire:model="term" name="term" class="form-control @error('term') is-invalid @enderror" sf-validate="required">
                                                                                    <option value={{$subscription->term}}>No Change</option>
                                                                                    <option value="p1m">Monthly</option>
                                                                                    <option value="p1y">Annual</option>
                                                                                </select>
                                                                                @error('term')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror

                                                                            </div>
                                                                        </div>
                                                                        @if($term == "p1y")
                                                                        <div class="row">
                                                                            <div class="mt-2 mb-2 col-md-4">
                                                                                <x-label for="billing_period">{{ucwords(trans_choice('messages.billing_cycle', 1))}}</x-label>
                                                                                <p class="mt-2 text-xs text-gray-500">
                                                                                    <strong>Current Billing Cycle:</strong>{{$subscription->billing_period}}
                                                                                </p>
                                                                                <select wire:model="billing_period" name="billing_period" class="form-control @error('billing_period') is-invalid @enderror" sf-validate="required">
                                                                                    <option value={{$subscription->billing_period}}>No Change</option>
                                                                                    <option value="monthly">Monthly</option>
                                                                                    <option value="annual">Annual</option>
                                                                                </select>
                                                                                @error('billing_period')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                                            </div>
                                                                        </div>
                                                                        @endif
                                                                        <div class="row">
                                                                            <div class="mt-2 mb-2 col-md-12">
                                                                                <x-label for="newterm">{{ucwords(trans_choice('messages.start_new_term', 1))}}</x-label>
                                                                                <div class="mb-3 input-group">
                                                                                    <x-input.checkbox wire:model="newterm"></x-input.checkbox>
                                                                                    @error('newterm')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div wire:loading>
                                                                            <button wire:loading type="submit" class="inline-flex justify-center px-4 py-2 ml-4 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                                                <svg class="w-5 h-5 text-white motion-reduce:hidden animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                                                </svg>
                                                                            </button>
                                                                        </div>
                                                                        <div wire:loading.remove>
                                                                            <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                                                {{ucwords(trans_choice('accept', 1))}}
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    @else
                                    <div class="bg-white border border-gray-200 ">
                                        <ul class="shadow-box">
                                            <li class="relative border-b border-gray-200" x-data="{selected:null}">
                                                <button type="button" class="w-full px-8 py-6 -ml-1 text-left" @click="selected !== 1 ? selected = 1 : selected = null">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex">
                                                            <div class="flex-shrink-0">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                            </div>
                                                            <div class="ml-3 text-base text-gray-500">
                                                                Migration
                                                            </div>
                                                        </div>
                                                    </div>
                                                </button>
                                                <div class="relative overflow-hidden transition-all duration-700 max-h-0" style="" x-ref="container1" x-bind:style="selected == 1 ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : ''">
                                                    <div class="p-6">
                                                        <p>{{$tt['errors'][0]['description'] ?? $tt['description'] ?? $tt['message'] }}</p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    @endif
                                    @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>

                    @else
                    <div class="px-0 pt-0 mt-10 break-words border-b">
                        <div class="flex flex-col lg:flex-row">
                            <div class="flex items-center">
                                <h4>Schedule Renewall</h4>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-flow-col grid-cols-2 gap-4 ml-7">
                        <div class="mt-4 mb-8">
                            <div class="w-auto p-0 m-0">
                                <div class="box-border focus:border-transparent">
                                    <div style="display:flex" class="box-border flex leading-5 focus:border-transparent">
                                        <span class="box-border relative inline-block pt-2 text-xl not-italic font-normal leading-none align-baseline focus:border-transparent" >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </span>
                                        <button @if($autorenew == false) disabled @endif wire:click="manageSchedule({{$subscription->id}})" class="{{ $autorenew == false ? 'text-gray-400 cursor-not-allowed' : 'bg-yellow-100 text-black-800'  }} box-border relative inline-block max-w-full py-2 m-0 mt-1 overflow-hidden font-semibold leading-none text-center whitespace-no-wrap align-middle bg-white border-2 border-transparent border-solid rounded-sm disabled:cursor-not-allowed disabled:opacity-75 focus:bg-black focus:border-white hover:bg-black hover:border-white">
                                            Manage renewall
                                        </button>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
                @endif
                @endif
                @endif

                <div class="px-0 pt-0 mt-2 break-words border-b">
                    <div class="flex flex-col lg:flex-row">
                        <div class="flex items-center">
                            <h4>{{ ucwords(trans_choice('messages.subscription_details', 1)) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="grid grid-flow-col grid-cols-2 gap-4">
                    <div class="mt-4">
                        <div class="px-0 py-0 sm:p-0">
                            <dl class="">
                                <div class="py-0 sm:py-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        {{ ucwords(trans_choice('messages.customer', 1)) }}
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <a href="{{$subscription->customer->format()['path']}}" >
                                            {{$subscription->customer->company_name}}
                                        </a>
                                    </dd>
                                </div>
                                <div class="py-0 sm:py-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        {{ ucwords(trans_choice('messages.created_at', 1)) }}
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{$subscription->created_at->format('j F, Y')}}
                                    </dd>
                                </div>
                                <div class="py-0 sm:py-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        {{ ucwords(trans_choice('messages.subscription_period', 1)) }}
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
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
                    </div>
                    <div class="mt-4">
                        <div class="px-0 py-0 sm:p-0">
                            <dl class="">
                                <div class="py-0 sm:py-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        {{ ucwords(trans_choice('messages.billing_cycle', 1)) }}
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{strtoupper($subscription->billing_period)}}
                                    </dd>
                                </div>

                                <div class="py-0 sm:py-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        {{ ucwords(trans_choice('messages.product_term', 1)) }}
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{strtoupper($subscription->term)}}
                                    </dd>
                                </div>
                                <div class="py-0 sm:py-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        {{ ucwords(trans_choice('messages.tenant', 1)) }}
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <div class="flex items-center mt-0 text-sm text-gray-500">
                                            <input id="copy_{{ $subscription->tenant_name }}" value="{{$subscription->tenant_name}}" aria-invalid="false" readonly="" placeholder="" type="text"
                                            class="relative inline-flex px-2 py-1 font-mono text-xs leading-4 text-left no-underline whitespace-no-wrap align-middle bg-gray-100 border-0 rounded appearance-none select-auto"/>
                                            <span class="text-smtext-gray-500">
                                                <button id="myButton" value="copy" onclick="copyToClipboard('copy_{{ $subscription->tenant_name }}')" class="inline-flex items-center px-2 overflow-visible font-sans text-sm font-medium text-gray-400 no-underline normal-case bg-transparent border border-0 border-gray-200 rounded-lg cursor-pointer -py-4 focus:shadow-xs focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500 hover:text-gray-600 group">
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
                                </div>
                                <div class="py-0 sm:py-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">
                                        {{ ucwords(trans_choice('messages.tenant_id', 1)) }}
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <div class="flex items-center mt-0 text-sm text-gray-500">
                                            <input id="copy_{{ $subscription->customer->microsoftTenantInfo->first()->tenant_id }}" value="{{$subscription->customer->microsoftTenantInfo->first()->tenant_id}}" aria-invalid="false" readonly="" placeholder="" type="text"
                                            class="relative inline-flex px-2 py-1 font-mono text-xs leading-4 text-left no-underline whitespace-no-wrap align-middle bg-gray-100 border-0 rounded appearance-none select-auto"/>
                                            <span class="text-sm font-medium text-gray-500">
                                                <button id="myButton" value="copy" onclick="copyToClipboard('copy_{{ $subscription->customer->microsoftTenantInfo->first()->tenant_id }}')" class="inline-flex items-center px-2 overflow-visible font-sans text-sm font-medium text-gray-400 no-underline normal-case bg-transparent border border-0 border-gray-200 rounded-lg cursor-pointer -py-4 focus:shadow-xs focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500 hover:text-gray-600 group">
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
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="p-0 m-0 break-words">
                    <div class="px-0 pt-0 pb-5 m-0">
                        <div class="p-0 m-0 overflow-visible bg-white rounded" style="overflow: visible; outline: 0px; overflow-wrap: break-word;">
                            <div class="px-0 pt-0 mt-2 break-words border-b">
                                <div class="flex flex-col lg:flex-row">
                                    <div class="flex items-center">
                                        <h4>{{ ucwords(trans_choice('messages.price', 2)) }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                                        <div class="overflow-hidden shadow-md sm:rounded-lg">
                                            <table class="min-w-full">
                                                <thead class="bg-gray-50 dark:bg-gray-700">
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                            {{ ucwords(trans_choice('messages.product', 2)) }}
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                            {{ ucwords(trans_choice('messages.subscription_id', 1)) }}
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                            {{ ucwords(trans_choice('messages.amount', 2)) }}
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                                            {{ ucwords(trans_choice('messages.total', 1)) }}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Product 1 -->
                                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                            <div class="p-0 mt-px mb-0 ml-px mr-0 pointer-events-auto">
                                                                <span class="inline font-medium text-gray-900">
                                                                    {{$subscription->products->first()->name ?? ''}}
                                                                    <span class="inline text-gray-600">
                                                                        •
                                                                    </span>
                                                                    {{$subscription->product_id}}
                                                                </span>
                                                            </div>
                                                            @if($subscription->orders->first() != null)
                                                            @if($subscription->orders->first()->orderproduct != null)
                                                            <span class="inline text-xs text-gray-600">
                                                                {{$subscription->orders->first()->orderproduct->retail_price}} {{$subscription->currency}} / {{$subscription->billing_period}}
                                                            </span>
                                                            @endif
                                                            @endif
                                                        </td>
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
                                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                            {{$subscription->amount}}
                                                        </td>
                                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">
                                                            @if($subscription->orders->first() != null)
                                                            @if($subscription->orders->first()->orderproduct != null)
                                                            @if($subscription->product->IsPerpetual())
                                                            <span class="inline text-sm font-normal leading-5">
                                                                {{number_format(($subscription->orders->first()->orderproduct->retail_price*$subscription->amount))}} {{$subscription->currency}} / {{$subscription->billing_period}}
                                                            </span>
                                                            @else
                                                            <span class="inline text-sm font-normal leading-5">
                                                                {{number_format(($subscription->orders->first()->orderproduct->retail_price*$subscription->amount)*($subscription->billing_period === 'annual' ? 12 : 1 ),2)}} {{$subscription->currency}} / {{$subscription->billing_period}}
                                                            </span>
                                                            @endif
                                                            @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-0 pt-0 pb-5 m-0 text-blue-900 break-words">
                        <div class="p-0 m-0 overflow-visible break-words bg-white rounded" style="overflow: visible; outline: 0px; overflow-wrap: break-word;">
                            <div class="px-0 pt-0 mt-2 break-words border-b">
                                <div class="flex flex-col lg:flex-row">
                                    <div class="flex items-center">
                                        <h4>{{ ucwords(trans_choice('messages.order', 1)) }}</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="ml-6">
                                <div class="mt-4 mb-8"><ol class="relative border-l border-gray-200 dark:border-gray-700">
                                    @foreach ($subscription->orders->sortByDesc('id') as $item)
                                    <li class="mb-10 ml-6">
                                        <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-200 rounded-full -left-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                                            <svg class="w-3 h-3 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                        </span>
                                        {{-- <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900 dark:text-white">{{$subscription->name}} <span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 ml-3">Latest</span></h3> --}}
                                        <time class="block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{$item->created_at}}</time>
                                        <p class="mb-3 text-base font-normal text-gray-500 dark:text-gray-400">{{$item->details}}</p>
                                    </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                        <a class="font-medium text-indigo-600 no-underline bg-transparent cursor-pointer hover:text-gray-900 hover:no-underline focus:shadow-xs" href="/order">
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
<div>
    <form wire:submit.prevent="disable({{$subscription->id}})">
        <x-modal.confirmation wire:model.defer="showconfirmationModal">
            <x-slot name="title">Disabling Subscription</x-slot>
            <x-slot name="content">
                Are you sure you want to suspend this subscription? By doing so you have 90 days to re-activate the subscription.
            </x-slot>
            <x-slot name="footer">
                <button wire:click="$set('showconfirmationModal', false)" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
                Are you sure you want to cancel this subscription? All data will be deleted from this subscription.
            </x-slot>
            <x-slot name="footer">
                <button wire:click="$set('showcancelconfirmationModal', false)" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ucwords(trans_choice('messages.cancel', 1))}}
                </button>
                <button type="submit" class="inline-flex justify-center px-4 py-2 ml-4 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ucwords(trans_choice('messages.are_you_sure', 2))}}
                </button>
            </x-slot>
        </x-modal.confirmation>
    </form>
    <form @if($ScheduleEdit == false) wire:submit.prevent="save({{$subscription->id}})" @else wire:submit.prevent="saveScheduled({{$subscription->id}})" @endif class="flex flex-col h-full bg-white divide-y divide-gray-200 shadow-xl">
        <x-modal.slideout wire:model.defer="showEditModal">
            <x-slot name="title">@if($ScheduleEdit == true){{ ucwords(trans_choice('messages.schedule_subscription', 1)) }}
                <p class="text-sm text-gray-500">
                    Changes take effect upon subscription renewal date:
                    <strong>{{date('M d, Y', strtotime($subscription->expiration_data))}}.</strong>
                    <br>
                    For SKU upgrades, if the quantity doesn't change, licenses will be assigned automatically.
                    <br>
                    Otherwise, you will need to manually assign licenses.
                    @else{{ ucwords(trans_choice('messages.edit_subscription', 1)) }}@endif
                </x-slot>
                @if($ScheduleEdit == false)
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
                                        @if($showEditModal == true)

                                        @if($editing->amount <= 0)
                                        @php
                                        $editing->amount = 1;
                                        @endphp
                                        @endif
                                        @endif
                                        <x-input wire:dirty wire:model="editing.amount" type="number" id="editing.amount" class="@error('editing.amount') is-invalid @enderror"></x-input>
                                        @error('editing.amount')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        <p class="mt-2 text-xs text-gray-500">
                                            <strong>Seats Limit:</strong>  @if($showEditModal == true)
                                            {{$max_quantity-$editing->amount}}
                                            @endif
                                        </p>
                                        @if($subscription->productonce != null)
                                        @if($subscription->productonce->IsNCE())
                                        <p class="-mt-3 text-xs text-gray-500 ">
                                            <strong>Important:</strong> You can only reduce the seat quantity within the cancellation window.
                                        </p>
                                        @endif
                                        @endif
                                    </div>
                                </div>
                                @if($subscription->productonce != null)
                                @if($subscription->productonce->IsNCE())
                                @if($subscription->refundableQuantity)
                                <div class="row">
                                    <div class="mt-2 mb-2 col-md-12">
                                        <div class="bg-white border border-gray-200 ">
                                            <ul class="shadow-box">
                                                <li class="relative border-b border-gray-200" x-data="{selected:null}">
                                                    <button type="button" class="w-full px-8 py-6 -ml-1 text-left" @click="selected !== 1 ? selected = 1 : selected = null">
                                                        <div class="flex items-center justify-between">
                                                            <div class="flex">
                                                                <div class="flex-shrink-0">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                </div>
                                                                <div class="ml-3 text-base text-gray-500">
                                                                    Seats allowed to change
                                                                </div>
                                                            </div>
                                                        </button>
                                                        <div class="relative overflow-hidden transition-all duration-700 max-h-0" style="" x-ref="container1" x-bind:style="selected == 1 ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : ''">
                                                            <div class="p-6">
                                                                @if($subscription->refundableQuantity['0'])
                                                                @foreach ($subscription->refundableQuantity as $item)
                                                                <span class="text-xs text-gray-500">Total Quantity: {{$item['totalQuantity']}}</span>
                                                                @foreach ($item['details'] as $item)
                                                                <ul>
                                                                    <li>Allowed to change {{$item['quantity']}} seats By {{date('j F, H:m', strtotime($item['allowedUntilDateTime']))}}  GMT+1 </li>
                                                                </ul>
                                                                @endforeach
                                                                @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endif
                                    @endif

                                    <div class="row">
                                        <div class="mt-2 mb-2 col-md-12">
                                            <x-label for="billing_period">{{ucwords(trans_choice('messages.billing_cycle', 1))}}</x-label>
                                            <div class="mb-3 input-group">
                                                @if ($subscription->billing_type != 'software')
                                                <select wire:model="editing.billing_period" name="billing_period" class="form-control @error('editing.billing_period') is-invalid @enderror" sf-validate="required">
                                                    <option value="{{$subscription->billing_period}}">{{$subscription->billing_period}}</option>
                                                    @foreach($subscription->product->supported_billing_cycles as $cycle)
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
                                    @if($subscription->productonce != null)
                                    @if($subscription->productonce->IsNCE())
                                    @if($subscription->term == "P1Y")
                                    @foreach($subscription->productonce->terms[0] as $cycle)
                                    @endforeach
                                    <div class="row">
                                        <div class="mt-2 mb-2 col-md-12">
                                            <x-label for="billing_period">{{ucwords(trans_choice('messages.product_term', 1))}}</x-label>
                                            <div class="mb-3 input-group">
                                                @if ($subscription->billing_type != 'software')
                                                <select @if($subscription->term == "P1Y") disabled @endif wire:model="editing.billing_period" name="billing_period" class="form-control @error('editing.billing_period') is-invalid @enderror" sf-validate="required">
                                                    <option value="{{$subscription->term}}">{{$subscription->term}}</option>
                                                    @foreach($subscription->productonce->terms as $cycle)
                                                    <option value="{{ $cycle['duration'] }}" @if($cycle == $subscription->term) selected @endif>
                                                        {{ $cycle['duration'] }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('editing.billing_period')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endif
                                    @endif
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
                        </section>
                    </x-slot>
                    @else
                    {{-- This is Schedule --}}
                    <x-slot name="content">
                        <section class="dark-grey-text">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="p-6">
                                        <section class="dark-grey-text">
                                            <div class="row">
                                                <div class="mb-2 col-md-6">
                                                    <x-label for="status">{{ ucwords(trans_choice('messages.upgradeOffers', 1)) }}</x-label>
                                                    @if($subscription->changes_on_renew != null)
                                                    <select wire:model="upgradeOfferselected" name="upgradeOfferselected" class="form-control "required>
                                                        <option value="no change">no change</option>
                                                        <option value="{{ $upgradeOfferselected }}" >
                                                            {{ $upgradeOfferselected }}
                                                        </option>
                                                    </select>
                                                    @else
                                                    <select wire:model="upgradeOfferselected" name="upgradeOfferselected" class="form-control "required>
                                                        <option value="no change">no change</option>
                                                        @foreach($upgradeOffers as $key => $value)
                                                        <option value="{{ $value['sku'] }}" >
                                                            {{ $value['name'] }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @endif
                                                </div>
                                                <div class="mb-2 col-md-6">
                                                    <x-label for="editing.amount">{{ ucwords(trans_choice('messages.amount', 1)) }}
                                                    </x-label>
                                                    <x-input wire:model="quantity" type="number" id="quantity" class="@error('quantity') is-invalid @enderror"></x-input>
                                                    <p class="mt-2 text-xs text-gray-500">
                                                        <strong>current Seats:</strong>
                                                        {{$subscription->amount}}
                                                    </p>
                                                    <p class="-mt-3 text-xs text-gray-500">
                                                        <strong>Limits:</strong>
                                                        @if($showEditModal == true)
                                                        {{$max_quantity-$quantity}}
                                                        @endif
                                                    </p>
                                                    @error('quantity')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mb-2 col-md-6">
                                                    <x-label for="term">{{ucwords(trans_choice('messages.product_term', 1))}}</x-label>
                                                    <p class="mt-2 text-xs text-gray-500">
                                                        <strong>Current Term:</strong>
                                                        {{$subscription->term}}
                                                    </p>
                                                    <select wire:model="term" name="term" class="form-control @error('term') is-invalid @enderror" @if($subscription->term == "P1Y") disabled @endif sf-validate="required">
                                                        <option value={{$subscription->term}}>No Change</option>
                                                        @if($subscription->term == "P1M")
                                                        <option value="p1y">Annual</option>
                                                        @else
                                                        <option value="p1m">Monthly</option>
                                                        @endif
                                                    </select>
                                                    @error('term')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                </div>
                                                <div class="mb-2 col-md-6">
                                                    @if($subscription->term == "P1Y" || $subscription->term == "P1M")
                                                    <x-label for="billing_period">{{ucwords(trans_choice('messages.billing_cycle', 1))}}</x-label>
                                                    <p class="mt-2 text-xs text-gray-500">
                                                        <strong>Current Billing Cycle:</strong> {{$subscription->billing_period}}
                                                    </p>
                                                    <select wire:model="billing_period" name="billing_period" class="form-control @error('billing_period') is-invalid @enderror" sf-validate="required">
                                                        <option value={{$subscription->billing_period}}>No Change</option>
                                                        @if($subscription->term == "P1M")
                                                        <option value="annual">Annual</option>
                                                        @else
                                                        <option value="monthly">Monthly</option>
                                                        @endif
                                                    </select>
                                                    @error('billing_period')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                    @endif
                                                </div>
                                                <div class="mt-4 mb-2 col-md-12">
                                                    <div class="mt-4 bg-white shadow sm:rounded-lg">
                                                        <div class="px-4 py-4 sm:p-6">
                                                            <h3 class="text-lg font-medium leading-6 text-gray-900">Remove Schedule</h3>
                                                            <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                                                                <div class="max-w-xl text-sm text-gray-500">
                                                                    <p>This action will remove current schedule settings</p>
                                                                </div>
                                                                <div class="sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center">
                                                                    <button wire:click="removeScheduled({{ $subscription->id }})" type="button" class="inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">Remove</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </x-slot>
                    @endif
                    <x-slot name="footer">
                        <div wire:loading>
                            <button wire:loading type="submit" class="inline-flex justify-center px-4 py-2 ml-4 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="w-5 h-5 text-white motion-reduce:hidden animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                        <div wire:loading.remove>
                            <button wire:click="$set('showEditModal', false)" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ucwords(trans_choice('cancel', 1))}}
                            </button>
                            <button type="submit" class="inline-flex justify-center px-4 py-2 ml-4 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ucwords(trans_choice('save', 1))}}
                            </button>
                        </div>
                    </x-slot>
                </x-modal.slideout>
            </form>
        </div>
    </div>
</div>
<script>
    function copyToClipboard(subscription_id) {
        document.getElementById(subscription_id).select();
        document.execCommand('copy');1
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
