@extends('layouts.master')
@section('css')


@endsection
@section('content')

{{-- @livewire('price.show-pricelist', ['priceList' => $priceList]) --}}
@livewire('price.price-table')

@endsection
@section('js')

@endsection
