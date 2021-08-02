@extends('layouts.master')
@section('css')

@endsection

@section('content')
@livewire('reseller.show-reseller', ['reseller' => $reseller, 'countries' => $countries, 'statuses' => $statuses], key($reseller->id))
@endsection
