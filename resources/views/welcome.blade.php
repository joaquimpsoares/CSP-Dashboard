@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome</div>
                <div class="card-body">
                    <p>CSP Dashboard is running.</p>
                    @auth
                        <a class="btn btn-primary" href="{{ url('/home') }}">Go to Home</a>
                    @else
                        <a class="btn btn-primary" href="{{ route('login') }}">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
