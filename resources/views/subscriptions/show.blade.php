@extends('layouts.master')
@section('css')
@endsection
@section('content')
@livewire('subscription.show-subscription', ['subscription' => $subscription], key($subscription->id))
@endsection
