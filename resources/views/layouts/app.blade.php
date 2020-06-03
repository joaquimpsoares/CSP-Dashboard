<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
	<title>{{ config('app.name', 'Tagydes') }}</title>
	
		{{-- <script src="{{ asset('js/app.js') }}" defer></script> -- > --}}

		<!-- Styles -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">


		<link rel="stylesheet" href="{{ asset('vendors/linericon/style.css') }}">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">

		<link rel="stylesheet" href="{{ asset('vendors/owl-carousel/owl.carousel.min.css') }}">
		<link rel="stylesheet" href="{{ asset('vendors/lightbox/simpleLightbox.css') }}">
		<link rel="stylesheet" href="{{ asset('vendors/nice-select/css/nice-select.css') }}">
		<link rel="stylesheet" href="{{ asset('vendors/animate-css/animate.css') }}">
		<link rel="stylesheet" href="{{ asset('vendors/jquery-ui/jquery-ui.css') }}"> 
		<link rel="stylesheet" href="{{ asset('css/style.css') }}">
		<link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

		@yield('styles')
	</head>
	<body>


		<div id="app">

			@include('layouts.nav')

			@include('layouts.bread')

			{{-- @include('partials.messages') --}}

			@yield('content')

			@include('layouts.footer')
		</div>


		{{-- <script src="{{ asset('jquery/jquery.js') }}"></script> --}}
		
		{{-- <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script> --}}
		<script src="{{ asset('js/popper.js') }}"></script>
		<script src="{{ asset('js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('js/stellar.js') }}"></script>
		<script src="{{ asset('vendors/lightbox/simpleLightbox.min.js') }}"></script>
		{{-- <script src="{{ asset('vendors/nice-select/js/jquery.nice-select.min.js') }}"></script> --}}
		<script src="{{ asset('vendors/isotope/imagesloaded.pkgd.min.js') }}"></script>
		<script src="{{ asset('vendors/isotope/isotope-min.js') }}"></script>
		<script src="{{ asset('vendors/owl-carousel/owl.carousel.min.js') }}"></script>
		{{-- <script src="{{ asset('js/jquery.ajaxchimp.min.js') }}"></script> --}}
		{{-- <script src="{{ asset('vendors/counter-up/jquery.waypoints.min.js') }}"></script> --}}
		<script src="{{ asset('vendors/flipclock/timer.js') }}"></script>
		{{-- <script src="{{ asset('vendors/counter-up/jquery.counterup.js') }}"></script> --}}
		<script src="{{ asset('js/mail-script.js') }}"></script>
		<script src="{{ asset('js/theme.js') }}"></script>
		@yield('scripts')

		<script type="text/javascript">
			$(function () {
				$('[data-toggle="tooltip"]').tooltip()
			})
		</script>

		<livewire:scripts>	
	</body>
	</html>
