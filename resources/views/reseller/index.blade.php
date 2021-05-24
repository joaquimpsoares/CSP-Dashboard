@extends('layouts.master')
@section('css')

@endsection

@section('content')


@include('reseller.partials.table', ['resellers' => $resellers])

@endsection

