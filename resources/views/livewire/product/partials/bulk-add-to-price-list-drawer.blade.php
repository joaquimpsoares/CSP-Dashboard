<div>
    <div
        x-data="{ open: @entangle('showBulkAddToPriceList').live }"
        x-cloak
        x-show="open"
        @keydown.escape.window="$wire.closeBulkAddToPriceList()"
        class="fixed inset-0 z-50"
        role="dialog"
        aria-modal="true"
    >
        <div class="absolute inset-0 bg-slate-900/30" @click="$wire.closeBulkAddToPriceList()" aria-hidden="true"></div>

        <div class="absolute inset-y-0 right-0 flex w-full max-w-[520px]">
            <div class="flex h-full w-full flex-col bg-white shadow-xl">
                <div class="sticky top-0 z-10 border-b border-slate-200 bg-white/90 backdrop-blur px-6 py-4">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="text-base font-semibold text-slate-900">Add to price list</div>
                            <div class="mt-1 text-sm text-slate-600">Upsert mapped rows for the selected products.</div>
                        </div>
                        <button type="button" @click="$wire.closeBulkAddToPriceList()" class="inline-flex items-center justify-center rounded-lg p-2 text-slate-500 hover:bg-slate-50 hover:text-slate-700 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </button>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto px-6 py-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700">Target price list</label>
                            <select wire:model.defer="targetPriceListId" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                @foreach(\App\PriceList::orderByDesc('id')->limit(50)->get() as $pl)
                                    <option value="{{ $pl->id }}">#{{ $pl->id }} — {{ $pl->name }}</option>
                                @endforeach
                            </select>
                            @error('targetPriceListId')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700">Pricing rule</label>
                            <select wire:model.defer="bulkPricingRule" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                <option value="copy_msrp">Copy MSRP → sell</option>
                                <option value="margin_percent">Apply margin % on MSRP</option>
                                <option value="fixed">Fixed sell price</option>
                            </select>
                        </div>

                        @if($bulkPricingRule === 'margin_percent')
                            <div>
                                <label class="block text-sm font-semibold text-slate-700">Margin %</label>
                                <input wire:model.defer="bulkMarginPercent" type="number" step="0.01" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                @error('bulkMarginPercent')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                            </div>
                        @endif

                        @if($bulkPricingRule === 'fixed')
                            <div>
                                <label class="block text-sm font-semibold text-slate-700">Fixed sell price</label>
                                <input wire:model.defer="bulkFixedPrice" type="number" step="0.01" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                @error('bulkFixedPrice')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                            </div>
                        @endif

                        <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                            <div>
                                <div class="text-sm font-semibold text-slate-900">Availability</div>
                                <div class="text-sm text-slate-600">Set available_for_purchase on created items.</div>
                            </div>
                            <input wire:model.defer="bulkAvailability" type="checkbox" class="h-5 w-5 rounded border-slate-300 text-primary-600 focus:ring-primary-500" />
                        </div>
                    </div>
                </div>

                <div class="sticky bottom-0 border-t border-slate-200 bg-white/90 backdrop-blur px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <button type="button" @click="$wire.closeBulkAddToPriceList()" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Cancel</button>
                        <button type="button" wire:click="executeBulkAddToPriceList" class="inline-flex items-center justify-center rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">Run</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
