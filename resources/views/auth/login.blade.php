@extends('layouts.master2')
@section('css')
@endsection
@section('content')

<div class="page">
    <div class="page-single">
        <div class="p-5">
            <div class="row">
                <div class="col mx-auto">
                    <div class="row justify-content-center">
                        <div class="col-lg-9 col-xl-8">
                            <div class="card-group mb-0">
                                <div class="card p-4 page-content">
                                    <div class="card-body page-single-content">
                                        <div class="w-100">
                                            @include('layouts.messages')
                                            <div class="">
                                                <h1 class="mb-2">Login</h1>
                                                <p class="text-muted">Sign In to your account <i class="fab fa-microsoft"></i></p>
                                            </div>
                                            <form class="" action="{{ route('login') }}" method="post" id="contactForm">
                                                <div class="btn-list d-sm-flex">
                                                    <a href="/login/microsoft" class="btn btn-google btn-block">Microsoft</a>
                                                    {{-- <a href="https://twitter.com/" class="btn btn-twitter d-block d-sm-inline mr-0 mr-sm-2">Twitter</a>
                                                    <a href="https://www.facebook.com/" class="btn btn-facebook d-block d-sm-inline">Facebook</a> --}}
                                                </div>
                                                <hr class="divider my-6">
                                                @csrf
                                                @csrf
                                                <div class="input-group mb-3">
                                                    <span class="input-group-addon"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 16c-2.69 0-5.77 1.28-6 2h12c-.2-.71-3.3-2-6-2z" opacity=".3"/><circle cx="12" cy="8" opacity=".3" r="2"/><path d="M12 14c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4zm-6 4c.22-.72 3.31-2 6-2 2.7 0 5.8 1.29 6 2H6zm6-6c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z"/></svg></span>
                                                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="" placeholder="Username" required autocomplete="email" autofocus>
                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="input-group mb-4">
                                                    <span class="input-group-addon"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><g fill="none"><path d="M0 0h24v24H0V0z"/><path d="M0 0h24v24H0V0z" opacity=".87"/></g><path d="M6 20h12V10H6v10zm6-7c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z" opacity=".3"/><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"/></svg></span>
                                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" value="" name="password" placeholder="Password" required autocomplete="current-password">
                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        {{-- <button type="submit"  class="btn submit_btn">Log In</button> --}}
                                                        <button type="button submit" value="submit" class="btn btn-lg btn-primary btn-block"><i class="fe fe-arrow-right"></i> Login</button>
                                                    </div>
                                                    <div class="col-12">
                                                        <a href="{{ url('/' . $page='forgot-password-1') }}" class="btn btn-link box-shadow-0 px-0">Forgot password?</a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card text-white bg-primary py-5 d-md-down-none page-content mt-0">
                                    <div class="card-body text-center justify-content-center page-single-content">
                                        <img src="{{URL::asset('assets/images/pattern/login.png')}}" alt="img">
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="text-center pt-4">
                                <div class="font-weight-normal fs-16">You Don't have an account <a class="btn-link font-weight-normal" href="#">Register Here</a></div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@endsection



{{-- <form class="row login_form" action="{{ route('login') }}" method="post" id="contactForm" novalidate="novalidate">
    @csrf
    <div class="col-md-12 form-group">
        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="superadmin@admin.com" placeholder="Username" required autocomplete="email" autofocus>
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="col-md-12 form-group">
        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" value="admin123" name="password" placeholder="Password" required autocomplete="current-password">
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="col-md-12 form-group">
        <div class="creat_account">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label for="f-option2">Keep me logged in</label>
        </div>
    </div>
    <div class="col-md-12 form-group">
        <button type="submit" value="submit" class="btn submit_btn">Log In</button>
        <a href="#">Forgot Password?</a>
    </div>
</form> --}}

<!--================End Login Box Area =================-->
