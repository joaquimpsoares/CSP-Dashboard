<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="Tagydes - CSP Automation Platform" name="description">
    <meta content="Tagydes Limited" name="author">
    <meta name="keywords" content="Admin, Admin Dashboard, Automation, Microsoft CSP, Admin Resellers, O354 Automation Platform, Kaspersky, license management"/>
    @include('layouts.custom-head')
	</head>

	<body class="h-100vh page-style1 light-mode default-sidebar">
		@yield('content')
		@include('layouts.custom-footer-scripts')
	</body>
</html>
