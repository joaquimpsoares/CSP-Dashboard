{{-- <div class="row"> --}}
    <div class="col-md-12 col-lg-12 col-xl-12   ">
        <div class="row">
            @foreach ($subscriptions as $item)
            <!-- col -->
            <div class="col-xl-4 col-lg-6">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="todo-widget-header d-flex pb-2 p-4">
                            <h6 class="pro-user-desc text-muted"><span class="badge badge-success mt-2">{{ ucwords(trans_choice( $item->status->name, 1)) }}</span></h6>
                            <div class="ml-auto">
                                {{-- <div class="">
                                    <a class="option-dots new-list" data-toggle="dropdown"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg></a>
                                    <div class="dropdown-menu tx-13 dropdown-menu-right">
                                        <a class="dropdown-item" href="#">Disable</a>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="px-4 pb-4">
                            <a class="p-0 text-muted" data-toggle="dropdown">
                                <div class="font-weight-bold d-flex">
                                    <div class="media-icon bg-success-transparent text-success mr-4">
                                    <i class="fa fa-suitcase"></i>
                                    </div>
                                    {{-- <img  class="avatat avatar-md brround mr-2" src="https://img.pngio.com/microsoft-corporate-logo-guidelines-trademarks-microsoft-logo-png-2008_900.jpg" alt="img"> --}}
                                    <div class="mt-1">
                                        <small>{{ ucwords(trans_choice('messages.subscription_name', 1)) }}</small>
                                        <h6 class="font-weight-semibold mb-0">{{$item->name}}</h6>
                                    </div>
                                </div>
                            </a>
                            {{-- <div class="dropdown-menu tx-13">
                                <a class="dropdown-item" href="#">View Total Tasks</a>
                                <a class="dropdown-item" href="#">Completed Tasks</a>
                                <a class="dropdown-item" href="#">Delete Tasks</a>
                                <a class="dropdown-item" href="#">Settings</a>
                            </div> --}}
                        </div>
                        <div class="card-body border-top">
                            <div class="main-profile-contact-list d-lg-flex">
                                <div class="media mr-5">
                                    <div class="media-icon bg-danger-transparent text-danger mr-4">
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <div class="media-body">
                                        <small class="text-muted">{{ ucwords(trans_choice('messages.tenant_name', 1)) }}</small>
                                        <h6 class="mb-0  mt-2 fs-13">{{$item->tenant_name}}</h6>
                                    </div>

                                </div>
                                <div class="media mr-5">
                                    <div class="media-icon bg-danger-transparent text-danger mr-4">
                                        <i class="fa fa-cloud-upload"></i>
                                    </div>
                                    <div class="media-body">
                                        <small class="text-muted">{{ ucwords(trans_choice('messages.licenses', 1)) }}</small>
                                        <h6 class="mb-0  mt-2 fs-13">{{$item->amount}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 border-top">
                            <small class="text-muted">{{ ucwords(trans_choice('messages.billing_cycle', 1)) }}</small>
                            <h6 class="mb-0  mt-2 fs-13">{{ucfirst($item->billing_period)}}</h6>
                        </div>
                    </div>
                    <div class="card-footer">

                        {{-- <a class="btn btn-primary btn-sm px-xl-5" href="#" title="Assign Task">Edit</a> --}}
                        <a class="btn btn-primary ml-auto float-right btn-sm px-xl-5" href="{{route('subscription.show', [$item['id']])}}" data-placement="top" data-toggle="tooltip" title="" data-original-title="View Task">Edit</a>
                    </div>
                </div>
            </div>
            <!-- /col -->
            @endforeach
        </div>
    </div>
</div>


{{-- <div class="row row-deck">
    @foreach ($subscriptions as $item)
    <div class="col-xl-6 col-lg-5 col-md-12">
        <div class="card overflow-hidden">
            <a href="{{route('subscription.show', [$item['id']])}}">
                <img  src="https://img.pngio.com/microsoft-corporate-logo-guidelines-trademarks-microsoft-logo-png-2008_900.jpg" alt="image">
            </a>
            <div class="card-body">
                <div class="row  text-center">
                    <div class="col-sm-6 border-right">
                        <h4 class="pro-user-username text-dark mb-1 font-weight-bold">{{ ucwords(trans_choice('messages.subscription_name', 1)) }}</h4>
                        <h6 class="pro-user-desc text-muted">{{$item->name}}</h6>
                    </div>
                    <div class="col-sm-6">
                        <h3><p>{{ ucwords(trans_choice('messages.tenant_name', 1)) }}</p>
                            <p class="pro-user-desc text-muted"> <a href="{{route('subscription.show', [$item['id']])}}"> {{$item->tenant_name}}  </a></p>
                        </h3>
                    </div>
                </div>
                <div class=" p-0">
                    <div class="row  text-center ">
                        <div class="col-sm-6 border-right text-center">
                            <div class="description-block p-4">
                                <h5 class="description-header mb-1 font-weight-bold">{{ ucwords(trans_choice('messages.licenses', 1)) }}</h5>
                                <span class="text-muted">{{$item->amount}}  {{ ucwords(trans_choice('messages.licenses', 1)) }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="description-block text-center p-4">
                                <h5 class="description-header mb-1 font-weight-bold">{{ ucwords(trans_choice('messages.billing_cycle', 1)) }}</h5>
                                <span class="text-muted">{{$item->billing_period}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="pro-user text-center">
                            <h4 class="pro-user-username text-dark mb-1 font-weight-bold">{{ ucwords(trans_choice('messages.subscription_status', 1)) }}</h4>
                            <h6 class="pro-user-desc text-muted"><span class="badge badge-success mt-2">{{ ucwords(trans_choice( $item->status->name, 1)) }}</span></h6>
                        </div>
                    </div>
                </div>

                <div class="card-footer p-0">
                    <div class="row">
                        <div class="col-sm-6 border-right text-center">
                            <div class="description-block p-4">
                                <h5 class="description-header mb-1 font-weight-bold">{{ ucwords(trans_choice('messages.licenses', 1)) }}</h5>
                                <span class="text-muted">{{$item->amount}}  {{ ucwords(trans_choice('messages.licenses', 1)) }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div> --}}
