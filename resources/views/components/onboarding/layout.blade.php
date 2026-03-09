@props(['title' => 'Onboarding', 'step' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Onboarding' }} — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 antialiased">

    <!-- Top bar with logo -->
    <div class="flex justify-center pt-10 pb-6">
        <span class="text-2xl font-bold tracking-tight text-slate-900">{{ config('app.name') }}</span>
    </div>

    <!-- Step progress -->
    @isset($step)
    <div class="flex items-center justify-center gap-3 mb-8">
        @foreach([1 => 'Verify email', 2 => 'Partner type', 3 => 'Select plan'] as $n => $label)
            <div class="flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-full text-xs font-bold
                    {{ $step >= $n ? 'bg-primary-600 text-white' : 'bg-slate-200 text-slate-500' }}">
                    {{ $n }}
                </span>
                <span class="text-xs font-medium {{ $step >= $n ? 'text-slate-800' : 'text-slate-400' }}">
                    {{ $label }}
                </span>
                @if($n < 3)
                    <span class="mx-1 h-px w-8 bg-slate-300"></span>
                @endif
            </div>
        @endforeach
    </div>
    @endisset

    <!-- Card -->
    <div class="mx-auto max-w-lg px-4 pb-16">
        {{ $slot }}
    </div>

</body>
</html>
