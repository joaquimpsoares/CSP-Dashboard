@extends('layouts.master')

@section('page-title', __('Users'))
@section('page-heading', __('Users'))

@section('breadcrumbs')
<li class="breadcrumb-item active">
    @lang('Users')
</li>
@stop

@section('content')

@include('partials.messages')

<div class="card">
    <div class="card-body">

        <form action="" method="GET" id="users-form" class="pb-2 mb-3 border-bottom-light">
            <div class="row my-3 flex-md-row flex-column-reverse">
                <div class="col-md-4 mt-md-0 mt-2">
                    <div class="input-group custom-search-form">
                        <input type="text"
                        class="form-control input-solid"
                        name="search"
                        value="{{ Request::get('search') }}"
                        placeholder="@lang('Search for users...')">

                        <span class="input-group-append">
                            @if (Request::has('search') && Request::get('search') != '')
                            <a href="{{ route('user.index') }}"
                            class="btn btn-light d-flex align-items-center text-muted"
                            role="button">
                            <i class="fa fa-times"></i>
                        </a>
                        @endif
                        <button class="btn btn-light" type="submit" id="search-users-btn">
                            <i class="fa fa-search text-muted"></i>
                        </button>
                    </span>
                </div>
            </div>

            <div class="col-md-2 mt-2 mt-md-0">
                <select name="status" class="form-control SlectBox @error('status') is-invalid @enderror" sf-validate="required">
                    @foreach ($statuses as $key => $status)
                    @dump($status)
                    <option value="{{$key}}">{{ucwords(trans_choice($status, 1))}}</option>
                    @endforeach
                </select>
                </div>

                <div class="col-md-6">
                    <a href="{{ route('user.create') }}" class="btn btn-primary btn-rounded float-right">
                        <i class="fa fa-plus mr-2"></i>
                        @lang('Add User')
                    </a>
                </div>
            </div>
        </form>

        <div class="table-responsive" id="users-table-wrapper">
            <table class="table table-borderless table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th class="min-width-100">@lang('Email')</th>
                        <th class="min-width-150">@lang('Full Name')</th>
                        <th class="min-width-80">@lang('Registration Date')</th>
                        <th class="min-width-80">@lang('Status')</th>
                        <th class="text-center min-width-150">@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($users))
                    @foreach ($users as $user)
                    @include('user.partials.row')
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7"><em>@lang('No records found.')</em></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

{!! $users->render() !!}

@stop

@section('scripts')
<script>
    $("#status").change(function () {
        $("#users-form").submit();
    });
</script>
@stop
