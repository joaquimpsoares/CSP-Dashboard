<div class="h-full">
    <div class="flex flex-col max-w-4xl mx-auto md:px-8 xl:px-0">
        <main class="flex-1">
            <div class="relative max-w-4xl mx-auto md:px-8 xl:px-0">
                <div class="pt-10 pb-16">
                    <div class="px-4 sm:px-6 md:px-0">
                        <h1 class="text-3xl font-extrabold text-gray-900">Settings</h1>
                    </div>
                    <div class="px-4 sm:px-6 md:px-0">
                        <div x-data="{ tab: '#tab1' }" class="py-6">
                            <div class="hidden sm:block" x-description="Tabs at small breakpoint and up" >
                                    <div class="border-b border-gray-200">
                                        <nav class="flex -mb-px space-x-8" x-data="{tab: '#tab1'}">
                                            <a class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === '#tab1'}" href="#" x-on:click.prevent="tab='#tab1'">
                                                {{ ucwords(trans_choice('messages.all', 1)) }}
                                            </a>
                                            <a href="#" class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === '#tab2'}" x-on:click.prevent="tab='#tab2'">
                                                {{ ucwords(trans_choice('messages.legacy', 1)) }}
                                            </a>
                                            {{-- <a href="#" class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === 3}" @click.prevent="tab = 3" @click.prevent="tab = 3">
                                                {{ ucwords(trans_choice('messages.perpetual_software', 1)) }}
                                            </a>
                                            <a href="#" class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === 4}"@click.prevent="tab = 4" @click.prevent="tab = 4">
                                                {{ ucwords(trans_choice('messages.abouttoexpire', 1)) }}
                                            </a>
                                            <a href="#" class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === 5}" @click.prevent="tab = 5" @click.prevent="tab = 5">
                                                {{ ucwords(trans_choice('messages.nce', 1)) }}
                                            </a> --}}
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
                                            <form action="#" method="POST">
                                                <div class="shadow sm:rounded-md sm:overflow-hidden">
                                                    <div class="px-4 py-6 bg-white sm:p-6">
                                                        <div>
                                                            <h2 id="payment-details-heading" class="text-lg font-medium leading-6 text-gray-900">User details</h2>
                                                            <p class="mt-1 text-sm text-gray-500">Update your billing information. Please note that updating your location could affect your tax rates.</p>
                                                        </div>
                                                        <div class="grid grid-cols-4 gap-6 mt-6">
                                                            <div class="col-span-4 sm:col-span-2">
                                                                <label for="password" class="@error('password') is-invalid @enderror block text-sm font-medium text-gray-700">First name</label>
                                                                <input wire:model="password"  type="password" autocomplete="current-password" required placeholder="Password" name="first-name" id="first-name" autocomplete="cc-given-name" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                                                @error('password') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                                                            </div>
                                                            <div class="col-span-4 sm:col-span-2">
                                                                <label for="password_confirmation" class="@error('password_confirmation') is-invalid @enderror block text-sm font-medium text-gray-700">First name</label>
                                                                <input wire:model="password_confirmation"  type="password_confirmation" autocomplete="current-password_confirmation" required placeholder="Password Confirmation" name="first-name" id="first-name" autocomplete="cc-given-name" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
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
                                            <form wire:submit.prevent="generateToken" action="#">
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
                                                                <button  wire:click='generateToken' class="inline-flex justify-center px-3.5 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                                                    Generate Token
                                                                    <span class="sr-only">Search</span>
                                                                </button>
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
                                                        <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-gray-800 border border-transparent rounded-md shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </section>
                                    </div>
                                </div>
                            </div>
                    </div>


                            {{-- <x-bladewind.tab-group name="settings">
                                <x-slot name="headings">
                                    <x-bladewind.tab-heading x-on:click.prevent="tab='#tab1'" name="userprofile" active="true" label="User Profile" />
                                    <x-bladewind.tab-heading name="unsplash-2" label="Account" />
                                    <x-bladewind.tab-heading name="unsplash-3" label="Notifications" />
                                    <x-bladewind.tab-heading name="unsplash-4" label="Security" />
                                    <x-bladewind.tab-heading name="payments" label="Payments" />
                                </x-slot>

                                <x-bladewind.tab-body>
                                    <x-bladewind.tab-content name="userprofile"  active="true">
                                        <div x-data="{ tab: '#tab1' }" class="">
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
                                        </div>
                                    </x-bladewind.tab-content>

                                    <x-bladewind.tab-content name="unsplash-2">
                                        <img src="/path/to/the/image/file"
                                        alt="Picture by Marko Pavlichenko" />
                                    </x-bladewind.tab-content>

                                    <x-bladewind.tab-content name="unsplash-3">
                                        <img src="/path/to/the/image/file"
                                        alt="Picture by Yoonbae Cho" />
                                    </x-bladewind.tab-content>

                                    <x-bladewind.tab-content name="unsplash-4">

                                        <div class="mt-10 space-y-6 divide-y divide-gray-200 sm:px-6 lg:px-0 lg:col-span-9">
                                            <section aria-labelledby="payment-details-heading">
                                                <form action="#" method="POST">
                                                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                                                        <div class="px-4 py-6 bg-white sm:p-6">
                                                            <div>
                                                                <h2 id="payment-details-heading" class="text-lg font-medium leading-6 text-gray-900">User details</h2>
                                                                <p class="mt-1 text-sm text-gray-500">Update your billing information. Please note that updating your location could affect your tax rates.</p>
                                                            </div>
                                                            <div class="grid grid-cols-4 gap-6 mt-6">
                                                                <div class="col-span-4 sm:col-span-2">
                                                                    <label for="password" class="@error('password') is-invalid @enderror block text-sm font-medium text-gray-700">First name</label>
                                                                    <input wire:model="password"  type="password" autocomplete="current-password" required placeholder="Password" name="first-name" id="first-name" autocomplete="cc-given-name" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                                                                    @error('password') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror
                                                                </div>
                                                                <div class="col-span-4 sm:col-span-2">
                                                                    <label for="password_confirmation" class="@error('password_confirmation') is-invalid @enderror block text-sm font-medium text-gray-700">First name</label>
                                                                    <input wire:model="password_confirmation"  type="password_confirmation" autocomplete="current-password_confirmation" required placeholder="Password Confirmation" name="first-name" id="first-name" autocomplete="cc-given-name" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
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
                                                <form wire:submit.prevent="generateToken" action="#">
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
                                                                    <button  wire:click='generateToken' class="inline-flex justify-center px-3.5 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                                                        Generate Token
                                                                        <span class="sr-only">Search</span>
                                                                    </button>
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
                                                            <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-gray-800 border border-transparent rounded-md shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">Save</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </section>
                                        </div>
                                    </x-bladewind.tab-content>
                                    <x-bladewind.tab-content name="payments">
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
                                                                    <input type="text" name="expiration-date" id="expiration-date" autocomplete="cc-exp" class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
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
                                            </section> --}}

                                            <!-- Plan -->
                                            {{-- <section aria-labelledby="plan-heading">
                                                <form action="#" method="POST">
                                                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                                                        <div class="px-4 py-6 space-y-6 bg-white sm:p-6">
                                                            <div>
                                                                <h2 id="plan-heading" class="text-lg font-medium leading-6 text-gray-900">Plan</h2>
                                                            </div>

                                                            <fieldset x-data="window.Components.radioGroup({ initialCheckedIndex: 1 })" x-init="init()">
                                                                <legend class="sr-only">
                                                                    Pricing plans
                                                                </legend>
                                                                <div class="relative -space-y-px bg-white rounded-md">

                                                                    <label x-radio-group-option="" class="relative flex flex-col p-4 border border-gray-200 cursor-pointer rounded-tl-md rounded-tr-md md:pl-4 md:pr-6 md:grid md:grid-cols-3 focus:outline-none" x-description="Checked: &quot;bg-orange-50 border-orange-200 z-10&quot;, Not Checked: &quot;border-gray-200&quot;" :class="{ 'bg-orange-50 border-orange-200 z-10': (value === 'Startup'), 'border-gray-200': !(value === 'Startup') }">
                                                                        <span class="flex items-center text-sm">
                                                                            <input type="radio" x-model="value" name="pricing-plan" value="Startup" class="w-4 h-4 text-orange-500 border-gray-300 focus:ring-gray-900" aria-labelledby="pricing-plans-0-label" aria-describedby="pricing-plans-0-description-0 pricing-plans-0-description-1">
                                                                            <span id="pricing-plans-0-label" class="ml-3 font-medium text-gray-900">Startup</span>
                                                                        </span>
                                                                        <span id="pricing-plans-0-description-0" class="pl-1 ml-6 text-sm md:ml-0 md:pl-0 md:text-center">
                                                                            <span class="font-medium text-gray-900" x-description="Checked: &quot;text-orange-900&quot;, Not Checked: &quot;text-gray-900&quot;" :class="{ 'text-orange-900': (value === 'Startup'), 'text-gray-900': !(value === 'Startup') }">$29 / mo</span>
                                                                            <!-- space -->
                                                                            <span x-description="Checked: &quot;text-orange-700&quot;, Not Checked: &quot;text-gray-500&quot;" :class="{ 'text-orange-700': (value === 'Startup'), 'text-gray-500': !(value === 'Startup') }" class="text-gray-500">($290 / yr)</span>
                                                                        </span>
                                                                        <span id="pricing-plans-0-description-1" class="pl-1 ml-6 text-sm text-gray-500 md:ml-0 md:pl-0 md:text-right" x-description="Checked: &quot;text-orange-700&quot;, Not Checked: &quot;text-gray-500&quot;" :class="{ 'text-orange-700': (value === 'Startup'), 'text-gray-500': !(value === 'Startup') }">Up to 5 active job postings</span>
                                                                    </label>

                                                                    <label x-radio-group-option="" class="relative flex flex-col p-4 border border-gray-200 cursor-pointer md:pl-4 md:pr-6 md:grid md:grid-cols-3 focus:outline-none" x-description="Checked: &quot;bg-orange-50 border-orange-200 z-10&quot;, Not Checked: &quot;border-gray-200&quot;" :class="{ 'bg-orange-50 border-orange-200 z-10': (value === 'Business'), 'border-gray-200': !(value === 'Business') }">
                                                                        <span class="flex items-center text-sm">
                                                                            <input type="radio" x-model="value" name="pricing-plan" value="Business" class="w-4 h-4 text-orange-500 border-gray-300 focus:ring-gray-900" aria-labelledby="pricing-plans-1-label" aria-describedby="pricing-plans-1-description-0 pricing-plans-1-description-1">
                                                                            <span id="pricing-plans-1-label" class="ml-3 font-medium text-gray-900">Business</span>
                                                                        </span>
                                                                        <span id="pricing-plans-1-description-0" class="pl-1 ml-6 text-sm md:ml-0 md:pl-0 md:text-center">
                                                                            <span class="font-medium text-gray-900" x-description="Checked: &quot;text-orange-900&quot;, Not Checked: &quot;text-gray-900&quot;" :class="{ 'text-orange-900': (value === 'Business'), 'text-gray-900': !(value === 'Business') }">$99 / mo</span>
                                                                            <!-- space -->
                                                                            <span x-description="Checked: &quot;text-orange-700&quot;, Not Checked: &quot;text-gray-500&quot;" :class="{ 'text-orange-700': (value === 'Business'), 'text-gray-500': !(value === 'Business') }" class="text-gray-500">($990 / yr)</span>
                                                                        </span>
                                                                        <span id="pricing-plans-1-description-1" class="pl-1 ml-6 text-sm text-gray-500 md:ml-0 md:pl-0 md:text-right" x-description="Checked: &quot;text-orange-700&quot;, Not Checked: &quot;text-gray-500&quot;" :class="{ 'text-orange-700': (value === 'Business'), 'text-gray-500': !(value === 'Business') }">Up to 25 active job postings</span>
                                                                    </label>

                                                                    <label x-radio-group-option="" class="relative z-10 flex flex-col p-4 border border-orange-200 cursor-pointer rounded-bl-md rounded-br-md md:pl-4 md:pr-6 md:grid md:grid-cols-3 focus:outline-none bg-orange-50" x-description="Checked: &quot;bg-orange-50 border-orange-200 z-10&quot;, Not Checked: &quot;border-gray-200&quot;" :class="{ 'bg-orange-50 border-orange-200 z-10': (value === 'Enterprise'), 'border-gray-200': !(value === 'Enterprise') }">
                                                                        <span class="flex items-center text-sm">
                                                                            <input type="radio" x-model="value" name="pricing-plan" value="Enterprise" class="w-4 h-4 text-orange-500 border-gray-300 focus:ring-gray-900" aria-labelledby="pricing-plans-2-label" aria-describedby="pricing-plans-2-description-0 pricing-plans-2-description-1">
                                                                            <span id="pricing-plans-2-label" class="ml-3 font-medium text-gray-900">Enterprise</span>
                                                                        </span>
                                                                        <span id="pricing-plans-2-description-0" class="pl-1 ml-6 text-sm md:ml-0 md:pl-0 md:text-center">
                                                                            <span class="font-medium text-orange-900" x-description="Checked: &quot;text-orange-900&quot;, Not Checked: &quot;text-gray-900&quot;" :class="{ 'text-orange-900': (value === 'Enterprise'), 'text-gray-900': !(value === 'Enterprise') }">$249 / mo</span>
                                                                            <!-- space -->
                                                                            <span x-description="Checked: &quot;text-orange-700&quot;, Not Checked: &quot;text-gray-500&quot;" :class="{ 'text-orange-700': (value === 'Enterprise'), 'text-gray-500': !(value === 'Enterprise') }" class="text-orange-700">($2490 / yr)</span>
                                                                        </span>
                                                                        <span id="pricing-plans-2-description-1" class="pl-1 ml-6 text-sm text-orange-700 md:ml-0 md:pl-0 md:text-right" x-description="Checked: &quot;text-orange-700&quot;, Not Checked: &quot;text-gray-500&quot;" :class="{ 'text-orange-700': (value === 'Enterprise'), 'text-gray-500': !(value === 'Enterprise') }">Unlimited active job postings</span>
                                                                    </label>

                                                                </div>
                                                            </fieldset>

                                                            <div class="flex items-center" x-data="{ on: true }">
                                                                <button type="button" class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out bg-orange-500 border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900" role="switch" aria-checked="true" x-ref="switch" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'bg-orange-500': on, 'bg-gray-200': !(on) }" aria-labelledby="annual-billing-label" :aria-checked="on.toString()" @click="on = !on">
                                                                    <span aria-hidden="true" class="inline-block w-5 h-5 transition duration-200 ease-in-out transform translate-x-5 bg-white rounded-full shadow ring-0" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'translate-x-5': on, 'translate-x-0': !(on) }"></span>
                                                                </button>
                                                                <span class="ml-3" id="annual-billing-label" @click="on = !on; $refs.switch.focus()">
                                                                    <span class="text-sm font-medium text-gray-900">Annual billing </span>
                                                                    <span class="text-sm text-gray-500">(Save 10%)</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                                                            <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-gray-800 border border-transparent rounded-md shadow-sm hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                                                                Save
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </section> --}}

                                            <!-- Billing history -->
                                            {{-- <section aria-labelledby="billing-history-heading">
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
                                                                            <tr>
                                                                                <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                                                    <time datetime="2020-01-01">1/1/2020</time>
                                                                                </td>
                                                                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">Business Plan - Annual Billing</td>
                                                                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">CA$109.00</td>
                                                                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                                                                    <a href="#" class="text-orange-600 hover:text-orange-900">View receipt</a>
                                                                                </td>
                                                                            </tr>

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
                                    </x-bladewind.tab-content>
                                </x-bladewind.tab-body>
                            </x-bladewind.tab-group> --}}
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
