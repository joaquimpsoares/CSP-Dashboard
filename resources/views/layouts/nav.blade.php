
<nav class="navbar navbar-expand-lg navbar-dark primary-color">
    <a class="navbar-brand" href="/">
        <img src="{{ asset('images/small_logo.png') }}" width="30" height="30" class="d-inline-block " alt="">    
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            @auth
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('home') }}">{{ ucwords(__('messages.home')) }} <span class="sr-only">(current)</span></a>
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
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ ucwords(__('messages.marketplace')) }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('store.index') }}">{{ ucwords(trans_choice('messages.product', 2)) }}</a>
                    <a class="dropdown-item" href="{{ route('cart.index') }}">{{ ucwords(__('messages.cart')) }}</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">{{ ucwords(trans_choice('messages.order', 2)) }}</a>
                </div>
            </li>
            @can(config('app.manage_roles'))
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Manage
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('roles.index') }}">{{ ucwords(trans_choice('messages.manage_role', 2)) }}</a>
                    <a class="dropdown-item" href="{{ route('priceList.index') }}">{{ ucwords(trans_choice('messages.price_list', 2)) }}</a>
                    <a class="dropdown-item" href="{{ route('product.import') }}">{{ ucwords(trans_choice('messages.import_product', 2)) }}</a>
                    <a class="dropdown-item" href="{{ route('product.index') }}">{{ ucwords(trans_choice('messages.product', 2)) }}</a>
                    <a class="dropdown-item" href="{{ route('jobs') }}">{{ ucwords(trans_choice('messages.job', 2)) }}</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            @endcan
            <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li>
            @endauth
        </ul>
        <ul class="navbar-nav ml-auto nav-flex-icons">
            @auth
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class ="nav-link" data-toggle="modal" data-target="#modalCart" href="{{ route('cart.pending') }}" >
                            
                            <span class="badge badge-pill badge-primary aqua-gradient" style="float:right;margin-bottom:-10px;">{{ Auth::user()->unreadnotifications->count() }}</span> <!-- your badge -->
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="badge badge-pill badge-primary aqua-gradient   " style="float:right;margin-bottom:-10px;">{{ Auth::user()->unreadnotifications->count() }}</span> <!-- your badge -->
                            {{ ucwords(trans_choice('messages.notification', 2)) }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            {{ $tt = Auth::user()->unreadnotifications}}
                        </div>
                    </li>
                </ul>
            </div>
            <div class="buttons">
                <a class="btn btn-primary">
                    {{ Auth::user()->username }}
                </a>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-secondary">
                    {{ ucwords(__('messages.logout')) }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <ul class="navbar-nav ml-auto nav-flex-icons">
                    
                    <li class="nav-item avatar">
                        <a class="nav-link p-0" href="{{'/user/profile/' .auth::user()->id}}">
                            <img src="{{Auth::user()->avatar}}" class="rounded-circle z-depth-0" alt="avatar image"  width='50' Height ='auto'>
                        </a>
                    </li>
                </ul>
            </ul>
            @endauth
            @guest
            @if (Route::has('register'))
            <a class="btn btn-primary" href="{{ route('register') }}">
                {{ ucwords(__('messages.register')) }}
            </a>
            @endif
            <a class="btn btn-secondary" href="{{ route('login') }}">
                {{ ucwords(__('messages.login')) }}
            </a>
            @endguest
        </div>
    </div>
</nav>



<!-- Modal: modalCart -->
<div class="modal fade" id="modalCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true"  data-backdrop="false">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Your cart</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            {{-- <table class="table table-hover">
                @foreach($cart->products as $product)
                <dl class="row">
                    <dd class="col-sm-8">
                        {{ $product->name }}
                    </dd>
                    <dd class="col-sm-4">
                        @php
                        $price = floatval($product->pivot->retail_price * $product->pivot->quantity);
                        echo "$ " . number_format($price, 2);
                        
                        $totalPrice+=$price;
                        @endphp
                        
                    </dd>
                </dl>
                <hr>
                @endforeach --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary">Checkout</button>
            </div>
        </div>
    </div>
</div>