@php
$percentage =($subscription->customer->markup/100)*$subscription->azureresources->sum('cost');
$markup = $percentage+$subscription->azureresources->sum('cost');
@endphp

<div class="row row-deck">
    <div class="col-xl-3 col-md-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ ucwords(trans_choice('messages.budget_grow', 1)) }}</h3>
                <div class="ml-20">
                    <button type="button" class="inline-flex items-center px-4 py-2 ml-30 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ ucwords(trans_choice('messages.change_budget', 1)) }}
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="text-center row">
                    <div class="mb-4 col-md-12 mt-sm-0">
                        <div class="mx-auto mb-0 chart-circle chart-circle-primary chart-circle-lg mt-sm-0 donutShadow" data-value="{{$average/100}}" data-thickness="15" data-color="#4454c3">
                            <div class="mx-auto mb-2 text-center chart-circle-value"><h1 class="mt-2 mb-0">{{$average}}%</h1><small>{{ ucwords(trans_choice('messages.goal', 1)) }}</small></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h2 class="mt-3 mb-0 fs-50 counter font-weight-bold">${{$budget}}</h2>
                        <small class="mt-1 fs-12 text-muted">{{ ucwords(trans_choice('messages.updated', 1)) }} {{$date->azure_updated_at ?? ' '}}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-12 col-lg-6">
        <div class="card">
            <div class="mb-4 card-header">
                <h3 class="card-title">{{ ucwords(trans_choice('messages.current_estimated_usage', 1)) }}</h3>
            </div>
            <div class="p-2">
                <h5 class="pl-4 mb-4 font-weight-bold">{{ ucwords(trans_choice('messages.current_estimated_usage', 1)) }}</h5>
                <table class="table card-table text-nowrap">
                    <tbody>
                        <tr>
                            <td>{{ ucwords(trans_choice('messages.usage', 1)) }}</td>
                            <td class="w-3 text-right"><span class="">{{$subscription->customer->country->currency_symbol}}@money($markup)
                            </span></td>
                        </tr>
                        <tr>
                            <td>{{ ucwords(trans_choice('messages.budget', 1)) }}</td>
                            <td class="w-3 text-right"><span class="">{{$subscription->customer->country->currency_symbol}}{{$budget}}</span></td>
                        </tr>
                        <tr>
                            <td>{{ ucwords(trans_choice('messages.percentage', 1)) }}</td>
                            <td class="w-3 text-right"><span class="">{{$average}}%</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <i class="fas fa-chart-pie"></i>
            <div class="card-footer">
                <a href="{{route('analytics.reports',$subscription)}}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 block text-center bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">  Reports</a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-12 col-lg-12">
        <div class="card">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-lg-12">
                    <div class="card-header">
                        <h4 class="card-title">{{ ucwords(trans_choice('messages.top_service_by_costs', 1)) }}</h4>
                    </div>
                    <div class="text-center card-body">
                        <div class="table-responsive">
                            <table id="" class="table mg-b-0 text-nowrap">
                                <thead>
                                    <tr>
                                        <th>{{ ucwords(trans_choice('messages.name', 1)) }}</th>
                                        <th>{{ ucwords(trans_choice('messages.category', 1)) }}</th>
                                        <th>{{ ucwords(trans_choice('messages.total', 1)) }}</th>
                                    </tr>
                                </thead>
                                <body>
                                    @foreach ($resourcet5Name as $item)
                                    @php
                                    $percentage =($subscription->customer->markup/100)*$item->sum;
                                    $markup = $percentage+$item->sum;
                                    @endphp
                                    <tr>
                                        <td >{{$item->name}}</td>
                                        <td >{{$item->category}}</td>
                                        <td >{{$subscription->customer->country->currency_symbol}}@money($markup)</td>
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
    <div class="col-xl-8 col-md-12 col-lg-12">
        <div class="card">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-lg-12">
                    <div class="card-header">
                        <h4 class="card-title"><i class="fab fa-chart-pie"></i> {{ ucwords(trans_choice('messages.top_10_resources', 1)) }}</h4>
                    </div>
                    <div class="text-center card-body">
                        <div id="myfirstchart" class="BarChartShadow" style="height: 285px;"></div>
                        <div class="mt-5 row">
                            <div class="text-center col">
                                <span class="float-right text-muted"><div class="float-left w-3 h-3 mt-1 mr-1 bg-primary br-3"></div> {{ ucwords(trans_choice('messages.value', 1)) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ ucwords(trans_choice('messages.top_10_resources', 1)) }}</h3>
            </div>
            <div class="mx-auto text-center card-body">
                <div class="overflow-hidden">
                    <canvas class="canvasDoughnut" height="240" width="310"></canvas>
                </div>
            </div>
            <div class="card-body">
            </div>
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ ucwords(trans_choice('messages.resource_names', 1)) }}</h4>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <div class="">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered text-wrap key-buttons">
                                <thead class="thead-dark">
                                    <tr>
                                        <th >{{ ucwords(trans_choice('messages.name', 1)) }}</th>
                                        <th>{{ ucwords(trans_choice('messages.category', 1)) }}</th>
                                        <th>{{ ucwords(trans_choice('messages.sub_category', 1)) }}</th>
                                        <th>{{ ucwords(trans_choice('messages.total', 1)) }}</th>
                                    </tr>
                                </thead>
                                <body>
                                    @foreach ($resourceName as $item)
                                    @php
                                    $percentage =($subscription->customer->markup/100)*$item->sum;
                                    $markup = $percentage+$item->sum;
                                    @endphp
                                    <tr>
                                        <td >{{$item->name}}</td>
                                        <td >{{$item->category}}</td>
                                        <td >{{$item->subcategory}}</td>
                                        <td >{{$subscription->customer->country->currency_symbol}}@money($markup)</td>
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
