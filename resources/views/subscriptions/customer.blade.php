@extends('layouts.master')
@section('css')

@endsection

@section('content')
<div class="jumbotron">
    <h1 class="display-3">Welcome {{Auth::user()->name}}</h1>
    <p class="lead">Here you'll be able to manage your Subscriptions licenses.</p>
    <hr class="my-4">
    {{-- <p>It uses utility classes for typography and spacing to space content out within the larger container.</p> --}}
    <p class="lead m-0">
        {{-- <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a> --}}
    </p>
</div>
<section class="section">
    @include('subscriptions.partials.card', ['subscriptions' => $subscriptions])
</section>
@endsection
