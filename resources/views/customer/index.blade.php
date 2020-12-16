@extends('layouts.master')

@section('content')

    @include('customer.partials.table', ['customers' => $customers])

@endsection


