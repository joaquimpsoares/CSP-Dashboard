<div>
    <style>
        .toogle-a input:checked ~ .dot {
            transform: translateX(100%);
            background: rgb(67, 56, 202);
        }

        .toogle-a input:checked ~ .bar {
            background: rgb(165, 180, 252);
        }

        .toogle-b input:checked ~ .dot {
            transform: translateX(100%);
            background: rgb(67, 56, 202);
        }

        .toogle-b input:checked ~ .bar {
            background: rgb(165, 180, 252);
        }

        .toogle-c input:checked ~ .dot {
            transform: translateX(100%);
            background: rgb(67, 56, 202);
        }

        .toogle-c input:checked ~ .bar {
            background: rgb(165, 180, 252);
        }

        .toogle-d input:checked ~ .dot {
            transform: translateX(100%);
            background: rgb(67, 56, 202);
        }

        .toogle-d input:checked ~ .bar {
            background: rgb(165, 180, 252);
        }

    </style>
    {{-- @dd($bulletInvoices); --}}
    <div class="h-full">
        <div class="flex flex-col max-w-4xl mx-auto md:px-8 xl:px-0">
            <main class="flex-1">
                <div class="relative max-w-4xl mx-auto md:px-8 xl:px-0">
                    <div class="pt-10 pb-16">
                        <div class="px-4 sm:px-6 md:px-0">
                            <h1 class="text-3xl font-extrabold text-gray-900">Settings</h1>
                        </div>
                        <div class="px-4 sm:px-6 md:px-0">
                            <div x-data="{ tab: '#tab1' }" class="">
                                <div class="border-b border-gray-200">
                                    <div class="flex flex-row justify-between">
                                        <nav class="flex -mb-px space-x-8">
                                            <a class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === '#tab1'}" href="#"
                                            x-on:click.prevent="tab='#tab1'">{{ ucwords(trans_choice('messages.user_profile', 1)) }}</a>
                                            <a class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === '#tab2'}" href="#"
                                            href="#" x-on:click.prevent="tab='#tab2'">{{ ucwords(trans_choice('messages.security', 1)) }}</a>
                                            <a class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === '#tab3'}" href="#"
                                            href="#" x-on:click.prevent="tab='#tab3'">{{ ucwords(trans_choice('messages.notification', 2)) }}</a>
                                            <a class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === '#tab4'}" href="#"
                                            href="#" x-on:click.prevent="tab='#tab4'">{{ ucwords(trans_choice('messages.business_account', 2)) }}</a>
                                            <a class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === '#tab5'}" href="#"
                                            href="#" x-on:click.prevent="tab='#tab5'">{{ ucwords(trans_choice('messages.payment', 2)) }}</a>
                                        </nav>
                                    </div>
                                </div>
                                <div x-show="tab == '#tab1'" x-cloak>
                                    <div class="mt-10 space-y-6 divide-y divide-gray-200 sm:px-6 lg:px-0 lg:col-span-9">
                                        <section aria-labelledby="payment-details-heading">
                                            <form wire:submit.prevent="save_user" action="#" >
                                                <div class="shadow sm:rounded-md sm:overflow-hidden">
                                                    <div class="px-4 py-6 bg-white sm:p-6">
                                                        <div>
                                                            <h2 id="payment-details-heading" class="text-lg font-medium leading-6 text-gray-900">User details</h2>
                                                            <p class="mt-1 text-sm text-gray-500">Update your billing information. Please note that updating your location could affect your tax rates.</p>
                                                        </div>
                                                        <div class="grid grid-cols-4 gap-6 mt-6">
                                                            <div class="col-span-4 sm:col-span-2">
                                                                <label for="first-name" class="@error('editing.name') is-invalid @enderror block text-sm font-medium text-gray-700">First name</label>
                                                                <input wire:model.debounce.500ms="editing.name" type="text" name="first-name" id="first-name" autocomplete="cc-given-name" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                                                @error('editing.name') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                                                            </div>

                                                            <div class="col-span-4 sm:col-span-2">
                                                                <label for="last-name" class="@error('editing.last_name') is-invalid @enderror block text-sm font-medium text-gray-700">Last name</label>
                                                                <input wire:model.debounce.500ms="editing.last_name" type="text" name="last-name" id="last-name" autocomplete="cc-family-name" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                                                @error('editing.last_name') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                                                            </div>

                                                            <div class="col-span-4 sm:col-span-2">
                                                                <label for="email-address" class="block text-sm font-medium text-gray-700">Email address</label>
                                                                <input wire:model.debounce.500ms="editing.email" type="text" name="email-address" id="email-address" autocomplete="email" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                                            </div>

                                                            <div class="col-span-4 sm:col-span-1">
                                                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                                                <input wire:model.debounce.500ms="editing.address" type="text" name="address" id="address" autocomplete="cc-exp" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                                            </div>

                                                            <div class="col-span-4 sm:col-span-1">
                                                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                                                <input wire:model.debounce.500ms="editing.city" type="text" name="city" id="city" autocomplete="cc-exp" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                                            </div>
                                                            <div class="col-span-4 sm:col-span-2">
                                                                <label for="email-address" class="block text-sm font-medium text-gray-700">State</label>
                                                                <input wire:model.debounce.500ms="editing.state" type="text" name="email-address" id="email-address" autocomplete="email" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                                            </div>

                                                            <div class="col-span-4 sm:col-span-2">
                                                                <label for="expiration-date" class="block text-sm font-medium text-gray-700">ZIP / Postal code</label>
                                                                <input wire:model.debounce.500ms="editing.postal_code" type="text" name="expiration-date" id="expiration-date" autocomplete="cc-exp" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                                            </div>
                                                            <div class="col-span-4 sm:col-span-2">
                                                                <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                                                                <select wire:model="editing.country_id" name="country_id" id="country" autocomplete="country-name" class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm @error('editing.country_id') is-invalid @enderror" sf-validate="required">
                                                                    <option value="{{$editing->country->name}}">{{$editing->country->name}}</option>
                                                                    @foreach ($countries as $key => $country)
                                                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('editing.country_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                                            </div>
                                                            <div class="col-span-4 sm:col-span-2">
                                                                <label for="Phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                                                <input wire:model.debounce.500ms="editing.phone" type="text" name="Phone" id="Phone" autocomplete="postal-code" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                                                        <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-gray-800 border border-transparent rounded-md shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </section>

                                        <!-- Billing history -->
                                        <section aria-labelledby="payment-details-heading">
                                            <form action="#" method="POST">
                                                <div class="shadow sm:rounded-md sm:overflow-hidden">
                                                    <div class="px-4 py-6 bg-white sm:p-6">
                                                        <div>
                                                            <h2 id="payment-details-heading" class="text-lg font-medium leading-6 text-gray-900">User details</h2>
                                                            <p class="mt-1 text-sm text-gray-500">Update your billing information. Please note that updating your location could affect your tax rates.</p>
                                                        </div>
                                                    </div>
                                                    <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                                                        <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-gray-800 border border-transparent rounded-md shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </section>
                                    </div>
                                </div>
                                <div x-show="tab == '#tab2'" x-cloak>
                                    <div class="mt-10 space-y-6 divide-y divide-gray-200 sm:px-6 lg:px-0 lg:col-span-9">
                                        <section aria-labelledby="payment-details-heading">
                                            <form wire:submit.prevent="saveauth" action="#">
                                                <div class="shadow sm:rounded-md sm:overflow-hidden">
                                                    <div class="px-4 py-6 bg-white sm:p-6">
                                                        <div>
                                                            <h2 id="payment-details-heading" class="text-lg font-medium leading-6 text-gray-900">User details</h2>
                                                            <p class="mt-1 text-sm text-gray-500">Update your billing information. Please note that updating your location could affect your tax rates.</p>
                                                        </div>
                                                        <div class="grid grid-cols-4 gap-6 mt-6">
                                                            <div class="col-span-4 sm:col-span-2">
                                                                <label for="password" class="@error('password') is-invalid @enderror block text-sm font-medium text-gray-700">{{ ucwords(trans_choice('messages.password', 1)) }}</label>
                                                                <input wire:model="password"  type="password" autocomplete="current-password" required placeholder="Password" name="first-name" id="first-name" autocomplete="cc-given-name" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                                                @error('password') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                                                            </div>
                                                            <div class="col-span-4 sm:col-span-2">
                                                                <label for="password_confirmation" class="@error('password_confirmation') is-invalid @enderror block text-sm font-medium text-gray-700">{{ ucwords(trans_choice('messages.password_confirmation', 2)) }}</label>
                                                                <input wire:model="password_confirmation"  type="password" autocomplete="current-password_confirmation" required placeholder="Password Confirmation" name="first-name" id="first-name" autocomplete="cc-given-name" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                                                @error('password') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                                                        <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-gray-800 border border-transparent rounded-md shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </section>
                                        <section aria-labelledby="payment-details-heading" wire:ignore.self>
                                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                                                <div class="px-4 py-6 bg-white sm:p-6">
                                                    <div>
                                                        <h2 id="payment_details_heading" class="text-lg font-medium leading-6 text-gray-900">Create API Token</h2>
                                                        <p class="mt-1 text-sm text-gray-500">API Tokens allow third-party services to authenticate with our application on your behalf.</p>
                                                    </div>
                                                    <div>
                                                        <div class="flex mt-6 space-x-4" action="#">
                                                            <div class="flex-1 min-w-0">
                                                                <label for="search" class="sr-only">Search</label>
                                                                <div>
                                                                    <x-input wire:model.debounce.500ms='token_name' type="text" name="name" id="name" class="@error('token_name') is-invalid @enderror  block w-full px-3 py-2 placeholder-gray-400" placeholder="Token Name"></x-input>
                                                                    @error('token_name') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <button wire:click='generateToken' class="inline-flex justify-center px-3.5 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                                                    Generate Token
                                                                    <span class="sr-only">Search</span>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        @if($token)
                                                        <div class="flex-1 min-w-0 mt-3">
                                                            <h2 id="payment_details_heading" class="text-lg font-medium leading-6 text-gray-900">Token Created</h2>
                                                            <p class="mt-1 text-sm text-gray-500">Copy this Token, we will not be able to show it again.</p>
                                                        </div>
                                                        <div class="flex mt-6 space-x-4" action="#">
                                                            <div class="flex-1 min-w-0">
                                                                <x-input wire:model='token' type="token" name="token" id="token" class="" placeholder="Token Name"></x-input>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="mt-8 overflow-hidden bg-white shadow sm:rounded-md">
                                                        <ul role="list" class="divide-y divide-gray-200">
                                                            @foreach($editing->tokens as $token)
                                                            <li>
                                                                <div class="px-4 py-4 sm:px-6">
                                                                    <div class="flex items-center justify-between">
                                                                        <p class="text-sm font-medium text-indigo-600 truncate">{{$token->name}}</p>
                                                                        <div class="flex flex-shrink-0 ml-2">
                                                                            <a href="#" wire:click="deleteToken({{ $token->id }})" class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 ">Delete</a>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                                                    {{-- <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-gray-800 border border-transparent rounded-md shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">Save</button> --}}
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <div x-show="tab == '#tab3'" x-cloak>
                                    <div class="mt-10 space-y-6 divide-y divide-gray-200 sm:px-6 lg:px-0 lg:col-span-9">
                                        <section aria-labelledby="payment-details-heading">
                                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                                                <div class="px-4 py-6 bg-white sm:p-6">
                                                    <div>
                                                        <h2 id="payment-details-heading" class="text-lg font-medium leading-6 text-gray-900">{{ucwords(trans_choice('messages.notifications', 1))}}</h2>
                                                        <p class="mt-1 text-sm text-gray-500">{{ucwords(trans_choice('descriptions.notifications_description', 1))}}</p>
                                                    </div>

                                                    <ul class="mt-2 ">
                                                        <li class="flex items-center justify-between py-4" x-data="{ on: true }">
                                                            <div class="flex flex-col">
                                                                <p class="text-sm font-medium text-gray-900" id="privacy-option-1-label">
                                                                    {{ucwords(trans_choice('messages.email', 1))}}
                                                                </p>
                                                                <p class="text-sm text-gray-500" id="privacy-option-1-description">
                                                                    {{ucwords(trans_choice('descriptions.recieve_email_notifications', 1))}}

                                                                </p>
                                                            </div>
                                                            <label for="toogle-a" class="relative inline-flex items-center cursor-pointer toogle-a">
                                                                <input wire:model='mail' id="toogle-a" type="checkbox" class="hidden">
                                                                <div class="w-10 h-4 transition duration-300 bg-gray-300 border border-gray-100 rounded-full shadow-inner bar"></div>
                                                                <div class="absolute w-6 h-6 transition duration-300 bg-gray-400 rounded-full shadow-md dot -left-1"></div>
                                                            </label>
                                                        </li>
                                                        @if($mail == true)
                                                        <section aria-labelledby="payment-details-heading">
                                                            <div class="grid grid-cols-4 gap-6 mt-0">
                                                                <div class="col-span-4 sm:col-span-2">
                                                                    <x-label for="hostname" class="block text-sm font-medium text-gray-700">{{ucwords(trans_choice('messages.hostname', 1))}}</x-label>
                                                                    <x-input wire:model='hostname' type="text" name="hostname" id="hostname" autocomplete="hostname" class="w-full form-input"></x-input>
                                                                </div>

                                                                <div class="col-span-4 sm:col-span-1">
                                                                    <x-label for="port" class="block text-sm font-medium text-gray-700">{{ucwords(trans_choice('messages.port', 1))}}</x-label>
                                                                    <x-input wire:model='port' type="text" name="port" id="port" autocomplete="port" class="w-full form-input" ></x-input>
                                                                </div>

                                                                <div class="col-span-4 sm:col-span-1">
                                                                    <x-label for="encryption" class="flex items-center text-sm font-medium text-gray-700">{{ucwords(trans_choice('messages.encryption', 1))}}</x-label>
                                                                    <x-input wire:model='encryption' type="text" name="encryption" id="encryption" autocomplete="encryption" class="w-full form-input"></x-input>
                                                                </div>
                                                                <div class="col-span-4 sm:col-span-2">
                                                                    <x-label for="username" class="block text-sm font-medium text-gray-700">{{ucwords(trans_choice('messages.username', 1))}}</x-label>
                                                                    <x-input wire:model='username' type="text" name="username" id="username" autocomplete="username" class="w-full form-input"></x-input>
                                                                </div>
                                                                <div class="col-span-4 sm:col-span-2">
                                                                    <x-label for="password" class="block text-sm font-medium text-gray-700">{{ucwords(trans_choice('messages.password', 1))}}</x-label>
                                                                    <x-input wire:model='password' type="password" name="password" id="password" autocomplete="password" class="w-full form-input"></x-input>
                                                                </div>
                                                            </div>
                                                        </section>
                                                        @endif
                                                        <li class="flex items-center justify-between py-4" x-data="{ on: false }">
                                                            <div class="flex flex-col">
                                                                <p class="text-sm font-medium text-gray-900" id="privacy-option-2-label">
                                                                    {{ucwords(trans_choice('messages.teams', 1))}}
                                                                </p>
                                                                <p class="text-sm text-gray-500" id="privacy-option-2-description">
                                                                    {{ucwords(trans_choice('descriptions.recieve_teams_notifications', 1))}}
                                                                </p>
                                                            </div>
                                                            <div class="flex flex-col">
                                                                <label for="toogle-b" class="relative inline-flex items-center cursor-pointer toogle-b">
                                                                    <input wire:model='teams' id="toogle-b" type="checkbox" class="hidden">
                                                                    <div class="w-10 h-4 transition duration-300 bg-gray-300 border border-gray-100 rounded-full shadow-inner bar"></div>
                                                                    <div class="absolute w-6 h-6 transition duration-300 bg-gray-400 rounded-full shadow-md dot -left-1"></div>
                                                                </label>
                                                            </div>
                                                        </li>
                                                        @if($teams == true)
                                                        <div class="col-span-12">
                                                            <label for="url" class="block text-sm font-medium text-gray-700">URL</label>
                                                            <input wire:model='teams_webhook' type="text" name="url" id="url" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm">
                                                        </div>
                                                        @endif
                                                    </ul>
                                                </div>
                                                <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                                                    <x-button wire:click='saveNotifications' class="inline-flex justify-center px-4 py-2 ml-5 text-sm font-medium ">
                                                        {{ucwords(trans_choice('messages.save', 1))}}
                                                    </x-button>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <div x-show="tab == '#tab4'" x-cloak>
                                    <p>This is the content of Tab 3</p>
                                </div>
                                <div x-show="tab == '#tab5'" x-cloak>
                                    <div class="mt-10 space-y-6 divide-y divide-gray-200 sm:px-6 lg:px-0 lg:col-span-9">
                                        <section aria-labelledby="payment-details-heading">
                                            <form action="#" method="POST">
                                                <div class="shadow sm:rounded-md sm:overflow-hidden">
                                                    <div class="px-4 py-6 bg-white sm:p-6">
                                                        <div>
                                                            <h2 id="payment-details-heading" class="text-lg font-medium leading-6 text-gray-900">Payment details</h2>
                                                            <p class="mt-1 text-sm text-gray-500">Update your billing information. Please note that updating your location could affect your tax rates.</p>
                                                        </div>

                                                        <div class="grid grid-cols-4 gap-6 mt-6">
                                                            <div class="col-span-4 sm:col-span-2">
                                                                <label for="first-name" class="block text-sm font-medium text-gray-700">First name</label>
                                                                <input type="text" name="first-name" id="first-name" autocomplete="cc-given-name" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                                            </div>

                                                            <div class="col-span-4 sm:col-span-2">
                                                                <label for="last-name" class="block text-sm font-medium text-gray-700">Last name</label>
                                                                <input type="text" name="last-name" id="last-name" autocomplete="cc-family-name" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                                            </div>

                                                            <div class="col-span-4 sm:col-span-2">
                                                                <label for="email-address" class="block text-sm font-medium text-gray-700">Email address</label>
                                                                <input type="text" name="email-address" id="email-address" autocomplete="email" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                                            </div>

                                                            <div class="col-span-4 sm:col-span-1">
                                                                <label for="expiration-date" class="block text-sm font-medium text-gray-700">Expration date</label>
                                                                <input type="text" name="expiration-date" id="expiration-date" autocomplete="cc-exp" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm" placeholder="MM / YY">
                                                            </div>

                                                            <div class="col-span-4 sm:col-span-1">
                                                                <label for="security-code" class="flex items-center text-sm font-medium text-gray-700">
                                                                    <span>Security code</span>
                                                                    <!-- Heroicon name: solid/question-mark-circle -->
                                                                    <svg class="flex-shrink-0 w-5 h-5 ml-1 text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                                                    </svg>
                                                                </label>
                                                                <input type="text" name="security-code" id="security-code" autocomplete="cc-csc" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                                            </div>

                                                            <div class="col-span-4 sm:col-span-2">
                                                                <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                                                                <select id="country" name="country" autocomplete="country-name" class="block w-full px-3 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                                                    <option>United States</option>
                                                                    <option>Canada</option>
                                                                    <option>Mexico</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-span-4 sm:col-span-2">
                                                                <label for="postal-code" class="block text-sm font-medium text-gray-700">ZIP / Postal code</label>
                                                                <input type="text" name="postal-code" id="postal-code" autocomplete="postal-code" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                                                        <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-gray-800 border border-transparent rounded-md shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </section>

                                        <!-- Billing history -->
                                        <section aria-labelledby="billing-history-heading">
                                            <div class="pt-6 bg-white shadow sm:rounded-md sm:overflow-hidden">
                                                <div class="px-4 sm:px-6">
                                                    <h2 id="billing-history-heading" class="text-lg font-medium leading-6 text-gray-900">Billing history</h2>
                                                </div>
                                                <div class="flex flex-col mt-6">
                                                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                                            <div class="overflow-hidden border-t border-gray-200">
                                                                <table class="min-w-full divide-y divide-gray-200">
                                                                    <thead class="bg-gray-50">
                                                                        <tr>
                                                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Date</th>
                                                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Description</th>
                                                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Amount</th>
                                                                            <!--
                                                                                `relative` is added here due to a weird bug in Safari that causes `sr-only` headings to introduce overflow on the body on mobile.
                                                                            -->
                                                                            <th scope="col" class="relative px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                                                <span class="sr-only">View receipt</span>
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="bg-white divide-y divide-gray-200">
                                                                        @foreach ($invoices as $invoice)
                                                                    @php

                                                                    @endphp
                                                                        {{-- @dd($this->cleanData($invoice->invoiceLines->first()['rate'])) --}}
                                                                        {{-- @dd(3818.67, 2)); --}}
                                                                        {{-- @dd(('2'*'3818.67')) --}}
                                                                        // *$invoice->invoiceLines->first()['rate'])
                                                                        <tr>

                                                                            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                                                <time datetime="2020-01-01">{{$invoice->issueDate}}</time>
                                                                            </td>
                                                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">Business Plan - Annual Billing</td>
                                                                            {{-- <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{$invoice->invoiceLines->first()['quantity'] * $invoice->invoiceLines->first()['rate']}}</td> --}}
                                                                            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                                                                <a href="#" class="text-orange-600 hover:text-orange-900">View receipt</a>
                                                                            </td>
                                                                        </tr>
                                                                        @endforeach

                                                                        <!-- More payments... -->
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
</div>
</div>
