<div class="form-group">
    <label for="email">@lang('Email')</label>
    <input type="email" class="form-control input-solid @error('email') is-invalid @enderror" id="email" name="email" placeholder="@lang('Email')" value="{{ old('email') }}">
    @error('email')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror

</div>

<div class="form-group">
    <label for="username">@lang('Username')</label>
    <input type="text" class="form-control input-solid @error('username') is-invalid @enderror" id="username" placeholder="(@lang('optional'))" name="username" value="{{ old('username') }}">
    @error('username')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror

</div>

<div class="form-group">
    <label for="password">{{ $edit ? __("New Password") : __('Password') }}</label>
    <input type="password" class="form-control input-solid @error('password') is-invalid @enderror" id="password" name="password"  value="{{ old('password') }}"
           @if ($edit) placeholder="@lang("Leave field blank if you don't want to change it")" @endif>
    @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror

</div>

<div class="form-group">
    <label for="password_confirmation">{{ $edit ? __("Confirm New Password") : __('Confirm Password') }}</label>
    <input type="password" class="form-control input-solid @error('password') is-invalid @enderror" id="password_confirmation" name="password_confirmation"  value="{{ old('password_confirmation') }}"
           @if ($edit) placeholder="@lang("Leave field blank if you don't want to change it")" @endif>
           @error('password')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror

</div>

@if ($edit)
    <button type="submit" class="btn btn-primary mt-2" id="update-login-details-btn">
        <i class="fa fa-refresh"></i>
        @lang('Update Details')
    </button>
@endif
