@extends('layouts.master')

@section('content')

@include('layouts.messages')
<div class="grid grid-cols-1 gap-2 p-10 lg:grid-cols-4 h-100 w-100">
    <div class="bg-white border border-gray-200 rounded shadow">
        <div class="p-4">
            <div class="flex items-center">
                <div class="text-xs font-medium text-gray-500 uppercase">Revenue</div>
                <div class="ml-auto text-gray-500">{{ucwords(trans_choice('messages.last_30Days', 2))}}</div>
            </div>
            <div class="flex items-center">
                <div class="text-2xl font-semibold">${{array_sum($ChartRevenew)}}</div>
            </div>
        </div>
        <div id="chart-area"></div>
    </div>
    <div class="bg-white border border-gray-200 rounded shadow">
        <div class="p-4">
            <div class="flex items-center">
                <div class="text-xs font-medium text-gray-500 uppercase">{{ucwords(trans_choice('messages.order', 2))}}</div>
                <div class="ml-auto text-gray-500">Last 30 days</div>
            </div>
            <div class="flex items-center">
                <div class="text-2xl font-semibold">{{array_sum($chartDataCurrentByDay)}}</div>
            </div>
        </div>
        <div id="chart-two-area"></div>
    </div>
    <div class="bg-white border border-gray-200 rounded shadow">
        <div class="p-4">
            <div class="flex items-center">
                <div class="text-xs font-medium text-gray-500 uppercase">{{ucwords(trans_choice('messages.reseller', 2))}}</div>
                <div class="ml-auto text-gray-500">{{ucwords(trans_choice('messages.last_30Days', 2))}}</div>
            </div>
            <div class="flex items-center">
                <div class="text-2xl font-semibold">{{array_sum($chartDataCurrentResellerByDay)}}</div>
            </div>
        </div>
        <div id="chart-bar"></div>
    </div>

    <div class="bg-white border border-gray-200 rounded shadow">
        <div class="p-4">
            <div class="flex items-center">
                <div class="text-xs font-medium text-gray-500 uppercase">{{ucwords(trans_choice('messages.customer', 2))}}</div>
                <div class="ml-auto text-gray-500">{{ucwords(trans_choice('messages.last_30Days', 2))}}</div>
            </div>
            <div class="flex items-center">
                <div class="text-2xl font-semibold">{{array_sum($chartDataCurrentCustomerByDay)}}</div>
            </div>
        </div>
        <div id="chart-barcustomer"></div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts &&
        new ApexCharts(document.getElementById("chart-area"), {
            chart: {
                type: "area",
                height: 40.0,
                sparkline: { enabled: true }
            },
            stroke: { width: 2 },
            tooltip: { x: { show: false } },
            series: [
            {
                name: "{{ucwords(trans_choice('messages.order', 2))}}",
                data: {!! json_encode($ChartRevenew) !!},
            }
            ]
        }).render();
        window.ApexCharts &&
        new ApexCharts(document.getElementById("chart-two-area"), {
            chart: {
                type: "area",
                height: 40.0,
                sparkline: { enabled: true }
            },
            stroke: { width: [2,1], dashArray:[0,3], lineCap: "round", curve: "smooth" },
            tooltip: { x: { show: false } },
            colors: ["#c120c4", "#a8aeb7"],
            xaxis: {tickPlacement: 'between'},
            series: [
            {
                name: "{{\Carbon\Carbon::now()->format('M')}}",
                data: {!! json_encode($chartDataCurrentByDay) !!},
            }
            ]
        }).render();
        window.ApexCharts &&
        new ApexCharts(document.getElementById("chart-bar"), {
            chart: {
                type: "area",
                height: 40.0,
                sparkline: { enabled: true }
            },
            stroke: { width: 1 },
            tooltip: { x: { show: false } },
            colors: ["#20c439", "#a8aeb7"],
            series: [
            {
                name: "{{ucwords(trans_choice('messages.reseller', 2))}}",
                data: {!! json_encode($chartDataCurrentResellerByDay) !!},
            }
            ]
        }).render();
        window.ApexCharts &&
        new ApexCharts(document.getElementById("chart-barcustomer"), {
            chart: {
                type: "area",
                height: 40.0,
                sparkline: { enabled: true }
            },
            stroke: { width: 1 },
            tooltip: { x: { show: false } },
            colors: ["#c48020", "#a8aeb7"],
            series: [
            {
                name: "{{ucwords(trans_choice('messages.customer', 2))}}",
                data: {!! json_encode($chartDataCurrentCustomerByDay) !!},
            }
            ]
        }).render();
    });
