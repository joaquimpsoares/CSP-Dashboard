<div class="space-y-6">

    {{-- Tab bar --}}
    <div class="flex items-center gap-1 border-b border-slate-200">
        <button wire:click="$set('tab','resellers')"
            class="px-4 py-2.5 text-sm font-semibold rounded-t-lg border-b-2 transition-colors
                {{ $tab === 'resellers'
                    ? 'border-primary-600 text-primary-700 bg-primary-50'
                    : 'border-transparent text-slate-600 hover:text-slate-900 hover:border-slate-300' }}">
            Resellers
            <span class="ml-1.5 inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                {{ $tab === 'resellers' ? 'bg-primary-100 text-primary-700' : 'bg-slate-100 text-slate-600' }}">
                {{ count($resellerAssignments) }}
            </span>
        </button>
        <button wire:click="$set('tab','customers')"
            class="px-4 py-2.5 text-sm font-semibold rounded-t-lg border-b-2 transition-colors
                {{ $tab === 'customers'
                    ? 'border-primary-600 text-primary-700 bg-primary-50'
                    : 'border-transparent text-slate-600 hover:text-slate-900 hover:border-slate-300' }}">
            Customers
            <span class="ml-1.5 inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                {{ $tab === 'customers' ? 'bg-primary-100 text-primary-700' : 'bg-slate-100 text-slate-600' }}">
                {{ count($customerAssignments) }}
            </span>
        </button>
    </div>

    {{-- ── Resellers tab ───────────────────────────────────────────────────── --}}
    @if($tab === 'resellers')
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-600">Resellers that use this price list by default.</p>
            <button wire:click="openResellerDrawer"
                class="inline-flex items-center gap-1.5 rounded-lg bg-primary-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"/></svg>
                Assign reseller
            </button>
        </div>

        @if($resellerAssignments->isEmpty())
            <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 py-10 text-center">
                <svg class="mx-auto h-8 w-8 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                <p class="mt-2 text-sm font-medium text-slate-600">No reseller assignments yet.</p>
                <p class="mt-1 text-xs text-slate-500">Click "Assign reseller" to set a default for a reseller.</p>
            </div>
        @else
            <div class="overflow-hidden rounded-lg border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Reseller</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Market</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Currency</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">List type</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @foreach($resellerAssignments as $ra)
                            <tr wire:key="ra-{{ $ra->id }}">
                                <td class="px-4 py-3 font-medium text-slate-900">{{ $ra->reseller?->company_name ?? '—' }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $ra->market ?? '—' }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $ra->currency ?? '—' }}</td>
                                <td class="px-4 py-3 text-slate-600">
                                    @if($ra->list_type)
                                        <span class="inline-flex items-center rounded-full bg-indigo-50 px-2 py-0.5 text-xs font-medium text-indigo-700">
                                            {{ $listTypes[$ra->list_type] ?? $ra->list_type }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">Any</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <button wire:click="removeResellerAssignment({{ $ra->id }})"
                                        wire:confirm="Remove this reseller assignment?"
                                        class="text-xs font-semibold text-rose-600 hover:text-rose-800">
                                        Remove
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif

    {{-- ── Customers tab ───────────────────────────────────────────────────── --}}
    @if($tab === 'customers')
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-600">Customers that use this price list as their default override.</p>
            <button wire:click="openCustomerDrawer"
                class="inline-flex items-center gap-1.5 rounded-lg bg-primary-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"/></svg>
                Assign customer
            </button>
        </div>

        @if($customerAssignments->isEmpty())
            <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 py-10 text-center">
                <svg class="mx-auto h-8 w-8 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                <p class="mt-2 text-sm font-medium text-slate-600">No customer assignments yet.</p>
                <p class="mt-1 text-xs text-slate-500">Click "Assign customer" to give a specific customer this price list.</p>
            </div>
        @else
            <div class="overflow-hidden rounded-lg border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Reseller</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Market</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Currency</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">List type</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @foreach($customerAssignments as $ca)
                            <tr wire:key="ca-{{ $ca->id }}">
                                <td class="px-4 py-3 font-medium text-slate-900">{{ $ca->customer?->company_name ?? '—' }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $ca->reseller?->company_name ?? '—' }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $ca->market ?? '—' }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $ca->currency ?? '—' }}</td>
                                <td class="px-4 py-3 text-slate-600">
                                    @if($ca->list_type)
                                        <span class="inline-flex items-center rounded-full bg-indigo-50 px-2 py-0.5 text-xs font-medium text-indigo-700">
                                            {{ $listTypes[$ca->list_type] ?? $ca->list_type }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">Any</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <button wire:click="removeCustomerAssignment({{ $ca->id }})"
                                        wire:confirm="Remove this customer assignment?"
                                        class="text-xs font-semibold text-rose-600 hover:text-rose-800">
                                        Remove
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif

    {{-- ══ Assign-reseller drawer ══════════════════════════════════════════════ --}}
    <div
        x-data="{ open: @entangle('showResellerDrawer').live }"
        x-cloak x-show="open"
        @keydown.escape.window="$wire.closeResellerDrawer()"
        class="fixed inset-0 z-50" role="dialog" aria-modal="true">
        <div class="absolute inset-0 bg-slate-900/30" @click="$wire.closeResellerDrawer()"></div>
        <div class="absolute inset-y-0 right-0 flex w-full sm:max-w-md">
            <div class="flex h-full w-full flex-col bg-white shadow-xl">
                <!-- Header -->
                <div class="sticky top-0 z-10 border-b border-slate-200 bg-white/90 backdrop-blur px-6 py-4 flex items-center justify-between gap-4">
                    <div>
                        <div class="text-base font-semibold text-slate-900">Assign reseller default</div>
                        <div class="mt-0.5 text-sm text-slate-600">Make this price list the default for a reseller.</div>
                    </div>
                    <button type="button" @click="$wire.closeResellerDrawer()" class="rounded-lg p-2 text-slate-500 hover:bg-slate-50">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                    </button>
                </div>
                <!-- Body -->
                <form wire:submit.prevent="assignReseller" class="flex h-full flex-col">
                    <div class="flex-1 overflow-y-auto px-6 py-6 space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700">Reseller <span class="text-rose-500">*</span></label>
                            <select wire:model="assignResellerId" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                <option value="">Select a reseller…</option>
                                @foreach($availableResellers as $r)
                                    <option value="{{ $r->id }}">{{ $r->company_name }}</option>
                                @endforeach
                            </select>
                            @if($availableResellers->isEmpty())
                                <p class="mt-1 text-xs text-amber-600">All resellers already have this price list assigned as their default.</p>
                            @endif
                            @error('assignResellerId')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700">Market</label>
                                <input wire:model.defer="assignResellerMarket" type="text" placeholder="PT" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                @error('assignResellerMarket')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700">Currency</label>
                                <input wire:model.defer="assignResellerCurrency" type="text" placeholder="EUR" maxlength="3" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                @error('assignResellerCurrency')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700">List type</label>
                                <select wire:model.defer="assignResellerListType" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                    <option value="">Any</option>
                                    @foreach($listTypes as $val => $lbl)
                                        <option value="{{ $val }}">{{ $lbl }}</option>
                                    @endforeach
                                </select>
                                @error('assignResellerListType')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <p class="text-xs text-slate-500">
                            Market, currency, and list type narrow the lookup context. Leave blank to match any.
                        </p>
                    </div>
                    <!-- Footer -->
                    <div class="sticky bottom-0 border-t border-slate-200 bg-white/90 backdrop-blur px-6 py-4 flex justify-end gap-2">
                        <button type="button" @click="$wire.closeResellerDrawer()" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</button>
                        <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                            <span wire:loading.remove wire:target="assignReseller">Save assignment</span>
                            <span wire:loading wire:target="assignReseller">Saving…</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ══ Assign-customer drawer ═══════════════════════════════════════════════ --}}
    <div
        x-data="{ open: @entangle('showCustomerDrawer').live }"
        x-cloak x-show="open"
        @keydown.escape.window="$wire.closeCustomerDrawer()"
        class="fixed inset-0 z-50" role="dialog" aria-modal="true">
        <div class="absolute inset-0 bg-slate-900/30" @click="$wire.closeCustomerDrawer()"></div>
        <div class="absolute inset-y-0 right-0 flex w-full sm:max-w-md">
            <div class="flex h-full w-full flex-col bg-white shadow-xl">
                <!-- Header -->
                <div class="sticky top-0 z-10 border-b border-slate-200 bg-white/90 backdrop-blur px-6 py-4 flex items-center justify-between gap-4">
                    <div>
                        <div class="text-base font-semibold text-slate-900">Assign customer default</div>
                        <div class="mt-0.5 text-sm text-slate-600">Give a specific customer this price list as their override.</div>
                    </div>
                    <button type="button" @click="$wire.closeCustomerDrawer()" class="rounded-lg p-2 text-slate-500 hover:bg-slate-50">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                    </button>
                </div>
                <!-- Body -->
                <form wire:submit.prevent="assignCustomer" class="flex h-full flex-col">
                    <div class="flex-1 overflow-y-auto px-6 py-6 space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700">Customer <span class="text-rose-500">*</span></label>
                            <select wire:model="assignCustomerId" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                <option value="">Select a customer…</option>
                                @foreach($availableCustomers as $c)
                                    <option value="{{ $c->id }}">{{ $c->company_name }}</option>
                                @endforeach
                            </select>
                            @if($availableCustomers->isEmpty())
                                <p class="mt-1 text-xs text-amber-600">All customers already have this price list assigned as their default.</p>
                            @endif
                            @error('assignCustomerId')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700">Market</label>
                                <input wire:model.defer="assignCustomerMarket" type="text" placeholder="PT" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                @error('assignCustomerMarket')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700">Currency</label>
                                <input wire:model.defer="assignCustomerCurrency" type="text" placeholder="EUR" maxlength="3" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                @error('assignCustomerCurrency')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700">List type</label>
                                <select wire:model.defer="assignCustomerListType" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                    <option value="">Any</option>
                                    @foreach($listTypes as $val => $lbl)
                                        <option value="{{ $val }}">{{ $lbl }}</option>
                                    @endforeach
                                </select>
                                @error('assignCustomerListType')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <p class="text-xs text-slate-500">
                            Market, currency, and list type narrow the lookup context. Leave blank to match any.
                        </p>
                    </div>
                    <!-- Footer -->
                    <div class="sticky bottom-0 border-t border-slate-200 bg-white/90 backdrop-blur px-6 py-4 flex justify-end gap-2">
                        <button type="button" @click="$wire.closeCustomerDrawer()" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</button>
                        <button type="submit" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                            <span wire:loading.remove wire:target="assignCustomer">Save assignment</span>
                            <span wire:loading wire:target="assignCustomer">Saving…</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
