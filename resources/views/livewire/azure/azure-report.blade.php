<div>
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Resources name </h4>
                <div class="page-rightheader ml-auto d-lg-flex d-none">
                    <div class="ml-6 mb-0">
                        <input wire:model="taskduedate" placeholder="Select Date" id="daterange-btn" type="text" class="datetimepicker form-control @error('date') is-invalid @enderror" name="date" >
                            {{-- @dump($taskduedate) --}}
                        {{-- <a class="btn btn-white date-range-btn" name="date" href="#" id="daterange-btn">
                            <svg class="header-icon2 mr-3" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                                <path d="M5 8h14V6H5z" opacity=".3"/><path d="M7 11h2v2H7zm12-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2zm-4 3h2v2h-2zm-4 0h2v2h-2z"/>
                            </svg> <span>Select Date
                                <i class="fa fa-caret-down"></i></span>
                            </a> --}}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <div class="">
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered text-wrap key-buttons">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Resource Group</th>
                                            <th>Total Cost</th>
                                            <th>Quantity</th>
                                            <th>start date</th>
                                            <th>end date</th>
                                        </tr>
                                    </thead>
                                    <body>
                                        @foreach ($reports as $item)
                                        {{-- @dd($item) --}}
                                        <tr>
                                            <td >{{$item->resource_name}}</td>
                                            <td >{{$item->resource_id}}</td>
                                            <td >{{$item->resource_group}}</td>
                                            <td >$@money($item->cost)</td>
                                            <td >{{$item->quantity}}</td>
                                            <td >{{$item->usageStartTime}}</td>
                                            <td >{{$item->usageEndTime}}</td>
                                        </tr>
                                        @endforeach
                                    </body>
                                    {{-- <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Total: {{}}</th>
                                            <th>#</th>
                                            <th>#</th>
                                        </tr>
                                    </tfoot> --}}
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-xl-8 col-md-12 col-lg-12">
            <div class="card">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-lg-12">
                        <div class="card-header">
                            <h4 class="card-title"><i class="fab fa-chart-pie"></i> Top 10 Resouces</h4>
                        </div>
                        <div class="card-body text-center">
                            <div id="myfirstchart" class="BarChartShadow" style="height: 285px;"></div>
                            <div class="row mt-5">
                                <div class="col text-center">
                                    <span class="text-muted float-right"><div class="w-3 h-3 bg-primary br-3 mr-1 mt-1 float-left"></div> Value</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- <div class="col-xl-4 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Top 10 Resouces</h3>
                </div>
                <div class="card-body text-center mx-auto">
                    <div class="overflow-hidden">
                        <canvas class="canvasDoughnut" height="240" width="310"></canvas>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row no-gutters">
                        <div class="col text-center">
                            @php
                            $query = collect($query)
                            @endphp
                            @foreach ($top10q as $key => $item)
                            <span class="text-muted float-left"><div class="w-4 h-3 bg-success br-3 mr-1 mt-1 float-left"></div> {{$item['category']}}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}


    </div>
</div>

