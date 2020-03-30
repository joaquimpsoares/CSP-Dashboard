<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Scripts -->
	<script src="{{ asset('jquery/jquery.js') }}"></script>
	<script src="{{ asset('js/app.js') }}" defer></script>

	<!-- Styles -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">

	@yield('styles')
</head>
<body>
	<div id="app" class="container-fluid">
		<div class="row">
			<div class="col">
				@include('layouts.nav')
			</div>
        </div>

        {{-- @include('layouts.sidebar') --}}


		@include('partials.messages')

		<main class="py-4">
			@yield('content')
		</main>

	</div>


	<script type="text/javascript">
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})
	</script>
	@yield('scripts')

</body>
</html>
