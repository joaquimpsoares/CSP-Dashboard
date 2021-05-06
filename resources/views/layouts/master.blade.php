<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <!-- Meta data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta content="Tagydes - CSP Automation Platform" name="description">
    <meta content="Tagydes Limited" name="author">
    <meta name="keywords" content="Admin, Admin Dashboard, Automation, Microsoft CSP, Admin Resellers, O354 Automation Platform, Kaspersky, license management"/>

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
    @include('layouts.head')
</head>

<body  class="antialiased bg-gray-200">
    @livewireStyles
    <div class="page">
        <div class="page-main">
            @include('layouts.sidemenu')
            {{-- @include('layouts.header') --}}
            <div class="px-4 py-8 md:max-w-8xl md:mx-auto">
                @include('layouts.messages')
                {{-- @include('layouts.bread') --}}
                @yield('page-header')
                @yield('content')
                {{-- @include('layouts.footer') --}}
            </div><!-- End Page -->
            @include('layouts.footer-scripts')
        </div>
    </div>
</div>

@livewireScripts
@yield('footer')
</body>
</html>
