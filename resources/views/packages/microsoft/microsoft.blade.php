@extends('layouts.master')
@section('css')

@endsection
@section('content')

@livewire('instance.show-instance', ['instance' => $instance, 'expiration'=> $expiration], key($instance->id))

@endsection


@section('scripts')
@endsection

