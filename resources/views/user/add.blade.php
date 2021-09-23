@extends('layouts.master')
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')


@livewire('user.create-user')
{{-- {!! Form::open(['route' => 'user.store', 'files' => true, 'id' => 'user-form']) !!}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <h5 class="card-title">
                        @lang('User Details')
                    </h5>
                    <p class="text-muted font-weight-light">
                        @lang('A general user profile information.')
                    </p>
                </div>
                <div class="col-md-9">
                    @include('user.partials.details', ['edit' => false, 'profile' => false])
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <h5 class="card-title">
                        @lang('Login Details')
                    </h5>
                    <p class="text-muted font-weight-light">
                        @lang('Details used for authenticating with the application.')
                    </p>
                </div>
                <div class="col-md-9">
                    @include('user.partials.auth', ['edit' => false])
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                @lang('Create User')
            </button>
        </div>
    </div>
{!! Form::close() !!} --}}

<br>
@stop

{{-- @section('scripts')
    {!! HTML::script('assets/js/as/profile.js') !!}
    {!! JsValidator::formRequest('Vanguard\Http\Requests\User\CreateUserRequest', '#user-form') !!}
@stop --}}
