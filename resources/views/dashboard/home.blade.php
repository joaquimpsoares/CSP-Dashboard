<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold tracking-tight text-slate-900">Dashboard</h2>
            <p class="mt-1 text-sm text-slate-600">Overview of your platform activity.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            @include('layouts.messages')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

                {{-- ── Left column (2/3) ──────────────────────────────── --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Stat cards --}}
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                        <div class="rounded-xl border border-slate-200 bg-white p-4">
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">Revenue</p>
                            <p class="text-xs text-slate-400">{{ ucwords(trans_choice('messages.last_30Days', 2)) }}</p>
                            <p class="mt-2 text-2xl font-semibold text-slate-900">${{ array_sum($ChartRevenew) }}</p>
                            <div id="chart-area" class="mt-2"></div>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-white p-4">
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">{{ ucwords(trans_choice('messages.order', 2)) }}</p>
                            <p class="text-xs text-slate-400">Last 30 days</p>
                            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ array_sum($chartDataCurrentByDay) }}</p>
                            <div id="chart-two-area" class="mt-2"></div>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-white p-4">
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">{{ ucwords(trans_choice('messages.reseller', 2)) }}</p>
                            <p class="text-xs text-slate-400">{{ ucwords(trans_choice('messages.last_30Days', 2)) }}</p>
                            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ array_sum($chartDataCurrentResellerByDay) }}</p>
                            <div id="chart-bar" class="mt-2"></div>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-white p-4">
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">{{ ucwords(trans_choice('messages.customer', 2)) }}</p>
                            <p class="text-xs text-slate-400">{{ ucwords(trans_choice('messages.last_30Days', 2)) }}</p>
                            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ array_sum($chartDataCurrentCustomerByDay) }}</p>
                            <div id="chart-barcustomer" class="mt-2"></div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            window.ApexCharts && new ApexCharts(document.getElementById("chart-area"), {
                                chart: { type: "area", height: 40.0, sparkline: { enabled: true } },
                                stroke: { width: 2 },
                                tooltip: { x: { show: false } },
                                series: [{ name: "{{ ucwords(trans_choice('messages.order', 2)) }}", data: {!! json_encode($ChartRevenew) !!} }]
                            }).render();
                            window.ApexCharts && new ApexCharts(document.getElementById("chart-two-area"), {
                                chart: { type: "area", height: 40.0, sparkline: { enabled: true } },
                                stroke: { width: [2,1], dashArray: [0,3], lineCap: "round", curve: "smooth" },
                                tooltip: { x: { show: false } },
                                colors: ["#c120c4", "#a8aeb7"],
                                xaxis: { tickPlacement: 'between' },
                                series: [{ name: "{{ \Carbon\Carbon::now()->format('M') }}", data: {!! json_encode($chartDataCurrentByDay) !!} }]
                            }).render();
                            window.ApexCharts && new ApexCharts(document.getElementById("chart-bar"), {
                                chart: { type: "area", height: 40.0, sparkline: { enabled: true } },
                                stroke: { width: 1 },
                                tooltip: { x: { show: false } },
                                colors: ["#20c439", "#a8aeb7"],
                                series: [{ name: "{{ ucwords(trans_choice('messages.reseller', 2)) }}", data: {!! json_encode($chartDataCurrentResellerByDay) !!} }]
                            }).render();
                            window.ApexCharts && new ApexCharts(document.getElementById("chart-barcustomer"), {
                                chart: { type: "area", height: 40.0, sparkline: { enabled: true } },
                                stroke: { width: 1 },
                                tooltip: { x: { show: false } },
                                colors: ["#c48020", "#a8aeb7"],
                                series: [{ name: "{{ ucwords(trans_choice('messages.customer', 2)) }}", data: {!! json_encode($chartDataCurrentCustomerByDay) !!} }]
                            }).render();
                        });
                    </script>

                    {{-- Instance alert --}}
                    @if(Auth::user()->userlevel == "provider")
                        @if($provider->instances->isEmpty())
                        <x-bladewind.alert type="warning">
                            You need to configure your instance. Please complete the settings in order to start using the app.<br>
                            <x-bladewind.button class="mt-2" size="small" url="/instances">Instances</x-bladewind.button>
                        </x-bladewind.alert>
                        @endif
                    @endif

                    {{-- Charts --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="rounded-xl border border-slate-200 bg-white p-4">
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-3">Evolution licenses comparison</p>
                            <div id="chart"></div>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-white p-4">
                            <p class="text-xs font-medium text-slate-500 uppercase tracking-wide mb-3">Top 5 products by licenses count</p>
                            <div id="chart2"></div>
                        </div>
                    </div>

                    <script>
                        var chart2opts = {
                            labels: {!! json_encode(array_keys($Top5LicensesSubscriptions)) !!},
                            series: {!! json_encode(array_values($Top5LicensesSubscriptions)) !!},
                            chart: { width: '100%', type: 'donut' },
                            plotOptions: { pie: { startAngle: -90, endAngle: 270 } },
                            dataLabels: { enabled: false },
                            fill: { type: 'gradient' },
                            legend: { position: 'bottom' },
                            responsive: [{ breakpoint: 480, options: { chart: { width: 200 }, legend: { position: 'bottom' } } }]
                        };
                        new ApexCharts(document.querySelector("#chart2"), chart2opts).render();

                        var chartOpts = {
                            series: [
                                { name: "Last year",    data: {!! json_encode(array_values($chartDataSubscriptionYear)) !!} },
                                { name: "Current Year", data: {!! json_encode(array_values($chartDataSubscriptionYearCurrent)) !!} }
                            ],
                            chart: { height: 280, type: "area", zoom: { enabled: true }, toolbar: { show: false } },
                            markers: { show: true, size: 6 },
                            dataLabels: { enabled: false },
                            legend: { show: true, showForSingleSeries: true, position: "top", horizontalAlign: "right" },
                            stroke: { curve: "smooth", linecap: "round" },
                            grid: { row: { colors: ["#f8fafc", "transparent"], opacity: 0.5 } },
                            xaxis: { categories: {!! json_encode(array_keys($chartDataSubscriptionYear)) !!} },
                            yaxis: { title: { text: 'Licenses Sold' } }
                        };
                        new ApexCharts(document.querySelector("#chart"), chartOpts).render();
                    </script>

                    {{-- Quick links --}}
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <a href="{{ route('store.index') }}" class="group relative flex flex-col gap-3 rounded-xl border border-slate-200 bg-white p-5 hover:bg-slate-50 transition-colors">
                            <span class="inline-flex w-10 h-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 3H5L5.4 5M7 13H17L21 5H5.4M7 13L5.4 5M7 13L4.70711 15.2929C4.07714 15.9229 4.52331 17 5.41421 17H17M17 17C15.8954 17 15 17.8954 15 19C15 20.1046 15.8954 21 17 21C18.1046 21 19 20.1046 19 19C19 17.8954 18.1046 17 17 17ZM9 19C9 20.1046 8.10457 21 7 21C5.89543 21 5 20.1046 5 19C5 17.8954 5.89543 17 7 17C8.10457 17 9 17.8954 9 19Z" />
                                </svg>
                            </span>
                            <div>
                                <p class="text-sm font-medium text-slate-800">{{ ucwords(trans_choice('messages.store', 1)) }}</p>
                                <p class="mt-0.5 text-xs text-slate-500">Purchase on-behalf your customers.</p>
                            </div>
                        </a>
                        <a href="/customer" class="group relative flex flex-col gap-3 rounded-xl border border-slate-200 bg-white p-5 hover:bg-slate-50 transition-colors">
                            <span class="inline-flex w-10 h-10 items-center justify-center rounded-lg bg-purple-50 text-purple-600">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            </span>
                            <div>
                                <p class="text-sm font-medium text-slate-800">{{ ucwords(trans_choice('messages.customer', 2)) }}</p>
                                <p class="mt-0.5 text-xs text-slate-500">Manage your customers.</p>
                            </div>
                        </a>
                        <a href="/subscription" class="group relative flex flex-col gap-3 rounded-xl border border-slate-200 bg-white p-5 hover:bg-slate-50 transition-colors">
                            <span class="inline-flex w-10 h-10 items-center justify-center rounded-lg bg-green-50 text-green-600">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            </span>
                            <div>
                                <p class="text-sm font-medium text-slate-800">{{ ucwords(trans_choice('messages.subscription', 2)) }}</p>
                                <p class="mt-0.5 text-xs text-slate-500">Manage your customers subscriptions.</p>
                            </div>
                        </a>
                        <a href="/analytics" class="group relative flex flex-col gap-3 rounded-xl border border-slate-200 bg-white p-5 hover:bg-slate-50 transition-colors">
                            <span class="inline-flex w-10 h-10 items-center justify-center rounded-lg bg-yellow-50 text-yellow-600">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" /></svg>
                            </span>
                            <div>
                                <p class="text-sm font-medium text-slate-800">{{ ucwords(trans_choice('messages.analytics', 2)) }}</p>
                                <p class="mt-0.5 text-xs text-slate-500">Check your current Azure budget.</p>
                            </div>
                        </a>
                        <a href="tickets" class="group relative flex flex-col gap-3 rounded-xl border border-slate-200 bg-white p-5 hover:bg-slate-50 transition-colors">
                            <span class="inline-flex w-10 h-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z" /></svg>
                            </span>
                            <div>
                                <p class="text-sm font-medium text-slate-800">{{ ucwords(trans_choice('messages.ticket', 2)) }}</p>
                                <p class="mt-0.5 text-xs text-slate-500">Submit a support ticket.</p>
                            </div>
                        </a>
                        <a href="/priceList" class="group relative flex flex-col gap-3 rounded-xl border border-slate-200 bg-white p-5 hover:bg-slate-50 transition-colors">
                            <span class="inline-flex w-10 h-10 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </span>
                            <div>
                                <p class="text-sm font-medium text-slate-800">{{ ucwords(trans_choice('messages.price', 2)) }}</p>
                                <p class="mt-0.5 text-xs text-slate-500">Manage your price list.</p>
                            </div>
                        </a>
                    </div>

                </div>{{-- end left column --}}

                {{-- ── Right column — News (1/3) ──────────────────────── --}}
                <div class="lg:col-span-1">
                    <div class="rounded-2xl border border-slate-200 bg-white overflow-hidden sticky top-6">
                        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                            <h3 class="text-sm font-semibold text-slate-800">{{ ucwords(trans_choice('messages.announcement', 2)) }}</h3>
                            <a href="{{ route('news.list') }}" class="text-xs text-indigo-600 hover:underline">View all</a>
                        </div>
                        @isset($news)
                        @if($news->isNotEmpty())
                        <ul class="divide-y divide-slate-100">
                            @foreach($news as $new)
                            @php $desc = is_resource($new->description) ? stream_get_contents($new->description) : (string)$new->description; @endphp
                            <li class="px-5 py-4">
                                @if($new->image)
                                <img class="object-cover w-full h-28 rounded-lg mb-3" src="{{ $new->image }}" alt="">
                                @endif
                                <a href="{{ route('news.view', $new->id) }}" class="block text-sm font-medium text-slate-800 hover:text-indigo-600 leading-snug">
                                    {{ $new->title }}
                                </a>
                                <p class="mt-1 text-xs text-slate-500 line-clamp-2">
                                    {!! \Illuminate\Support\Str::limit(strip_tags(\Michelf\Markdown::defaultTransform($desc)), 120) !!}
                                </p>
                                <p class="mt-2 text-xs text-slate-400">{{ $new->created_at->diffForHumans() }}</p>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <div class="px-5 py-10 text-center">
                            <p class="text-sm text-slate-400">No announcements yet.</p>
                        </div>
                        @endif
                        @else
                        <div class="px-5 py-10 text-center">
                            <p class="text-sm text-slate-400">No announcements yet.</p>
                        </div>
                        @endisset
                    </div>
                </div>{{-- end right column --}}

            </div>{{-- end grid --}}
        </div>
    </div>
</x-app-layout>
