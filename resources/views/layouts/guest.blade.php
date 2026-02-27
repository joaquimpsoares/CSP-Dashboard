<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CSP Dashboard') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center px-4 py-10 bg-[#f6f9fc]">
            <div class="mb-6">
                <a href="/" class="inline-flex items-center gap-3">
                    <x-application-logo class="h-10 w-auto" />
                </a>
            </div>

            <div class="w-full sm:max-w-md rounded-2xl border border-slate-200 bg-white/80 backdrop-blur px-6 py-6 shadow-sm">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
