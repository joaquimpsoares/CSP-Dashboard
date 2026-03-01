<div>
    <div
        x-data="{ open: @entangle('showCreateDrawer').live }"
        x-cloak
        x-show="open"
        @keydown.escape.window="$wire.closeCreateDrawer()"
        class="fixed inset-0 z-50"
        role="dialog"
        aria-modal="true"
    >
        <div class="absolute inset-0 bg-slate-900/30" @click="$wire.closeCreateDrawer()" aria-hidden="true"></div>

        <!-- Right drawer -->
        <div class="absolute inset-y-0 right-0 flex w-full sm:max-w-lg">
            <div class="flex h-full w-full flex-col bg-white shadow-xl">

                <!-- Sticky header -->
                <div class="sticky top-0 z-10 border-b border-slate-200 bg-white/90 backdrop-blur px-6 py-4">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="text-base font-semibold text-slate-900">Create price list</div>
                            <div class="mt-1 text-sm text-slate-600">Set up a new price list for your products.</div>
                        </div>
                        <button type="button" @click="$wire.closeCreateDrawer()" class="inline-flex items-center justify-center rounded-lg p-2 text-slate-500 hover:bg-slate-50 hover:text-slate-700 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </button>
                    </div>
                </div>

                <form wire:submit.prevent="createPriceList" class="flex h-full flex-col">
                    <!-- Scrollable body -->
                    <div class="flex-1 overflow-y-auto px-6 py-6">
                        <div class="space-y-5">

                            {{-- Provider (required) --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700">
                                    Provider <span class="text-rose-500">*</span>
                                </label>
                                @if($providers->count() === 1)
                                    {{-- Single provider: show as read-only badge + hidden input --}}
                                    <input type="hidden" wire:model="newProviderId">
                                    <div class="mt-1 flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">
                                        <span class="text-sm text-slate-900">{{ $providers->first()->company_name }}</span>
                                        <span class="ml-auto inline-flex items-center rounded-full bg-primary-50 px-2 py-0.5 text-xs font-medium text-primary-700">Your provider</span>
                                    </div>
                                @else
                                    <select wire:model="newProviderId" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                        <option value="">Select a provider…</option>
                                        @foreach($providers as $provider)
                                            <option value="{{ $provider->id }}">{{ $provider->company_name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                                @error('newProviderId')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                            </div>

                            {{-- Name --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700">Name <span class="text-rose-500">*</span></label>
                                <input wire:model.defer="newName" type="text" placeholder="e.g. Standard EUR 2025" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                @error('newName')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                            </div>

                            {{-- Description --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700">Description</label>
                                <input wire:model.defer="newDescription" type="text" placeholder="Optional description" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                @error('newDescription')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                            </div>

                            {{-- List type --}}
                            <div>
                                <label class="block text-sm font-semibold text-slate-700">List type</label>
                                <select wire:model.defer="newListType" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                    <option value="">Any / not specified</option>
                                    @foreach($listTypes as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-slate-500">Used by the resolver to match the right list per product type.</p>
                                @error('newListType')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                            </div>

                            {{-- Currency + Market + Margin --}}
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700">Currency</label>
                                    <input wire:model.defer="newCurrency" type="text" placeholder="EUR" maxlength="3" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                    @error('newCurrency')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700">Market</label>
                                    <input wire:model.defer="newMarket" type="text" placeholder="PT" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                    @error('newMarket')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700">Margin %</label>
                                    <input wire:model.defer="newMargin" type="text" placeholder="0" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                    @error('newMargin')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            {{-- Set as provider default --}}
                            <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
                                <label class="flex cursor-pointer items-start gap-3">
                                    <input wire:model.defer="newSetAsProviderDefault" type="checkbox" class="mt-0.5 h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500" />
                                    <div>
                                        <span class="block text-sm font-semibold text-slate-800">Set as provider default</span>
                                        <span class="block text-xs text-slate-500 mt-0.5">
                                            Immediately mark this list as the default for the selected
                                            provider / market / currency / type combination.
                                            Resellers and customers without an explicit assignment will
                                            fall back to this list.
                                        </span>
                                    </div>
                                </label>
                            </div>

                        </div>
                    </div>

                    <!-- Sticky footer -->
                    <div class="sticky bottom-0 border-t border-slate-200 bg-white/90 backdrop-blur px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <button type="button" @click="$wire.closeCreateDrawer()" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Cancel</button>
                            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">
                                <span wire:loading.remove wire:target="createPriceList">Create</span>
                                <span wire:loading wire:target="createPriceList">Creating…</span>
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
