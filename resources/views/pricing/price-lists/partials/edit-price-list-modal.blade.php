<div>
    <div
        x-data="{ open: @entangle('showEditPriceListModal').live }"
        x-cloak
        x-show="open"
        @keydown.escape.window="$wire.closeEditPriceListModal()"
        class="fixed inset-0 z-50"
        role="dialog"
        aria-modal="true"
    >
        <div class="absolute inset-0 bg-slate-900/30" @click="$wire.closeEditPriceListModal()" aria-hidden="true"></div>

        <!-- Right drawer -->
        <div class="absolute inset-y-0 right-0 flex w-full max-w-[520px]">
            <div class="flex h-full w-full flex-col bg-white shadow-xl">
                <!-- Sticky header -->
                <div class="sticky top-0 z-10 border-b border-slate-200 bg-white/90 backdrop-blur px-6 py-4">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="text-base font-semibold text-slate-900">Edit price list</div>
                            <div class="mt-1 text-sm text-slate-600">Update details and status.</div>
                        </div>
                        <button type="button" @click="$wire.closeEditPriceListModal()" class="inline-flex items-center justify-center rounded-lg p-2 text-slate-500 hover:bg-slate-50 hover:text-slate-700 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </button>
                    </div>
                </div>

                <form wire:submit.prevent="savePriceList" class="flex h-full flex-col">
                    <div class="flex-1 overflow-y-auto px-6 py-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700">Name</label>
                                <input wire:model.defer="priceList.name" type="text" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                @error('priceList.name')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700">Description</label>
                                <input wire:model.defer="priceList.description" type="text" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                @error('priceList.description')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700">Status</label>
                                <select wire:model.defer="priceListStatus" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                    <option value="active">Active</option>
                                    <option value="draft">Draft</option>
                                    <option value="archived">Archived</option>
                                </select>
                                @error('priceListStatus')<p class="mt-1 text-xs font-semibold text-rose-700">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700">List type</label>
                                <input value="{{ $priceList->source ?? '—' }}" readonly type="text" class="mt-1 block w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700" />
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700">Market</label>
                                    <input wire:model.defer="priceList.market" type="text" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700">Currency</label>
                                    <input wire:model.defer="priceList.currency" type="text" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700">Effective from</label>
                                    <input wire:model.defer="priceList.effective_from" type="datetime-local" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700">Effective to</label>
                                    <input wire:model.defer="priceList.effective_to" type="datetime-local" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700">Margin %</label>
                                    <input wire:model.defer="priceList.margin" type="text" class="mt-1 block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sticky bottom-0 border-t border-slate-200 bg-white/90 backdrop-blur px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <button type="button" @click="$wire.closeEditPriceListModal()" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Cancel</button>
                            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