</script>


<div class="p-6 mb-10 -mt-10 ">
    @if(Auth::user()->userlevel == "provider")
    @if($provider->instances->isEmpty())
    <x-bladewind.alert type="warning" >
        You need to configure your instance. Please complete the settings in order to start using the app. <br>
        <x-bladewind.button class="mt-2" size="small" url="/instances">Instances</x-bladewind.button>
    </x-bladewind.alert>
    @endif
    @endif

    <div class="mb-4 overflow-hidden bg-gray-200 rounded-lg shadow sm:grid sm:grid-cols-2 sm:gap-px">
        <div class="relative p-6 bg-white group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="text-xs font-medium text-gray-500 uppercase">Evolution licenses comparison</div>
                </div>
            </div>
            <div id="chart"></div>
        </div>
        <div class="relative p-6 bg-white group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
            <div class="p-4">
                <div class="flex items-center">
                    <div class="text-xs font-medium text-gray-500 uppercase">Top 5 products by licenses count</div>
                </div>
            </div>
            <div id="chart2"></div>
        </div>
    </div>

    <script>
        var options = {
            labels: {!! json_encode(array_keys($Top5LicensesSubscriptions    ))!!},
            series: {!! json_encode(array_values($Top5LicensesSubscriptions))!!},
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return {!! json_encode(array_values($Top5LicensesSubscriptions))!!}
                }
            },
            chart: {
                width: 500,
                type: 'donut',
            },

            plotOptions: {
                pie: {
                    startAngle: -90,
                    endAngle: 270
                }
            },
            dataLabels: {
                enabled: false
            },
            fill: {
                type: 'gradient',
            },
            legend: {
                position: 'bottom',
                formatter: function(val, opts) {
                    return {!! json_encode(array_keys($Top5LicensesSubscriptions    ))!!} + " - " + opts.w.globals.series[opts.seriesIndex]
                }
            },

            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#chart2"), options);
        chart.render();
    </script>
    <script>
        var options = {

            series: [
            {
                name: "Last year",
                data: {!! json_encode(array_values($chartDataSubscriptionYear))!!}
            },
            {
                name: "Current Year",
                data: {!! json_encode(array_values($chartDataSubscriptionYearCurrent))!!}
            }
            ],

            chart: {
                height: 350,
                type: "area",
                zoom: {
                    enabled: true
                },
                toolbar: {
                    show: false
                }
            },
            markers: {
                show: true,
                size: 6
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: true,
                showForSingleSeries: true,
                position: "top",
                horizontalAlign: "right"
            },
            stroke: {
                curve: "smooth",
                linecap: "round"
            },
            grid: {
                row: {
                    colors: ["#f3f3f3", "transparent"], // takes an array which will be repeated on columns
                    opacity: 0.5
                }
            },
            xaxis: {
                categories: {!! json_encode(array_keys($chartDataSubscriptionYear))!!}
            },
            yaxis: {
                title: {
                    text: 'Licenses Sold'
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
    <div class="overflow-hidden bg-gray-200 divide-y divide-gray-200 rounded-lg shadow sm:divide-y-0 sm:grid sm:grid-cols-2 sm:gap-px">
        <div class="relative p-6 bg-white rounded-tl-lg rounded-tr-lg sm:rounded-tr-none group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
            <div >
                <span class="inline-flex p-3 rounded-lg bg-blue-50 ring-4 ring-white">
                    <!-- Heroicon name: outline/clock -->
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 3H5L5.4 5M7 13H17L21 5H5.4M7 13L5.4 5M7 13L4.70711 15.2929C4.07714 15.9229 4.52331 17 5.41421 17H17M17 17C15.8954 17 15 17.8954 15 19C15 20.1046 15.8954 21 17 21C18.1046 21 19 20.1046 19 19C19 17.8954 18.1046 17 17 17ZM9 19C9 20.1046 8.10457 21 7 21C5.89543 21 5 20.1046 5 19C5 17.8954 5.89543 17 7 17C8.10457 17 9 17.8954 9 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                <div class="mt-6">
                    <h3 class="text-lg font-medium">
                        <a href="/store" class="focus:outline-none">
                            <!-- Extend touch target to entire panel -->
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            {{ucwords(trans_choice('messages.store', 1))}}
                        </a>
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Purchase on-behalf your customers.
                    </p>
                </div>
                <span class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400" aria-hidden="true">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                    </svg>
                </span>
            </div>
            <div class="relative p-6 bg-white sm:rounded-tr-lg group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                <div>
                    <span class="inline-flex p-3 text-purple-700 rounded-lg bg-purple-50 ring-4 ring-white">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </span>
                </div>
                <div class="mt-6">
                    <h3 class="text-lg font-medium">
                        <a href="/customer" class="focus:outline-none">
                            <!-- Extend touch target to entire panel -->
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            {{ucwords(trans_choice('messages.customer', 2))}}
                        </a>
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Manage your customers
                    </p>
                </div>
                <span class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400" aria-hidden="true">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                    </svg>
                </span>
            </div>
            <div class="relative p-6 bg-white group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                <div>
                    <span class="inline-flex p-3 text-green-700 rounded-lg bg-blue-50 ring-4 ring-white">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </span>
                </div>
                <div class="mt-6">
                    <h3 class="text-lg font-medium">
                        <a href="/subscription" class="focus:outline-none">
                            <!-- Extend touch target to entire panel -->
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            {{ucwords(trans_choice('messages.subscription', 2))}}
                        </a>
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Manage your customers subscriptions.
                    </p>
                </div>
                <span class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400" aria-hidden="true">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                    </svg>
                </span>
            </div>
            <div class="relative p-6 bg-white group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                <div>
                    <span class="inline-flex p-3 text-yellow-700 rounded-lg bg-yellow-50 ring-4 ring-white">
                        <!-- Heroicon name: outline/badge-check -->
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                    </span>
                </div>
                <div class="mt-6">
                    <h3 class="text-lg font-medium">
                        <a href="/analytics" class="focus:outline-none">
                            <!-- Extend touch target to entire panel -->
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            {{ucwords(trans_choice('messages.analytics', 2))}}
                        </a>
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Check your current budget for Azure Subscriptions
                    </p>
                </div>
                <span class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400" aria-hidden="true">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                    </svg>
                </span>
            </div>
            <div class="relative p-6 bg-white sm:rounded-bl-lg group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                <div>
                    <span class="inline-flex p-3 text-blue-700 rounded-lg bg-purple-50 ring-4 ring-white">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z" />
                        </svg>
                    </span>
                </div>
                <div class="mt-6">
                    <h3 class="text-lg font-medium">
                        <a href="tickets" class="focus:outline-none">
                            <!-- Extend touch target to entire panel -->
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            {{ucwords(trans_choice('messages.ticket', 2))}}
                        </a>
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Submit a support ticket
                    </p>
                </div>
                <span class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400" aria-hidden="true">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                    </svg>
                </span>
            </div>
            <div class="relative p-6 bg-white rounded-bl-lg rounded-br-lg sm:rounded-bl-none group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                <div>
                    <span class="inline-flex p-3 text-indigo-700 rounded-lg bg-indigo-50 ring-4 ring-white">
                        <!-- Heroicon name: outline/academic-cap -->
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <div class="mt-6">
                    <h3 class="text-lg font-medium">
                        <a href="/priceList" class="focus:outline-none">
                            <!-- Extend touch target to entire panel -->
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            {{ucwords(trans_choice('messages.price', 2))}}
                        </a>
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Manage your price List
                    </p>
                </div>
                <span class="absolute text-gray-300 pointer-events-none top-6 right-6 group-hover:text-gray-400" aria-hidden="true">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                    </svg>
                </span>
            </div>
        </div>
    </div>
</div>


@endsection
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js">
</script>
