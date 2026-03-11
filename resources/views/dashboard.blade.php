<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold tracking-tight text-slate-900">Dashboard</h2>
                <p class="mt-1 text-sm text-slate-500">Platform overview — {{ now()->format('F j, Y') }}</p>
            </div>
        </div>
    </x-slot>

    {{-- ApexCharts --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.49.0/dist/apexcharts.min.js"></script>

    @php
        // Trend helper: % change vs previous period
        $trend = function(int|float $curr, int|float $prev): array {
            if ($prev == 0) { $pct = $curr > 0 ? 100 : 0; }
            else { $pct = round((($curr - $prev) / $prev) * 100, 1); }
            return ['pct' => abs($pct), 'up' => $pct >= 0];
        };

        // Subscription status labels
        $statusLabels = [1 => 'Active', 2 => 'Inactive', 3 => 'Canceled', 4 => 'Expired', 5 => 'Pending'];
        $statusColors = [1 => '#10b981', 2 => '#94a3b8', 3 => '#ef4444', 4 => '#f59e0b', 5 => '#6366f1'];
    @endphp

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- ── Onboarding checklist ─────────────────────────────────── --}}
            @php
                $obUser      = auth()->user();
                $obProvider  = $obUser?->provider;
                $hasInstance = \Modules\MicrosoftCspConnection\Models\MicrosoftCspConnection
                    ::where('provider_id', $obProvider?->id)->whereNotNull('consented_at')->exists();
                $hasCustomer = \App\Customer::whereHas('resellers', fn($q) =>
                    $q->where('provider_id', $obProvider?->id ?? 0))->exists();
                $hasTeamMember = \App\Models\User::where('provider_id', $obProvider?->id ?? 0)
                    ->where('id', '!=', $obUser?->id)->exists();
                $allDone = $hasInstance && $hasCustomer && $hasTeamMember;
            @endphp

            @if(!$allDone && ($obUser->onboarding_step ?? 0) >= 3)
            <div class="mb-6 rounded-2xl border border-blue-100 bg-blue-50 p-5">
                <h3 class="text-sm font-semibold text-blue-900 mb-3">Getting started — complete your setup</h3>
                <div class="flex flex-wrap gap-x-8 gap-y-2">
                    @foreach([
                        ['done' => true,          'label' => 'Create account'],
                        ['done' => true,          'label' => 'Verify email'],
                        ['done' => true,          'label' => 'Select plan'],
                        ['done' => $hasInstance,  'label' => 'Connect Partner Center', 'link' => route('instances.index')],
                        ['done' => $hasCustomer,  'label' => 'Add first customer',     'link' => route('customer.index')],
                        ['done' => $hasTeamMember,'label' => 'Invite team member'],
                    ] as $step)
                    <div class="flex items-center gap-2">
                        @if($step['done'])
                            <span class="flex h-4 w-4 items-center justify-center rounded-full bg-green-500 text-white text-xs">✓</span>
                            <span class="text-xs text-slate-400 line-through">{{ $step['label'] }}</span>
                        @else
                            <span class="flex h-4 w-4 items-center justify-center rounded-full border-2 border-blue-400"></span>
                            @if(isset($step['link']))
                                <a href="{{ $step['link'] }}" class="text-xs font-medium text-blue-700 hover:text-blue-900">{{ $step['label'] }} →</a>
                            @else
                                <span class="text-xs text-slate-600">{{ $step['label'] }}</span>
                            @endif
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ── EST Risk banner ─────────────────────────────────────── --}}
            @if(isset($estRiskCount) && $estRiskCount > 0)
            <div class="mb-6 flex items-center justify-between rounded-xl border border-red-200 bg-red-50 px-5 py-3">
                <div class="flex items-center gap-3">
                    <span class="flex h-2.5 w-2.5 rounded-full bg-red-500 animate-pulse"></span>
                    <span class="text-sm font-semibold text-red-800">{{ $estRiskCount }} subscription{{ $estRiskCount > 1 ? 's' : '' }} at EST auto-enrollment risk</span>
                    <span class="text-xs text-red-600">— Auto-enrolls Apr 1 unless opted out</span>
                </div>
                <a href="{{ route('subscription.index') }}" class="text-xs font-semibold text-red-700 hover:text-red-900">Review now →</a>
            </div>
            @endif

            {{-- ── Main grid: 2/3 left + 1/3 right ────────────────────── --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

                {{-- ════════════════ LEFT COLUMN (2/3) ════════════════ --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- KPI cards --}}
                    <div class="grid grid-cols-2 sm:grid-cols-2 gap-4">

                        {{-- Customers --}}
                        @if(($userLevel ?? null) !== config('app.customer'))
                        @php $ct = $trend($metrics['customers_month'] ?? 0, $metrics['customers_prev'] ?? 0); @endphp
                        <div class="rounded-2xl border border-slate-200 bg-white px-5 py-4 shadow-sm">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Customers</span>
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-50">
                                    <svg class="h-4 w-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </span>
                            </div>
                            <div class="text-3xl font-bold text-slate-900">{{ number_format($metrics['customers'] ?? 0) }}</div>
                            <div class="mt-2 flex items-center gap-1.5">
                                <span class="inline-flex items-center gap-0.5 rounded-full px-1.5 py-0.5 text-xs font-medium {{ $ct['up'] ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-600' }}">
                                    {{ $ct['up'] ? '↑' : '↓' }} {{ $ct['pct'] }}%
                                </span>
                                <span class="text-xs text-slate-400">vs last month</span>
                            </div>
                            <div class="mt-1 text-xs text-slate-500">{{ $metrics['customers_month'] ?? 0 }} new this month</div>
                        </div>
                        @endif

                        {{-- Subscriptions --}}
                        <div class="rounded-2xl border border-slate-200 bg-white px-5 py-4 shadow-sm">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Subscriptions</span>
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50">
                                    <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </span>
                            </div>
                            <div class="text-3xl font-bold text-slate-900">{{ number_format($metrics['subscriptions'] ?? 0) }}</div>
                            <div class="mt-2 flex items-center gap-2">
                                <span class="text-xs font-medium text-emerald-600">{{ number_format($metrics['subscriptions_active'] ?? 0) }} active</span>
                                @if(($metrics['subscriptions_expiring'] ?? 0) > 0)
                                <span class="text-xs font-medium text-amber-600">· {{ $metrics['subscriptions_expiring'] }} expiring soon</span>
                                @endif
                            </div>
                            <div class="mt-1 text-xs text-slate-500">total across all customers</div>
                        </div>

                        {{-- Orders --}}
                        @php $ot = $trend($metrics['orders_month'] ?? 0, $metrics['orders_prev'] ?? 0); @endphp
                        <div class="rounded-2xl border border-slate-200 bg-white px-5 py-4 shadow-sm">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Orders</span>
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-violet-50">
                                    <svg class="h-4 w-4 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                </span>
                            </div>
                            <div class="text-3xl font-bold text-slate-900">{{ number_format($metrics['orders_month'] ?? 0) }}</div>
                            <div class="mt-2 flex items-center gap-1.5">
                                <span class="inline-flex items-center gap-0.5 rounded-full px-1.5 py-0.5 text-xs font-medium {{ $ot['up'] ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-600' }}">
                                    {{ $ot['up'] ? '↑' : '↓' }} {{ $ot['pct'] }}%
                                </span>
                                <span class="text-xs text-slate-400">vs last month</span>
                            </div>
                            <div class="mt-1 text-xs text-slate-500">{{ number_format($metrics['orders'] ?? 0) }} total all time</div>
                        </div>

                        {{-- EST Risk or Expiring --}}
                        @if(isset($estRiskCount) && $estRiskCount > 0)
                        <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 shadow-sm">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-semibold uppercase tracking-wide text-red-600">EST Risk</span>
                                <span class="flex h-2.5 w-2.5 rounded-full bg-red-500 animate-pulse"></span>
                            </div>
                            <div class="text-3xl font-bold text-red-900">{{ $estRiskCount }}</div>
                            <div class="mt-2 text-xs text-red-700 font-medium">Subscriptions at risk</div>
                            <div class="mt-1 text-xs text-red-500">Auto-enroll date: Apr 1</div>
                        </div>
                        @else
                        <div class="rounded-2xl border border-slate-200 bg-white px-5 py-4 shadow-sm">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Expiring Soon</span>
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50">
                                    <svg class="h-4 w-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </span>
                            </div>
                            <div class="text-3xl font-bold text-slate-900">{{ number_format($metrics['subscriptions_expiring'] ?? 0) }}</div>
                            <div class="mt-2 text-xs text-amber-600 font-medium">within next 90 days</div>
                            <div class="mt-1 text-xs text-slate-500">active subscriptions</div>
                        </div>
                        @endif

                    </div>{{-- end KPI grid --}}

                    {{-- ── Orders – last 30 days chart ─────────────────── --}}
                    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                            <div>
                                <h3 class="text-sm font-semibold text-slate-800">Orders — last 30 days</h3>
                                <p class="mt-0.5 text-xs text-slate-500">Daily order volume</p>
                            </div>
                            <span class="text-lg font-bold text-slate-900">{{ array_sum($orderChartData ?? []) }}</span>
                        </div>
                        <div class="px-2 py-2">
                            <div id="chart-orders-30d"></div>
                        </div>
                    </div>

                    {{-- ── Expiring subscriptions ───────────────────────── --}}
                    @if(isset($expiringSoon) && $expiringSoon->isNotEmpty())
                    <div class="rounded-2xl border border-amber-200 bg-white shadow-sm overflow-hidden">
                        <div class="flex items-center justify-between px-5 py-4 border-b border-amber-100 bg-amber-50">
                            <div>
                                <h3 class="text-sm font-semibold text-amber-900">Expiring subscriptions</h3>
                                <p class="mt-0.5 text-xs text-amber-700">Active subscriptions expiring within 90 days</p>
                            </div>
                            <a href="{{ route('subscription.index') }}" class="text-xs font-medium text-amber-700 hover:text-amber-900">View all →</a>
                        </div>
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-5 py-2.5 text-left text-xs font-medium text-slate-500 uppercase tracking-wide">Product</th>
                                    <th class="px-5 py-2.5 text-left text-xs font-medium text-slate-500 uppercase tracking-wide">Customer</th>
                                    <th class="px-5 py-2.5 text-left text-xs font-medium text-slate-500 uppercase tracking-wide">Qty</th>
                                    <th class="px-5 py-2.5 text-right text-xs font-medium text-slate-500 uppercase tracking-wide">Expires</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($expiringSoon as $sub)
                                @php $daysLeft = now()->diffInDays($sub->expiration_data, false); @endphp
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-5 py-3 text-slate-800 font-medium">{{ $sub->name ?? '—' }}</td>
                                    <td class="px-5 py-3 text-slate-600">{{ optional($sub->customer)->company_name ?? '—' }}</td>
                                    <td class="px-5 py-3 text-slate-600">{{ $sub->amount ?? '—' }}</td>
                                    <td class="px-5 py-3 text-right">
                                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                                            {{ $daysLeft <= 30 ? 'bg-red-50 text-red-700' : 'bg-amber-50 text-amber-700' }}">
                                            {{ $daysLeft }}d left
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif

                    {{-- ── Recent orders table ──────────────────────────── --}}
                    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                            <div>
                                <h3 class="text-sm font-semibold text-slate-800">Recent orders</h3>
                                <p class="mt-0.5 text-xs text-slate-500">Last 10 orders created</p>
                            </div>
                            <a href="{{ route('order.index') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">View all →</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-5 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wide">ID</th>
                                        <th class="px-5 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wide">Customer</th>
                                        <th class="px-5 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wide">Domain</th>
                                        <th class="px-5 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wide">Status</th>
                                        <th class="px-5 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wide">Created</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse(($recentOrders ?? []) as $order)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-5 py-3 font-medium text-slate-900">#{{ $order->id }}</td>
                                        <td class="px-5 py-3 text-slate-700">{{ optional($order->customer)->company_name ?? '—' }}</td>
                                        <td class="px-5 py-3 text-slate-600">{{ $order->domain ?? '—' }}</td>
                                        <td class="px-5 py-3">
                                            @php
                                                $sColor = match((string)($order->order_status_id ?? '')) {
                                                    '4'     => 'bg-emerald-50 text-emerald-700',
                                                    '3'     => 'bg-red-50 text-red-700',
                                                    '2'     => 'bg-blue-50 text-blue-700',
                                                    default => 'bg-slate-100 text-slate-600',
                                                };
                                                $sLabel = match((string)($order->order_status_id ?? '')) {
                                                    '4' => 'Completed', '3' => 'Failed',
                                                    '2' => 'Running',   default => 'Placed',
                                                };
                                            @endphp
                                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium {{ $sColor }}">{{ $sLabel }}</span>
                                        </td>
                                        <td class="px-5 py-3 text-right text-slate-500">{{ optional($order->created_at)->diffForHumans() ?? '—' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-10 text-center text-sm text-slate-400">No orders found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>{{-- end left column --}}

                {{-- ════════════════ RIGHT COLUMN — News (1/3) ════════════ --}}
                <div class="lg:col-span-1 space-y-6">
                    <div class="rounded-2xl border border-slate-200 bg-white overflow-hidden">
                        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                            <h3 class="text-sm font-semibold text-slate-800">Announcements</h3>
                            <a href="{{ route('news.list') }}" class="text-xs text-indigo-600 hover:underline">View all</a>
                        </div>
                        @if(isset($news) && $news->isNotEmpty())
                        <ul class="divide-y divide-slate-100">
                            @foreach($news as $new)
                            @php $desc = is_resource($new->description) ? stream_get_contents($new->description) : (string)$new->description; @endphp
                            <li class="px-5 py-4">
                                @if($new->image)
                                <img class="object-cover w-full h-24 rounded-lg mb-3" src="{{ $new->image }}" alt="">
                                @endif
                                <a href="{{ route('news.view', $new->id) }}" class="block text-sm font-medium text-slate-800 hover:text-indigo-600 leading-snug">
                                    {{ $new->title }}
                                </a>
                                <p class="mt-1 text-xs text-slate-500 line-clamp-2">
                                    {!! \Illuminate\Support\Str::limit(strip_tags(\Michelf\Markdown::defaultTransform($desc)), 110) !!}
                                </p>
                                <p class="mt-2 text-xs text-slate-400">{{ $new->created_at->diffForHumans() }}</p>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <div class="px-5 py-12 text-center">
                            <svg class="mx-auto h-8 w-8 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            <p class="text-sm text-slate-400">No announcements yet.</p>
                        </div>
                        @endif
                    </div>

                    {{-- Subscriptions – last 6 months --}}
                    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <div class="px-5 py-4 border-b border-slate-100">
                            <h3 class="text-sm font-semibold text-slate-800">Subscriptions — last 6 months</h3>
                            <p class="mt-0.5 text-xs text-slate-500">New subscriptions per month</p>
                        </div>
                        <div class="px-2 py-2">
                            <div id="chart-subs-6m"></div>
                        </div>
                    </div>

                    {{-- Top 5 products --}}
                    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <div class="px-5 py-4 border-b border-slate-100">
                            <h3 class="text-sm font-semibold text-slate-800">Top 5 products</h3>
                            <p class="mt-0.5 text-xs text-slate-500">By subscription count</p>
                        </div>
                        <div class="px-2 py-2">
                            <div id="chart-top5"></div>
                        </div>
                    </div>

                </div>{{-- end right column --}}

            </div>{{-- end main grid --}}
        </div>
    </div>

    {{-- ── ApexCharts initialisation ──────────────────────────────────── --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        var SLATE  = '#64748b';
        var GRID   = '#f1f5f9';
        var INDIGO = '#6366f1';
        var VIOLET = '#8b5cf6';

        var baseChart = {
            toolbar:   { show: false },
            sparkline: { enabled: false },
            fontFamily: 'Figtree, ui-sans-serif, system-ui, sans-serif',
            foreColor: SLATE,
        };

        // ── Orders – last 30 days (area) ─────────────────────────────────
        var orderDates = {!! json_encode($orderChartDates ?? []) !!};
        var orderData  = {!! json_encode($orderChartData ?? []) !!};

        new ApexCharts(document.querySelector('#chart-orders-30d'), {
            chart:  { ...baseChart, type: 'area', height: 160 },
            series: [{ name: 'Orders', data: orderData }],
            xaxis:  {
                categories: orderDates,
                tickAmount: 6,
                labels: { style: { fontSize: '11px', colors: SLATE } },
                axisBorder: { show: false },
                axisTicks:  { show: false },
            },
            yaxis:  { labels: { style: { fontSize: '11px', colors: SLATE } }, min: 0 },
            stroke: { curve: 'smooth', width: 2 },
            fill:   { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.35, opacityTo: 0.02 } },
            colors: [INDIGO],
            grid:   { borderColor: GRID, strokeDashArray: 4 },
            tooltip:{ theme: 'light' },
            dataLabels: { enabled: false },
        }).render();

        // ── Subscriptions – last 6 months (bar) ──────────────────────────
        var subLabels = {!! json_encode($subChartLabels ?? []) !!};
        var subData   = {!! json_encode($subChartData ?? []) !!};

        new ApexCharts(document.querySelector('#chart-subs-6m'), {
            chart:  { ...baseChart, type: 'bar', height: 180 },
            series: [{ name: 'New subscriptions', data: subData }],
            xaxis:  {
                categories: subLabels,
                labels: { style: { fontSize: '11px', colors: SLATE } },
                axisBorder: { show: false },
                axisTicks:  { show: false },
            },
            yaxis:  { labels: { style: { fontSize: '11px', colors: SLATE } }, min: 0 },
            colors: [VIOLET],
            plotOptions: { bar: { borderRadius: 4, columnWidth: '55%' } },
            grid:    { borderColor: GRID, strokeDashArray: 4 },
            tooltip: { theme: 'light' },
            dataLabels: { enabled: false },
        }).render();

        // ── Top 5 products (donut) ────────────────────────────────────────
        var top5Labels = {!! json_encode(array_keys($top5Products ?? [])) !!};
        var top5Data   = {!! json_encode(array_values($top5Products ?? [])) !!};

        if (top5Data.length > 0) {
            new ApexCharts(document.querySelector('#chart-top5'), {
                chart:  { ...baseChart, type: 'donut', height: 180 },
                series: top5Data,
                labels: top5Labels,
                colors: ['#6366f1','#8b5cf6','#06b6d4','#10b981','#f59e0b'],
                legend: { position: 'bottom', fontSize: '11px', fontFamily: 'Figtree, sans-serif' },
                plotOptions: { pie: { donut: { size: '60%' } } },
                dataLabels: { enabled: false },
                tooltip:    { theme: 'light' },
            }).render();
        } else {
            document.querySelector('#chart-top5').innerHTML =
                '<p class="text-center text-sm text-slate-400 py-10">No product data yet.</p>';
        }

    });
    </script>

</x-app-layout>
