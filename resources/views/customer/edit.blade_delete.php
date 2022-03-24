
@extends('layouts.master')
@section('css')

@endsection


@section('content')
@livewire('customer.edit-customer', ['customers' => $customers])
@endsection


@section('js')

@endsection
