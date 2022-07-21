@extends('layouts.master')

@section('content')

@include('layouts.messages')

{{-- <div class="relative px-4 pt-10 pb-10 sm:px-6 lg:pt-24 lg:pb-28 lg:px-8">
    <div class="absolute inset-0">
        <div class="bg-white h-1/3 sm:h-2/3"></div>
    </div>
    <div class="relative mx-auto max-w-7xl">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">From the blog</h2>
        </div>
        <div class="grid max-w-lg gap-5 mx-auto mt-12 lg:grid-cols-3 lg:max-w-none">
            @foreach($news as $key => $new)
            <div class="flex flex-col overflow-hidden rounded-lg shadow-lg">
                <div class="flex-shrink-0">
                    <img class="object-cover w-full h-48" src="$new->image" alt="">
                </div>
                <div class="flex flex-col justify-between flex-1 p-6 bg-white">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-indigo-600">
                            <a href="#" class="hover:underline"> Article </a>
                        </p>
                        <a href="{{route('news.view', $new->id)}}" class="block mt-2">
                            <p class="text-xl font-semibold text-gray-900">{{$new->title}}</p>
                            <p class="mt-3 text-base text-gray-500">
                                {!! \Illuminate\Support\Str::limit(\Michelf\Markdown::defaultTransform($new->description), 130, $end='...') !!}
                            </p>
                        </a>
                    </div>
                    <div class="flex items-center mt-6">
                        <div class="flex-shrink-0">
                            <a href="#">
                                <span class="sr-only">Roel Aufderehar</span>
                                <img class="w-10 h-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            </a>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">
                                <a href="#" class="hover:underline"> Roel Aufderehar </a>
                            </p>
                            <div class="flex space-x-1 text-sm text-gray-500">
                                <time datetime="2020-03-16"> Mar 16, 2020 </time>
                                <span aria-hidden="true"> &middot; </span>
                                <span> 6 min read </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div> --}}

