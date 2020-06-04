<!--================Header Menu Area =================-->
<header class="header_area">
    
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light main_box">
            <div class="container">
                <a class="navbar-brand logo_h" href="/">
                    <img src="{{ asset('images/small_logo.png') }}" width="60" height="auto" class="d-inline-block " alt="">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    @auth
                    
                    <ul class="nav navbar-nav menu_nav ml-auto">
                        
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('home') }}">
                                {{ ucwords(trans_choice('messages.home', 1)) }}
                            </a>
                        </li>
                        @can(config('app.provider_index'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('provider.index') }}">
                                {{ ucwords(trans_choice('messages.provider', 2)) }}
                            </a>
                        </li>
                        @endcan
                        @can(config('app.reseller_index'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('reseller.index') }}">
                                {{ ucwords(trans_choice('messages.reseller', 2)) }}
                            </a>
                        </li>
                        @endcan
                        @can(config('app.customer_index'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('customer.index') }}">
                                {{ ucwords(trans_choice('messages.customer', 2)) }}
                            </a> 
                        </li>
                        @endcan
                        
                        @can(config('app.subscription_index'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('subscription.index') }}">
                                {{ ucwords(trans_choice('messages.subscription', 2)) }}
                            </a> 
                        </li>
                        @endcan
                        
                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                {{ ucwords(__('messages.marketplace')) }}
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('store.index') }}">
                                        {{ ucwords(trans_choice('messages.product', 2)) }} 
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('cart.index') }}">
                                        {{ ucwords(__('messages.cart')) }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('order.index') }}">
                                        {{ ucwords(trans_choice('messages.order', 2)) }}
                                    </a>
                                </li>
                                
                            </ul>
                        </li>
                        
                        @can(config('app.manage_roles'))
                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                {{ ucwords(__('messages.manage')) }}
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('roles.index') }}">
                                        {{ ucwords(trans_choice('messages.manage_role', 2)) }} 
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('priceList.index') }}">
                                        {{ ucwords(trans_choice('messages.price_list', 2)) }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('product.index') }}">
                                        {{ ucwords(trans_choice('messages.product', 2)) }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('jobs') }}">
                                        {{ ucwords(trans_choice('messages.job', 2)) }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('order.index') }}">
                                        {{ ucwords(trans_choice('messages.order', 2)) }}
                                    </a>
                                </li>
                                
                            </ul>
                        </li>
                        @endcan
                        
                        {{-- @can(config('app.settings.general'))
                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                {{ ucwords(trans_choice('messages.setting', 2)) }}
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('roles.index') }}">
                                        {{ ucwords(trans_choice('messages.account', 2)) }} 
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('priceList.index') }}">
                                        {{ ucwords(trans_choice('messages.instance', 2)) }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endcan --}}
                        
                        @if (app('impersonate')->isImpersonating())
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="{{ route('impersonate.leave') }}">
                                <i class="fas fa-user-secret"></i>
                                <span>{{ ucwords(trans_choice('messages.stop_impersonation', 2)) }}</span>
                            </a>
                        </li>
                        @endif
                        <ul class="nav navbar-nav navbar-right">
                            <li class="nav-item">
                                <a href="{{ route('cart.pending') }}" class="cart">
                                    <span class="badge badge-pill badge-primary aqua-gradient" style="float:right;margin-bottom:-10px;">{{ Auth::user()->unreadnotifications->count() }}</span>
                                    <i class="lnr lnr lnr-cart"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="search">
                                    <span class="badge badge-pill badge-primary aqua-gradient   " style="float:right;margin-bottom:-10px;">{{ Auth::user()->unreadnotifications->count() }}</span>
                                    <i class="lnr lnr-magnifier"></i>
                                </a>
                            </li>
                        </ul>
                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <img src="{{Auth::user()->avatar}}" class="rounded-circle z-depth-0" alt="avatar image"  width='50' Height ='auto'>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ '/user/profile/' .auth::user()->id }}">
                                        {{ ucwords(trans_choice('messages.account', 2)) }} 
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ ucwords(__('messages.logout')) }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                        
                    </ul>
                    
                    
                    @endauth
                    
                    @guest
                    <ul class="nav navbar-nav menu_nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">
                                Menu Guest 1
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Menu Guest 2
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Menu Guest x
                            </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('register') }}">
                                {{ ucwords(__('messages.register')) }}
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="btn btn-secondary" href="{{ route('login') }}">
                                {{ ucwords(__('messages.login')) }}
                            </a>
                        </li>
                    </ul>
                    @endguest
                    
                </div> 
            </div>
        </nav>
    </div>
</header>
<!--================Header Menu Area =================-->


<script>
   $(document).ready(function(){
  $('ul li a').click(function(){
    $('li a').removeClass("active");
    $(this).addClass("active");
});
});
    
</script>