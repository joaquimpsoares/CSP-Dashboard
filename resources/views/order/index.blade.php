@extends('layouts.master')
@section('css')

@endsection
@section('content')
<section class="section">
    <div class="card">
        <div class="card-body">
            {{-- @livewire('order.order-table') --}}
            @include('order.partials.table', ['orders' => $orders])
        </div>
    </div>
</section>
@endsection
@section('js')

@endsection
