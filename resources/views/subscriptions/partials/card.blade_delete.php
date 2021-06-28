<div class="col-md-12 col-lg-12 col-xl-12 ">
    <div class="row">
        @foreach ($subscriptions as $item)
        <div class="col-xl-4 col-lg-6">
            <div class="card">
                <div class="p-0 card-body">
                    <div class="p-4 pb-2 todo-widget-header d-flex">
                        <h6 class="pro-user-desc text-muted"><span class="mt-2 badge badge-success">{{ ucwords(trans_choice( $item->status->name, 1)) }}</span></h6>
                        <div class="ml-auto">
                        </div>
                    </div>
                    <div class="px-4 pb-4">
                        <a class="p-0 text-muted" data-toggle="dropdown">
                            <div class="font-weight-bold d-flex">
                                <div class="mr-4 media-icon bg-success-transparent text-success">
                                    <i class="fa fa-suitcase"></i>
                                </div>
                                <div class="mt-1">
                                    <small>{{ ucwords(trans_choice('messages.subscription_name', 1)) }}</small>
                                    <h6 class="mb-0 font-weight-semibold">{{$item->name}}</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card-body border-top">
                        <div class="main-profile-contact-list d-lg-flex">
                            <div class="mr-5 media">
                                <div class="mr-4 media-icon bg-danger-transparent text-danger">
                                    <i class="fa fa-home"></i>
                                </div>
                                <div class="media-body">
                                    <small class="text-muted">{{ ucwords(trans_choice('messages.tenant_name', 1)) }}</small>
                                    <h6 class="mt-2 mb-0 fs-13">{{$item->tenant_name}}</h6>
                                </div>
                            </div>
                            <div class="mr-5 media">
                                <div class="mr-4 media-icon bg-danger-transparent text-danger">
                                    <i class="fa fa-cloud-upload"></i>
                                </div>
                                <div class="media-body">
                                    <small class="text-muted">{{ ucwords(trans_choice('messages.licenses', 1)) }}</small>
                                    <h6 class="mt-2 mb-0 fs-13">{{$item->amount}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 border-top">
                        <small class="text-muted">{{ ucwords(trans_choice('messages.billing_cycle', 1)) }}</small>
                        <h6 class="mt-2 mb-0 fs-13">{{ucfirst($item->billing_period)}}</h6>
                    </div>
                </div>
                <div class="card-footer">
                    @can(config('app.subscription_edit'))
                    <a class="float-right ml-auto btn btn-primary btn-sm px-xl-5" href="{{route('subscription.show', [$item['id']])}}" >{{ ucwords(trans_choice('messages.edit', 1)) }}</a>
                    @endcan
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
