@extends('layouts.master')
@section('css')

@endsection

@section('content')
<!-- Charting library -->
<script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
<!-- Chartisan -->
<script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
@php
$user = Auth::user();
@endphp
<main class="flex flex-1 overflow-hidden bg-white">
    <div class="flex flex-col flex-1 overflow-y-auto xl:overflow-hidden">
        <!-- Breadcrumb -->
        <nav aria-label="Breadcrumb" class="bg-white border-b border-blue-gray-200 xl:hidden">
            <div class="flex items-start max-w-3xl px-4 py-3 mx-auto sm:px-6 lg:px-8">
                <a href="#" class="inline-flex items-center -ml-1 space-x-3 text-sm font-medium text-blue-gray-900">
                    <!-- Heroicon name: solid/chevron-left -->
                    <svg class="w-5 h-5 text-blue-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span>Settings</span>
                </a>
            </div>
        </nav>

        <div class="flex flex-1 xl:overflow-hidden">
            <!-- Sidebar -->
            @livewire('user.sidebar', ['user' => $user], key($user->id))
            <div x-data="{ resellerOpen: false , isOpen: false }" class="relative z-0 flex-col flex-1 overflow-y-auto">
                <div class="p-4 overflow-hidden bg-white">
                    <div class="flex flex-col">
                        <div class="flex flex-col items-center justify-between lg:flex-row">
                            <div class="flex items-center">
                                <h4>{{ ucwords(trans_choice('messages.microsoft_invoices', 2)) }}</h4>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-5 py-5 sm:grid-cols-2">
                            <div class="flex flex-col overflow-hidden bg-white rounded-lg shadow">
                                <div class="flex-grow px-4 py-5 sm:p-6">
                                    <div class="flex items-center ">
                                        <h3 class="text-lg font-semibold text-gray-600 ">Invoices paid to Microsoft Evolution [Year]</h3>
                                    </div>
                                    <canvas id="chartjs-0" class="chartjs" width="undefined" height="undefined"></canvas>
                                    <script>
                                        new Chart(document.getElementById("chartjs-0"), {
                                            "type": "line",
                                            "data": {
                                                "labels": {!!$invoicelabel!!},
                                                "datasets": [{
                                                    "label": "Total paid",
                                                    "data": {!!$invoicedata!!},
                                                    "fill": true,
                                                    "borderColor": "rgb(99, 102, 241, 1)",
                                                    "lineTension": 0.1
                                                }]
                                            },
                                            "options": {}
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center mt-4 card-footer">
                    </div>

                    <div>
                        <div class="relative z-0 flex-col flex-1 overflow-y-auto">
                            <div class="p-4 overflow-hidden bg-white">
                                <div class="flex flex-col">
                                    <div class="flex flex-col items-center justify-between lg:flex-row">
                                        <div class="flex items-center">
                                            <h4>{{ ucwords(trans_choice('messages.microsoft_invoices_table', 2)) }}</h4>
                                        </div>
                                        <div class="flex items-center justify-between">

                                            <div>
                                                <div class="flex justify-center flex-1 lg:justify-end">
                                                    <!-- Search section -->
                                                    <div class="w-full max-w-lg lg:max-w-xs">
                                                        <label for="search" class="sr-only">Search</label>
                                                        <div class="relative text-gray-400 focus-within:text-gray-500">
                                                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                                <!-- Heroicon name: solid/search -->
                                                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                                                </svg>
                                                            </div>
                                                            <input wire:model="search" id="search" class="block w-full bg-white py-1.5 pl-10 pr-3 border border-gray-300 rounded-md leading-5 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-purple-500 focus:border-purple-500 focus:placeholder-gray-500 sm:text-sm" placeholder="Search" type="search" name="search">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <a onclick="confirm('Are you sure you want to export these Records?') || event.stopImmediatePropagation()"wire:click="exportSelected()" href="#" class="px-2 py-2 ml-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden w-5 h-5 lg:inline" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                                                    </svg>
                                                    {{ ucwords(trans_choice('messages.export', 1)) }}
                                                </a>
                                            </div>

                                            <div>
                                                <a  href="{{ route('customer.create') }}" class="px-2 py-2 ml-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="hidden w-5 h-5 lg:inline" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    {{ ucwords(trans_choice('messages.create', 1)) }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <x-table :list="$invoices" :mobileColumns="[
                                    'company_name',
                                    ]"
                                    :columns="[

                                    'invoice_id' => null,
                                    'instance_id' => null,
                                    'totalCharges' => null,
                                    'paidAmount' => null,
                                    'invoiceDate' => null,
                                    ]"
                                    :listElementActions="[
                                    [
                                    'icon' => 'PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGNsYXNzPSJpbmxpbmUgdy01IGgtNSBtci0yIiB2aWV3Qm94PSIwIDAgMjAgMjAiIGZpbGw9ImN1cnJlbnRDb2xvciI+CjxwYXRoIGQ9Ik0xMy41ODYgMy41ODZhMiAyIDAgMTEyLjgyOCAyLjgyOGwtLjc5My43OTMtMi44MjgtMi44MjguNzkzLS43OTN6TTExLjM3OSA1Ljc5M0wzIDE0LjE3MlYxN2gyLjgyOGw4LjM4LTguMzc5LTIuODMtMi44Mjh6IiAvPgo8L3N2Zz4=',
                                    'textKey' => 'Edit', // To get the translation on the view
                                    'url' => function($customer){
                                        return $customer['path'].'/edit';
                                    }
                                    ],
                                    [
                                    'icon' => 'PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGNsYXNzPSJpbmxpbmUgdy01IGgtNSBtci0yIiB2aWV3Qm94PSIwIDAgMjAgMjAiIGZpbGw9ImN1cnJlbnRDb2xvciI+CjxwYXRoIGQ9Ik0xMCAxMmEyIDIgMCAxMDAtNCAyIDIgMCAwMDAgNHoiIC8+CjxwYXRoIGZpbGwtcnVsZT0iZXZlbm9kZCIgZD0iTS40NTggMTBDMS43MzIgNS45NDMgNS41MjIgMyAxMCAzczguMjY4IDIuOTQzIDkuNTQyIDdjLTEuMjc0IDQuMDU3LTUuMDY0IDctOS41NDIgN1MxLjczMiAxNC4wNTcuNDU4IDEwek0xNCAxMGE0IDQgMCAxMS04IDAgNCA0IDAgMDE4IDB6IiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIC8+Cjwvc3ZnPg==',
                                    'textKey' => 'Impersonate',
                                    'url' => function($customer){
                                        return route('impersonate', $customer['mainUser']['id'] ?? '');
                                    }
                                    ]
                                    ]" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection


