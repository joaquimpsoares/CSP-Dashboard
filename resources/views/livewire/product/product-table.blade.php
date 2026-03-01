<div class="p-6">
    <div class="flex flex-col gap-4">
        <div class="flex flex-col items-start justify-between gap-3 lg:flex-row lg:items-center">
            <div>
                <h4 class="text-base font-semibold text-slate-900">Products</h4>
                <p class="mt-1 text-sm text-slate-600">Preview reseller pricing and manage active/archived products.</p>
            </div>

            <div class="flex w-full flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
                <div class="w-full max-w-lg lg:max-w-xs">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative text-gray-400 focus-within:text-gray-500">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input wire:model.debounce.300ms="filters.search" id="search" class="block w-full rounded-lg border border-slate-300 bg-white py-2 pl-10 pr-3 text-sm text-slate-900 placeholder-slate-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" placeholder="Search products" type="search" name="search">
                    </div>
                </div>

                <a onclick="confirm('Are you sure you want to export these Records?') || event.stopImmediatePropagation()" wire:click="exportSelected()" href="#" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5 lg:inline" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                    </svg>
                    Export
                </a>
            </div>
        </div>

        <!-- Status cards -->
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <button type="button" wire:click="setStatusFilter('all')" class="rounded-2xl border border-slate-200 bg-white p-4 text-left shadow-sm hover:bg-slate-50 @if($statusFilter==='all') ring-2 ring-primary-500/40 @endif">
                <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">All</div>
                <div class="mt-2 text-2xl font-semibold text-slate-900">{{ $counts['all'] ?? 0 }}</div>
            </button>
            <button type="button" wire:click="setStatusFilter('active')" class="rounded-2xl border border-slate-200 bg-white p-4 text-left shadow-sm hover:bg-slate-50 @if($statusFilter==='active') ring-2 ring-primary-500/40 @endif">
                <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Active</div>
                <div class="mt-2 text-2xl font-semibold text-slate-900">{{ $counts['active'] ?? 0 }}</div>
            </button>
            <button type="button" wire:click="setStatusFilter('archived')" class="rounded-2xl border border-slate-200 bg-white p-4 text-left shadow-sm hover:bg-slate-50 @if($statusFilter==='archived') ring-2 ring-primary-500/40 @endif">
                <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">Archived</div>
                <div class="mt-2 text-2xl font-semibold text-slate-900">{{ $counts['archived'] ?? 0 }}</div>
            </button>
        </div>

        <!-- Bulk actions -->
        <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <input type="checkbox" wire:model="selectPage" class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500" />
                <div class="text-sm text-slate-600">
                    @if(!empty($selected))
                        <span class="font-semibold text-slate-900">{{ count($selected) }}</span> selected
                    @else
                        Select products to run bulk actions
                    @endif
                </div>
            </div>

            <div class="relative" x-data="{ open:false }">
                <button type="button" @click="open=!open" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50" :disabled="{{ empty($selected) ? 'true' : 'false' }}">Bulk actions</button>
                <div x-cloak x-show="open" @click.away="open=false" class="absolute right-0 z-10 mt-2 w-60 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                    <button type="button" wire:click="openBulkAddToPriceList" @click="open=false" class="flex w-full items-center px-4 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-50">Add to price list</button>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto overflow-y-visible">
            <table class="min-w-full divide-y divide-slate-200">
                <thead>
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <th class="w-10 px-3 py-2"></th>
                        <th class="px-3 py-2">SKU</th>
                        <th class="px-3 py-2">Name</th>
                        <th class="px-3 py-2">Preview price</th>
                        <th class="px-3 py-2">Category</th>
                        <th class="px-3 py-2">Updated</th>
                        <th class="px-3 py-2 text-right"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $p)
                        <tr class="text-sm text-slate-800 @if($p->deleted_at) bg-slate-50/50 @endif">
                            <td class="px-3 py-2">
                                <input type="checkbox" wire:model="selected" value="{{ $p->id }}" class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500" />
                            </td>
                            <td class="px-3 py-2 font-mono text-xs text-slate-600">{{ $p->sku }}</td>
                            <td class="px-3 py-2">
                                <div class="font-semibold text-slate-900">{{ $p->name ?? '—' }}</div>
                                <div class="text-xs text-slate-500">ID: {{ $p->id }}</div>
                            </td>
                            <td class="px-3 py-2">
                                @php($pv = $pricePreview[$p->id] ?? null)
                                @if($pv && !empty($pv['ok']))
                                    <div class="font-semibold text-slate-900">{{ $pv['sell_unit'] }}</div>
                                    @if(!empty($pv['reason']))
                                        <div class="text-xs text-slate-500">{{ $pv['reason'] }}</div>
                                    @endif
                                @else
                                    <div class="text-xs text-slate-500">n/a</div>
                                @endif
                            </td>
                            <td class="px-3 py-2 text-xs text-slate-600">{{ $p->category ?? '—' }}</td>
                            <td class="px-3 py-2 text-xs text-slate-600">{{ optional($p->updated_at)->format('Y-m-d') }}</td>
                            <td class="px-3 py-2 text-right">
                                <div x-data="{
                                    componentId: @js($this->getId()),
                                    open: false,
                                    top: 0,
                                    left: 0,
                                    width: 0,
                                    place() {
                                        const r = this.$refs.btn.getBoundingClientRect();
                                        this.width = 192;
                                        this.top = r.bottom + 8;
                                        this.left = Math.max(8, r.right - this.width);
                                    },
                                    toggle() {
                                        this.open = !this.open;
                                        if (this.open) this.$nextTick(() => this.place());
                                    },
                                    call(method, id) {
                                        const lw = window.Livewire;
                                        if (lw && lw.find) {
                                            const c = lw.find(this.componentId);
                                            if (!c) return;
                                            c.call(method, id);
                                        }
                                    }
                                }" @keydown.escape.window="open=false" class="inline-block">

                                    <button type="button" x-ref="btn" @click="toggle()" class="inline-flex items-center justify-center rounded-lg px-2 py-2 text-slate-600 hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-4 focus:ring-primary-500/20">
                                        <span class="sr-only">Actions</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>

                                    <template x-teleport="body">
                                        <div x-cloak x-show="open" @click.away="open=false" @scroll.window="open=false" @resize.window="open=false" class="fixed z-[9999] w-48 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg" :style="`top:${top}px; left:${left}px;`">
                                            <a href="{{ route('product.edit', $p->id) }}" class="flex w-full items-center gap-2 px-4 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-50">
                                                Edit
                                            </a>

                                            @if(!$p->deleted_at)
                                                <button type="button" @click="call('archive', {{ $p->id }}); open=false" class="flex w-full items-center gap-2 px-4 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-50">
                                                    Archive
                                                </button>
                                            @else
                                                <button type="button" @click="call('restore', {{ $p->id }}); open=false" class="flex w-full items-center gap-2 px-4 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-50">
                                                    Restore
                                                </button>
                                                <button type="button" @click="if(confirm('Delete permanently?')) { call('forceDelete', {{ $p->id }}); open=false }" class="flex w-full items-center gap-2 px-4 py-2 text-left text-sm font-medium text-red-700 hover:bg-red-50">
                                                    Delete permanently
                                                </button>
                                            @endif
                                        </div>
                                    </template>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-3 py-8 text-sm text-slate-500" colspan="6">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>

    @include('livewire.product.partials.bulk-add-to-price-list-drawer')
</div>
