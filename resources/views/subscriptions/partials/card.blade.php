<div class="row row-deck">
    @foreach ($subscriptions as $item)
    <div class="col-xl-6 col-lg-5 col-md-12">
        <div class="card overflow-hidden">
        {{-- <div class="card box-widget widget-user"> --}}
            <a href="{{route('subscription.show', [$item['id']])}}">
                <img  src="https://img.pngio.com/microsoft-corporate-logo-guidelines-trademarks-microsoft-logo-png-2008_900.jpg" alt="image">
            </a>
            <div class="card-body">
                <div class="row  text-center">
                    <div class="col-sm-6 border-right">
                        <h4 class="pro-user-username text-dark mb-1 font-weight-bold">{{ ucwords(trans_choice('messages.subscription_name', 1)) }}</h4>
                        <h6 class="pro-user-desc text-muted">{{$item->name}}</h6>
                        {{-- <p class="pro-user-desc text-muted"><a href=" {{route('subscription.show', [$item['id']])}} ">{{$item->name}}</a></p></h3> --}}
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
                                {{-- <h5 class="description-header mb-1 font-weight-bold">689k</h5>
                                <span class="text-muted">Followers</span> --}}
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
                            {{-- <a href="{{ url('/' . $page='profile') }}" class="btn btn-primary btn-sm mt-3">Edit Profile</a>
                            <a href="#" class="btn btn-success btn-sm mt-3">Follow</a> --}}
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
                            {{-- <div class="description-block text-center p-4">
                                <h5 class="description-header mb-1 font-weight-bold">3,765</h5>
                                <span class="text-muted">Following</span>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
