@extends('layouts.master')
@section('css')

@endsection

@section('content')
<!-- Charting library -->
<script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
<!-- Chartisan -->
<script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
@php
$user = Auth::user();
@endphp

@livewire('user.security', ['user' => $user], key($user->id))

@endsection


