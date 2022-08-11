<div>
    <div x-data="{ userOpen: false , isOpen: false }" class="relative z-0 flex-col flex-1 overflow-y-auto">
        <div class="p-4 overflow-hidden bg-white">
            <div class="flex flex-col">
                <div class="flex flex-col items-center justify-between lg:flex-row">
                    <div class="flex items-center">
                        <h4>{{ ucwords(trans_choice('messages.user_table', 2)) }}</h4>
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

                <x-tableazure>
                    <x-slot name="head">
                        <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('id')" :direction="$sorts['id'] ?? null">{{ ucwords(trans_choice('messages.id', 2)) }}</x-table.heading>
                        <x-table.heading sortable multi-column wire:click="sortBy('company_name')"  :direction="$sorts['company_name'] ?? null">{{ ucwords(trans_choice('messages.company_name', 1)) }}</x-table.heading>
                        <x-table.heading  wire:click="sortBy('subscriptions')"         :direction="$sorts['subscriptions'] ?? null">{{ ucwords(trans_choice('messages.subscriptions', 1)) }}</x-table.heading>
                        <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('country_id')"       :direction="$sorts['country_id'] ?? null">{{ ucwords(trans_choice('messages.relationship', 1)) }}</x-table.heading>
                        <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('country_id')"       :direction="$sorts['country_id'] ?? null">{{ ucwords(trans_choice('messages.country', 2)) }}</x-table.heading>
                    </x-slot>
                    <x-slot name="body">
                        @forelse ($users as $user)
                        <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $user['id'] }}">
                            <x-table.cell visibility='hidden' tablecell='lg:table-cell'>
                                <a href="{{$user->format()['path']}}" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                    <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                            {{ $user['id'] }}
                                        </span>
                                    </div>
                                </a>
                            </x-table.cell>
                            <x-table.cell>
                                <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                    <a href="{{$user->format()['path']}}" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                            {{ $user['name'] }}
                                        </span>
                                    </div>
                                </a>
                            </x-table.cell>
                            <x-table.cell>
                                <a href="{{$user->format()['path']}}" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                    <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                            {{ $user['last_name']}}
                                        </span>
                                    </div>
                                </a>
                            </x-table.cell>
                            <x-table.cell>
                                <a href="{{$user->format()['path']}}" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                    <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                            {{ $user['email']}}
                                        </span>
                                    </div>
                                </a>
                            </x-table.cell>

                            <x-table.cell>
                                <a href="{{$user->format()['path']}}" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                    <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                            {{ $user->reseller['company_name'] ?? $user->provider['company_name'] ?? $user->customer['company_name'] ?? ''}}
                                        </span>
                                    </div>
                                </a>
                            </x-table.cell>
                            <x-table.cell>
                                <a href="{{$user->format()['path']}}" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                    <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                            {{ $user['Created_at']}}
                                        </span>
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
                                        <a wire:click="edit({{ $user->id }})" class="dropdown-item" href="#">
                                            <x-icon.edit></x-icon.edit>
                                            {{ ucwords(trans_choice('messages.edit', 1)) }}
                                        </a>
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
                                        @canImpersonate
                                        @if(!empty($user->format()['mainUser']))
                                        <a class="dropdown-item" href="{{ route('impersonate', $user->format()['id'])}}">
                                            <x-icon.impersonate></x-icon.impersonate>
                                            {{ ucwords(trans_choice('messages.impersonate', 1)) }}
                                        </a>
                                        @endif
                                        @endCanImpersonate
                                    </div>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                        @empty
                        <x-table.row>
                            <x-table.cell colspan="9">
                                <div class="flex items-center justify-center space-x-2">
                                    <x-icon.inbox class="w-8 h-8 text-cool-gray-400" />
                                    <span class="py-8 text-xl font-medium text-cool-gray-400">No user found...</span>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                        @endforelse
                    </x-slot>
                </x-tableazure>
                <div>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
        <div>
            <form @if($showuserCreateModal == false) wire:submit.prevent="save({{$user->id}})" @endif>
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
                        <x-slot name="content">
                            <div class="flex-1 xl:overflow-y-auto">
                                <form wire:submit.prevent="save({{$user->id}})"class="mt-6 space-y-8 divide-y divide-y-blue-gray-200">
                                    <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-6 sm:gap-x-6">
                                        <div class="sm:col-span-6">
                                            <h2 class="text-xl font-medium text-blue-gray-900">Profile</h2>
                                            <p class="mt-1 text-sm text-blue-gray-500">This information will be displayed publicly so be careful what you share.</p>
                                        </div>

                                        <div class="sm:col-span-3">
                                            <label for="first-name" class="block text-sm font-medium text-blue-gray-900"> First name </label>
                                            <input wire:model.debounce.500ms="editing.name" type="text" name="first-name" id="first-name" autocomplete="given-name" class="block w-full mt-1 rounded-md shadow-sm border-blue-gray-300 text-blue-gray-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500">
                                        </div>

                                        <div class="sm:col-span-3">
                                            <label for="last-name" class="block text-sm font-medium text-blue-gray-900"> Last name </label>
                                            <input wire:model.debounce.500ms="editing.last_name" type="text" name="last-name" id="last-name" autocomplete="family-name" class="block w-full mt-1 rounded-md shadow-sm border-blue-gray-300 text-blue-gray-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500">
                                        </div>

                                        <div class="sm:col-span-6">
                                            <label for="username" class="block text-sm font-medium text-blue-gray-900"> Username </label>
                                            <input wire:model.debounce.500ms="editing.username" type="text" name="username" id="username" autocomplete="username" class="block w-full mt-1 rounded-md shadow-sm border-blue-gray-300 text-blue-gray-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500">
                                            {{-- <input wire:model.debounce.500ms="editing.username" type="text" name="username" id="username" autocomplete="username" value="lisamarie" class="flex-1 block w-full min-w-0 rounded-none border-blue-gray-300 rounded-r-md text-blue-gray-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500"> --}}

                                        </div>
                                        @if($editing)
                                        <div class="sm:col-span-6">
                                            <label for="photo" class="block text-sm font-medium text-blue-gray-900"> Photo </label>
                                            <div class="flex items-center mt-1">
                                                <img class="inline-block w-12 h-12 rounded-full" src="{{$editing['avatar']}}" alt="">
                                                <div class="flex ml-4">
                                                    <div class="relative flex items-center px-3 py-2 bg-white border rounded-md shadow-sm cursor-pointer border-blue-gray-300 hover:bg-blue-gray-50 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-blue-gray-50 focus-within:ring-blue-500">
                                                        <label for="user-photo" class="relative text-sm font-medium pointer-events-none text-blue-gray-900">
                                                            <span>Change</span>
                                                            <span class="sr-only"> user photo</span>
                                                        </label>
                                                        <input id="user-photo" name="user-photo" type="file" class="absolute inset-0 w-full h-full border-gray-300 rounded-md opacity-0 cursor-pointer">
                                                    </div>
                                                    <button type="button" class="px-3 py-2 ml-3 text-sm font-medium bg-transparent border border-transparent rounded-md text-blue-gray-900 hover:text-blue-gray-700 focus:outline-none focus:border-blue-gray-300 focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-gray-50 focus:ring-blue-500">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    <div class="grid grid-cols-1 pt-8 gap-y-6 sm:grid-cols-6 sm:gap-x-6">
                                        <div class="sm:col-span-6">
                                            <h2 class="text-xl font-medium text-blue-gray-900">Personal Information</h2>
                                            <p class="mt-1 text-sm text-blue-gray-500">This information will be displayed publicly so be careful what you share.</p>
                                        </div>

                                        <div class="sm:col-span-3">
                                            <label for="email-address" class="block text-sm font-medium text-blue-gray-900"> Email address </label>
                                            <input wire:model.debounce.500ms="editing.email" type="text" name="email-address" id="email-address" autocomplete="email" class="block w-full mt-1 rounded-md shadow-sm border-blue-gray-300 text-blue-gray-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500">
                                        </div>

                                        <div class="sm:col-span-3">
                                            <label for="phone-number" class="block text-sm font-medium text-blue-gray-900"> Phone number </label>
                                            <input wire:model.debounce.500ms="editing.phone" type="text" name="phone-number" id="phone-number" autocomplete="tel" class="block w-full mt-1 rounded-md shadow-sm border-blue-gray-300 text-blue-gray-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500">
                                        </div>

                                        <div class="sm:col-span-3">
                                            @if($editing)
                                            <label for="country" class="block text-sm font-medium text-blue-gray-900"> Country </label>
                                            <select wire:model="editing.country_id" name="country_id" class="form-control @error('editing.country_id') is-invalid @enderror" sf-validate="required">
                                                <option value="{{$editing->country->name}}">{{$editing->country->name}}</option>
                                                @foreach ($countries as $key => $country)
                                                <option value="{{$country->id}}">{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('editing.country_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                            {{-- <select id="country" name="country" autocomplete="country-name" class="block w-full mt-1 rounded-md shadow-sm border-blue-gray-300 text-blue-gray-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500">
                                                <option></option>
                                                <option>United States</option>
                                                <option>Canada</option>
                                                <option>Mexico</option>
                                            </select> --}}
                                            @endif
                                        </div>

                                        <div class="sm:col-span-3">
                                            <label for="language" class="block text-sm font-medium text-blue-gray-900"> Language </label>
                                            <input wire:model.debounce.500ms="editing.locale" type="text" name="language" id="language" class="block w-full mt-1 rounded-md shadow-sm border-blue-gray-300 text-blue-gray-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        @if($editing)
                                        <p class="text-sm text-blue-gray-500 sm:col-span-6">This account was created on <time datetime="2017-01-05T20:35:40">{{$editing['created_at']}}</time>.</p>
                                        @endif
                                    </div>
                                </form>

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
        </div>

