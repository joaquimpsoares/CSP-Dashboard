<div>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <div class="mx-auto md:max-w-5xl pt-14">
        <div class="relative z-0 flex-col flex-1 overflow-y-auto">
            <div class="p-4 overflow-hidden bg-white">
                <div class="lg:flex lg:items-center lg:justify-between">
                    <div class="flex-1 min-w-0">
                        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                            {{$reseller->company_name}}
                            <span wire:loading>
                                <x-bladewind.spinner size="small"/>
                            </span>
                        </h2>
                        <div class="flex flex-col mt-1 mb-5 sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                            <div class="flex items-center mt-2 text-sm text-gray-500">
                                <div class="flex items-center mt-2 text-sm text-gray-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $reseller->status->name == 'messages.active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'  }}  capitalize">
                                        {{ ucwords(trans_choice($reseller->status->name, 1)) }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center mt-2 text-sm text-gray-500">
                                <div class="flex items-center mt-2 text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" x-description="Heroicon name: solid/calendar" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ ucwords(trans_choice('messages.created_at', 2)) }} {{$reseller->created_at->format('j F, Y')}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <div x-data="{ open: false }"   @keydown.escape.stop="open = false; focusButton()" class="relative inline-block px-3 mt-6 text-left">
                                <button type="button" class="px-4 py-2 mb-1 mr-1 text-xs font-bold text-white uppercase transition-all duration-150 ease-linear bg-indigo-500 rounded shadow outline-none active:bg-indigo-600 hover:shadow-md focus:outline-none"  x-state:on="Current" x-state:off="Default" aria-controls="sub-menu-2" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()" x-state-description="Current:"bg-gray-100 text-gray-900", Default:"bg-white text-gray-600 hover:bg-gray-50 hover:text-gray-900"">
                                    <span class="block -mt-px normal-case whitespace-no-wrap" style='margin-top: -1px; font-feature-settings: "pnum"; font-variant: proportional-nums; transition: color 0.24s ease 0s; overflow-wrap: break-word;'>
                                        <span class="box-border">
                                            {{ ucwords(trans_choice('messages.actions', 1)) }}
                                        </span>
                                    </span>
                                </button>
                                <div  x-cloak x-show.transition="open" @click.away="open = false" class="absolute right-0 w-56 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                    <div class="py-1" role="none">
                                        <span>
                                            <a href="#" wire:click="edit({{ $reseller->id }})" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-4">
                                                <x-icon.edit></x-icon.edit>
                                                {{ ucwords(trans_choice('messages.edit', 1)) }}
                                            </a>
                                        </span>
                                    </div>
                                    <div class="py-1" role="none">
                                        @canImpersonate
                                        @if(!empty($reseller->format()['mainUser']))
                                        <a href="{{ route('impersonate', $reseller->format()['mainUser']['id']) }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-4">
                                            <x-icon.impersonate></x-icon.impersonate>
                                            {{ ucwords(trans_choice('messages.impersonate', 1)) }}
                                        </a>
                                        @endif
                                        @endCanImpersonate
                                    </div>
                                    <div class="py-1" role="none">
                                        @if($reseller->status->name == 'messages.active')
                                        <a href="#" wire:click="$toggle('showconfirmationModal')" class="block px-4 py-2 text-sm text-red-700" role="menuitem" tabindex="-1" id="menu-item-6">
                                            <x-icon.pause></x-icon.pause>
                                            {{ ucwords(trans_choice('messages.suspend', 1)) }}
                                        </a>
                                        @endif
                                        @if($reseller->status->name != 'messages.active')
                                        <a type="button" wire:click="enable({{ $reseller->id }})" class="block px-4 py-2 text-sm text-green-700" role="menuitem" tabindex="-1" id="menu-item-6">
                                            <x-icon.play></x-icon.play>
                                            {{ ucwords(trans_choice('messages.reactivate', 1)) }}

                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Start Reseller Details -->
                <x-bladewind.card  title="{{ ucwords(trans_choice('messages.reseller_details', 1)) }}">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.company_name', 1)) }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{$reseller->company_name}}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.address', 1)) }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{strtoupper($reseller->address_1)}}
                            </dd>
                        </div>

                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.city', 1)) }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{$reseller->city}}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.mpnid', 1)) }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ ($reseller->mpnid)}}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">{{ ucwords(trans_choice('messages.country', 1)) }}</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{$reseller->country->name}}
                            </dd>
                        </div>
                    </dl>
                </x-bladewind.card>
                <!-- End Reseller Details -->

                <!-- Start relationship -->
                <x-bladewind.card  title="{{ ucwords(trans_choice('messages.provider_relationship', 1)) }}" subtitle="{{$reseller->provider->first()->company_name}}" url="{{$reseller->provider->first()->format()['path']}}">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dd class="mt-1 text-sm text-gray-900">
                                <x-bladewind.contact-card
                                name="{{$reseller->provider->first()->users->first()->name}}"
                                mobile="{{$reseller->provider->first()->users->first()->phone}}"
                                image="{{$reseller->provider->first()->users->first()->avatar}}"
                                email="{{$reseller->provider->first()->users->first()->email}}">
                            </x-bladewind.contact-card>
                        </dd>
                    </div>
                </dl>
            </x-bladewind.card>
            <!-- End relationship -->


            {{-- <!-- Start statistics -->
                <div>
                    <dl class="grid grid-cols-1 gap-5 mt-5 sm:grid-cols-3">
                        <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">{{ ucwords(trans_choice('messages.active_subscriptions', 1)) }}</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{$reseller->customers->subscriptions->where('status_id', 1)->count()}}</dd>
                        </div>
                        <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">{{ ucwords(trans_choice('messages.total_subscriptions', 1)) }}</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{$reseller->customer->subscriptions->count()}}</dd>
                        </div>
                        <div class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6">
                            <dt class="text-sm font-medium text-gray-500 truncate">{{ ucwords(trans_choice('messages.active_licenses', 1)) }}</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{$reseller->customer->subscriptions->where('status_id', 1)->sum('amount')}}</dd>
                        </div>
                    </dl>
                </div>
                <!-- End statistics --> --}}

                <!-- Start customer table -->
                <x-bladewind.card  title="{{ ucwords(trans_choice('messages.customer', 1)) }}">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">{{ ucwords(trans_choice('messages.name', 2)) }}</th>
                                <th scope="col" class="hidden px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400 lg:table-cell">{{ ucwords(trans_choice('messages.subscription', 2)) }}</th>
                                <th scope="col" class="hidden px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400 sm:table-cell">{{ ucwords(trans_choice('messages.license', 1)) }}</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">{{ ucwords(trans_choice('messages.tenant', 2)) }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($reseller->customers as $key => $customers)
                            @foreach($customers->subscriptions->groupby('customer_id') as $subscription)
                            <tr>
                                <td class="w-full py-4 pl-4 pr-3 text-sm font-medium text-gray-900 max-w-0 sm:w-auto sm:max-w-none sm:pl-6">
                                    <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" href="{{$subscription->first()->customer->format()['path']}}">
                                        <div class="p-0 mt-px mb-0 ml-px mr-0 pointer-events-auto">
                                            <span class="inline font-medium text-gray-900">
                                                @php
                                                $subscription->map(function ($item) {
                                                    foreach ($item->customer as $customer) {
                                                        $item['company_name'] = $item->customer->company_name;
                                                    }
                                                    return $item;
                                                });
                                                @endphp
                                                {{$subscription->first()->company_name}}
                                            </span>
                                        </div>
                                    </a>
                                </td>
                                <td class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell">
                                    <a class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline"href="{{$subscription->first()->customer->format()['path']}}">
                                        <div class="p-0 mt-px mb-0 ml-px mr-0 pointer-events-auto">
                                            <span class="inline font-medium text-gray-900">
                                                {{$subscription->count()}}
                                            </span>
                                        </div>
                                    </a>
                                </td>
                                <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">
                                    <a  href="{{$subscription->first()->customer->format()['path']}}" class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline">
                                        <span class="inline font-medium text-gray-900">
                                            {{$subscription->sum('amount')}}
                                        </span>
                                    </a>
                                </td>
                                <td class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <input id="copy_{{  $subscription->first()->tenant_name }}" value="{{ $subscription->first()->tenant_name}}" aria-invalid="false" readonly="" placeholder="" type="text"
                                        class="relative inline-flex flex-auto px-2 py-1 m-0 font-mono text-xs leading-4 text-left no-underline whitespace-no-wrap align-middle bg-gray-100 border-0 rounded appearance-none select-auto"/>
                                        <span class="text-sm font-medium text-gray-500">
                                            <button id="myButton" value="copy" onclick="copyToClipboard('copy_{{  $subscription->first()->tenant_name }}')" class="inline-flex items-center px-2 overflow-visible font-sans text-sm font-medium text-gray-400 no-underline normal-case bg-transparent border border-0 border-gray-200 rounded-lg cursor-pointer -py-4 focus:shadow-xs focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500 hover:text-gray-600 group">
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
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </x-bladewind.card>
                <!-- End customer table -->

                <!-- Start users table -->
                <x-bladewind.card  title="{{ ucwords(trans_choice('messages.user', 1)) }}" button='New' button_function="addUser({{ $reseller->id }})">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">{{ ucwords(trans_choice('messages.name', 2)) }}</th>
                                <th scope="col" class="hidden px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400 lg:table-cell">{{ ucwords(trans_choice('messages.email', 2)) }}</th>
                                <th scope="col" class="hidden px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400 sm:table-cell">{{ ucwords(trans_choice('messages.status', 1)) }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reseller->users as $key => $user)
                            <tr  class="hover:bg-gray-100">
                                <td class="w-full py-4 pl-4 pr-3 text-sm font-medium text-gray-900 max-w-0 sm:w-auto sm:max-w-none sm:pl-6">
                                    <a href="{{ route('user.edit', $user) }}" class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" >
                                        <div class="p-0 mt-px mb-0 ml-px mr-0 pointer-events-auto">
                                            <span class="inline font-medium text-gray-900">
                                                {{$user->name}}
                                                {{$user->last_name}}
                                            </span>
                                        </div>
                                    </a>
                                </td>
                                <td class="hidden px-3 py-4 text-sm text-gray-500 lg:table-cell">
                                    <a href="{{ route('user.edit', $user) }}" class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" >
                                        {{$user->email}}
                                    </a>
                                </td>
                                <td class="hidden px-3 py-4 text-sm text-gray-500 sm:table-cell">
                                    <a href="{{ route('user.edit', $user) }}" class="block w-full h-full p-0 m-0 text-indigo-600 no-underline bg-transparent border-0 hover:text-gray-900 hover:no-underline" >
                                        <p>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 capitalize">
                                                {{ ucwords(trans_choice($user->status->name, 1)) }}
                                            </span>
                                        </p>
                                    </a>
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-500">
                                    <div class="z-10">
                                        <button type="button" class="px-1 py-1 text-sm font-medium text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                        <div class="dropdown-menu">
                                            @if($user->status_id == 1)
                                            <a class="dropdown-item" href="#" wire:click="disableUser({{ $user->id }})">
                                                <x-icon.ban class="text-gray-400"/> <span>{{ ucwords(trans_choice('disable', 1)) }}</span>
                                            </a>
                                            @else
                                            <a class="dropdown-item" href="#" wire:click="enableUser({{ $user->id }})">
                                                <x-icon.play class="text-gray-400"/> <span>{{ ucwords(trans_choice('enable', 1)) }}</span>
                                            </a>
                                            @endif
                                            <a class="dropdown-item" href="#" wire:click="deleteUser({{ $user->id }})">
                                                <x-icon.trash class="text-gray-400"/> <span>{{ ucwords(trans_choice('delete', 1)) }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </x-bladewind.card>
                <!-- End user table -->

            </div>
            <form wire:submit.prevent="disable({{$reseller->id}})">
                <x-modal.confirmation wire:model.defer="showconfirmationModal">
                    <x-slot name="title">Disabling Reseller</x-slot>

                    <x-slot name="content">
                        Are you sure you want to suspend <strong>{{$reseller->company_name}}</strong>? By doing so you have this reseller will loose it's access to the control panel.
                    </x-slot>

                    <x-slot name="footer">
                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" @click="open = false">
                                Suspend
                            </button>
                            <a type="button" wire:click="$set('showconfirmationModal', false)" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" @click="open = false">
                                Cancel
                            </a>
                        </div>
                    </x-slot>
                </x-modal.confirmation>
            </form>
            <!-- Save Transaction Modal -->
            <div>
                <form @if($showuserCreateModal == false) wire:submit.prevent="save({{$reseller->id}})" @else wire:submit.prevent="saveuser({{$reseller->id}})" @endif>
                    <x-modal.slideout wire:model.defer="showEditModal">
                        <x-slot name="title">@if($showuserCreateModal == false){{ ucwords(trans_choice('messages.edit_reseller', 1)) }}
                            {{-- <p class="text-sm text-gray-500">
                                Changes take effect upon subscription renewal date:
                                <strong>{{date('M d, Y', strtotime($subscription->expiration_data))}}.</strong>
                                <br>
                                For SKU upgrades, if the quantity doesn't change, licenses will be assigned automatically.
                                <br>
                                Otherwise, you will need to manually assign licenses. --}}
                                @else{{ ucwords(trans_choice('messages.new_user', 1)) }}@endif
                            </x-slot>
                            @if($showuserCreateModal == false)
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
                                                            <option value="{{$reseller->country->name}}">{{$reseller->country->name}}</option>
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
                                                    <x-label for="mpnid" class="">{{ucwords(trans_choice('messages.mpnid', 1))}}</x-label>
                                                    <x-input wire:model="editing.mpnid" type="number" class="@error('editing.mpnid') is-invalid @enderror"></x-input>
                                                    @error('editing.mpnid')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                </div>
                                                <div class="mb-4 col-lg-4 col-md-6">

                                                    <x-label for="country">{{ucwords(trans_choice('messages.price_list', 1))}}</x-label>
                                                    <div class="mb-3 input-group">
                                                        <select wire:model="editing.price_list_id" name="price_list_id" class="form-control @error('editing.price_list_id') is-invalid @enderror" sf-validate="required">
                                                            @foreach ($reseller->provider->availablePriceLists as $pricelist)
                                                            <option value="{{$pricelist->id}}" {{ $reseller->pricelist->id === $pricelist->id ? 'selected' : '' }}>{{$pricelist->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('editing.price_list_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <x-label for="status">{{ ucwords(trans_choice('messages.status', 1)) }}</x-label>
                                                        <div class="form-group">
                                                            <select wire:model="editing.status_id" name="status" class="form-control @error('editing.status') is-invalid @enderror" sf-validate="required">
                                                                <option value="{{$reseller->status->id}}" selected>{{ucwords(trans_choice($reseller->status->name, 1))}}</option>
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
                                </section>
                            </x-slot>
                            @else
                            <x-slot name="content">
                                <section class="dark-grey-text">
                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <x-label for="name">@lang('First Name')</x-label>
                                                <x-input wire:model.debounce.500ms="creatingUser.name" type="text" class="@error('creatingUser.name') is-invalid @enderror" id="name" name="name" placeholder="First Name" value="{{ old('name') }}"></x-input>
                                                @error('creatingUser.name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                            <div class="form-group">
                                                <x-label for="last_name">@lang('Last Name')</x-label>
                                                <x-input wire:model.debounce.500ms="creatingUser.last_name" type="text" class="@error('creatingUser.last_name') is-invalid @enderror" id="last_name" name="last_name" placeholder="Last Name" value="{{ old('last_name')  }}"></x-input>
                                                @error('creatingUser.last_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <x-label for="socialite_id">@lang('socialite_id')</x-label>
                                                <div class="form-group">
                                                    <x-input wire:model.debounce.500ms="creatingUser.socialite_id" class="@error('socialite_id') is-invalid @enderror" type="text" name="socialite_id" id='socialite_id' value="{{ old('socialite_id') }}"></x-input>
                                                    @error('creatingUser.socialite_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <x-label for="phone">@lang('Phone')</x-label>
                                                <x-input wire:model.debounce.500ms="creatingUser.phone" type="text" class="@error('creatingUser.phone') is-invalid @enderror" id="phone_number" name="phone" placeholder="Phone" value="{{ old('phone') }}"></x-input>
                                                @error('creatingUser.phone')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                            <div class="form-group">
                                                <x-label for="address">@lang('Address')</x-label>
                                                <x-input wire:model.debounce.500ms="creatingUser.address" type="text" class="@error('creatingUser.address') is-invalid @enderror" id="address"
                                                name="address" placeholder="Address" value="{{ old('address') }}"></x-input>
                                                @error('creatingUser.address')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <x-label for="email">@lang('Email')</x-label>
                                                <x-input wire:model.debounce.500ms="email" type="email" class="@error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{ old('email') }}"></x-input>
                                                @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror

                                            </div>
                                            <div class="form-group">
                                                <x-label for="password">{{ __('Password') }}</x-label>
                                                <x-input wire:model.debounce.500ms="password" type="password" class="@error('password') is-invalid @enderror" id="password" name="password"  value="{{ old('password') }}"></x-input>
                                                @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                            <div class="form-group">
                                                <x-label for="password_confirmation">{{ __('Confirm Password') }}</x-label>
                                                <x-input wire:model.debounce.500ms="password_confirmation" type="password" class="@error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation"  value="{{ old('password_confirmation') }}"></x-input>
                                                @error('password_confirmation')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </x-slot>
                            @endif
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
