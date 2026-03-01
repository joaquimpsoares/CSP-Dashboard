<div>
    <div
        x-data="{ open: @entangle('open').live }"
        x-cloak
        x-show="open"
        @keydown.escape.window="$wire.close()"
        class="fixed inset-0 z-50"
        role="dialog"
        aria-modal="true"
    >
        <div class="absolute inset-0 bg-slate-900/30" @click="$wire.close()" aria-hidden="true"></div>

        <!-- Right drawer -->
        <div class="absolute inset-y-0 right-0 flex w-full max-w-5xl">
            <div class="flex h-full w-full flex-col bg-white shadow-xl">
                <!-- Sticky header -->
                <div class="sticky top-0 z-10 border-b border-slate-200 bg-white/90 backdrop-blur px-6 py-4">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="text-base font-semibold text-slate-900">{{ $priceId ? 'Edit price' : 'Add price' }}</div>
                            <div class="mt-1 text-sm text-slate-600">Select a product and confirm mapping + sell price.</div>
                        </div>
                        <button type="button" @click="$wire.close()" class="inline-flex items-center justify-center rounded-lg p-2 text-slate-500 hover:bg-slate-50 hover:text-slate-700 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Body -->
                <div class="flex-1 overflow-y-auto px-6 py-6">
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        <!-- Left: form -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700">Product</label>
                                <input wire:model.live="productQuery" type="text" placeholder="Search products by name or SKU" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                @error('productId')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror

                                @if(!empty($productResults))
                                    <div class="mt-2 overflow-hidden rounded-xl border border-slate-200 bg-white">
                                        @foreach($productResults as $r)
                                            <button type="button" wire:click="selectProduct({{ $r['id'] }})" class="flex w-full items-center justify-between gap-3 px-4 py-2 text-left text-sm hover:bg-slate-50">
                                                <div class="min-w-0">
                                                    <div class="truncate font-semibold text-slate-900">{{ $r['name'] }}</div>
                                                    <div class="mt-0.5 truncate text-xs text-slate-600">{{ $r['vendor'] }} · {{ $r['sku'] }}</div>
                                                </div>
                                                <span class="text-xs font-semibold text-slate-500">Select</span>
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700">Name</label>
                                    <input wire:model.defer="name" type="text" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                    @error('name')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700">Currency</label>
                                    <input wire:model.defer="currency" type="text" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700">Sell price</label>
                                    <input wire:model.defer="amount" type="text" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                    @error('amount')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700">MSRP</label>
                                    <input wire:model.defer="msrp" type="text" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700">Billing cycle</label>
                                    <select wire:model.defer="billingCycle" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                        <option value="monthly">Monthly</option>
                                        <option value="annual">Annual</option>
                                        <option value="PAYG">PAYG</option>
                                        <option value="one_time">One time</option>
                                        <option value="none">None</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700">Term duration</label>
                                    <select wire:model.defer="termDuration" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                        <option value="">—</option>
                                        <option value="P1M">P1M</option>
                                        <option value="P1Y">P1Y</option>
                                    </select>
                                </div>
                            </div>

                            <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                                <div>
                                    <div class="text-sm font-semibold text-slate-900">Available for purchase</div>
                                    <div class="text-sm text-slate-600">Used at checkout time.</div>
                                </div>
                                <input wire:model.defer="available" type="checkbox" class="h-5 w-5 rounded border-slate-300 text-primary-600 focus:ring-primary-500" />
                            </div>

                            <div class="rounded-xl border border-slate-200 bg-white">
                                <button type="button" wire:click="$toggle('showMoreOptions')" class="flex w-full items-center justify-between gap-3 px-4 py-3 text-left text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                    <span>More options</span>
                                    <svg class="h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.94a.75.75 0 111.08 1.04l-4.24 4.5a.75.75 0 01-1.08 0l-4.24-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                                </button>
                                @if($showMoreOptions)
                                    <div class="border-t border-slate-200 p-4">
                                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                            <div>
                                                <label class="block text-sm font-semibold text-slate-700">Vendor</label>
                                                <input wire:model.defer="vendor" type="text" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-slate-700">SKU</label>
                                                <input wire:model.defer="sku" type="text" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-slate-700">Offer ID</label>
                                                <input wire:model.defer="offerId" type="text" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                                @error('offerId')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-slate-700">SKU ID</label>
                                                <input wire:model.defer="skuId" type="text" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                            </div>
                                            <div class="sm:col-span-2">
                                                <label class="block text-sm font-semibold text-slate-700">Meter ID</label>
                                                <input wire:model.defer="meterId" type="text" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Right: preview -->
                        <div class="lg:pl-2">
                            <div class="lg:sticky lg:top-24 rounded-2xl border border-slate-200 bg-slate-50 p-5">
                                <div class="text-sm font-semibold text-slate-900">Preview</div>
                                <div class="mt-1 text-sm text-slate-600">Quick estimate (tax calculated later).</div>

                                <div class="mt-4">
                                    <label class="block text-sm font-semibold text-slate-700">Quantity</label>
                                    <input wire:model.live="previewQty" type="number" min="1" class="mt-1 block w-20 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                </div>

                                <div class="mt-6 space-y-2 text-sm">
                                    <div class="flex items-center justify-between">
                                        <span class="text-slate-600">Subtotal</span>
                                        <span class="font-semibold text-slate-900">{{ number_format((float)$this->previewSubtotal, 2) }} {{ $currency }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-slate-600">Taxes</span>
                                        <span class="text-slate-600">Calculated later</span>
                                    </div>
                                    <div class="flex items-center justify-between border-t border-slate-200 pt-2">
                                        <span class="text-slate-600">Total</span>
                                        <span class="font-semibold text-slate-900">{{ number_format((float)$this->previewSubtotal, 2) }} {{ $currency }}</span>
                                    </div>
                                </div>

                                <div class="mt-4 text-xs text-slate-500">
                                    {{ $billingCycle ?: '—' }} · {{ $termDuration ?: '—' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sticky footer -->
                <div class="sticky bottom-0 border-t border-slate-200 bg-white/90 backdrop-blur px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <button type="button" @click="$wire.close()" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Cancel</button>
                        <button type="button" wire:click="save" class="inline-flex items-center justify-center rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
