@extends('layouts.master')
@section('css')
@endsection
@section('content')


@livewire('customer.show-customer', ['customer' => $customer, 'countries' => $countries, 'statuses' => $statuses], key($customer->id))

@endsection
