<!--aside open-->
<div class="app-sidebar app-sidebar2">
    <div class="app-sidebar__logo">
        <a class="header-brand" href="{{ url('/' . $page='index') }}">
            <img src="{{URL::asset('images/tagydes_logo.png')}}" class="header-brand-img desktop-lgo" alt="Covido logo">
            <img src="{{URL::asset('assets/images/brand/logo1.png')}}" class="header-brand-img dark-logo" alt="Covido logo">
            <img src="{{URL::asset('assets/images/brand/favicon.png')}}" class="header-brand-img mobile-logo" alt="Covido logo">
            <img src="{{URL::asset('assets/images/brand/favicon1.png')}}" class="header-brand-img darkmobile-logo" alt="Covido logo">
        </a>
    </div>
</div>
<aside class="app-sidebar app-sidebar3">
    <div class="app-sidebar__user">
        <div class="dropdown user-pro-body text-center">
            <div class="user-pic">
                <img src="{{Auth::user()->avatar}}" alt="user-img" class="avatar-xl rounded-circle mb-1">
            </div>
            <div class="user-info">
                <h5 class=" mb-1 font-weight-bold">{{Auth::user()->first_name . Auth::user()->last_name}}</h5>
                <span class="text-muted app-sidebar__user-name text-sm">{{Auth::user()->resellers}}</span>
            </div>
        </div>
    </div>
    <ul class="side-menu">
        <li class="slide">
            <a class="side-menu__item"  data-toggle="slide" href="{{  route('home') }}">
                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="26" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <span class="side-menu__label">Dashboard</span><i class="angle fa fa-angle-right"></i></a>
            <ul class="slide-menu">
                <li><a class="slide-item"  href="{{  route('home') }}"><span>Dashboard</span></a></li>
            </ul>
        </li>
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                <span class="side-menu__label">Manage</span><i class="angle fa fa-angle-right"></i></a>
                <ul class="slide-menu">
                    <li class="sub-slide">
                        @can(config('app.provider_index'))
                        <li><a href="{{ route('provider.index') }}" class="slide-item"> {{ ucwords(trans_choice('messages.provider', 2)) }}</a></li>
                        @endcan
                        @can(config('app.reseller_index'))
                        <li><a href="{{ route('reseller.index') }}" class="slide-item"> {{ ucwords(trans_choice('messages.reseller', 2)) }}</a></li>
                        @endcan
                        @can(config('app.customer_index'))
                        <li><a href="{{ route('customer.index') }}" class="slide-item"> {{ ucwords(trans_choice('messages.customer', 2)) }}</a></li>
                        @endcan
                        @can(config('app.subscription'))
                        <li><a href="{{ route('subscription.index') }}" class="slide-item"> {{ ucwords(trans_choice('messages.subscription', 2)) }}</a></li>
                        @endcan
                    </li>
                </ul>
            </li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg>
                    <span class="side-menu__label">{{ ucwords(trans_choice('messages.analytics', 1)) }}</span><i class="angle fa fa-angle-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{ url('/' . $page='analytics') }}" class="slide-item">{{ ucwords(trans_choice('messages.azure_analytic', 1)) }}</a></li>
                        {{-- <li><a href="{{ url('/' . $page='chart-morris') }}" class="slide-item"> Morris Charts</a></li>
                        <li><a href="{{ url('/' . $page='chart-apex') }}" class="slide-item"> Apex Charts</a></li>
                        <li><a href="{{ url('/' . $page='chart-peity') }}" class="slide-item"> Pie Charts</a></li>
                        <li><a href="{{ url('/' . $page='chart-echart') }}" class="slide-item"> Echart Charts</a></li>
                        <li><a href="{{ url('/' . $page='chart-flot') }}" class="slide-item"> Flot Charts</a></li>
                        <li><a href="{{ url('/' . $page='chart-c3') }}" class="slide-item">C3 Charts</a></li> --}}
                    </ul>
                </li>
            {{--
                <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    <span class="side-menu__label">Widgets</span><i class="angle fa fa-angle-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{ url('/' . $page='widgets-1') }}" class="slide-item">Widgets</a></li>
                        <li><a href="{{ url('/' . $page='widgets-2') }}" class="slide-item">Chart Widgets</a></li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="side-menu__icon"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        <span class="side-menu__label">Forms</span><i class="angle fa fa-angle-right"></i></a>
                        <ul class="slide-menu">
                            <li><a href="{{ url('/' . $page='form-elements') }}" class="slide-item"> Form Elements</a></li>
                            <li><a href="{{ url('/' . $page='advanced-forms') }}" class="slide-item"> Advanced Forms</a></li>
                            <li><a href="{{ url('/' . $page='form-wizard') }}" class="slide-item"> Form Wizard</a></li>
                            <li><a href="{{ url('/' . $page='wysiwyag') }}" class="slide-item"> Form Edit</a></li>
                            <li><a href="{{ url('/' . $page='form-sizes') }}" class="slide-item"> Form Element Sizes</a></li>
                            <li><a href="{{ url('/' . $page='form-treeview') }}" class="slide-item"> Form Treeview</a></li>
                        </ul>
                    </li>

                        <li class="slide">
                            <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line></svg>
                                <span class="side-menu__label">Map</span><i class="angle fa fa-angle-right"></i></a>
                                <ul class="slide-menu">
                                    <li><a href="{{ url('/' . $page='maps') }}" class="slide-item">Vector Maps</a></li>
                                    <li><a href="{{ url('/' . $page='maps2') }}" class="slide-item">Leaflet Maps</a></li>
                                    <li><a href="{{ url('/' . $page='maps3') }}" class="slide-item">Mapel Maps</a></li>
                                </ul>
                            </li>
                            <li class="slide">
                                <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                    <span class="side-menu__label">Tables</span><i class="angle fa fa-angle-right"></i></a>
                                    <ul class="slide-menu">
                                        <li><a href="{{ url('/' . $page='tables') }}" class="slide-item">Default table</a></li>
                                        <li><a href="{{ url('/' . $page='datatable') }}" class="slide-item">Data Table</a></li>
                                    </ul>
                                </li>
                                <li class="slide">
                                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="side-menu__icon"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                                        <span class="side-menu__label">Elements</span><i class="angle fa fa-angle-right"></i></a>
                                        <ul class="slide-menu">
                                            <li><a href="{{ url('/' . $page='accordion') }}" class="slide-item"> Accordion</a></li>
                                            <li><a href="{{ url('/' . $page='alerts') }}" class="slide-item"> Alerts</a></li>
                                            <li><a href="{{ url('/' . $page='avatars') }}" class="slide-item"> Avatars</a></li>
                                            <li><a href="{{ url('/' . $page='badge') }}" class="slide-item"> Badges</a></li>
                                            <li><a href="{{ url('/' . $page='breadcrumbs') }}" class="slide-item"> Breadcrumb</a></li>
                                            <li><a href="{{ url('/' . $page='buttons') }}" class="slide-item"> Buttons</a></li>
                                            <li><a href="{{ url('/' . $page='cards') }}" class="slide-item"> Cards</a></li>
                                            <li><a href="{{ url('/' . $page='cards-image') }}" class="slide-item"> Card Images</a></li>
                                            <li><a href="{{ url('/' . $page='carousel') }}" class="slide-item"> Carousel</a></li>
                                            <li><a href="{{ url('/' . $page='dropdown') }}" class="slide-item"> Dropdown</a></li>
                                            <li><a href="{{ url('/' . $page='footers') }}" class="slide-item"> Footers</a></li>
                                            <li><a href="{{ url('/' . $page='headers') }}" class="slide-item"> Headers</a></li>
                                            <li><a href="{{ url('/' . $page='jumbotron') }}" class="slide-item"> Jumbotron</a></li>
                                            <li><a href="{{ url('/' . $page='list') }}" class="slide-item"> List</a></li>
                                            <li><a href="{{ url('/' . $page='media-object') }}" class="slide-item"> Media Obejct</a></li>
                                            <li><a href="{{ url('/' . $page='modal') }}" class="slide-item"> Modal</a></li>
                                            <li><a href="{{ url('/' . $page='navigation') }}" class="slide-item"> Navigation</a></li>
                                            <li><a href="{{ url('/' . $page='pagination') }}" class="slide-item"> Pagination</a></li>
                                            <li><a href="{{ url('/' . $page='panels') }}" class="slide-item"> Panel</a></li>
                                            <li><a href="{{ url('/' . $page='popover') }}" class="slide-item"> Popover</a></li>
                                            <li><a href="{{ url('/' . $page='progress') }}" class="slide-item"> Progress</a></li>
                                            <li><a href="{{ url('/' . $page='tabs') }}" class="slide-item"> Tabs</a></li>
                                            <li><a href="{{ url('/' . $page='tags') }}" class="slide-item"> Tags</a></li>
                                            <li><a href="{{ url('/' . $page='tooltip') }}" class="slide-item"> Tooltips</a></li>
                                        </ul>
                                    </li>
                                    <li class="slide">
                                        <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="side-menu__icon"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path></svg>
                                            <span class="side-menu__label">Icons</span><i class="angle fa fa-angle-right"></i></a>
                                            <ul class="slide-menu">
                                                <li><a href="{{ url('/' . $page='icons') }}" class="slide-item"> Font Awesome</a></li>
                                                <li><a href="{{ url('/' . $page='icons2') }}" class="slide-item"> Material Design Icons</a></li>
                                                <li><a href="{{ url('/' . $page='icons3') }}" class="slide-item"> Simple Line Icons</a></li>
                                                <li><a href="{{ url('/' . $page='icons4') }}" class="slide-item"> Feather Icons</a></li>
                                                <li><a href="{{ url('/' . $page='icons5') }}" class="slide-item"> Ionic Icons</a></li>
                                                <li><a href="{{ url('/' . $page='icons6') }}" class="slide-item"> Flag Icons</a></li>
                                                <li><a href="{{ url('/' . $page='icons7') }}" class="slide-item"> pe7 Icons</a></li>
                                                <li><a href="{{ url('/' . $page='icons8') }}" class="slide-item"> Themify Icons</a></li>
                                                <li><a href="{{ url('/' . $page='icons9') }}" class="slide-item">Typicons Icons</a></li>
                                                <li><a href="{{ url('/' . $page='icons10') }}" class="slide-item">Weather Icons</a></li>
                                                <li><a href="{{ url('/' . $page='icons11') }}" class="slide-item">Material Icons</a></li>
                                            </ul>
                                        </li>
                                        <li class="slide">
                                            <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                                                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                                                <span class="side-menu__label">Pages</span><i class="angle fa fa-angle-right"></i></a>
                                                <ul class="slide-menu">
                                                    <li class="sub-slide">
                                                        <a class="sub-side-menu__item" data-toggle="sub-slide" href="{{ url('/' . $page='#') }}"><span class="sub-side-menu__label">Profile</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                                        <ul class="sub-slide-menu">
                                                            <li><a class="sub-slide-item" href="{{ url('/' . $page='profile-1') }}">Profile 01</a></li>
                                                            <li><a class="sub-slide-item" href="{{ url('/' . $page='profile-2') }}">Profile 02</a></li>
                                                            <li><a class="sub-slide-item" href="{{ url('/' . $page='profile-3') }}">Profile 03</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="{{ url('/' . $page='editprofile') }}" class="slide-item"> Edit Profile</a></li>
                                                    <li class="sub-slide">
                                                        <a class="sub-side-menu__item" data-toggle="sub-slide" href="{{ url('/' . $page='#') }}"><span class="sub-side-menu__label">Email</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                                        <ul class="sub-slide-menu">
                                                            <li><a class="sub-slide-item" href="{{ url('/' . $page='email-compose') }}">Email Compose</a></li>
                                                            <li><a class="sub-slide-item" href="{{ url('/' . $page='email-inbox') }}">Email Inbox</a></li>
                                                            <li><a class="sub-slide-item" href="{{ url('/' . $page='email-read') }}">Email Read</a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="sub-slide">
                                                        <a class="sub-side-menu__item" data-toggle="sub-slide" href="{{ url('/' . $page='#') }}"><span class="sub-side-menu__label">Pricing</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                                        <ul class="sub-slide-menu">
                                                            <li><a class="sub-slide-item" href="{{ url('/' . $page='pricing') }}">Pricing 01</a></li>
                                                            <li><a class="sub-slide-item" href="{{ url('/' . $page='pricing-2') }}">Pricing 02</a></li>
                                                            <li><a class="sub-slide-item" href="{{ url('/' . $page='pricing-3') }}">Pricing 03</a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="sub-slide">
                                                        <a class="sub-side-menu__item" data-toggle="sub-slide" href="{{ url('/' . $page='#') }}"><span class="sub-side-menu__label">Invoice</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                                        <ul class="sub-slide-menu">
                                                            <li><a class="sub-slide-item" href="{{ url('/' . $page='invoice-list') }}">Invoice list</a></li>
                                                            <li><a class="sub-slide-item" href="{{ url('/' . $page='invoice-1') }}">Invoice 01</a></li>
                                                            <li><a class="sub-slide-item" href="{{ url('/' . $page='invoice-2') }}">Invoice 02</a></li>
                                                            <li><a class="sub-slide-item" href="{{ url('/' . $page='invoice-3') }}">Invoice 03</a></li>
                                                            <li><a class="sub-slide-item" href="{{ url('/' . $page='invoice-add') }}">Add Invoice</a></li>
                                                            <li><a class="sub-slide-item" href="{{ url('/' . $page='invoice-edit') }}">Edit Invoice</a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="sub-slide">
                                                        <a class="sub-side-menu__item" data-toggle="sub-slide" href="{{ url('/' . $page='#') }}"><span class="sub-side-menu__label">Blog</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                                        <ul class="sub-slide-menu">
                                                            <li><a class="sub-slide-item" href="{{ url('/' . $page='blog') }}">Blog 01</a></li>
                                                            <li><a class="sub-slide-item" href="{{ url('/' . $page='blog-2') }}">Blog 02</a></li>
                                                            <li><a class="sub-slide-item" href="{{ url('/' . $page='blog-3') }}">Blog 03</a></li>
                                                            <li><a class="sub-slide-item" href="{{ url('/' . $page='blog-styles') }}">Blog Styles</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="{{ url('/' . $page='gallery') }}" class="slide-item"> Gallery</a></li>
                                                    <li><a href="{{ url('/' . $page='faq') }}" class="slide-item"> FAQS</a></li>
                                                    <li><a href="{{ url('/' . $page='terms') }}" class="slide-item"> Terms</a></li>
                                                    <li><a href="{{ url('/' . $page='empty') }}" class="slide-item"> Empty Page</a></li>
                                                    <li><a href="{{ url('/' . $page='search') }}" class="slide-item"> Search</a></li>
                                                </ul>
                                            </li> --}}
                                            <li class="slide">
                                                <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="side-menu__icon"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                                    <span class="side-menu__label">{{ ucwords(__('messages.marketplace')) }}</span><i class="angle fa fa-angle-right"></i></a>
                                                    <ul class="slide-menu">
                                                        <li><a href="{{ route('store.index') }}" class="slide-item"> {{ ucwords(trans_choice('messages.store', 2)) }}</a></li>
                                                        <li><a href="{{ url('/' . $page='order') }}" class="slide-item">{{ ucwords(trans_choice('messages.order', 2)) }}</a></li>
                                                        <li><a href="{{ url('/' . $page='cart') }}" class="slide-item"> Shopping Cart</a></li>
                                                    </ul>
                                                </li>
                                                <li class="slide">
                                                    <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                                                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                                                        <span class="side-menu__label">{{ ucwords(trans_choice('messages.setting', 2)) }}</span><i class="angle fa fa-angle-right"></i></a>
                                                        <ul class="slide-menu">
                                                            <li><a href="{{ route('priceList.index') }}" class="slide-item"> {{ ucwords(trans_choice('messages.price_list', 2)) }}</a></li>
                                                            <li><a href="{{ route('product.index') }}" class="slide-item"> {{ ucwords(trans_choice('messages.product', 2)) }}</a></li>
                                                            <li><a href="{{ route('jobs') }}" class="slide-item"> {{ ucwords(trans_choice('messages.job', 2)) }}</a></li>
                                                        </ul>
                                                    </li>
                                                    {{-- <li class="slide">
                                                        <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                                                            <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                                            <span class="side-menu__label">Account</span><i class="angle fa fa-angle-right"></i></a>
                                                            <ul class="slide-menu">
                                                                <li class="sub-slide">
                                                                    <a class="sub-side-menu__item" data-toggle="sub-slide" href="{{ url('/' . $page='#') }}"><span class="sub-side-menu__label">Login</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                                                    <ul class="sub-slide-menu">
                                                                        <li><a class="sub-slide-item" href="{{ url('/' . $page='login-1') }}">Login 01</a></li>
                                                                        <li><a class="sub-slide-item" href="{{ url('/' . $page='login-2') }}">Login 02</a></li>
                                                                        <li><a class="sub-slide-item" href="{{ url('/' . $page='login-3') }}">Login 03</a></li>
                                                                    </ul>
                                                                </li>
                                                                <li class="sub-slide">
                                                                    <a class="sub-side-menu__item" data-toggle="sub-slide" href="{{ url('/' . $page='#') }}"><span class="sub-side-menu__label">Register</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                                                    <ul class="sub-slide-menu">
                                                                        <li><a class="sub-slide-item" href="{{ url('/' . $page='register-1') }}">Register 01</a></li>
                                                                        <li><a class="sub-slide-item" href="{{ url('/' . $page='register-2') }}">Register 02</a></li>
                                                                        <li><a class="sub-slide-item" href="{{ url('/' . $page='register-3') }}">Register 03</a></li>
                                                                    </ul>
                                                                </li>
                                                                <li class="sub-slide">
                                                                    <a class="sub-side-menu__item" data-toggle="sub-slide" href="{{ url('/' . $page='#') }}"><span class="sub-side-menu__label">Forget Password</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                                                    <ul class="sub-slide-menu">
                                                                        <li><a class="sub-slide-item" href="{{ url('/' . $page='forgot-password-1') }}">Forget Password 01</a></li>
                                                                        <li><a class="sub-slide-item" href="{{ url('/' . $page='forgot-password-2') }}">Forget Password 02</a></li>
                                                                        <li><a class="sub-slide-item" href="{{ url('/' . $page='forgot-password-3') }}">Forget Password 03</a></li>
                                                                    </ul>
                                                                </li>
                                                                <li class="sub-slide">
                                                                    <a class="sub-side-menu__item" data-toggle="sub-slide" href="{{ url('/' . $page='#') }}"><span class="sub-side-menu__label">Reset Password</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                                                    <ul class="sub-slide-menu">
                                                                        <li><a class="sub-slide-item" href="{{ url('/' . $page='reset-password-1') }}">Reset Password 01</a></li>
                                                                        <li><a class="sub-slide-item" href="{{ url('/' . $page='reset-password-2') }}">Reset Password 02</a></li>
                                                                        <li><a class="sub-slide-item" href="{{ url('/' . $page='reset-password-3') }}">Reset Password 03</a></li>
                                                                    </ul>
                                                                </li>
                                                                <li class="sub-slide">
                                                                    <a class="sub-side-menu__item" data-toggle="sub-slide" href="{{ url('/' . $page='#') }}"><span class="sub-side-menu__label">Lock Screen</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                                                    <ul class="sub-slide-menu">
                                                                        <li><a class="sub-slide-item" href="{{ url('/' . $page='lockscreen-1') }}">Lock Screen 01</a></li>
                                                                        <li><a class="sub-slide-item" href="{{ url('/' . $page='lockscreen-2') }}">Lock Screen 02</a></li>
                                                                        <li><a class="sub-slide-item" href="{{ url('/' . $page='lockscreen-3') }}">Lock Screen 03</a></li>
                                                                    </ul>
                                                                </li>
                                                                <li><a href="{{ url('/' . $page='construction') }}" class="slide-item"> Under Construction</a></li>
                                                                <li><a href="{{ url('/' . $page='coming') }}" class="slide-item"> Coming Soon</a></li>
                                                            </ul>
                                                        </li>
                                                        <li class="slide">
                                                            <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="side-menu__icon"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                                                <span class="side-menu__label">Error Pages</span><i class="angle fa fa-angle-right"></i></a>
                                                                <ul class="slide-menu">
                                                                    <li><a href="{{ url('/' . $page='400') }}" class="slide-item"> 400</a></li>
                                                                    <li><a href="{{ url('/' . $page='401') }}" class="slide-item"> 401</a></li>
                                                                    <li><a href="{{ url('/' . $page='403') }}" class="slide-item"> 403</a></li>
                                                                    <li><a href="{{ url('/' . $page='404') }}" class="slide-item"> 404</a></li>
                                                                    <li><a href="{{ url('/' . $page='500') }}" class="slide-item"> 500</a></li>
                                                                    <li><a href="{{ url('/' . $page='503') }}" class="slide-item"> 503</a></li>
                                                                </ul>
                                                            </li>
                                                            <li class="slide ">
                                                                <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="side-menu__icon"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
                                                                    <span class="side-menu__label">Submenus</span><i class="angle fe fe-chevron-down"></i></a>
                                                                    <ul class="slide-menu">
                                                                        <li class="sub-slide">
                                                                            <a class="sub-side-menu__item" data-toggle="sub-slide" href="{{ url('/' . $page='#') }}"><span class="sub-side-menu__label">Level1</span><i class="sub-angle fe fe-chevron-down"></i></a>
                                                                            <ul class="sub-slide-menu">
                                                                                <li><a class="sub-slide-item" href="{{ url('/' . $page='#') }}">Level01</a></li>
                                                                                <li><a class="sub-slide-item" href="{{ url('/' . $page='#') }}">Level02</a></li>
                                                                            </ul>
                                                                        </li>
                                                                    </ul>
                                                                </li> --}}
                                                            </ul>
                                                            <div class="app-sidebar-help">
                                                                <div class="dropdown text-center">
                                                                    <div class="help d-flex">
                                                                        <a href="{{ url('/' . $page='#') }}" class="nav-link p-0 help-dropdown" data-toggle="dropdown">
                                                                            <span class="font-weight-bold">Help Info</span> <i class="fa fa-angle-down ml-2"></i>
                                                                        </a>
                                                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow p-4">
                                                                            <div class="border-bottom pb-3">
                                                                                <h4 class="font-weight-bold">Help</h4>
                                                                                <a class="text-primary d-block" href="{{ url('/' . $page='#') }}">Knowledge base</a>
                                                                                <a class="text-primary d-block" href="{{ url('/' . $page='#') }}">Contact@info.com</a>
                                                                                <a class="text-primary d-block" href="{{ url('/' . $page='#') }}">88 8888 8888</a>
                                                                            </div>
                                                                            <div class="border-bottom pb-3 pt-3 mb-3">
                                                                                <p class="mb-1">Your Fax Number</p>
                                                                                <a class="font-weight-bold" href="{{ url('/' . $page='#') }}">88 8888 8888</a>
                                                                            </div>
                                                                            <a class="text-primary" href="{{ url('/' . $page='#') }}">Logout</a>
                                                                        </div>
                                                                        <div class="ml-auto">
                                                                            <a class="nav-link icon p-0" href="{{ url('/' . $page='#') }}">
                                                                                <svg class="header-icon" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><path opacity=".3" d="M12 6.5c-2.49 0-4 2.02-4 4.5v6h8v-6c0-2.48-1.51-4.5-4-4.5z"></path><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-11c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2v-5zm-2 6H8v-6c0-2.48 1.51-4.5 4-4.5s4 2.02 4 4.5v6zM7.58 4.08L6.15 2.65C3.75 4.48 2.17 7.3 2.03 10.5h2a8.445 8.445 0 013.55-6.42zm12.39 6.42h2c-.15-3.2-1.73-6.02-4.12-7.85l-1.42 1.43a8.495 8.495 0 013.54 6.42z"></path></svg>
                                                                                <span class="pulse "></span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </aside>
                                                        <!--aside closed-->
