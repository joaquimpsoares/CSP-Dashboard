<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CSP Dashboard') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-[#f6f9fc]">
            @if (app('impersonate')->isImpersonating())
                <div class="border-b border-amber-200 bg-amber-50">
                    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-2 text-sm sm:px-6 lg:px-8">
                        <div class="text-amber-900">
                            <span class="font-medium">Impersonating</span>
                            <span class="font-semibold">{{ Auth::user()->name }}</span>
                        </div>
                        <a href="{{ route('impersonate.leave') }}" class="rounded-lg bg-white px-3 py-1.5 font-semibold text-amber-900 shadow-sm ring-1 ring-amber-200 hover:bg-amber-100">
                            Stop impersonating
                        </a>
                    </div>
                </div>
            @endif

            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @livewireScripts
    </body>
</html>
