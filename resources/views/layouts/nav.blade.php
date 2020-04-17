<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<a class="navbar-brand" href="#">
    <img src="{{ asset('images/small_logo.png') }}" width="30" height="30" class="d-inline-block align-top" alt="">    
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
				<a class="nav-link" href="{{ route('providers.index') }}">
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

				<a class="nav-link" href="{{ route('customers.index') }}">
					{{ ucwords(trans_choice('messages.customer', 2)) }}
				</a>

			</li>
			@endcan


			
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					{{ ucwords(__('messages.maketplace')) }}
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
					<a class="dropdown-item" href="{{ route('products.import') }}">Import Products</a>
					<a class="dropdown-item" href="{{ route('products.index') }}">Products</a>
					<a class="dropdown-item" href="{{ route('jobs') }}">Tasks</a>
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
		<div class="buttons">
			@auth
			<a class="btn btn-primary">
				{{ Auth::user()->username }}
			</a>
			<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-secondary">
				{{ ucwords(__('messages.logout')) }}
			</a>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
				@csrf


			</form>
			@endauth
			@guest
			<a class="btn btn-secondary" href="{{ route('login') }}">
				{{ ucwords(__('messages.login')) }}
			</a>
			@endguest
		</div>
	</div>
</nav>
