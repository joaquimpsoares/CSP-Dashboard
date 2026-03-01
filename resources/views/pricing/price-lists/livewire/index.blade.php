<div class="p-6">
    <div class="flex flex-col gap-4">
        <!-- Top bar -->
        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <div class="w-full max-w-xl">
                <label for="pl-search" class="sr-only">Search</label>
                <div class="relative text-slate-400 focus-within:text-slate-500">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/></svg>
                    </div>
                    <input id="pl-search" wire:model.live="search" type="search" placeholder="Search price lists" class="block w-full rounded-xl border border-slate-300 bg-white py-2 pl-10 pr-3 text-sm text-slate-900 placeholder-slate-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" />
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" wire:click="openCreateDrawer" class="inline-flex items-center justify-center rounded-lg bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">Create price list</button>
            </div>
        </div>

        <!-- Status pills -->
        <div class="flex flex-wrap gap-2">
            <button wire:click="setStatus('all')" type="button" class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-sm font-semibold ring-1 ring-inset {{ $status==='all' ? 'bg-primary-50 text-primary-800 ring-primary-200' : 'bg-white text-slate-700 ring-slate-200 hover:bg-slate-50' }}">
                All <span class="text-xs font-bold">{{ $counts['all'] ?? 0 }}</span>
            </button>
            <button wire:click="setStatus('active')" type="button" class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-sm font-semibold ring-1 ring-inset {{ $status==='active' ? 'bg-emerald-50 text-emerald-800 ring-emerald-200' : 'bg-white text-slate-700 ring-slate-200 hover:bg-slate-50' }}">
                Active <span class="text-xs font-bold">{{ $counts['active'] ?? 0 }}</span>
            </button>
            <button wire:click="setStatus('archived')" type="button" class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-sm font-semibold ring-1 ring-inset {{ $status==='archived' ? 'bg-slate-100 text-slate-800 ring-slate-200' : 'bg-white text-slate-700 ring-slate-200 hover:bg-slate-50' }}">
                Archived <span class="text-xs font-bold">{{ $counts['archived'] ?? 0 }}</span>
            </button>

            <button wire:click="clearFilters" type="button" class="ml-auto inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Clear filters</button>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Pricing</th>
                        <th class="px-4 py-3">Created</th>
                        <th class="px-4 py-3">Updated</th>
                        <th class="px-4 py-3 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($priceLists as $pl)
                        <tr class="text-sm text-slate-800 hover:bg-slate-50/50">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <a class="font-semibold text-slate-900 hover:text-primary-700" href="{{ url('/pricing/price-lists/' . $pl->id) }}">{{ $pl->name }}</a>
                                    @if($pl->deleted_at)
                                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-700 ring-1 ring-inset ring-slate-200">Archived</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">Active</span>
                                    @endif
                                </div>
                                <div class="mt-0.5 text-xs text-slate-500">#{{ $pl->id }} · {{ $pl->currency ?? '—' }} {{ $pl->market ? '· '.$pl->market : '' }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-700">{{ \App\Price::query()->where('price_list_id', $pl->id)->count() }} prices</td>
                            <td class="px-4 py-3 text-sm text-slate-700">{{ optional($pl->created_at)->format('Y-m-d') }}</td>
                            <td class="px-4 py-3 text-sm text-slate-700">{{ optional($pl->updated_at)->format('Y-m-d') }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ url('/pricing/price-lists/' . $pl->id) }}" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-700 shadow-sm hover:bg-slate-50">Open</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-16">
                                <div class="flex flex-col items-center justify-center text-center">
                                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                        <svg class="h-6 w-6 text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-6 6l6 6" /></svg>
                                    </div>
                                    <div class="mt-3 text-sm font-semibold text-slate-900">No price lists found</div>
                                    <div class="mt-1 text-sm text-slate-600">Try adjusting filters or create a new price list.</div>
                                    <button type="button" wire:click="openCreateDrawer" class="mt-4 inline-flex items-center justify-center rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-500/30">Create price list</button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $priceLists->links() }}
        </div>
    </div>

    @include('pricing.price-lists.partials.create-price-list-drawer')
</div>
