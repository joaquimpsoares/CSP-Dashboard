@extends('layouts.master')
@section('css')

@section('content')

@livewire('pricelist.show-pricelist', ['priceList' => $priceList], key($priceList->id))

@endsection

@section('js')


@endsection

