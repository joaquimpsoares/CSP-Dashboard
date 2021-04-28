<div>

    <div class="grid grid-cols-1 gap-6 mx-auto mt-8 sm:px-6 lg:grid-flow-col-dense lg:grid-cols-3">
        <div class="space-y-6 lg:col-start-1 lg:col-span-2">
            <!-- Description list-->
            <section aria-labelledby="applicant-information-title">
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h2 id="applicant-information-title" class="text-lg font-medium leading-6 text-gray-900">
                            {{ ucwords(trans_choice('messages.top5_resource_group_cost', 1)) }}
                        </h2>
                    </div>

                    <div class="px-4 py-5 border-t border-gray-200 sm:px-6">
                        <div class="table-responsive">
                            <table id="" class="table mg-b-0 text-nowrap">
                                <thead>
                                    <tr>
                                        <th>{{ ucwords(trans_choice('messages.resource_group_name', 1)) }}</th>
                                        <th>{{ ucwords(trans_choice('messages.total', 1)) }}</th>
                                    </tr>
                                </thead>
                                <body>
                                    @foreach ($top5Q as $item)
                                    <tr>
                                        <td >{{$item['resource_group']}}</td>
                                        <td> $@money($item['sum'])</td>
                                    </tr>
                                    @endforeach
                                </body>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Comments-->
            <section aria-labelledby="notes-title">
                <!-- This example requires Tailwind CSS v2.0+ -->
                <div class="px-4 py-5 bg-white border-b border-gray-200 sm:px-6">
                    <div class="flex flex-wrap items-center justify-between -mt-4 -ml-4 sm:flex-nowrap">
                        <div class="mt-4 ml-4">
                            <div class="flex items-center">
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                                        {{ ucwords(trans_choice('messages.report', 1)) }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-shrink-0 mt-4 mb-10 ">
                            <button onclick="confirm('Are you sure you want to export these Records?') || event.stopImmediatePropagation()"wire:click="exportSelected()" type="button" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <!-- Heroicon name: solid/phone -->
                                <svg class="w-5 h-5 mr-2 -ml-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                <span>
                                    {{ ucwords(trans_choice('messages.export_to_xlsx', 1)) }}
                                </span>
                            </button>
                            <div class="relative ml-10">
                                <input type="text" wire:model="taskduedate"  class="w-full pl-4 pr-10 py-auto leading-none rounded-lg shadow-sm focus:outline-none text-gray-600 font-medium focus:ring focus:ring-blue-600 focus:ring-opacity-50" placeholder="Select date"
                                autocomplete="off" id="daterange-btn"
                                data-provide="datepicker" data-date-autoclose="true" data-date-format="yyyy-mm-dd" data-date-today-highlight="true"
                                onchange="this.dispatchEvent(new InputEvent('input'))"/>
                                <div class="absolute top-0 right-0 px-3 py-2">
                                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white shadow sm:rounded-lg sm:overflow-hidden">
                        <div class="divide-y divide-gray-200">
                            <div class="px-4 py-6 sm:px-6">
                                <table class="relative w-full whitespace-no-wrap bg-white border-collapse table-auto table-striped">
                                    <thead class="bg-gray-50">
                                        <tr class="text-left">
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase" wire:click="sortByColumn('resource_name')">
                                                {{ ucwords(trans_choice('messages.name', 1)) }}
                                                @if ($sortColumn == 'resource_name')
                                                <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                                @else
                                                <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                                @endif
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase" wire:click="sortByColumn('resource_group')">
                                                {{ ucwords(trans_choice('messages.resource_group', 1)) }}
                                                @if ($sortColumn == 'resource_group')
                                                <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                                @else
                                                <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                                @endif
                                            </th>
                                            {{-- <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase" wire:click="sortByColumn('resource_category')">
                                                Category
                                                @if ($sortColumn == 'resource_category')
                                                <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                                @else
                                                <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                                @endif
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase" wire:click="sortByColumn('resource_subcategory')">
                                                Sub-Category
                                                @if ($sortColumn == 'resource_subcategory')
                                                <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                                @else
                                                <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                                @endif
                                            </th> --}}
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase" wire:click="sortByColumn('resource_location')">
                                                {{ ucwords(trans_choice('messages.region', 1)) }}
                                                @if ($sortColumn == 'resource_location')
                                                <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                                @else
                                                <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                                @endif
                                            </th>
                                            {{-- <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase" wire:click="sortByColumn('name')">
                                                Name
                                                @if ($sortColumn == 'name')
                                                <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                                @else
                                                <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                                @endif
                                            </th>
                                            {{-- <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase" wire:click="sortByColumn('quantity')">
                                                Quantity
                                                @if ($sortColumn == 'quantity')
                                                <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                                @else
                                                <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                                @endif
                                            </th> --}}
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase" wire:click="sortByColumn('cost')">
                                                {{ ucwords(trans_choice('messages.total_cost', 1)) }}
                                                @if ($sortColumn == 'cost')
                                                <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                                @else
                                                <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                                @endif
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase" wire:click="sortByColumn('usageStartTime')">
                                                {{ ucwords(trans_choice('messages.start_date', 1)) }}
                                                @if ($sortColumn == 'usageStartTime')
                                                <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                                @else
                                                <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                                @endif
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase" wire:click="sortByColumn('usageEndTime')">
                                                {{ ucwords(trans_choice('messages.end_date', 1)) }}
                                                @if ($sortColumn == 'usageEndTime')
                                                <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                                @else
                                                <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                                @endif
                                            </th>
                                        </tr>
                                    </thead>
                                    <body>
                                        @foreach ($reports as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-wrap">{{$item->resource_name}}</td>
                                            <td class="px-6 py-4 whitespace-wrap">{{$item->resource_group}}</td>
                                            {{-- <td class="px-6 py-4 whitespace-nowrap">{{$item->resource_category}}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{$item->resource_subcategory}}</td> --}}
                                            <td class="px-6 py-4 whitespace-nowrap">{{$item->resource_location}}</td>
                                            {{--<td class="px-6 py-4 whitespace-nowrap">{{$item->name}}</td> --}}
                                            {{-- <td class="px-6 py-4 whitespace-nowrap">{{number_format($item->quantity , 4)}}</td> --}}
                                            <td class="px-6 py-4 whitespace-nowrap">$@money($item->cost)</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{date('Y-m-d', strtotime($item->usageStartTime))}}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{date('Y-m-d', strtotime($item->usageEndTime))}}</td>
                                        </tr>
                                        @endforeach
                                    </body>
                                </table>
                                <div class="text-right card-footer d-flex">
                                    @if ($reports->total() >= '10')
                                    {!! $reports->render() !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section aria-labelledby="timeline-title" class="lg:col-start-3 lg:col-span-1">
            <div class="px-4 py-5 bg-white shadow sm:rounded-lg sm:px-6">
                <h2 id="timeline-title" class="text-lg font-medium text-gray-900">{{ ucwords(trans_choice('messages.filter', 1)) }}</h2>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Resource Groups</label>
                        <select  wire:model="selectRgroup" name="beast" id="select-beast" class="form-control custom-select select2">
                            <option value="0">--Select--</option>
                            @foreach ($resourceGroups as $key => $item)
                            <option>{{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                    @if($selectRgroup)
                    <div class="form-group">
                        <label class="form-label">Categories</label>
                        <select wire:model="selectCategory" name="beast" id="select-beast1" class="form-control custom-select select2">
                            <option value="0">--Select--</option>
                            @foreach ($categories as $item)
                            <option>{{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    @if($selectCategory)
                    <div class="form-group">
                        <label class="form-label">Sub Categories</label>
                        <select wire:model="selectSubCategory" name="beast" id="select-beast2" class="form-control custom-select select2">
                            <option value="0">--Select--</option>
                            @foreach ($subcategories as $key => $item)
                            <option>{{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    @if($selectSubCategory)
                    <div class="form-group">
                        <label class="form-label">Region</label>
                        <select wire:model="selectRegion" name="beast" id="select-beast3" class="form-control custom-select select2">
                            <option value="0">--Select--</option>
                            @foreach ($region as $key => $item)
                            <option>{{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <a wire:click="resetFilters" class="inline-flex items-center px-2.5 py-2 block border text-center border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Clear Filter</a>
                </div>
            </div>
        </section>
    </div>
</main>
</div>



