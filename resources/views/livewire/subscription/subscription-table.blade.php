<div>
    <div class="relative z-0 flex-col flex-1 overflow-y-auto">
        <div class="p-4 overflow-hidden bg-white">
            <div class="relative pb-0 border-b border-gray-200 sm:pb-0">
                <div class="md:flex md:items-center md:justify-between">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        {{ ucwords(trans_choice('messages.subscription_table', 2)) }}
                    </h3>
                    <div class="flex mt-3 md:mt-0 md:absolute md:top-3 md:right-0">
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
                                    <input wire:model.live="search" id="search" class="block w-full bg-white py-1.5 pl-10 pr-3 border border-slate-300 rounded-lg leading-5 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/20 focus:border-primary-500 sm:text-sm" placeholder="Search subscriptions" type="search" name="search">
                                </div>
                            </div>
                        </div>
                        <a wire:click="$toggle('showFilters')" href="#" class="px-2 py-2 ml-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="hidden w-5 h-5 lg:inline" viewBox="0 0 20 20" fill="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                        </a>
                        <a onclick="confirm('Are you sure you want to export these Records?') || event.stopImmediatePropagation()"wire:click="exportSelected()" href="#" class="px-2 py-2 ml-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="hidden w-5 h-5 lg:inline" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                            </svg>
                            {{ ucwords(trans_choice('messages.export', 1)) }}
                        </a>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="sm:hidden" x-description="Dropdown menu on small screens">
                        <label for="current-tab" class="sr-only">Select a tab</label>
                        <select wire:model="filters" id="current-tab" name="current-tab" class="block w-full py-2 pl-3 pr-10 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option wire:click="legacy">{{ ucwords(trans_choice('messages.legacy', 1)) }}</option>
                            <option wire:click="perpetual">{{ ucwords(trans_choice('messages.perpetual_software', 1)) }}</option>
                            <option wire:click="expiration" selected="">{{ ucwords(trans_choice('messages.abouttoexpire', 1)) }}</option>
                            <option wire:click="nce" >{{ ucwords(trans_choice('messages.nce', 2)) }}</option>
                        </select>
                    </div>
                    <div class="hidden sm:block" x-description="Tabs at small breakpoint and up" >
                        <div class="border-b border-gray-200">
                            <nav class="flex -mb-px space-x-8" x-data="{tab: 1}">
                                <a wire:click="resetFilters" class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === 1}" href="#" @click.prevent="tab = 1">
                                    {{ ucwords(trans_choice('messages.all', 1)) }}
                                </a>
                                <a href="#" wire:click="legacy" class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === 2}" href="#" @click.prevent="tab = 2" @click.prevent="tab = 2">
                                    {{ ucwords(trans_choice('messages.legacy', 1)) }}
                                </a>
                                <a href="#" wire:click="perpetual" class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === 3}" href="#" @click.prevent="tab = 3" @click.prevent="tab = 3">
                                    {{ ucwords(trans_choice('messages.perpetual_software', 1)) }}
                                </a>
                                <a href="#" wire:click="expiration" class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === 4}" href="#" @click.prevent="tab = 4" @click.prevent="tab = 4">
                                    {{ ucwords(trans_choice('messages.abouttoexpire', 1)) }}
                                </a>
                                <a href="#" wire:click="nce" class="px-1 pb-4 text-sm font-medium text-gray-500 whitespace-nowrap" :class="{'z-20 text-indigo-600 border-b-2 border-indigo-500': tab === 5}" href="#" @click.prevent="tab = 5" @click.prevent="tab = 5">
                                    {{ ucwords(trans_choice('messages.nce', 1)) }}
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
                <div>
                    @if ($showFilters)
                    <div class="relative flex p-4 mt-3 bg-indigo-100 rounded shadow-inner">
                        <div class="w-1/2 pr-2 space-y-4">
                            <x-input.group inline for="filter-status" label="Status">
                                <x-input.select wire:model="filters.status" id="filter-status">
                                    <option value="" disabled>Select Status...</option>
                                    @foreach (App\Subscription::STATUSES as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </x-input.select>
                            </x-input.group>
                            <x-input.group inline for="filter-date-min" label="Expiration Date">
                                <x-input.date wire:model="filters.date-min" id="filter-date-min" placeholder="YYYY/MM/DD" />
                            </x-input.group>
                            <x-input.group inline for="filter-date-max" label="Expiration Date">
                                <x-input.date wire:model="filters.date-max" id="filter-date-max" placeholder="YYYY/MM/DD" />
                            </x-input.group>
                        </div>
                        <div class="w-1/2 pl-2 space-y-4">
                            <x-button.link wire:click="resetFilters" class="absolute bottom-0 right-0 p-4">Reset Filters</x-button.link>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="mt-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full px-4 py-1 align-middle">
                        <div class="flex-col mt-5 space-y-4">
                            <x-tableazure>
                                <x-slot name="head">
                                    <x-table.heading class="w-8 pr-0">
                                        <x-input.checkbox wire:model="selectPage" />
                                    </x-table.heading>
                                    <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('id')" :direction="$sorts['id'] ?? null">{{ ucwords(trans_choice('messages.id', 2)) }}</x-table.heading>
                                    <x-table.heading sortable multi-column wire:click="sortBy('name')"  :direction="$sorts['name'] ?? null">{{ ucwords(trans_choice('messages.subscription_name', 1)) }}</x-table.heading>
                                    <x-table.heading  wire:click="sortBy('subscriptions')"         :direction="$sorts['subscriptions'] ?? null">{{ ucwords(trans_choice('messages.company_name', 1)) }}</x-table.heading>
                                    <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('amount')"       :direction="$sorts['amount'] ?? null">{{ ucwords(trans_choice('messages.quantity', 1)) }}</x-table.heading>
                                    <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('expiration_data')"       :direction="$sorts['expiration_data'] ?? null">{{ ucwords(trans_choice('messages.expiration', 1)) }}</x-table.heading>
                                    <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('billing_period')"       :direction="$sorts['billing_period'] ?? null">{{ ucwords(trans_choice('messages.billing_cycle', 1)) }}</x-table.heading>
                                    <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('status')"       :direction="$sorts['status'] ?? null">{{ ucwords(trans_choice('messages.status', 1)) }}</x-table.heading>
                                </x-slot>
                                <x-slot name="body">
                                    @if ($selectPage)
                                    <x-table.row class="bg-cool-gray-200" wire:key="row-message">
                                        <x-table.cell colspan="9">
                                            @unless ($selectAll)
                                            <div>
                                                <span>You have selected <strong>{{ $subscriptions->count() }}</strong> transactions, do you want to select all <strong>{{ $subscriptions->total() }}</strong>?</span>
                                                <x-button.link wire:click="selectAll" class="ml-1 text-blue-600">Select All</x-button.link>
                                            </div>
                                            @else
                                            <span>You are currently selecting all <strong>{{ $subscriptions->total() }}</strong> transactions.</span>
                                            @endif
                                        </x-table.cell>
                                    </x-table.row>
                                    @endif
                                    @forelse ($subscriptions as $subscription)
                                    <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $subscription['id'] }}">
                                        <x-table.cell class="pr-0">
                                            <x-input.checkbox wire:model="selected" value="{{ $subscription['id'] }}" ></x-input.checkbox>
                                        </x-table.cell>
                                        <x-table.cell visibility='hidden' tablecell='lg:table-cell'>
                                            <a href="{{$subscription->format()['path']}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                                <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                        {{ $subscription['id'] }}
                                                    </span>
                                                </div>
                                            </a>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <a href="{{$subscription->format()['path']}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                                <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                        {{$subscription->name}}
                                                        @if($subscription->productonce)
                                                        @if($subscription->productonce->isNCE())
                                                        <span class="flex-shrink-0 inline-block px-2 py-0.5 ml-1 text-gray-600 text-xs font-medium bg-blue-300 rounded-full">{{ ucwords(trans_choice('messages.nce', 2)) }}</span>
                                                        @endif
                                                        @endif
                                                        @if($subscription->autorenew == 0)
                                                        <span class="flex-shrink-0 inline-block ml-1 px-2 py-0.5 text-red-800 text-xs font-medium bg-red-100 rounded-full">{{ ucwords(trans_choice('messages.no_autorenew', 1)) }}</span>
                                                        @endif
                                                    </span>
                                                </div>
                                            </a>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <a href="{{$subscription->format()['path']}}" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                                <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                        {{$subscription->customer->company_name}}
                                                    </span>
                                                </div>
                                            </a>
                                        </x-table.cell>
                                        @if ($subscription->billing_type === 'usage' )
                                        <x-table.cell>
                                            <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                            </div>
                                        </x-table.cell>
                                        @else
                                        <x-table.cell>
                                            <a href="{{$subscription->format()['path']}}" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                                <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                        {{$subscription->amount}}
                                                    </span>
                                                </div>
                                            </a>
                                        </x-table.cell>
                                        @endif
                                        <x-table.cell>
                                            <a href="{{$subscription->format()['path']}}" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                                <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                        {{$subscription->expiration_data}}
                                                    </span>
                                                </div>
                                            </a>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <a href="{{$subscription->format()['path']}}" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                                <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                        {{$subscription->billing_period}}
                                                    </span>
                                                </div>
                                            </a>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <a href="{{$subscription->format()['path']}}" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                                <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $subscription->status->name == 'messages.active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'  }}  capitalize">
                                                            {{ ucwords(trans_choice($subscription->status->name, 1)) }}
                                                        </span>
                                                    </span>
                                                </div>
                                            </a>
                                        </x-table.cell>
                                        <x-table.cell class="text-right">
                                            @php($disabled = ($subscription->status->name ?? '') === 'messages.canceled' || ($subscription->status->name ?? '') === 'messages.inactive')

                                            @if($openRowId === (int)$subscription->id)
                                                <button type="button" wire:click="closeEdit"
                                                    class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                                    Close
                                                </button>
                                            @else
                                                <button type="button" wire:click="edit({{ $subscription->id }})" @disabled($disabled)
                                                    class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20 disabled:opacity-40 disabled:cursor-not-allowed">
                                                    <x-icon.edit />
                                                    Edit
                                                </button>
                                            @endif
                                        </x-table.cell>
                                    </x-table.row>

                                    @if($openRowId === (int)$subscription->id)
                                        <x-table.row wire:key="row-subscription-edit-{{ $subscription->id }}" class="bg-slate-50/60">
                                            <x-table.cell colspan="9">
                                                <div class="p-4 sm:p-6">
                                                    <div class="flex items-start justify-between gap-4">
                                                        <div>
                                                            <div class="text-sm font-semibold text-slate-900">Edit subscription</div>
                                                            <div class="mt-0.5 text-xs text-slate-600">Changes are applied via Microsoft APIs when applicable. Be careful with NCE reductions.</div>
                                                        </div>
                                                        <div class="flex items-center gap-2">
                                                            <button type="button" wire:click="closeEdit"
                                                                class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                                                Cancel
                                                            </button>
                                                            @php($mode = $policyDecision['mode'] ?? 'immediate')
                                                            @php($reason = $policyDecision['reason_message'] ?? null)

                                                            @if($mode === 'immediate')
                                                                <button type="button" wire:click="save"
                                                                    class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                                                                    Apply now
                                                                </button>
                                                            @elseif($mode === 'schedule')
                                                                <button type="button" wire:click="scheduleForRenewal"
                                                                    class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-500/30">
                                                                    Schedule for renewal
                                                                </button>
                                                                <button type="button" disabled
                                                                    class="inline-flex items-center gap-2 rounded-lg bg-primary-300 px-3 py-2 text-sm font-semibold text-white shadow-sm opacity-60 cursor-not-allowed">
                                                                    Apply now
                                                                </button>
                                                            @else
                                                                <button type="button" disabled
                                                                    class="inline-flex items-center gap-2 rounded-lg bg-slate-300 px-3 py-2 text-sm font-semibold text-white shadow-sm opacity-60 cursor-not-allowed">
                                                                    Apply now
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    @if(!empty($reason))
                                                        <div class="mt-3 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700">
                                                            {{ $reason }}
                                                        </div>
                                                    @endif

                                                    <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-3">
                                                        <div class="md:col-span-2">
                                                            <label class="block text-sm font-medium text-slate-700" for="sub-name-{{ $subscription->id }}">Name</label>
                                                            <input id="sub-name-{{ $subscription->id }}" type="text" wire:model.defer="editing.name"
                                                                class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20" />
                                                            @error('editing.name')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                                        </div>

                                                        <div>
                                                            <label class="block text-sm font-medium text-slate-700" for="sub-amount-{{ $subscription->id }}">Quantity</label>
                                                            <input id="sub-amount-{{ $subscription->id }}" type="number" wire:model.defer="editing.amount"
                                                                min="{{ $min_quantity }}" max="{{ $max_quantity }}"
                                                                class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20" />
                                                            <p class="mt-1 text-xs text-slate-500">Min: {{ $min_quantity }} · Max: {{ $max_quantity }}</p>
                                                            @error('editing.amount')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                                        </div>

                                                        <div>
                                                            <label class="block text-sm font-medium text-slate-700" for="sub-billing-{{ $subscription->id }}">Billing cycle</label>
                                                            <select id="sub-billing-{{ $subscription->id }}" wire:model.defer="editing.billing_period"
                                                                class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20">
                                                                <option value="monthly">Monthly</option>
                                                                <option value="annual">Annual</option>
                                                                <option value="one_time">One time</option>
                                                            </select>
                                                            @error('editing.billing_period')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                                        </div>

                                                        <div>
                                                            <label class="block text-sm font-medium text-slate-700" for="sub-term-{{ $subscription->id }}">Term</label>
                                                            <select id="sub-term-{{ $subscription->id }}" wire:model.defer="editing.term"
                                                                class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20">
                                                                <option value="P1M">1 month</option>
                                                                <option value="P1Y">1 year</option>
                                                            </select>
                                                            @error('editing.term')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                                        </div>

                                                        <div>
                                                            <label class="block text-sm font-medium text-slate-700" for="sub-autorenew-{{ $subscription->id }}">Auto-renew</label>
                                                            <select id="sub-autorenew-{{ $subscription->id }}" wire:model.defer="editing.autorenew"
                                                                class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20">
                                                                <option value="1">Enabled</option>
                                                                <option value="0">Disabled</option>
                                                            </select>
                                                            @error('editing.autorenew')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                                        </div>

                                                        <div>
                                                            <label class="block text-sm font-medium text-slate-700" for="sub-status-{{ $subscription->id }}">Status</label>
                                                            <select id="sub-status-{{ $subscription->id }}" wire:model.defer="editing.status_id"
                                                                class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20">
                                                                @foreach (App\Subscription::STATUSES as $value => $label)
                                                                    <option value="{{ $value }}">{{ $label }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('editing.status_id')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                                        </div>
                                                    </div>

                                                    @if($editing?->productonce && $editing->productonce->IsNCE())
                                                        <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                                                            <span class="font-semibold">NCE note:</span> You can only reduce seat quantity within the cancellation window.
                                                        </div>
                                                    @endif
                                                </div>
                                            </x-table.cell>
                                        </x-table.row>
                                    @endif
                                    @empty
                                    <x-table.row>
                                        <x-table.cell colspan="9">
                                            <div class="flex items-center justify-center space-x-2">
                                                <x-icon.inbox class="w-8 h-8 text-cool-gray-400" />
                                                <span class="py-8 text-xl font-medium text-cool-gray-400">No Subscription found...</span>
                                            </div>
                                        </x-table.cell>
                                    </x-table.row>
                                    @endforelse
                                </x-slot>
                            </x-tableazure>
                            <div>
                                {{ $subscriptions->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        {{-- Subscription edit is now inline (collapsible per row). --}}
    </div>

<x-bladewind.modal
name="delete-paymentz"
show_action_buttons="false">

// this shows that process is in progress
<x-bladewind.processing
name="processing-delete"
message="Deleting pending payment"
hide="false" />

// this is shown when process completes with a pass
<x-bladewind.process-complete
name="delete-payment-yes"
process_completed_as="passed"
button_label="Done"
button_action="alert('i passed... closing modal now'); hideModal('delete-paymentz')"
message="Pending payment was deleted successfully" />

// this is shown when process completes with a failure
<x-bladewind.process-complete
name="delete-payment-no"
process_completed_as="failed"
button_label="Done"
button_action="alert('i failed... closing modal now'); hideModal('delete-paymentz')"
message="Pending payment could not be deleted" />

</x-bladewind.modal>

<script>
    deletePayment = (mode) => {
        // it is preferred to hide all three elements
        // and show only the element that needs to be shown
        // hide the processing delete element
        hideHideables();

        // show the modal and the processing delete element
        // showModal() and unhide() are helper functions
        // available in BladewindUI
        showModal('delete-paymentz');
        unhide('.processing-delete');

        // this example only shows a specific outcome
        // after 3 seconds based on which button was clicked.
        // In your apps you will typically display an outcome
        // based on some API return value or something similar
        setTimeout(function() {

            hideHideables();

            // determine which process outcome to show
            (mode == 'pass') ?
            unhide('.delete-payment-yes') :
            unhide('.delete-payment-no');
        }, 3000);
    }

    hideHideables = () => {
        // hide() is a helper function available in BladewindUI
        hide('.processing-delete');
        hide('.delete-payment-yes');
        hide('.delete-payment-no');
    }
</script>
</div>
