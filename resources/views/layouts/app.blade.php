<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
	<title>{{ config('app.name', 'Tagydes') }}</title>
	
	<!-- Scripts -->
	<script src="{{ asset('jquery/jquery.js') }}"></script>
	<script src="{{ asset('js/app.js') }}" defer></script>
	<!-- MDBootstrap Datatables  -->
	<script type="text/javascript" src="js/addons/datatables.min.js"></script>
	<!-- MDB core JavaScript -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.16.0/js/mdb.min.js"></script>
	
	
	
	<!-- Styles -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<!-- MDBootstrap Datatables  -->
	<link href="css/addons/datatables.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
	<!-- Google Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
	<!-- Bootstrap core CSS -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
	<!-- Material Design Bootstrap -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.16.0/css/mdb.min.css" rel="stylesheet">
	
	
	@yield('styles')
</head>
<body>
	<livewire:styles>
	
	<div id="app">
		<div class="row">
			<div class="col">
				@include('layouts.nav')
				{{-- @include('layouts.nav', ['cart' => $cart]) --}}
			</div>
		</div>
		@include('layouts.bread')
		
		@include('partials.messages')
		
		<main class="py-4">
			@yield('content')
		</main>
	</div>
	
	
	
	@yield('scripts')
	
	<script type="text/javascript">
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})
	</script>
	
	<livewire:scripts>	
</body>
</html>
