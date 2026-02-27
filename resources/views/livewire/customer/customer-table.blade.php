<div>
    <div class="relative z-0 flex-col flex-1 overflow-visible">
        <div class="p-6 bg-transparent">
            <div class="flex flex-col">
                <div class="flex flex-col items-center justify-between lg:flex-row">
                    <div class="flex items-center">
                        <h4 class="text-base font-semibold text-slate-900">{{ ucwords(trans_choice('messages.customer_table', 2)) }}</h4>
                    </div>
                    <div class="flex items-center justify-between gap-3">
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
                                        <input wire:model="search" id="search" class="block w-full bg-white py-2 pl-10 pr-3 border border-slate-300 rounded-lg leading-5 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/20 focus:border-primary-500 sm:text-sm" placeholder="Search customers" type="search" name="search">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <a onclick="confirm('Are you sure you want to export these Records?') || event.stopImmediatePropagation()" wire:click="exportSelected()" href="#" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="hidden w-5 h-5 lg:inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                                </svg>
                                {{ ucwords(trans_choice('messages.export', 1)) }}
                            </a>
                        </div>

                        @if(Auth::user()->userLevel->name == 'Reseller')
                        <div>
                            <a href="#" wire:click="create" class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="hidden w-5 h-5 lg:inline" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                {{ ucwords(trans_choice('messages.create', 1)) }}
                            </a>
                        </div>
                        @endif
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
                        @forelse ($customers as $customer)
                        <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $customer['id'] }}">
                            <x-table.cell visibility='hidden' tablecell='lg:table-cell'>
                                <a href="{{$customer->format()['path']}}" class="block w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                    <div class="h-full py-2 pl-1 pr-2 m-0 overflow-visible">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                            {{ $customer['id'] }}
                                        </span>
                                    </div>
                                </a>
                            </x-table.cell>
                            <x-table.cell>
                                <div class="h-full py-2 pl-1 pr-2 m-0 overflow-visible">
                                    <a href="{{$customer->format()['path']}}" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                            {{ $customer['company_name'] }}
                                        </span>
                                    </div>
                                </a>
                            </x-table.cell>
                            <x-table.cell>
                                <a href="{{$customer->format()['path']}}" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                    <div class="h-full py-2 pl-1 pr-2 m-0 overflow-visible">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                            {{ $customer->subscriptions->count() ?? ''}}
                                        </span>
                                    </div>
                                </a>
                            </x-table.cell>
                            <x-table.cell>
                                <a href="{{$customer->format()['path']}}" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                    <div class="h-full py-2 pl-1 pr-2 m-0 overflow-visible">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                            {{ $customer->resellers->first()->company_name ?? ''}}
                                        </span>
                                    </div>
                                </a>
                            </x-table.cell>

                            <x-table.cell>
                                <a href="{{$customer->format()['path']}}" class="w-full h-full p-0 m-0 no-underline bg-transparent border-0 cursor-pointer hover:text-gray-900 hover:no-underline">
                                    <div class="h-full py-2 pl-1 pr-2 m-0 overflow-visible">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                            {{ $customer->country->name ?? ''}}
                                        </span>
                                    </div>
                                </a>
                            </x-table.cell>
                            <x-table.cell class="text-right">
                                <!-- Use a fixed-position dropdown to avoid clipping inside overflow scroll containers -->
                                <div x-data="{
                                        componentId: @js($this->getId()),
                                        open: false,
                                        top: 0,
                                        left: 0,
                                        width: 0,
                                        place() {
                                            const r = this.$refs.btn.getBoundingClientRect();
                                            this.width = 192; // w-48
                                            this.top = r.bottom + 8;
                                            this.left = Math.max(8, r.right - this.width);
                                        },
                                        toggle() {
                                            this.open = !this.open;
                                            if (this.open) this.$nextTick(() => this.place());
                                        },
                                        callEdit(id) {
                                            // Teleported DOM isn't reliably wired for `wire:click`, so call by component id.
                                            const lw = window.Livewire;
                                            if (lw && lw.find) {
                                                const c = lw.find(this.componentId);
                                                if (!c) return;
                                                // Force a state change so repeated opens work reliably.
                                                c.set('showEditModal', false);
                                                // Give Livewire a beat to tear down the old modal DOM before reopening.
                                                setTimeout(() => c.call('edit', id), 50);
                                            }
                                        }
                                    }"
                                    @keydown.escape.window="open = false"
                                    class="inline-block">

                                    <button type="button" x-ref="btn" @click="toggle()"
                                        class="inline-flex items-center justify-center rounded-lg px-2 py-2 text-slate-600 hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                                        aria-haspopup="true">
                                        <span class="sr-only">Open actions</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>

                                    <template x-teleport="body">
                                        <div x-cloak x-show="open" @click.away="open = false" @scroll.window="open = false" @resize.window="open = false"
                                            class="fixed z-[9999] w-48 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg"
                                            :style="`top:${top}px; left:${left}px;`">

                                            <button type="button" @click="callEdit({{ $customer->id }}); open = false"
                                                class="flex w-full items-center gap-2 px-4 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-50">
                                                <x-icon.edit></x-icon.edit>
                                                <span>{{ ucwords(trans_choice('messages.edit', 1)) }}</span>
                                            </button>

                                            @canImpersonate
                                                @if(!empty($customer->format()['mainUser']))
                                                    <a class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
                                                       href="{{ route('impersonate', $customer->format()['mainUser']['id'])}}">
                                                        <x-icon.impersonate></x-icon.impersonate>
                                                        <span>{{ ucwords(trans_choice('messages.impersonate', 1)) }}</span>
                                                    </a>
                                                @endif
                                            @endCanImpersonate
                                        </div>
                                    </template>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                        @empty
                        <x-table.row>
                            <x-table.cell colspan="9">
                                <div class="flex items-center justify-center space-x-2">
                                    <x-icon.inbox class="w-8 h-8 text-cool-gray-400" />
                                    <span class="py-8 text-xl font-medium text-cool-gray-400">No Customer found...</span>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                        @endforelse
                    </x-slot>
                </x-tableazure>
                <div>
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- Save Transaction Modal -->
    <div>
        @if($showEditModal == true)
        <form wire:submit.prevent="submit">
            <x-modal.slideout wire:model="showEditModal">
                @if ($showCreateUser == false)
                <x-slot name="title">{{ ucwords(trans_choice('messages.edit_customer', 1)) }}</x-slot>
                @elseif($showCreateUser == true)
                <x-slot name="title">{{ ucwords(trans_choice('messages.create_customer', 1)) }}</x-slot>
                @endif
                <x-slot name="content">
                    <div class="mb-4 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-xs text-slate-600">
                        Editing: <span class="font-semibold text-slate-900">{{ $editing->company_name ?? '—' }}</span> (ID: {{ $editing->id ?? '—' }})
                    </div>

                    @if ($errors->any())
                        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                            <div class="font-semibold">Missing required fields / validation errors:</div>
                            <ul class="mt-1 list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <section class="dark-grey-text">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <x-label for="company_name" class="">{{ ucwords(trans_choice('messages.company_name', 1)) }}</x-label>
                                        <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20" value="{{ $editing->company_name ?? '' }}" type="text" id="company_name" name="company_name">
                                        @error('editing.company_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                    <div class="mb-2 col-md-6">
                                        <x-label for="nif">{{ ucwords(trans_choice('messages.nif', 1)) }}</x-label>
                                        <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20" value="{{ $editing->nif ?? '' }}" type="text" id="nif" name="nif">
                                        @error('editing.nif')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-2 col-md-12">
                                        <label class="block text-sm font-medium text-slate-700" for="country_id">
                                            {{ ucwords(trans_choice('messages.country', 1)) }} <span class="text-red-600">*</span>
                                        </label>
                                        <div class="mb-3 input-group">
                                            <select
                                                wire:model.debounce.500ms="editing.country_id"
                                                name="country_id"
                                                id="country_id"
                                                @class([
                                                    'block w-full rounded-lg bg-white px-3 py-2 text-sm text-slate-900 shadow-sm border focus:ring-4',
                                                    'border-slate-300 focus:border-primary-500 focus:ring-primary-500/20' => !$errors->has('editing.country_id'),
                                                    'border-red-400 focus:border-red-500 focus:ring-red-500/20' => $errors->has('editing.country_id'),
                                                ])
                                                required
                                            >
                                                <option value="" disabled>—</option>
                                                @foreach ($countries as $key => $country)
                                                <option value="{{$key}}" @selected((int)$editing->country_id === (int)$key)>{{$country}}</option>
                                                @endforeach
                                            </select>
                                            @error('editing.country_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-slate-700" for="address_1">
                                        {{ ucwords(trans_choice('messages.address_1', 1)) }} <span class="text-red-600">*</span>
                                    </label>
                                    <input
                                        @class([
                                            'w-full rounded-lg bg-white px-3 py-2 text-sm text-slate-900 shadow-sm border focus:ring-4',
                                            'border-slate-300 focus:border-primary-500 focus:ring-primary-500/20' => !$errors->has('editing.address_1'),
                                            'border-red-400 focus:border-red-500 focus:ring-red-500/20' => $errors->has('editing.address_1'),
                                        ])
                                        value="{{ $editing->address_1 ?? '' }}"
                                        type="text"
                                        id="address_1"
                                        name="address_1"
                                        placeholder="1234 Main St"
                                        wire:model.debounce.500ms="editing.address_1"
                                        required
                                    >
                                    @error('editing.address_1')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-slate-700" for="address_2">
                                        {{ ucwords(trans_choice('messages.address_2', 1)) }}
                                    </label>
                                    <input
                                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20"
                                        value="{{ $editing->address_2 ?? '' }}"
                                        type="text"
                                        id="address_2"
                                        name="address_2"
                                        placeholder="Apartment or number"
                                        wire:model.debounce.500ms="editing.address_2"
                                    >
                                    @error('editing.address_2')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-lg-4 col-md-6">
                                        <label class="block text-sm font-medium text-slate-700" for="city">
                                            {{ ucwords(trans_choice('messages.city', 1)) }} <span class="text-red-600">*</span>
                                        </label>
                                        <input
                                            @class([
                                                'w-full rounded-lg bg-white px-3 py-2 text-sm text-slate-900 shadow-sm border focus:ring-4',
                                                'border-slate-300 focus:border-primary-500 focus:ring-primary-500/20' => !$errors->has('editing.city'),
                                                'border-red-400 focus:border-red-500 focus:ring-red-500/20' => $errors->has('editing.city'),
                                            ])
                                            value="{{ $editing->city ?? '' }}"
                                            type="text"
                                            id="city"
                                            name="city"
                                            wire:model.debounce.500ms="editing.city"
                                            required
                                        >
                                        @error('editing.city')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="mb-3 col-lg-4 col-md-6">
                                        <label class="block text-sm font-medium text-slate-700" for="state">
                                            {{ ucwords(trans_choice('messages.state', 1)) }} <span class="text-red-600">*</span>
                                        </label>
                                        <input
                                            @class([
                                                'w-full rounded-lg bg-white px-3 py-2 text-sm text-slate-900 shadow-sm border focus:ring-4',
                                                'border-slate-300 focus:border-primary-500 focus:ring-primary-500/20' => !$errors->has('editing.state'),
                                                'border-red-400 focus:border-red-500 focus:ring-red-500/20' => $errors->has('editing.state'),
                                            ])
                                            value="{{ $editing->state ?? '' }}"
                                            name="state"
                                            type="text"
                                            id="state"
                                            placeholder=""
                                            wire:model.debounce.500ms="editing.state"
                                            required
                                        >
                                        @error('editing.state')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="mb-3 col-lg-4 col-md-6">
                                        <label class="block text-sm font-medium text-slate-700" for="postal_code">
                                            {{ ucwords(trans_choice('messages.postal_code', 1)) }} <span class="text-red-600">*</span>
                                        </label>
                                        <input
                                            @class([
                                                'w-full rounded-lg bg-white px-3 py-2 text-sm text-slate-900 shadow-sm border focus:ring-4',
                                                'border-slate-300 focus:border-primary-500 focus:ring-primary-500/20' => !$errors->has('editing.postal_code'),
                                                'border-red-400 focus:border-red-500 focus:ring-red-500/20' => $errors->has('editing.postal_code'),
                                            ])
                                            value="{{ $editing->postal_code ?? '' }}"
                                            name="postal_code"
                                            type="text"
                                            id="postal_code"
                                            placeholder=""
                                            wire:model.debounce.500ms="editing.postal_code"
                                            required
                                        >
                                        @error('editing.postal_code')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <x-label for="markup" class="">{{ucwords(trans_choice('messages.markup', 1))}} (optional)</x-label>
                                    <input class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:ring-4 focus:ring-primary-500/20" value="{{ $editing->markup ?? '' }}" type="text" id="markup" name="markup" placeholder="Markup % for Azure Subscription">
                                    @error('editing.markup')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-slate-700" for="direct_buy">
                                        Direct buy <span class="text-red-600">*</span>
                                    </label>
                                    <div class="mb-3 input-group">
                                        <select
                                            wire:model.debounce.500ms="editing.direct_buy"
                                            name="direct_buy"
                                            id="direct_buy"
                                            @class([
                                                'block w-full rounded-lg bg-white px-3 py-2 text-sm text-slate-900 shadow-sm border focus:ring-4',
                                                'border-slate-300 focus:border-primary-500 focus:ring-primary-500/20' => !$errors->has('editing.direct_buy'),
                                                'border-red-400 focus:border-red-500 focus:ring-red-500/20' => $errors->has('editing.direct_buy'),
                                            ])
                                            required
                                        >
                                            <option value="1" {{ $editing->direct_buy ? 'selected' : '' }}>The customer can buy directly</option>
                                            <option value="0" {{ $editing->direct_buy ? '' : 'selected' }}>Customer buys need to be verified</option>
                                        </select>
                                        @error('editing.direct_buy')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                </div>
                                <div class="row">
                                    {{-- <div class="mb-4 col-lg-4 col-md-6">
                                        <x-label for="country">{{ucwords(trans_choice('messages.price_list', 1))}}</x-label>
                                        <div class="mb-3 input-group">
                                            <select wire:model.debounce.500ms="editing.price_list_id" name="price_list_id" class="form-control @error('editing.price_list_id') is-invalid @enderror" sf-validate="required">
                                                @foreach ($customer->resellers->first()->availablePriceLists as $pricelist)
                                                <option value="{{$pricelist->id}}" >{{$pricelist->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('editing.price_list_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                        </div>
                                    </div> --}}
                                    <hr>
                                </div>
                            </div>
                        </div>
                        @if ($showCreateUser == true)
                        <h3>{{ucwords(trans_choice('user_information', 1))}}</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <x-label for="status">@lang('Status')</x-label>
                                    <select wire:model.debounce.500ms="creatingUser.status_id" name="status" class="form-control @error('creatingUser.status') is-invalid @enderror" sf-validate="required" >
                                        <option value="{{ old('status')}}" selected></option>
                                        @foreach ($statuses as $key => $status)
                                        <option value="{{$key}}">{{ucwords(trans_choice($status, 1))}}</option>
                                        @endforeach
                                    </select>
                                    @error('creatingUser.status')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="form-group">
                                    <x-label for="name">@lang('First Name')</x-label>
                                    <x-input wire:model.debounce.500ms="creatingUser.name" type="text" class="@error('creatingUser.name') is-invalid @enderror" id="name" name="name" placeholder="First Name" value="{{ old('name') }}" />
                                    @error('creatingUser.name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="form-group">
                                    <x-label for="last_name">@lang('Last Name')</x-label>
                                    <x-input wire:model.debounce.500ms="creatingUser.last_name" type="text" class="@error('creatingUser.last_name') is-invalid @enderror" id="last_name" name="last_name" placeholder="Last Name" value="{{ old('last_name')  }}" />
                                    @error('creatingUser.last_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <x-label for="socialite_id">@lang('socialite_id')</x-label>
                                    <div class="form-group">
                                        <x-input wire:model.debounce.500ms="creatingUser.socialite_id" class="@error('creatingUser.socialite_id') is-invalid @enderror" type="text" name="socialite_id" id='socialite_id' value="{{ old('socialite_id') }}" />
                                        @error('creatingUser.socialite_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <x-label for="phone">@lang('Phone')</x-label>
                                    <x-input wire:model.debounce.500ms="creatingUser.phone" type="text" class="@error('creatingUser.phone') is-invalid @enderror" id="phone_number" name="phone" placeholder="Phone" value="{{ old('phone') }}" />
                                    @error('creatingUser.phone')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="form-group">
                                    <x-label for="address">@lang('Address')</x-label>
                                    <x-input wire:model.debounce.500ms="creatingUser.address" type="text" class="@error('creatingUser.address') is-invalid @enderror" id="address"
                                    name="address" placeholder="Address" value="{{ old('address') }}" />
                                    @error('creatingUser.address')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <x-label for="email">@lang('Email')</x-label>
                                    <x-input wire:model.debounce.500ms="email" type="email" class="@error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{ old('email') }}" />
                                    @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror

                                </div>
                                <div class="form-group">
                                    <x-label for="password">{{ __('Password') }}</x-label>
                                    <x-input wire:model.debounce.500ms="password" type="password" class="@error('password') is-invalid @enderror" id="password" name="password"  value="{{ old('password') }}" />
                                    @error('creatingUser.password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                                <div class="form-group">
                                    <x-label for="password_confirmation">{{ __('Confirm Password') }}</x-label>
                                    <x-input wire:model.debounce.500ms="password_confirmation" type="password" class="@error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation"  value="{{ old('password_confirmation') }}" />
                                    @error('password_confirmation')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
                                </div>
                            </div>
                        </div>
                        @endif
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
