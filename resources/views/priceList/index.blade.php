@extends('layouts.master')
@section('css')

@section('content')

@include('priceList.partials.pricelisttable', ['products' => $products])

@livewire('price.pricelist-table')

@endsection

@section('js')


@endsection

