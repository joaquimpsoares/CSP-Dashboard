<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-slate-900">Instances</h2>
            <p class="mt-1 text-sm text-slate-600">Partner Center connections are provider-owned and market-scoped.</p>
        </div>
    </x-slot>

    {{-- Right drawer (always open on this route) --}}
    <div x-data="{ open: true, partnerType: @js(old('external_type', 'direct_reseller')), instanceMode: @js(old('mode', 'live')), showTokenWarning: false }" x-cloak>
        <div x-show="open" class="fixed inset-0 z-50" role="dialog" aria-modal="true">
            <div class="absolute inset-0 bg-slate-900/30" @click="window.location.href='{{ url()->previous() }}'" aria-hidden="true"></div>

            <div class="absolute inset-y-0 right-0 flex w-full sm:max-w-2xl">
                <div class="flex h-full w-full flex-col bg-slate-50 shadow-xl">

                    {{-- Drawer header --}}
                    <div class="sticky top-0 z-10 border-b border-slate-200 bg-slate-50/95 backdrop-blur px-6 py-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-slate-500">Instances / <span class="text-slate-900">New instance</span></div>
                                <h1 class="mt-1 truncate text-2xl font-semibold text-slate-900">Add Instance</h1>
                                <p class="mt-1 text-sm text-slate-600">Connect a Microsoft Partner Center tenant to your provider account.</p>
                            </div>
                            <a href="{{ url()->previous() }}" class="shrink-0 inline-flex items-center justify-center rounded-lg p-2 text-slate-500 hover:bg-white hover:text-slate-700 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                <span class="sr-only">Close</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                            </a>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('instances.store') }}" class="flex h-full flex-col">
                        @csrf
                        <input type="hidden" name="provider_id" value="{{ $provider->id }}">

                        <div class="flex-1 overflow-y-auto px-6 py-6">
                            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                                {{-- Section 1: Instance details --}}
                                <div class="px-6 py-5">
                                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500">Instance details</h2>

                                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <div>
                                            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Name <span class="text-rose-600">*</span></label>
                                            <input
                                                type="text"
                                                name="name"
                                                value="{{ old('name') }}"
                                                placeholder="e.g. Portugal Market"
                                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 shadow-sm focus:border-transparent focus:outline-none focus:ring-4 focus:ring-primary-500/20 @error('name') border-rose-400 focus:ring-rose-500/20 @enderror"
                                            />
                                            <p class="mt-1 text-xs text-slate-400">A friendly name to identify this connection.</p>
                                            @error('name')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                                        </div>

                                        <div>
                                            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Provider</label>
                                            <div class="flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">
                                                <div class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-primary-100">
                                                    <span class="text-xs font-bold text-primary-700">{{ strtoupper(substr($provider->company_name ?? 'P', 0, 1)) }}</span>
                                                </div>
                                                <span class="text-sm font-semibold text-slate-700">{{ $provider->company_name }}</span>
                                                <span class="ml-auto inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-semibold text-slate-500">locked</span>
                                            </div>
                                            <p class="mt-1 text-xs text-slate-400">Instances are always scoped to the owning provider.</p>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Tenant ID <span class="text-rose-600">*</span></label>
                                            <input
                                                type="text"
                                                name="tenant_id"
                                                value="{{ old('tenant_id') }}"
                                                placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"
                                                class="w-full rounded-lg border border-slate-300 px-3 py-2 font-mono text-sm text-slate-900 placeholder-slate-400 shadow-sm focus:border-transparent focus:outline-none focus:ring-4 focus:ring-primary-500/20 @error('tenant_id') border-rose-400 focus:ring-rose-500/20 @enderror"
                                            />
                                            <p class="mt-1 text-xs text-slate-400">The Entra tenant ID of the Partner Center account.</p>
                                            @error('tenant_id')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="border-t border-slate-100"></div>

                                {{-- Section 2: Partner type --}}
                                <div class="px-6 py-5">
                                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500">Partner type</h2>
                                    <p class="mt-1 text-xs text-slate-500">Choose how this instance transacts with Microsoft.</p>

                                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                        @php
                                            $partnerOptions = [
                                                [
                                                    'id' => 'direct_reseller',
                                                    'title' => 'Direct Provider',
                                                    'desc' => 'Transacts directly with Microsoft. Manages own resellers and customers.',
                                                ],
                                                [
                                                    'id' => 'indirect_reseller',
                                                    'title' => 'Indirect Provider',
                                                    'desc' => 'Sells through a distributor. Resellers sell to end customers.',
                                                ],
                                            ];
                                        @endphp

                                        @foreach($partnerOptions as $opt)
                                            <button
                                                type="button"
                                                @click="partnerType='{{ $opt['id'] }}'"
                                                class="text-left rounded-xl border-2 p-4 transition-all"
                                                :class="partnerType === '{{ $opt['id'] }}'
                                                    ? 'border-primary-500 bg-primary-50'
                                                    : 'border-slate-200 bg-white hover:border-slate-300'"
                                            >
                                                <div class="flex items-start gap-3">
                                                    <div class="mt-0.5 flex h-4 w-4 flex-shrink-0 items-center justify-center rounded-full border-2"
                                                        :class="partnerType === '{{ $opt['id'] }}' ? 'border-primary-500' : 'border-slate-300'"
                                                    >
                                                        <div class="h-2 w-2 rounded-full" :class="partnerType === '{{ $opt['id'] }}' ? 'bg-primary-500' : 'bg-transparent'"></div>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-semibold" :class="partnerType === '{{ $opt['id'] }}' ? 'text-primary-900' : 'text-slate-700'">{{ $opt['title'] }}</p>
                                                        <p class="mt-0.5 text-xs leading-relaxed text-slate-500">{{ $opt['desc'] }}</p>
                                                    </div>
                                                </div>
                                            </button>
                                        @endforeach
                                    </div>

                                    {{-- actual radio value (submitted) --}}
                                    <input type="hidden" name="external_type" :value="partnerType">
                                    @error('external_type')<p class="mt-2 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                                </div>

                                <div class="border-t border-slate-100"></div>

                                {{-- Section 3: Mode (Sandbox vs Live) --}}
                                <div class="px-6 py-5">
                                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500">Mode</h2>
                                    <p class="mt-1 text-xs text-slate-500">Start in sandbox (free trial) or connect live now.</p>

                                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                        <button
                                            type="button"
                                            @click="instanceMode='sandbox'"
                                            class="text-left rounded-xl border-2 p-4 transition-all"
                                            :class="instanceMode === 'sandbox'
                                                ? 'border-amber-500 bg-amber-50'
                                                : 'border-slate-200 bg-white hover:border-slate-300'"
                                        >
                                            <p class="text-sm font-semibold" :class="instanceMode === 'sandbox' ? 'text-amber-900' : 'text-slate-700'">Start with sandbox (free trial)</p>
                                            <p class="mt-0.5 text-xs leading-relaxed text-slate-500">No payment now. 30-day trial. Writes become read-only after expiry until you upgrade.</p>
                                        </button>

                                        <button
                                            type="button"
                                            @click="instanceMode='live'"
                                            class="text-left rounded-xl border-2 p-4 transition-all"
                                            :class="instanceMode === 'live'
                                                ? 'border-primary-500 bg-primary-50'
                                                : 'border-slate-200 bg-white hover:border-slate-300'"
                                        >
                                            <p class="text-sm font-semibold" :class="instanceMode === 'live' ? 'text-primary-900' : 'text-slate-700'">Connect live now</p>
                                            <p class="mt-0.5 text-xs leading-relaxed text-slate-500">Use production Partner Center API. Billing continues as configured.</p>
                                        </button>
                                    </div>

                                    <input type="hidden" name="mode" :value="instanceMode">
                                    @error('mode')<p class="mt-2 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                                </div>

                                <div class="border-t border-slate-100"></div>

                                {{-- Section 4: Configuration --}}
                                <div class="px-6 py-5">
                                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500">Configuration</h2>
                                    <p class="mt-1 text-xs text-slate-500">Partner Center connection settings.</p>

                                    <div class="mt-4">
                                        <label class="mb-1.5 block text-sm font-semibold text-slate-700">Invitation URL</label>
                                        <input
                                            type="url"
                                            name="external_url"
                                            value="{{ old('external_url') }}"
                                            placeholder="https://portal.office.com/partner/partnersignup.aspx?..."
                                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 placeholder-slate-400 shadow-sm focus:border-transparent focus:outline-none focus:ring-4 focus:ring-primary-500/20 @error('external_url') border-rose-400 focus:ring-rose-500/20 @enderror"
                                        />
                                        <p class="mt-1 text-xs text-slate-400">The admin relationship invitation link from Partner Center.</p>
                                        @error('external_url')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="mt-5 rounded-xl border border-amber-200 bg-amber-50 p-4">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <p class="text-sm font-semibold text-amber-900">Partner Center token</p>
                                                <p class="mt-1 text-xs text-amber-700">Refreshing the token will invalidate the current Partner Center API connection. Only do this if the connection is broken or expired.</p>
                                            </div>
                                            <button
                                                type="button"
                                                @click="showTokenWarning = !showTokenWarning"
                                                class="shrink-0 rounded-lg border border-amber-300 bg-white px-3 py-2 text-xs font-semibold text-amber-900 hover:bg-amber-50"
                                            >
                                                Refresh token
                                            </button>
                                        </div>

                                        <div x-show="showTokenWarning" x-cloak class="mt-3 border-t border-amber-200 pt-3">
                                            <p class="text-xs font-semibold text-amber-900">Are you sure?</p>
                                            <p class="mt-1 text-xs text-amber-800">This will disconnect active syncs until the new token is validated.</p>
                                            <div class="mt-3">
                                                <a
                                                    class="inline-flex items-center justify-center rounded-lg bg-amber-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-amber-700 focus:outline-none focus:ring-4 focus:ring-amber-500/30"
                                                    target="_blank"
                                                    rel="noopener"
                                                    href="https://login.microsoftonline.com/common/oauth2/authorize?client_id=66127fdf-8259-429c-9899-6ec066ff8915&response_type=code&redirect_uri=https://partnerconsent.tagydes.com/&prompt=admin_consent"
                                                >
                                                    Continue to consent
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Footer --}}
                                <div class="flex items-center justify-between border-t border-slate-200 bg-slate-50 px-6 py-4">
                                    <a href="{{ url()->previous() }}" class="text-sm font-semibold text-slate-500 hover:text-slate-700">Cancel</a>
                                    <button type="submit" class="rounded-lg bg-primary-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                                        Create instance
                                    </button>
                                </div>
                            </div>

                            <p class="mt-4 text-center text-xs text-slate-400">Instances are market-scoped — products and price lists are isolated per instance.</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
