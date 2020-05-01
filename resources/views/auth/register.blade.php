@extends('layouts.app')

@section('content')

{{-- <div class="container">  --}}
    <div class="row justify-content-center">
        <div class="col-md-8">
            <section>
                <div class="card-body">
                    <div class="card">
                        <div class="">
                            <i class="fas fa-unlock fa-lg blue-gradient  p-4 ml-2 mt-n3 py-2 mx-4 d-flex justify-content-between align-items-center rounded text-white">{{ __(' Register') }}</i>
                            <div class="card-body">
                                <form method="POST" action="{{ route('provider.register') }}">
                                    @csrf
                                    {{-- <div class="row">
                                        <div class="md-form col-md-6">
                                            <label for="company_name" class="col-md-4">{{ __('Company Name') }}</label>
                                            <input id="company_name" type="text" class="form-control @error('name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" required autocomplete="company_name">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="md-form col-md-6">
                                            <label for="nif" class="col-md-4">{{ __('NIF') }}</label>
                                            <input id="nif" type="text" class="form-control @error('name') is-invalid @enderror" name="nif" value="{{ old('nif') }}" required autocomplete="nif">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="row">
                                        <div class="md-form col-md-6">
                                            <label for="first_name" class="col-md-4">{{ __('First Name') }}</label>
                                            <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="md-form col-md-6">
                                            <label for="last_name" class="col-md-4">{{ __('Last Name') }}</label>
                                            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        {{-- <div class="md-form col-md-4">
                                            <label for="email" class="col-md-4">{{ __('E-Mail Address') }}</label>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div> --}}
                                    </div>
                                    <div class="row">
                                        <div class="md-form col-md-6">
                                            <label for="email" class="col-md-4">{{ __('E-Mail Address') }}</label>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                        <div class="row"> 
                                            <div class="md-form col-md-6">
                                                <label for="password" class="col-md-4">{{ __('Password') }}</label>
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror   
                                            </div>
                                            
                                            <div class="md-form col-md-6">
                                                <label for="password-confirm" class="col-md-4">{{ __('Confirm Password') }}</label>
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-success">
                                                {{ __('Register') }}
                                            </button>
                                            <a href="https://login.microsoftonline.com/common/oauth2/authorize?client_id=66127fdf-8259-429c-9899-6ec066ff8915&response_mode=form_post&response_type=code%20id_token&scope=openid%20profile&state=OpenIdConnect.AuthenticationProperties%3DI1GSEMQ5vkDi3jW3ICsu3q3Gu2YZ2EaVSDg_6LSze9jkkzOWMNk6_dt7foli3-P_5-y0R9niZdkTqAaH-fCRC9deVyckpElYkGBBFSlj1owO9thmnqCUkejka2wceAbreckdP4bye-Axg0OZQ0BF6w&nonce=636981181817049026.NzVmYTczYzMtNjUwZS00NmUwLWEyZmMtMWVjMmJjN2VlY2U3Njg3NzA3Y2YtOTZlNi00ODk3LThiYjktYjMwYzc3ZDhhYTNk&x-client-SKU=ID_NET461&x-client-ver=5.3.0.0" class="btn btn-primary">Consent</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    
    
    
    @endsection
