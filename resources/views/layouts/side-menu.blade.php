<!--aside open-->
@php
$cartcount = App\Http\Controllers\Web\CartController::CountCart();
@endphp

<div class="app-sidebar app-sidebar2">
    <div class="app-sidebar__logo">
        <a class="header-brand" href="/">
            @if(Auth::user()->userlevel->name == 'Reseller')
            <img src="{{URL::asset(Auth::user()->reseller->provider->logo)}}" class="header-brand-img desktop-lgo" alt="Covido logo">
            @endif
            @if(Auth::user()->userlevel->name == 'Provider')
            <img src="{{URL::asset(Auth::user()->provider->logo)}}" class="header-brand-img desktop-lgo" alt="Covido logo">
            @endif
            @if(Auth::user()->userlevel->name == 'Customer')
            <img src="{{URL::asset(Auth::user()->customer->resellers->first()->provider->logo)}}" class="header-brand-img desktop-lgo" alt="Covido logo">
            @endif
            @if(Auth::user()->userlevel->name == "Super Admin")
            <img src="{{URL::asset('/images/logos/tagydes.png')}}" class="header-brand-img desktop-lgo" alt="Covido logo">
            <img src="{{URL::asset('assets/images/brand/favicon.png')}}" class="header-brand-img mobile-logo" alt="Covido logo">
            @endif
            {{-- <img src="{{URL::asset('assets/images/brand/favicon1.png')}}" class="header-brand-img darkmobile-logo" alt="Covido logo"> --}}
        </a>
    </div>
</div>
<aside class="app-sidebar app-sidebar3">
    <div class="app-sidebar__user">
        <div class="text-center dropdown user-pro-body">
            <div class="user-pic">
                <img src="{{Auth::user()->avatar}}" alt="user-img" class="mb-1 avatar-xl rounded-circle">
            </div>
            <div class="user-info">
                <h5 class="mb-1 font-weight-bold">{{Auth::user()->name}} {{Auth::user()->last_name}}</h5>
                <span class="text-sm text-muted app-sidebar__user-name">{{Auth::user()->resellers}}</span>
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
            <span class="side-menu__label">Dashboard</span><i class="angle fa fa-angle-right"></i>
        </a>
        <ul class="slide-menu">
            <li><a class="slide-item"  href="{{  route('home') }}"><span>Dashboard</span></a></li>
        </ul>
    </li>
    @canany([config('app.provider_index'),config('app.reseller_index'),config('app.customer_index'),config('app.subscription_index')])
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
                    @can(config('app.subscription_index'))
                    <li><a href="{{ route('subscription.index') }}" class="slide-item"> {{ ucwords(trans_choice('messages.subscription', 2)) }}</a></li>
                    @endcan
                </li>
            </ul>
        </li>
        @endcanany
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg>
                <span class="side-menu__label">{{ ucwords(trans_choice('messages.analytics', 1)) }}</span><i class="angle fa fa-angle-right"></i>
            </a>
            <ul class="slide-menu">
                <li><a href="{{ url('/' . $page='analytics') }}" class="slide-item">{{ ucwords(trans_choice('messages.azure_analytic', 1)) }}</a></li>
                <li><a href="{{ url('/' . $page='analytics/licenses') }}" class="slide-item">{{ ucwords(trans_choice('messages.license_based', 1)) }}</a></li>
            </ul>
        </li>
        @can('marketplace.index')
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="side-menu__icon"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                <span class="side-menu__label">{{ ucwords(__('messages.marketplace')) }}
                </span><i class="angle fa fa-angle-right"></i>
            </a>

            <ul class="slide-menu">
                <li><a href="{{ route('store.index') }}" class="slide-item"> {{ ucwords(trans_choice('messages.store', 2)) }}</a></li>
                <li><a href="{{ url('/' . $page='order') }}" class="slide-item">{{ ucwords(trans_choice('messages.order', 2)) }}</a></li>
                <li><a href="{{ url('/' . $page='cart') }}" class="slide-item"> Shopping Cart
                </a>
            </ul>
        </li>
        @endcan
        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                <span class="side-menu__label">{{ ucwords(trans_choice('messages.setting', 2)) }}</span><i class="angle fa fa-angle-right"></i>
            </a>
            <ul class="slide-menu">
                @can(config('app.customer_index'))
                <li><a href="{{ route('priceList.index') }}" class="slide-item"> {{ ucwords(trans_choice('messages.price_list', 2)) }}</a></li>
                <li><a href="{{ route('product.index') }}" class="slide-item"> {{ ucwords(trans_choice('messages.product', 2)) }}</a></li>
                <li><a href="{{ route('instances.index') }}" class="slide-item"> {{ ucwords(trans_choice('messages.instance', 2)) }}</a></li>
                @endcan
                @can(config('app.provider_index'))
                <li><a href="{{ route('jobs') }}" class="slide-item"> {{ ucwords(trans_choice('messages.job', 2)) }}</a></li>
                @endcan
                @can('users.manage')
                <li><a href="{{ route('user.index') }}" class="slide-item"> {{ ucwords(trans_choice('messages.user', 2)) }}</a></li>
                @endcan
                @can(config('app.provider_index'))
                <li><a href="/userloginfo" class="slide-item"> {{ ucwords(trans_choice('messages.user_log_information', 2)) }}</a></li>
                <li><a href="/logactivity" class="slide-item"> {{ ucwords(trans_choice('messages.log_activity_information', 2)) }}</a></li>
                @endcan
            </ul>
        </li>
    </ul>
    <div class="app-sidebar-help">
        <div class="text-center dropdown">
            <div class="help d-flex">
                <a href="{{ url('/' . $page='#') }}" class="p-0 nav-link help-dropdown" data-toggle="dropdown">
                    <span class="font-weight-bold">Help Info</span> <i class="ml-2 fa fa-angle-down"></i>
                </a>
                <div class="p-4 dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <div class="pb-3 border-bottom">
                        <h4 class="font-weight-bold">Help</h4>
                        <a class="btn btn-secondary" style="color: white" href="{{ url('/' . $page='tickets') }}">Support Tickets</a>
                        <a class="text-primary d-block" href="{{ url('/' . $page='#') }}">Support@tagydes.com</a>
                    </div>
                    <div class="pt-3 pb-3 mb-3 border-bottom">

                    </div>
                </div>
                <div class="ml-auto">
                    <a class="p-0 nav-link icon" href="{{ url('/' . $page='#') }}">
                        <svg class="header-icon" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><path opacity=".3" d="M12 6.5c-2.49 0-4 2.02-4 4.5v6h8v-6c0-2.48-1.51-4.5-4-4.5z"></path><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-11c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2v-5zm-2 6H8v-6c0-2.48 1.51-4.5 4-4.5s4 2.02 4 4.5v6zM7.58 4.08L6.15 2.65C3.75 4.48 2.17 7.3 2.03 10.5h2a8.445 8.445 0 013.55-6.42zm12.39 6.42h2c-.15-3.2-1.73-6.02-4.12-7.85l-1.42 1.43a8.495 8.495 0 013.54 6.42z"></path></svg>
                        <span class="pulse "></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</aside>
<!--aside closed-->
