<div>
    <div class="row row-deck">
        <div class="col-xl-3 col-md-12 col-lg-12">
            <div class="card">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-lg-12">
                        <div class="card-header">
                            <h4 class="card-title">Top 5 Resource Group cost</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="" class="table mg-b-0 text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Resource Group Name</th>
                                            <th>Total</th>
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
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"> Filter</h3>
                        </div>
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

                            <a wire:click="resetFilters" class="btn btn-danger btn-block">Clear Filter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Resources name </h4>
                    <div class="page-rightheader ml-auto d-lg-flex">
                        <div class="ml-6 mb-0">
                            <div class="input-group custom-search-form">
                                <input
                                wire:model="taskduedate" class="datetimepicker form-control"
                                class="form-control datepicker" placeholder="Report Date" autocomplete="off" id="daterange-btn"
                                data-provide="datepicker" data-date-autoclose="true" data-date-format="yyyy-mm-dd" data-date-today-highlight="true"
                                onchange="this.dispatchEvent(new InputEvent('input'))">
                                <span class="input-group-append">
                                    @if ($taskduedate)
                                    <a wire:click="resetDate"
                                    class="btn btn-light d-flex align-items-center text-muted"
                                    role="button">
                                    <i class="fa fa-times"></i>
                                </a>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <div class="">
                        <div class="table-responsive">
                            <table class="table table-bordered text-wrap key-buttons">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="w-25" wire:click="sortByColumn('resource_name')">
                                            Name
                                            @if ($sortColumn == 'resource_name')
                                            <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                            @else
                                            <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                            @endif
                                        </th>
                                        <th class="w-25" wire:click="sortByColumn('resource_group')">
                                            Resource Group
                                            @if ($sortColumn == 'resource_group')
                                            <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                            @else
                                            <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                            @endif
                                        </th>
                                        <th class="w-25" wire:click="sortByColumn('resource_category')">
                                            Category
                                            @if ($sortColumn == 'resource_category')
                                            <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                            @else
                                            <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                            @endif
                                        </th>
                                        <th class="w-25" wire:click="sortByColumn('resource_subcategory')">
                                            Sub-Category
                                            @if ($sortColumn == 'resource_subcategory')
                                            <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                            @else
                                            <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                            @endif
                                        </th>
                                        <th class="w-25" wire:click="sortByColumn('resource_location')">
                                            Region
                                            @if ($sortColumn == 'resource_location')
                                            <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                            @else
                                            <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                            @endif
                                        </th>
                                        <th class="w-25" wire:click="sortByColumn('quantity')">
                                            Quantity
                                            @if ($sortColumn == 'quantity')
                                            <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                            @else
                                            <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                            @endif
                                        </th>
                                        <th class="w-25" wire:click="sortByColumn('cost')">
                                            Total Cost
                                            @if ($sortColumn == 'cost')
                                            <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                            @else
                                            <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                            @endif
                                        </th>
                                        <th class="w-25" wire:click="sortByColumn('usageStartTime')">
                                            start date
                                            @if ($sortColumn == 'usageStartTime')
                                            <i class="fa fa-fw fa-sort-{{ $sortDirection }}"></i>
                                            @else
                                            <i class="fa fa-fw fa-sort" style="color:#DCDCDC"></i>
                                            @endif
                                        </th>
                                        <th class="w-25" wire:click="sortByColumn('usageEndTime')">
                                            end date
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
                                        <td >{{$item->resource_name}}</td>
                                        <td >{{$item->resource_group}}</td>
                                        <td class="text-nowrap">{{$item->resource_category}}</td>
                                        <td class="text-nowrap">{{$item->resource_subcategory}}</td>
                                        <td class="text-nowrap">{{$item->resource_location}}</td>
                                        <td >{{number_format($item->quantity , 4)}}</td>
                                        <td class="text-nowrap">$@money($item->cost)</td>
                                        <td class="text-nowrap">{{date('Y-m-d', strtotime($item->usageStartTime))}}</td>
                                        <td class="text-nowrap">{{date('Y-m-d', strtotime($item->usageEndTime))}}</td>
                                    </tr>
                                    @endforeach
                                </body>
                            </table>
                            <div class="card-footer d-flex text-right">
                                @if ($reports->total() >= '10')
                                {{ $reports->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


</div>

