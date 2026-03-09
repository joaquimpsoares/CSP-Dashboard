<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold tracking-tight text-slate-900">
                    {{ __('Dashboard') }}
                </h2>
                <p class="mt-1 text-sm text-slate-600">Overview of customers, subscriptions and recent activity.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Metric cards -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @if(($userLevel ?? null) !== config('app.customer'))
                    <div class="rounded-2xl border border-slate-200 bg-white/80 px-6 py-5 shadow-sm">
                        <div class="text-sm font-medium text-slate-600">Customers</div>
                        <div class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">{{ number_format($metrics['customers'] ?? 0) }}</div>
                        <div class="mt-2 text-xs text-slate-500">Total customers in the platform</div>
                    </div>
                @endif

                <div class="rounded-2xl border border-slate-200 bg-white/80 px-6 py-5 shadow-sm">
                    <div class="text-sm font-medium text-slate-600">Subscriptions</div>
                    <div class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">{{ number_format($metrics['subscriptions'] ?? 0) }}</div>
                    <div class="mt-2 text-xs text-slate-500">{{ (($userLevel ?? null) === config('app.customer')) ? 'Your subscriptions' : 'Active + inactive (all records)' }}</div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white/80 px-6 py-5 shadow-sm">
                    <div class="text-sm font-medium text-slate-600">Orders</div>
                    <div class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">{{ number_format($metrics['orders'] ?? 0) }}</div>
                    <div class="mt-2 text-xs text-slate-500">{{ (($userLevel ?? null) === config('app.customer')) ? 'Your orders' : 'Total orders created' }}</div>
                </div>

                @php
                    $estRiskCount = \App\Subscription::withoutGlobalScopes()
                        ->where('est_risk', true)
                        ->where('environment', session('environment', 'live'))
                        ->count();
                @endphp

                @if($estRiskCount > 0)
                <div class="rounded-2xl border border-red-200 bg-red-50 px-6 py-5 shadow-sm">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-red-700">EST Risk</span>
                        <span class="flex h-2.5 w-2.5 rounded-full bg-red-500"></span>
                    </div>
                    <div class="text-3xl font-bold text-red-900">{{ $estRiskCount }}</div>
                    <div class="mt-1 text-xs text-red-600">
                        Subscription(s) at risk of EST auto-enrollment on Apr 1
                    </div>
                    <a href="{{ route('subscription.index') }}"
                        class="mt-3 inline-flex items-center text-xs font-medium text-red-700 hover:text-red-900">
                        Review now &rarr;
                    </a>
                </div>
                @endif
            </div>

            <!-- Recent activity -->
            <div class="mt-8 rounded-2xl border border-slate-200 bg-white/80 shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900">Recent orders</h3>
                        <p class="mt-1 text-xs text-slate-600">Last 10 orders created</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Customer</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Domain</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-600">Created</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @forelse(($recentOrders ?? []) as $order)
                                <tr class="hover:bg-slate-50/60">
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900">#{{ $order->id }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-700">
                                        {{ optional($order->customer)->company_name ?? '—' }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-700">{{ $order->domain ?? '—' }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-700">{{ $order->status ?? '—' }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-slate-600">
                                        {{ optional($order->created_at)?->diffForHumans() ?? '—' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-600">No orders found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
