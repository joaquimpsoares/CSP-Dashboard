<div class="p-6">
    <!-- Details card -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div class="min-w-0">
                <div class="flex items-center gap-2">
                    <h3 class="truncate text-lg font-semibold text-slate-900">{{ $priceList->name }}</h3>
                    @if($priceList->deleted_at)
                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-700 ring-1 ring-inset ring-slate-200">Archived</span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">Active</span>
                    @endif
                </div>
                <div class="mt-1 text-sm text-slate-600">{{ $priceList->description ?: '—' }}</div>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" wire:click="openEditPriceListModal" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20">Edit price list</button>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Margin</div>
                <div class="mt-1 text-sm font-semibold text-slate-900">{{ $priceList->margin !== null ? $priceList->margin.' %' : '—' }}</div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Created</div>
                <div class="mt-1 text-sm font-semibold text-slate-900">{{ optional($priceList->created_at)->format('Y-m-d') }}</div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Effective dates</div>
                <div class="mt-1 text-sm font-semibold text-slate-900">
                    {{ $priceList->effective_from ?? '—' }} → {{ $priceList->effective_to ?? '—' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Prices section -->
    <div class="mt-6 rounded-2xl border border-slate-200 bg-white">
        <div class="border-b border-slate-200 px-6 py-4">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h4 class="text-base font-semibold text-slate-900">Prices</h4>
                    <p class="mt-1 text-sm text-slate-600">Manage prices attached to this price list.</p>
                </div>

                <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                    <div>
                        <select wire:model.live="perPage" class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>

                    <div class="w-full max-w-xs">
                        <label class="sr-only" for="price-search">Search</label>
                        <input id="price-search" wire:model.live="search" type="search" placeholder="Search prices" class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 placeholder-slate-400 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                    </div>

                    <div class="relative" x-data="{ open: false }">
                        <button type="button" @click="open=!open" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Bulk actions</button>
                        <div x-cloak x-show="open" @click.away="open=false" class="absolute right-0 z-10 mt-2 w-56 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                            <button type="button" wire:click="toggleAvailability(true)" @click="open=false" class="flex w-full items-center px-4 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-50">Set available</button>
                            <button type="button" wire:click="toggleAvailability(false)" @click="open=false" class="flex w-full items-center px-4 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-50">Set unavailable</button>
                            <button type="button" wire:click="deleteSelected" onclick="confirm('Delete selected prices?') || event.stopImmediatePropagation()" @click="open=false" class="flex w-full items-center px-4 py-2 text-left text-sm font-medium text-rose-700 hover:bg-rose-50">Delete selected</button>
                        </div>
                    </div>

                    <button type="button" wire:click="openCreatePriceModal" class="inline-flex items-center justify-center rounded-lg bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">+ Add</button>
                </div>
            </div>

            <!-- Tabs -->
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach(['all'=>'All','legacy'=>'Legacy','perpetual'=>'Perpetual Software','nce'=>'New Commerce Experience'] as $k=>$label)
                    <button type="button" wire:click="setTab('{{ $k }}')" class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold ring-1 ring-inset {{ $tab===$k ? 'bg-primary-50 text-primary-800 ring-primary-200' : 'bg-white text-slate-700 ring-slate-200 hover:bg-slate-50' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        <div class="p-6">
            @if($prices->count() === 0)
                <div class="flex flex-col items-center justify-center rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-6 py-14 text-center">
                    <div class="rounded-2xl border border-slate-200 bg-white p-4">
                        <svg class="h-6 w-6 text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v5H4v-5" /></svg>
                    </div>
                    <div class="mt-3 text-sm font-semibold text-slate-900">No prices found…</div>
                    <div class="mt-1 text-sm text-slate-600">Add a price or import from CSV.</div>
                    <button type="button" wire:click="openCreatePriceModal" class="mt-4 inline-flex items-center justify-center rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">Add price</button>
                </div>
            @else
                <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                <th class="w-10 px-4 py-3"><input type="checkbox" wire:model="selectPage" class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500" /></th>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">SKU</th>
                                <th class="px-4 py-3">Currency</th>
                                <th class="px-4 py-3">Price</th>
                                <th class="px-4 py-3">MSRP</th>
                                <th class="px-4 py-3">Available</th>
                                <th class="px-4 py-3">Updated</th>
                                <th class="px-4 py-3 text-right"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($prices as $p)
                                <tr class="text-sm text-slate-800 hover:bg-slate-50/50">
                                    <td class="px-4 py-3"><input type="checkbox" wire:model="selected" value="{{ $p->id }}" class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500" /></td>
                                    <td class="px-4 py-3 font-semibold text-slate-900">{{ $p->title ?? ($p->product?->name ?? '—') }}</td>
                                    <td class="px-4 py-3 font-mono text-xs text-slate-700">{{ $p->sku ?? ($p->product?->sku ?? '—') }}</td>
                                    <td class="px-4 py-3">{{ $p->currency ?? '—' }}</td>
                                    <td class="px-4 py-3">{{ $p->price !== null ? number_format((float)$p->price, 2) : '—' }}</td>
                                    <td class="px-4 py-3">{{ $p->msrp !== null ? number_format((float)$p->msrp, 2) : '—' }}</td>
                                    <td class="px-4 py-3">
                                        @if($p->available_for_purchase)
                                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">Yes</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-rose-50 px-2 py-0.5 text-xs font-semibold text-rose-700 ring-1 ring-inset ring-rose-200">No</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">{{ optional($p->updated_at)->format('Y-m-d') }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <button type="button" wire:click="openEditPriceModal({{ $p->id }})" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Edit</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $prices->links() }}</div>
            @endif
        </div>
    </div>

    <!-- Edit price list modal -->
    @include('pricing.price-lists.partials.edit-price-list-modal')

    @if($showPriceModal)
        @livewire('pricing.price-editor-modal', ['priceListId' => $priceList->id, 'priceId' => $editingPriceId], key('price-editor-'.$priceList->id.'-'.$editingPriceId))
    @endif
</div>
