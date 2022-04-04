@extends('layouts.master')

@section('content')

@livewire('customer.home', ['customer' => $customer], key($customer->id))

@endsection


