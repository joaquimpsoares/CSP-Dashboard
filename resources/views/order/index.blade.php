@extends('layouts.master')
@section('css')

@endsection
@section('content')
<section class="section">
    <div class="card">
        <div class="card-body">
            @livewire('order.order-table')
        </div>
    </div>
</section>
@endsection
@section('js')

@endsection
