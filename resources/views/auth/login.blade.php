@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card-body">
            <div class="card">
                <div class="">
                    <i class="fas fa-lock fa-lg blue-gradient  p-4 ml-2 mt-n3 py-2 mx-4 d-flex justify-content-between align-items-center rounded text-white">{{ __(' Login') }}</i>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="md-form">
                                <label for="materialLoginFormEmail">E-mail</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="superadmin@admin.com" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="md-form">
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" value="admin123" >
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-0">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-0">   
                                <div class="col-md-12 offset-md-0">
                                    <button type="submit" class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0">
                                        {{ __('Login') }}
                                    </button>
                                    @if (Route::has('password.request'))
                                    <a class="btn btn-link align-items-center" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection
