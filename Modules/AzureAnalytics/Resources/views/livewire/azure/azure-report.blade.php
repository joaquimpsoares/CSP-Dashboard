@section('css')
<link href="{{URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />

<style>
    .rotate-45 {
        --transform-rotate: 45deg;
        transform: rotate(45deg);
    }

    .group:hover .group-hover\:flex {
        display: flex;
    }
</style>
@endsection
<div>
    <div x-data="{ resellerOpen: false , isOpen: false }" class="relative z-0 flex-col flex-1 overflow-y-auto">
        <div class="p-4 overflow-hidden bg-white">
            <div class="flex flex-col">
                <div class="flex flex-col items-center justify-between lg:flex-row">
                    <div class="flex items-center">
                        <h4>Analytics Dashboard - {{$subscription->customer->company_name}}</h4>
                    </div>
                </div>
            </div>
            <!-- Component start  -->

            <div class="relative flex items-center group">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                </svg>
                <div class="absolute left-0 flex items-center hidden ml-6 rounded group-hover:flex">
                    <div class="w-3 h-3 -mr-2 rotate-45 bg-black"></div>
                    <span class="relative z-10 p-2 text-xs leading-none text-white whitespace-no-wrap bg-black rounded shadow-lg">
                        <p class="-mt-1 text-white font-small">
                            This Azure report provides access to utilization records for a time period that represents when the utilization was reported in the billing system. It provides access to the same utilization data that is used to create and calculate the reconciliation file.
                        </p>
                        <p class="-mt-1 text-white font-small">
                            However, it does not have knowledge of billing system reconciliation file logic. You should not expect reconciliation file summary results to match the result retrieved from this API exactly for the same time period.
                        </p>

                        <p class="-mt-1 text-white font-small">
                            For example, the billing system takes the same utilization data and applies lateness rules to determine what is accounted for in a reconciliation file. When a billing period closes, all usage until the end of the day that the billing period ends is included in the reconciliation file.
                        </p>
                        <p class="-mt-1 text-white font-small">
                            Any late usage within the billing period that is reported within 24 hours after the billing period ends is accounted for in the next reconciliation file.
                        </p>

                    </span>

                </div>
            </div>
            <!-- Component End  -->

        </div>
    </div>

    <hr class="py-10">

    <div class="relative z-0 flex-col flex-1 overflow-y-auto">
        <div class="p-4 overflow-hidden bg-white">
            <div class="flex flex-col">
                <div class="flex flex-col items-center justify-between lg:flex-row">
                    <div class="flex items-center">
                        <h4>{{ ucwords(trans_choice('messages.analytics', 2)) }}</h4>
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
                            <div class="relative ml-10">
                                <input type="text" wire:model="taskduedate"  class="w-full pl-4 pr-10 font-medium leading-none text-gray-600 rounded-lg shadow-sm py-auto focus:outline-none focus:ring focus:ring-blue-600 focus:ring-opacity-50" placeholder="Select date"
                                autocomplete="off" id="daterange-btn"
                                data-provide="datepicker" data-date-autoclose="true" data-date-format="yyyy-mm-dd" data-date-today-highlight="true"
                                onchange="this.dispatchEvent(new InputEvent('input'))"/>
                                <div class="absolute top-0 right-0 px-3 py-2">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <x-tableazure>
                    <x-slot name="head">
                        <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('name')" :direction="$sorts['name'] ?? null">{{ ucwords(trans_choice('messages.name', 2)) }}</x-table.heading>
                        {{-- <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('resource_group')"  :direction="$sorts['resource_group'] ?? null">{{ ucwords(trans_choice('messages.resource_group', 1)) }}</x-table.heading> --}}
                        <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('resource_region')"         :direction="$sorts['resource_region'] ?? null">{{ ucwords(trans_choice('messages.region', 1)) }}</x-table.heading>
                        <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('cost')"       :direction="$sorts['cost'] ?? null">{{ ucwords(trans_choice('messages.total_cost', 1)) }}</x-table.heading>
                        <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('usageStartTime')"       :direction="$sorts['usageStartTime'] ?? null">{{ ucwords(trans_choice('messages.start_date', 2)) }}</x-table.heading>
                        <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('usageEndTime')"       :direction="$sorts['usageEndTime'] ?? null">{{ ucwords(trans_choice('messages.end_date', 2)) }}</x-table.heading>
                        <x-table.heading sortable multi-column visibility='hidden' tablecell='lg:table-cell' wire:click="sortBy('usagedate')"       :direction="$sorts['usagedate'] ?? null">{{ ucwords(trans_choice('messages.usage_date', 2)) }}</x-table.heading>
                    </x-slot>
                    <x-slot name="body">
                        @forelse ($reports as $item)
                        <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $item['id'] }}">
                            <x-table.cell visibility='hidden' tablecell='lg:table-cell'>
                                <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                        {{$item->resource_name}}
                                    </span>
                                </div>
                            </x-table.cell>

                            {{-- <x-table.cell>
                                <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                        {{$item->resource_group}}
                                    </span>
                                </span>
                            </x-table.cell> --}}
                            <x-table.cell>
                                <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                        {{$item->resource_region}}
                                    </span>
                                </div>
                            </x-table.cell>
                            <x-table.cell>
                                <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                        $@money($item->cost)
                                    </span>
                                </div>
                            </x-table.cell>

                            <x-table.cell>
                                <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                        {{date('Y-m-d', strtotime($item->usageStartTime))}}
                                    </span>
                                </div>
                            </x-table.cell>

                            <x-table.cell>
                                <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                        {{date('Y-m-d', strtotime($item->usageEndTime))}}
                                    </span>
                                </div>
                            </x-table.cell>
                            <x-table.cell>
                                <div class="h-full py-2 pl-1 pr-2 m-0 overflow-auto">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium leading-4 capitalize">
                                        {{date('Y-m-d', strtotime($item->usagedate))}}
                                    </span>
                                </div>
                            </x-table.cell>

                        </x-table.row>
                        @empty
                        <x-table.row>
                            <x-table.cell colspan="9">
                                <div class="flex items-center justify-center space-x-2">
                                    <x-icon.inbox class="w-8 h-8 text-cool-gray-400" />
                                    <span class="py-8 text-xl font-medium text-cool-gray-400">No Reports found...</span>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                        @endforelse
                    </x-slot>
                </x-tableazure>
                <div>
                    {{ $reports->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')

<!--Moment js-->
<script src="{{URL::asset('assets/plugins/moment/moment.js')}}"></script>
<!-- Daterangepicker js-->
<script src="{{URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{URL::asset('assets/js/daterange.js')}}"></script>
<!-- ECharts js -->
<script src="{{URL::asset('assets/plugins/echarts/echarts.js')}}"></script>
<!-- Chartjs js -->
<script src="{{URL::asset('assets/plugins/chart/chart.bundle.js')}}"></script>
<script src="{{URL::asset('assets/plugins/chart/utils.js')}}"></script>
<!--Morris Charts js-->
<script src="{{URL::asset('assets/plugins/morris/raphael-min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/morris/morris.js')}}"></script>
<!-- Index js-->
<script src="{{URL::asset('assets/js/index3.js')}}"></script>
<!-- Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/js/datatables.js')}}"></script>
<!-- Select2 js -->
{{-- <script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script> --}}
@endsection
