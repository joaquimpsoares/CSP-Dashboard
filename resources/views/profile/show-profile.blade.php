@extends('layouts.master')

@section('content')
@livewire('profile.show-profile', ['user' => $user], key($user->id))
@endsection
