<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <!-- Meta data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta content="Tagydes - CSP Automation Platform" name="description">
    <meta content="Tagydes Limited" name="author">
    <meta name="keywords" content="Admin, Admin Dashboard, Automation, Microsoft CSP, Admin Resellers, O354 Automation Platform, Kaspersky, license management"/>
    <!-- Tailwind UI -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tailwindcss/ui@latest/dist/tailwind-ui.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Paaji+2&display=swap" rel="stylesheet">

    <!-- Alpine -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

    @livewireStyles
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@1.2.3/dist/trix.css">
    @include('layouts.head')
</head>

<body  class="antialiased bg-gray-200">
    <div class="page">
        <div class="page-main">
            @include('layouts.sidemenu')
            <div class="md:max-w-8xl md:mx-auto">
                {{-- @include('layouts.messages') --}}
                <x-messages></x-messages>
                @yield('page-header')
                {{ $slot  ?? '' }}
                @yield('content')
            </div>
            @include('layouts.footer-scripts')
        </div>
    </div>
</div>

@livewireScripts
<script src="https://unpkg.com/moment"></script>
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script src="https://unpkg.com/trix@1.2.3/dist/trix.js"></script>
@yield('footer')
</body>
</html>
