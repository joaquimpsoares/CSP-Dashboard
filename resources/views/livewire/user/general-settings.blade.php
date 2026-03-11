<div>
    <div class="px-6 py-6 max-w-4xl mx-auto">

        {{-- Page Header --}}
        <div class="mb-6">
            <h1 class="text-xl font-semibold text-slate-900">{{ __('Settings') }}</h1>
            <p class="mt-1 text-sm text-slate-500">Manage your account, security, and notification preferences.</p>
        </div>

        <div x-data="{ tab: '#tab1' }">

            {{-- Tab Navigation --}}
            <div class="border-b border-slate-200 mb-6">
                <nav class="flex gap-6 -mb-px">
                    <button type="button" @click="tab='#tab1'"
                        :class="tab === '#tab1' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'border-b-2 border-transparent text-slate-500 hover:text-slate-700'"
                        class="pb-3 text-sm font-medium whitespace-nowrap transition-colors">
                        {{ ucwords(trans_choice('messages.user_profile', 1)) }}
                    </button>
                    <button type="button" @click="tab='#tab2'"
                        :class="tab === '#tab2' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'border-b-2 border-transparent text-slate-500 hover:text-slate-700'"
                        class="pb-3 text-sm font-medium whitespace-nowrap transition-colors">
                        {{ ucwords(trans_choice('messages.security', 1)) }}
                    </button>
                    <button type="button" @click="tab='#tab3'"
                        :class="tab === '#tab3' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'border-b-2 border-transparent text-slate-500 hover:text-slate-700'"
                        class="pb-3 text-sm font-medium whitespace-nowrap transition-colors">
                        {{ ucwords(trans_choice('messages.notification', 2)) }}
                    </button>
                    <button type="button" @click="tab='#tab4'"
                        :class="tab === '#tab4' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'border-b-2 border-transparent text-slate-500 hover:text-slate-700'"
                        class="pb-3 text-sm font-medium whitespace-nowrap transition-colors">
                        {{ ucwords(trans_choice('messages.business_account', 2)) }}
                    </button>
                    <button type="button" @click="tab='#tab5'"
                        :class="tab === '#tab5' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'border-b-2 border-transparent text-slate-500 hover:text-slate-700'"
                        class="pb-3 text-sm font-medium whitespace-nowrap transition-colors">
                        {{ ucwords(trans_choice('messages.payment', 2)) }}
                    </button>
                </nav>
            </div>

            {{-- Tab 1: User Profile --}}
            <div x-show="tab === '#tab1'" x-cloak class="space-y-6">
                <div class="rounded-xl border border-slate-200 bg-white">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h2 class="text-base font-semibold text-slate-800">User details</h2>
                        <p class="mt-1 text-sm text-slate-500">Update your personal information and contact details.</p>
                    </div>
                    <form wire:submit.prevent="save_user">
                        <div class="px-6 py-5 grid grid-cols-4 gap-5">
                            <div class="col-span-4 sm:col-span-2">
                                <label for="first-name" class="block text-sm font-medium text-slate-700">First name</label>
                                <input wire:model.debounce.500ms="editing.name" type="text" name="first-name" id="first-name" autocomplete="given-name"
                                    class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('editing.name') border-red-400 @enderror">
                                @error('editing.name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="col-span-4 sm:col-span-2">
                                <label for="last-name" class="block text-sm font-medium text-slate-700">Last name</label>
                                <input wire:model.debounce.500ms="editing.last_name" type="text" name="last-name" id="last-name" autocomplete="family-name"
                                    class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('editing.last_name') border-red-400 @enderror">
                                @error('editing.last_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="col-span-4 sm:col-span-2">
                                <label for="email-address" class="block text-sm font-medium text-slate-700">Email address</label>
                                <input wire:model.debounce.500ms="editing.email" type="email" name="email-address" id="email-address" autocomplete="email"
                                    class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>

                            <div class="col-span-4 sm:col-span-2">
                                <label for="phone" class="block text-sm font-medium text-slate-700">Phone</label>
                                <input wire:model.debounce.500ms="editing.phone" type="text" name="phone" id="phone" autocomplete="tel"
                                    class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>

                            <div class="col-span-4 sm:col-span-2">
                                <label for="address" class="block text-sm font-medium text-slate-700">Address</label>
                                <input wire:model.debounce.500ms="editing.address" type="text" name="address" id="address" autocomplete="street-address"
                                    class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>

                            <div class="col-span-4 sm:col-span-1">
                                <label for="city" class="block text-sm font-medium text-slate-700">City</label>
                                <input wire:model.debounce.500ms="editing.city" type="text" name="city" id="city" autocomplete="address-level2"
                                    class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>

                            <div class="col-span-4 sm:col-span-1">
                                <label for="state" class="block text-sm font-medium text-slate-700">State</label>
                                <input wire:model.debounce.500ms="editing.state" type="text" name="state" id="state" autocomplete="address-level1"
                                    class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>

                            <div class="col-span-4 sm:col-span-2">
                                <label for="postal_code" class="block text-sm font-medium text-slate-700">ZIP / Postal code</label>
                                <input wire:model.debounce.500ms="editing.postal_code" type="text" name="postal_code" id="postal_code" autocomplete="postal-code"
                                    class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>

                            <div class="col-span-4 sm:col-span-2">
                                <label for="country" class="block text-sm font-medium text-slate-700">Country</label>
                                <select wire:model="editing.country_id" name="country_id" id="country" autocomplete="country-name"
                                    class="mt-1 block w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('editing.country_id') border-red-400 @enderror">
                                    <option value="">Select a country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @error('editing.country_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="px-6 py-4 border-t border-slate-200 flex justify-end">
                            <button type="submit"
                                class="px-4 py-2 rounded-lg bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tab 2: Security --}}
            <div x-show="tab === '#tab2'" x-cloak class="space-y-6">

                {{-- Change Password --}}
                <div class="rounded-xl border border-slate-200 bg-white">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h2 class="text-base font-semibold text-slate-800">Change password</h2>
                        <p class="mt-1 text-sm text-slate-500">Update your password to keep your account secure.</p>
                    </div>
                    <form wire:submit.prevent="saveauth">
                        <div class="px-6 py-5 grid grid-cols-4 gap-5">
                            <div class="col-span-4 sm:col-span-2">
                                <label for="password" class="block text-sm font-medium text-slate-700">{{ ucwords(trans_choice('messages.password', 1)) }}</label>
                                <input wire:model="password" type="password" name="password" id="password" autocomplete="new-password" placeholder="New password"
                                    class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('password') border-red-400 @enderror">
                                @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-span-4 sm:col-span-2">
                                <label for="password_confirmation" class="block text-sm font-medium text-slate-700">{{ ucwords(trans_choice('messages.password_confirmation', 2)) }}</label>
                                <input wire:model="password_confirmation" type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" placeholder="Confirm password"
                                    class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                        </div>
                        <div class="px-6 py-4 border-t border-slate-200 flex justify-end">
                            <button type="submit"
                                class="px-4 py-2 rounded-lg bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Update password
                            </button>
                        </div>
                    </form>
                </div>

                {{-- API Tokens --}}
                <div class="rounded-xl border border-slate-200 bg-white" wire:ignore.self>
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h2 class="text-base font-semibold text-slate-800">API Tokens</h2>
                        <p class="mt-1 text-sm text-slate-500">API tokens allow third-party services to authenticate with this application on your behalf.</p>
                    </div>
                    <div class="px-6 py-5 space-y-4">
                        <div class="flex gap-3">
                            <div class="flex-1">
                                <input wire:model.debounce.500ms="token_name" type="text" name="token_name" id="token_name" placeholder="Token name"
                                    class="block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('token_name') border-red-400 @enderror">
                                @error('token_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <button wire:click="generateToken" type="button"
                                class="px-4 py-2 rounded-lg border border-slate-200 text-sm font-medium text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 whitespace-nowrap">
                                Generate token
                            </button>
                        </div>

                        @if($token)
                        <div class="rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3">
                            <p class="text-sm font-medium text-emerald-800 mb-2">Token created — copy it now, it won't be shown again.</p>
                            <input type="text" wire:model="token" readonly
                                class="block w-full rounded-lg border border-emerald-200 bg-white px-3 py-2 text-sm font-mono text-slate-700 focus:outline-none">
                        </div>
                        @endif

                        @if($editing->tokens->count() > 0)
                        <div class="rounded-lg border border-slate-200 overflow-hidden">
                            <ul role="list" class="divide-y divide-slate-100">
                                @foreach($editing->tokens as $apiToken)
                                <li class="flex items-center justify-between px-4 py-3">
                                    <p class="text-sm font-medium text-slate-700">{{ $apiToken->name }}</p>
                                    <button wire:click="deleteToken({{ $apiToken->id }})" type="button"
                                        class="text-xs font-medium text-red-600 hover:text-red-800">
                                        Delete
                                    </button>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Tab 3: Notifications --}}
            <div x-show="tab === '#tab3'" x-cloak class="space-y-6">
                <div class="rounded-xl border border-slate-200 bg-white">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h2 class="text-base font-semibold text-slate-800">{{ ucwords(trans_choice('messages.notifications', 1)) }}</h2>
                        <p class="mt-1 text-sm text-slate-500">{{ ucwords(trans_choice('descriptions.notifications_description', 1)) }}</p>
                    </div>
                    <div class="px-6 py-5 space-y-6">

                        {{-- Email toggle --}}
                        <div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-800">{{ ucwords(trans_choice('messages.email', 1)) }}</p>
                                    <p class="text-sm text-slate-500">{{ ucwords(trans_choice('descriptions.recieve_email_notifications', 1)) }}</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input wire:model="mail" type="checkbox" class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-500 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                </label>
                            </div>

                            @if($mail == true)
                            <div class="mt-4 grid grid-cols-4 gap-4">
                                <div class="col-span-4 sm:col-span-2">
                                    <label for="hostname" class="block text-sm font-medium text-slate-700">{{ ucwords(trans_choice('messages.hostname', 1)) }}</label>
                                    <input wire:model="hostname" type="text" name="hostname" id="hostname"
                                        class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div class="col-span-4 sm:col-span-1">
                                    <label for="port" class="block text-sm font-medium text-slate-700">{{ ucwords(trans_choice('messages.port', 1)) }}</label>
                                    <input wire:model="port" type="text" name="port" id="port"
                                        class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div class="col-span-4 sm:col-span-1">
                                    <label for="encryption" class="block text-sm font-medium text-slate-700">{{ ucwords(trans_choice('messages.encryption', 1)) }}</label>
                                    <input wire:model="encryption" type="text" name="encryption" id="encryption"
                                        class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div class="col-span-4 sm:col-span-2">
                                    <label for="smtp_username" class="block text-sm font-medium text-slate-700">{{ ucwords(trans_choice('messages.username', 1)) }}</label>
                                    <input wire:model="username" type="text" name="smtp_username" id="smtp_username"
                                        class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div class="col-span-4 sm:col-span-2">
                                    <label for="smtp_password" class="block text-sm font-medium text-slate-700">{{ ucwords(trans_choice('messages.password', 1)) }}</label>
                                    <input wire:model="password" type="password" name="smtp_password" id="smtp_password"
                                        class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="border-t border-slate-100 -mx-6"></div>

                        {{-- Teams toggle --}}
                        <div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-800">{{ ucwords(trans_choice('messages.teams', 1)) }}</p>
                                    <p class="text-sm text-slate-500">{{ ucwords(trans_choice('descriptions.recieve_teams_notifications', 1)) }}</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input wire:model="teams" type="checkbox" class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-focus:ring-2 peer-focus:ring-indigo-500 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                </label>
                            </div>

                            @if($teams == true)
                            <div class="mt-4">
                                <label for="teams_webhook" class="block text-sm font-medium text-slate-700">Webhook URL</label>
                                <input wire:model="teams_webhook" type="url" name="teams_webhook" id="teams_webhook"
                                    class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-slate-200 flex justify-end">
                        <button wire:click="saveNotifications" type="button"
                            class="px-4 py-2 rounded-lg bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            {{ ucwords(trans_choice('messages.save', 1)) }}
                        </button>
                    </div>
                </div>
            </div>

            {{-- Tab 4: Business Account --}}
            <div x-show="tab === '#tab4'" x-cloak>
                <div class="rounded-xl border border-slate-200 bg-white px-6 py-12 text-center">
                    <p class="text-sm text-slate-500">Business account settings coming soon.</p>
                </div>
            </div>

            {{-- Tab 5: Payments --}}
            <div x-show="tab === '#tab5'" x-cloak class="space-y-6">

                {{-- Payment details --}}
                <div class="rounded-xl border border-slate-200 bg-white">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h2 class="text-base font-semibold text-slate-800">Payment details</h2>
                        <p class="mt-1 text-sm text-slate-500">Update your billing information. Please note that updating your location could affect your tax rates.</p>
                    </div>
                    <form action="#" method="POST">
                        <div class="px-6 py-5 grid grid-cols-4 gap-5">
                            <div class="col-span-4 sm:col-span-2">
                                <label for="pay-first-name" class="block text-sm font-medium text-slate-700">First name</label>
                                <input type="text" name="first-name" id="pay-first-name" autocomplete="cc-given-name"
                                    class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div class="col-span-4 sm:col-span-2">
                                <label for="pay-last-name" class="block text-sm font-medium text-slate-700">Last name</label>
                                <input type="text" name="last-name" id="pay-last-name" autocomplete="cc-family-name"
                                    class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div class="col-span-4 sm:col-span-2">
                                <label for="pay-email" class="block text-sm font-medium text-slate-700">Email address</label>
                                <input type="email" name="email-address" id="pay-email" autocomplete="email"
                                    class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div class="col-span-4 sm:col-span-1">
                                <label for="expiration-date" class="block text-sm font-medium text-slate-700">Expiration date</label>
                                <input type="text" name="expiration-date" id="expiration-date" autocomplete="cc-exp" placeholder="MM / YY"
                                    class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div class="col-span-4 sm:col-span-1">
                                <label for="security-code" class="flex items-center gap-1 text-sm font-medium text-slate-700">
                                    Security code
                                    <svg class="h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                    </svg>
                                </label>
                                <input type="text" name="security-code" id="security-code" autocomplete="cc-csc"
                                    class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div class="col-span-4 sm:col-span-2">
                                <label for="pay-country" class="block text-sm font-medium text-slate-700">Country</label>
                                <select id="pay-country" name="country" autocomplete="country-name"
                                    class="mt-1 block w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <option>United States</option>
                                    <option>Canada</option>
                                    <option>Mexico</option>
                                </select>
                            </div>
                            <div class="col-span-4 sm:col-span-2">
                                <label for="postal-code" class="block text-sm font-medium text-slate-700">ZIP / Postal code</label>
                                <input type="text" name="postal-code" id="postal-code" autocomplete="postal-code"
                                    class="mt-1 block w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                        </div>
                        <div class="px-6 py-4 border-t border-slate-200 flex justify-end">
                            <button type="submit"
                                class="px-4 py-2 rounded-lg bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Save
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Billing history --}}
                <div class="rounded-xl border border-slate-200 bg-white overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h2 class="text-base font-semibold text-slate-800">Billing history</h2>
                    </div>
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wide">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wide">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wide">Amount</th>
                                <th class="relative px-6 py-3"><span class="sr-only">View receipt</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($invoices as $invoice)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 text-slate-700 whitespace-nowrap">
                                    <time>{{ $invoice->issueDate }}</time>
                                </td>
                                <td class="px-6 py-4 text-slate-500 whitespace-nowrap">Business Plan - Annual Billing</td>
                                <td class="px-6 py-4 text-slate-700 whitespace-nowrap"></td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <a href="#" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">View receipt</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-sm text-slate-400">No billing history found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
