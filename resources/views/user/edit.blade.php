@extends('layouts.master')

@section('page-title', __('Edit User'))
@section('page-heading', $user->nameOrEmail)

@section('breadcrumbs')
<li class="breadcrumb-item">
    <a href="{{ route('user.index') }}">@lang('Users')</a>
</li>
<li class="breadcrumb-item">
    <a href="{{ route('user.show', $user->id) }}">
        {{ $user->nameOrEmail }}
    </a>
</li>
<li class="breadcrumb-item active">
    @lang('Edit')
</li>
@stop

@section('content')

@include('partials.messages')

@livewire('user.edit-user', ['user' => $user], key($user->id))

@stop

{{-- @section('scripts')
{!! HTML::script('assets/js/as/btn.js') !!}
{!! HTML::script('assets/js/as/profile.js') !!}
{!! JsValidator::formRequest('Vanguard\Http\Requests\User\UpdateDetailsRequest', '#details-form') !!}
{!! JsValidator::formRequest('Vanguard\Http\Requests\User\UpdateLoginDetailsRequest', '#login-details-form') !!}

@if (setting('2fa.enabled'))
{!! JsValidator::formRequest('Vanguard\Http\Requests\TwoFactor\EnableTwoFactorRequest', '#two-factor-form') !!}
@endif
@stop --}}
