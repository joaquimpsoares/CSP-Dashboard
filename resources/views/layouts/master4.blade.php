<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="Tagydes - CSP Automation Platform" name="description">
    <meta content="Tagydes Limited" name="author">
    <meta name="keywords" content="Admin, Admin Dashboard, Automation, Microsoft CSP, Admin Resellers, O354 Automation Platform, Kaspersky, license management"/>
		@include('layouts.head')
	</head>

	<body class="app sidebar-mini light-mode default-sidebar">
		<!---Global-loader-->
		<div id="global-loader" >
			<img src="{{URL::asset('assets/images/svgs/loader.svg')}}" alt="loader">
		</div>

		<div class="page">
			<div class="page-main">
				@include('layouts.side-menu')
				<div class="app-content main-content">
					<div class="side-app">
						@include('layouts.header')
						@yield('page-header')
						@yield('content')
            			@include('layouts.footer')
		</div><!-- End Page -->
			@include('layouts.footer-scripts1')
	</body>
</html>