{{-- <div class="grid grid-cols-1 gap-6 mx-auto mt-8 sm:px-6 lg:grid-flow-col-dense lg:grid-cols-2"> --}}
    <!-- This example requires Tailwind CSS v2.0+ -->



    <!-- Announcements -->
    {{-- <section aria-labelledby="announcements-title" class="lg:col-start-3 lg:col-span-1">
        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="p-6">
                <h2 class="text-base font-medium text-gray-900" id="announcements-title">Announcements</h2>
                <div class="flow-root mt-3">
                    <ul class="-my-5 divide-y divide-gray-200">
                        @foreach($news as $key => $new)
                        <li class="py-3">
                            <div class="relative focus-within:ring-2 focus-within:ring-indigo-500">
                                <h3 class="text-sm font-semibold text-gray-800">
                                    <a href="{{route('news.view', $new->id)}}" class="hover:underline focus:outline-none">
                                        <!-- Extend touch target to entire panel -->
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        {{$new->title}}
                                    </a>
                                </h3>
                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                    {!! \Illuminate\Support\Str::limit(\Michelf\Markdown::defaultTransform($new->description), 130, $end='...') !!}
                                </p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="mt-4">
                    <a href="{{route('news.list')}}" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                        {{ucwords(trans_choice('messages.view_all', 2))}}
                    </a>
                </div>
            </div>
        </div>
    </section> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- grid grid-cols-1 gap-6 mx-auto mt-8 sm:px-6 lg:grid-flow-col-dense lg:grid-cols-3 --}}
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
                    <div class="ml-auto text-gray-500">Last 30 days</div>
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
                    name: "orders",
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
                    name: "Aktywacje",
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
                    name: "Aktywacje",
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
        {{-- <dl class="grid grid-cols-1 gap-5 mt-5 sm:grid-cols-2 @if(Auth::user()->userLevel->name == "Super Admin") lg:grid-cols-5 @endif ?? lg:grid-cols-4 "> --}}
            {{-- <div class="flex flex-col overflow-hidden bg-white rounded-lg shadow">
                <div class="flex-grow px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 bg-indigo-500 rounded-md">
                            <!-- Heroicon name: outline/users -->
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <div class="flex-1 w-0 ml-5">
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                {{ucwords(trans_choice('messages.order', 2))}}
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    @if($orders)
                                    {{$orders->count()}}
                                    @else
                                    0
                                    @endif
                                </div>
                            </dd>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-4 bg-gray-50 sm:px-6">
                    <div class="text-sm">
                        <a href="/order" class="font-medium text-indigo-600 hover:text-indigo-500"> View all<span class="sr-only"> Total Subscribers stats</span></a>
                    </div>
                </div>
            </div> --}}

            {{-- @if(Auth::user()->userLevel->name == "Super Admin")
            <div class="flex flex-col overflow-hidden bg-white rounded-lg shadow">
                <div class="flex-grow px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 bg-indigo-500 rounded-md">
                            <!-- Heroicon name: outline/mail-open -->
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="flex-1 w-0 ml-5">
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                {{ucwords(trans_choice('messages.provider', 2))}}
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    {{$providers->count()}}
                                </div>
                            </dd>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-4 bg-gray-50 sm:px-6">
                    <div class="text-sm">
                        <a href=" {{route('provider.index')}} " class="font-medium text-indigo-600 hover:text-indigo-500"> View all<span class="sr-only"> Avg. Open Rate stats</span></a>
                    </div>
                </div>
            </div>
            @endif
            <div class="flex flex-col overflow-hidden bg-white rounded-lg shadow">
                <div class="flex-grow px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 bg-indigo-500 rounded-md">
                            <!-- Heroicon name: outline/mail-open -->
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="flex-1 w-0 ml-5">
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                {{ucwords(trans_choice('messages.reseller', 2))}}
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    {{$resellers->count()}}
                                </div>
                            </dd>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-4 bg-gray-50 sm:px-6">
                    <div class="text-sm">
                        <a href=" {{route('reseller.index')}} " class="font-medium text-indigo-600 hover:text-indigo-500"> View all<span class="sr-only"> Avg. Open Rate stats</span></a>
                    </div>
                </div>
            </div>

            <div class="flex flex-col overflow-hidden bg-white rounded-lg shadow">
                <div class="flex-grow px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 bg-indigo-500 rounded-md">
                            <!-- Heroicon name: outline/mail-open -->
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1 w-0 ml-5">
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                {{ucwords(trans_choice('messages.customer', 2))}}
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    {{$customers->count()}}
                                </div>
                            </dd>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-4 bg-gray-50 sm:px-6">
                    <div class="text-sm">
                        <a href="/customer" class="font-medium text-indigo-600 hover:text-indigo-500"> View all<span class="sr-only"> Avg. Open Rate stats</span></a>
                    </div>
                </div>
            </div>

            <div class="flex flex-col overflow-hidden bg-white rounded-lg shadow">
                <div class="flex-grow px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 bg-indigo-500 rounded-md">
                            <!-- Heroicon name: outline/cursor-click -->
                            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="flex-1 w-0 ml-5">
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                {{ucwords(trans_choice('messages.subscription', 2))}}
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    {{$subscriptions->count()}}
                                </div>
                            </dd>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-4 bg-gray-50 sm:px-6">
                    <div class="text-sm">
                        <a href="/subscription" class="font-medium text-indigo-600 hover:text-indigo-500"> View all<span class="sr-only"> Avg. Click Rate stats</span></a>
                    </div>
                </div>
            </div>
        </dl> --}}
        {{-- <dl class="grid grid-cols-1 gap-5 mt-5 sm:grid-cols-2 lg:grid-cols-3 ">
            <div class="flex flex-col overflow-hidden bg-white rounded-lg shadow">
                <x-graph legendName="Total paid" headerTitle="Invoices Evolution" :labels="$invoicelabel" :data="$invoicedata" />
            </div>
            <div class="flex flex-col overflow-hidden bg-white rounded-lg shadow">
                <div class="flex-grow px-4 sm:p-6">
                    <x-graph legendName="Orders" headerTitle="Orders Evolution [Year]" :labels="$orderlabel" :data="$orderdata" />
                </div>
            </div>
            <div class="flex flex-col overflow-hidden bg-white rounded-lg shadow">
                <div class="flex-grow px-4 sm:p-6">
                    <x-graph legendName="Customers" headerTitle="Customers Evolution [Year]" :labels="$customerlabel" :data="$customerdata" />
                </div>
            </div>
        </dl> --}}
        <div class="mb-4 overflow-hidden bg-gray-200 rounded-lg shadow sm:grid sm:grid-cols-2 sm:gap-px">
            <div class="relative p-6 bg-white group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                        <div class="p-4">
                            <div class="flex items-center">
                                <div class="text-xs font-medium text-gray-500 uppercase">Evolution licenses last year</div>
                                {{-- <div class="ml-auto text-gray-500">{{ucwords(trans_choice('messages.last_30Days', 2))}}</div> --}}
                            </div>
                            {{-- <div class="flex items-center">
                                <div class="text-2xl font-semibold">${{array_sum($ChartRevenew)}}</div>
                            </div> --}}
                        </div>
                        <div id="chart"></div>
                    </div>
                    <div class="relative p-6 bg-white group focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                        <div class="p-4">
                            <div class="flex items-center">
                                <div class="text-xs font-medium text-gray-500 uppercase">Top 5 products by licenses count</div>
                                {{-- <div class="ml-auto text-gray-500">{{ucwords(trans_choice('messages.last_30Days', 2))}}</div> --}}
                            </div>
                            {{-- <div class="flex items-center">
                                <div class="text-2xl font-semibold">${{array_sum($ChartRevenew)}}</div>
                            </div> --}}
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
                            name: "Licenses",
                            data: {!! json_encode(array_values($chartDataSubscriptionYear))!!},
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
