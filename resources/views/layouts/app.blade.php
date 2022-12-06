@extends('layouts.master')

<head>
    @livewireStyles
</head>
<body>

    {{ $slot }}

    @livewireScripts
</body>
