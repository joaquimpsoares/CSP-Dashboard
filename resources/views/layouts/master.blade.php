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
    <link href="{{ asset('bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />

    @livewireStyles

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@1.2.3/dist/trix.css">
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>

    @include('layouts.head')
</head>

<body  class="antialiased bg-gray-200">
    <div class="page">
        <div class="page-main">
            @include('layouts.sidemenu')
            @include('layouts.header')
            <main class="relative flex-1 overflow-y-auto bg-white focus:outline-none">
                <div class="py-0 xl:py-0">
                    <div class="md:max-w-8xl md:mx-auto">
                        @if (app('impersonate')->isImpersonating())
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol role="list" class="flex px-6 space-x-4 bg-white rounded-md shadow">
                                <li class="flex px-2 py-2">
                                    <div id="myButton2" data-tippy-size="small" class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                        <a href="{{ route('impersonate.leave') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Currently impersonating {{Auth::user()->name}}</a>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                        @endif
                        <x-messages></x-messages>
                        @yield('page-header')
                        {{ $slot  ?? '' }}
                        @yield('content')
                    </div>
                    @include('layouts.footer-scripts')
                </div>
            </main>
        </div>
    </div>

    @livewireScripts
    <script src="https://unpkg.com/moment"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script src="https://unpkg.com/trix@1.2.3/dist/trix.js"></script>
    @yield('footer')
</body>
</html>
{{-- <script>
    tippy('#myButton2', {
        animation: 'fade',
        delay: [0,500],
        content: "{{ ucwords(trans_choice('messages.stop_impersonation', 2)) }}",
    });
</script> --}}
