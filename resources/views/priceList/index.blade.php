@extends('layouts.master')
@section('css')

@section('content')

@livewire('pricelist.pricelist-table', ['priceLists' => $priceLists], key($priceLists->id))

@endsection

@section('js')


@endsection

