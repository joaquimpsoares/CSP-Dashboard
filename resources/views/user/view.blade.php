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

<div class="row">
    <div class="col-lg-5 col-xl-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    {{ucwords(trans_choice('messages.details',1))}}

                    <small class="float-right">
                        @canBeImpersonated($user)
                            <a href="{{ route('impersonate', $user) }}"
                               data-toggle="tooltip" data-placement="top" title="{{ucwords(trans_choice('messages.impersonate',1))}}">
                            </a>{{ucwords(trans_choice('messages.impersonate',1))}}
                            <span class="text-muted">|</span>
                        @endCanBeImpersonated

                        <a href="{{ route('user.edit', $user->id) }}" class="edit"
                           data-toggle="tooltip" data-placement="top" title="{{ucwords(trans_choice('messages.edit_user',1))}}">
                                                    </a>{{ucwords(trans_choice('messages.edit_user',1))}}       
                    </small>
                </h5>

                <div class="d-flex align-items-center flex-column pt-3">
                    <div>
                        <img class="rounded-circle img-thumbnail img-responsive mb-4"
                             width="130"
                             height="130" src="{{ $user->avatar }}">
                    </div>

                    @if ($name = $user->name)
                        <h5>{{ $user->name }}</h5>
                    @endif
                    <a href="mailto:{{ $user->email }}" class="text-muted font-weight-light mb-2">
                        {{ $user->email }}
                    </a>
                </div>

                <ul class="list-group list-group-flush mt-3">
                    @if ($user->phone)
                        <li class="list-group-item">
                            <strong>{{ucwords(trans_choice('messages.phone',1))}}:</strong>
                            <a href="telto:{{ $user->phone }}">{{ $user->phone }}</a>
                        </li>
                    @endif
                    <li class="list-group-item">
                        <strong>{{ucwords(trans_choice('messages.address',1))}}:</strong>
                        {{ $user->fullAddress }}
                    </li>
                    <li class="list-group-item">
                        <strong>{{ucwords(trans_choice('messages.last_logged_in',1))}}:</strong>
                        {{ $user->lastLogin }}
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-7 col-xl-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">


                    {{ucwords(trans_choice('messages.latest_activity',1))}}


                    {{-- @if (count($userActivities))
                        <small class="float-right">
                            <a href="{{ route('activity.user', $user->id) }}" class="edit"
                               data-toggle="tooltip" data-placement="top" title="ucwords(trans_choice('app.complete_activity_log')">
                                ucwords(trans_choice('app.view_all')
                            </a>
                        </small>
                    @endif --}}
                </h5>


                {{-- @isset($branches)
                <h5>
                Branches
                </h5>
                @foreach($branches as $branch)
                {{ $branch->title }}
                </br>
                @endforeach
                @endisset --}}


                {{-- @if (count($userActivities))
                    <table class="table table-borderless table-striped">
                        <thead>
                        <tr>
                            <th>ucwords(trans_choice('app.action')</th>
                            <th>ucwords(trans_choice('app.date')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($userActivities as $activity)
                            <tr>
                                <td>{{ $activity->description }}</td>
                                <td>{{ $activity->created_at->format(config('app.date_time_formatuc',1)) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted font-weight-light"><em>ucwords(trans_choice('app.no_activity_from_this_user_yet')</em></p>
                @endif --}}
            </div>
        </div>
    </div>
</div>
@stop
