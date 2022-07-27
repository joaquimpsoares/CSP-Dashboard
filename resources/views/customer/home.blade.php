@extends('layouts.master')

@section('content')

@livewire('subscription.subscription-costumer', ['customer' => $customer], key($customer->id))

@endsection


