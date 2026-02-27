@php
    // Centralize the logo used across Breeze/Blade layouts.
    // If you change branding, swap this file (or make it config-driven).
    $src = asset('images/logos/tagydes.png');
@endphp

<img
    src="{{ $src }}"
    alt="{{ config('app.name', 'Tagydes') }}"
    {{ $attributes->merge(['class' => 'h-10 w-auto']) }}
/>