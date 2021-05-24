@extends('layouts.master')


@section('content')
@include('partials.messages')


@livewire('user.edit-user', ['user' => $user], key($user->id))

@endsection

