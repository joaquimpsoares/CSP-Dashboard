{{-- <div class="row"> --}}
    <div class="col-md-12 col-lg-12 col-xl-12 ">
        <div class="row">
            <!-- This example requires Tailwind CSS v2.0+ -->
            <ul class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($subscriptions as $item)
                <li class="col-span-1 bg-white divide-y divide-gray-200 rounded-lg shadow">
                    <div class="flex items-center justify-between w-full p-6 space-x-6">
                        <div class="flex-1 truncate">
                            <div class="flex items-center space-x-3">
                                <h3 class="text-sm font-medium text-gray-900 truncate">{{$item->name}}</h3>
                                <span class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 text-xs font-medium bg-green-100 rounded-full">{{ ucwords(trans_choice( $item->status->name, 1)) }}</span>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 truncate">{{$item->subscription_id}}</p>
                        </div>
                        <img class="flex-shrink-0 w-10 h-10 bg-gray-300 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixqx=uonr10FSf0&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60" alt="">
                    </div>
                    <div>
                        <div class="flex -mt-px divide-x divide-gray-200">
                            <div class="flex flex-1 w-0">
                                <a href="mailto:janecooper@example.com" class="relative inline-flex items-center justify-center flex-1 w-0 py-4 -mr-px text-sm font-medium text-gray-700 border border-transparent rounded-bl-lg hover:text-gray-500">
                                    <!-- Heroicon name: solid/mail -->
                                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                    <span class="ml-3">Email</span>
                                </a>
                            </div>
                            <div class="flex flex-1 w-0 -ml-px">
                                <a href="tel:+1-202-555-0170" class="relative inline-flex items-center justify-center flex-1 w-0 py-4 text-sm font-medium text-gray-700 border border-transparent rounded-br-lg hover:text-gray-500">
                                    <!-- Heroicon name: solid/phone -->
                                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                    <span class="ml-3">Call</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach

                <!-- More people... -->
            </ul>

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
                                    {{-- <img  class="mr-2 avatat avatar-md brround" src="https://img.pngio.com/microsoft-corporate-logo-guidelines-trademarks-microsoft-logo-png-2008_900.jpg" alt="img"> --}}
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
                        @can('subscription_edit')
                        <a class="float-right ml-auto btn btn-primary btn-sm px-xl-5" href="{{route('subscription.show', [$item['id']])}}" >Edit</a>
                        @endcan
                    </div>
                </div>
            </div>
            <!-- /col -->
        </div>
    </div>
</div>
