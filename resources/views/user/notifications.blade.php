@extends('layouts.master')


@section('content')
@include('partials.messages')


@livewire('user.notifications', ['user' => $user], key($user->id))

@endsection

