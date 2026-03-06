<div>
    <!-- Top metrics (Stripe-like summary cards) -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white/80 px-6 py-5 shadow-sm">
            <div class="text-sm font-medium text-slate-600">All</div>
            <div class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">{{ $subscriptions->total() }}</div>
            <div class="mt-1 text-xs text-slate-500">Total subscriptions (current filter)</div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white/80 px-6 py-5 shadow-sm">
            <div class="text-sm font-medium text-slate-600">Active</div>
            <div class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">{{ $subscriptions->where('status.name', 'messages.active')->count() }}</div>
            <div class="mt-1 text-xs text-slate-500">Currently active</div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white/80 px-6 py-5 shadow-sm">
            <div class="text-sm font-medium text-slate-600">Inactive</div>
            <div class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">{{ $subscriptions->where('status.name', 'messages.inactive')->count() }}</div>
            <div class="mt-1 text-xs text-slate-500">Paused / inactive</div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white/80 px-6 py-5 shadow-sm">
            <div class="text-sm font-medium text-slate-600">Canceled</div>
            <div class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">{{ $subscriptions->where('status.name', 'messages.canceled')->count() }}</div>
            <div class="mt-1 text-xs text-slate-500">No longer renewing</div>
        </div>
    </div>

    <!-- Tabs + search -->
    <div class="mt-8 rounded-2xl border border-slate-200 bg-white/80 shadow-sm">
        <div class="border-b border-slate-200 px-6 py-4">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h3 class="text-base font-semibold text-slate-900">Subscriptions</h3>
                    <p class="mt-1 text-sm text-slate-600">Filter and search your subscriptions.</p>
                </div>

                <div class="w-full max-w-lg">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input wire:model.live.debounce.300ms="search" id="search" class="block w-full rounded-lg border border-slate-300 bg-white py-2 pl-10 pr-3 text-sm text-slate-900 placeholder-slate-400 focus:border-primary-500 focus:outline-none focus:ring-4 focus:ring-primary-500/20" placeholder="Search by name, id, billing period…" type="search" name="search">
                    </div>
                </div>
            </div>

            <div class="mt-5 border-b border-slate-200">
                <nav class="-mb-px flex flex-wrap gap-6" x-data="{ tab: 1 }">
                    <a href="#" wire:click.prevent="resetFilters" @click.prevent="tab = 1" class="border-b-2 px-1 pb-3 text-sm font-semibold"
                       :class="tab === 1 ? 'border-primary-600 text-primary-700' : 'border-transparent text-slate-600 hover:text-slate-900'">
                        All
                    </a>
                    <a href="#" wire:click.prevent="legacy" @click.prevent="tab = 2" class="border-b-2 px-1 pb-3 text-sm font-semibold"
                       :class="tab === 2 ? 'border-primary-600 text-primary-700' : 'border-transparent text-slate-600 hover:text-slate-900'">
                        Legacy
                    </a>
                    <a href="#" wire:click.prevent="perpetual" @click.prevent="tab = 3" class="border-b-2 px-1 pb-3 text-sm font-semibold"
                       :class="tab === 3 ? 'border-primary-600 text-primary-700' : 'border-transparent text-slate-600 hover:text-slate-900'">
                        Perpetual
                    </a>
                    <a href="#" wire:click.prevent="expiration" @click.prevent="tab = 4" class="border-b-2 px-1 pb-3 text-sm font-semibold"
                       :class="tab === 4 ? 'border-primary-600 text-primary-700' : 'border-transparent text-slate-600 hover:text-slate-900'">
                        Expiring soon
                    </a>
                    <a href="#" wire:click.prevent="nce" @click.prevent="tab = 5" class="border-b-2 px-1 pb-3 text-sm font-semibold"
                       :class="tab === 5 ? 'border-primary-600 text-primary-700' : 'border-transparent text-slate-600 hover:text-slate-900'">
                        NCE
                    </a>
                </nav>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Term</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Billing</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-600">Qty</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse ($subscriptions as $subscription)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-sm font-semibold text-slate-900">
                                <a href="{{ $subscription->format()['path'] ?? '#' }}" class="hover:underline">
                                    {{ $subscription->name }}
                                </a>
                                <div class="mt-0.5 text-xs text-slate-500">ID: {{ $subscription->id }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $subscription->term }}</td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $subscription->billing_period }}</td>
                            <td class="px-6 py-4 text-right text-sm font-semibold text-slate-900">{{ $subscription->amount }}</td>
                            <td class="px-6 py-4">
                                @php($statusKey = $subscription->status->name ?? '')
                                @if($statusKey === 'messages.active')
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">Active</span>
                                    @if(!empty($subscription->expiration_data))
                                        <div class="mt-1 text-xs text-slate-500">Renews on {{ $subscription->expiration_data }}</div>
                                    @endif
                                @elseif($statusKey === 'messages.inactive')
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-700 ring-1 ring-inset ring-slate-200">Inactive</span>
                                @elseif($statusKey === 'messages.canceled')
                                    <span class="inline-flex items-center rounded-full bg-rose-50 px-2 py-0.5 text-xs font-semibold text-rose-700 ring-1 ring-inset ring-rose-200">Canceled</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-700 ring-1 ring-inset ring-slate-200">Unknown</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-600">No subscriptions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-200 px-6 py-4">
            {{ $subscriptions->links() }}
        </div>
    </div>
</div>
