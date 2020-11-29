

<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mb-2 fs-18 text-muted">
                            Resellers
                        </div>
                        <h1 class="font-weight-bold mb-1">{{$provider['resellers']->count()}}</h1>
                        <span class="text-primary"><i class="fa fa-arrow-up mr-1"></i> +1.4%</span>
                    </div>
                    <div class="col col-auto">
                        <div class="mx-auto chart-circle chart-circle-md chart-circle-primary mt-sm-0 mb-0" data-value="0.85" data-thickness="12" data-color="#4454c3">
                            <div class="mx-auto chart-circle-value text-center fs-20">85%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mb-2 fs-18 text-muted">
                            Customers
                        </div>
                        <h1 class="font-weight-bold mb-1">{{$countCustomers}}</h1>
                        <span class="text-success"><i class="fa fa-arrow-up mr-1"></i> +1.8%</span>
                    </div>
                    <div class="col col-auto">
                        <div class="mx-auto chart-circle chart-circle-md chart-circle-success mt-sm-0 mb-0" data-value="0.60" data-thickness="12" data-color="#2dce89">
                            <div class="mx-auto chart-circle-value text-center fs-20">60%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="mb-2 fs-18 text-muted">
                            Subscriptions
                        </div>
                        <h1 class="font-weight-bold mb-1">{{$countSubscriptions}}</h1>
                        <span class="text-danger"><i class="fa fa-arrow-down mr-1"></i> -2.4%</span>
                    </div>
                    <div class="col col-auto">
                        <div class="mx-auto chart-circle chart-circle-md chart-circle-secondary mt-sm-0 mb-0" data-value="0.45" data-thickness="12" data-color="#f7346b">
                            <div class="mx-auto chart-circle-value text-center fs-20">25%</div>
                        </div>
                    </div>
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
    <!-- ECharts js-->
    <script src="{{URL::asset('assets/plugins/echarts/echarts.js')}}"></script>
    <!--Chart js -->
    <script src="{{URL::asset('assets/plugins/chart/chart.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/chart/chart.extension.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/chartjs/chart.js')}}"></script>
    <!-- Index js-->
    <script src="{{URL::asset('assets/js/index4.js')}}"></script>
    @endsection
