<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
	<title>{{ config('app.name', 'Tagydes') }}</title>
	
	<!-- Styles -->
	
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">
	
	
	<link rel="stylesheet" href="{{ asset('vendors/linericon/style.css') }}">
	
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
	
	<link rel="stylesheet" href="{{ asset('vendors/owl-carousel/owl.carousel.min.css') }}">
	<link rel="stylesheet" href="{{ asset('vendors/lightbox/simpleLightbox.css') }}">
	<link rel="stylesheet" href="{{ asset('vendors/nice-select/css/nice-select.css') }}">
	<link rel="stylesheet" href="{{ asset('vendors/animate-css/animate.css') }}">
	<link rel="stylesheet" href="{{ asset('vendors/jquery-ui/jquery-ui.css') }}"> 
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	
	@yield('styles')
	
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
	<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>

</head>
<body>


	<div id="app">

		@include('layouts.nav')
		
		@include('layouts.bread')
		@include('partials.messages')

		<br/>
		@yield('content')
		<br/>
		@include('layouts.footer')
	</div>


	{{-- <script src="{{ asset('jquery/jquery.js') }}"></script> --}}



	<script src="{{ asset('js/popper.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/stellar.js') }}"></script>
	<script src="{{ asset('vendors/lightbox/simpleLightbox.min.js') }}"></script>
	<script src="{{ asset('vendors/nice-select/js/jquery.nice-select.min.js') }}"></script>
	<script src="{{ asset('vendors/isotope/imagesloaded.pkgd.min.js') }}"></script>
	<script src="{{ asset('vendors/isotope/isotope-min.js') }}"></script>
	<script src="{{ asset('vendors/owl-carousel/owl.carousel.min.js') }}"></script>
	<script src="{{ asset('js/jquery.ajaxchimp.min.js') }}"></script>
	<script src="{{ asset('vendors/counter-up/jquery.waypoints.min.js') }}"></script>
	<script src="{{ asset('vendors/flipclock/timer.js') }}"></script>
	<script src="{{ asset('vendors/counter-up/jquery.counterup.js') }}"></script>
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
