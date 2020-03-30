@extends('layouts.app')

@section('content')

<section class="container">
    <article class="half">
        <h1>Tagydes</h1>
        <div class="tabs">
            <span class="tab signin active"><a href="#signin">Sign in</a></span>
        </div>
        <div class="content">
            <div class="signin-cont cont">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input id="email" type="email" class="inpt @error('email') is-invalid @enderror" name="email" value="superadmin@admin.com" required autocomplete="email" autofocus>
                    <label for="email">Your email</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" value="admin123" >
                    <label for="password">Your password</label>
                    <input type="checkbox" id="remember" class="checkbox" checked>
                    <label for="remember">Remember me</label>
                    <div class="submit-wrap">
                        <input type="submit" value="Sign in" class="submit">
                        <a href="#" class="more">Forgot your password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</article>
<div class="half bg"></div>
</section>
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="superadmin@admin.com" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" value="admin123" >

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
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
</div> --}}
@endsection

@section('scripts')
<script>
    $('.tabs .tab').click(function(){
        if ($(this).hasClass('signin')) {
            $('.tabs .tab').removeClass('active');
            $(this).addClass('active');
            $('.cont').hide();
            $('.signin-cont').show();
        }
        if ($(this).hasClass('signup')) {
            $('.tabs .tab').removeClass('active');
            $(this).addClass('active');
            $('.cont').hide();
            $('.signup-cont').show();
        }
    });
    $('.container .bg').mousemove(function(e){
        var amountMovedX = (e.pageX * -1 / 30);
        var amountMovedY = (e.pageY * -1 / 9);
        $(this).css('background-position', amountMovedX + 'px ' + amountMovedY + 'px');
    });
</script>
@endsection
