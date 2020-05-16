@extends('layouts.app')


@section('content')


<div class="box">
    <section>
        <table class="table"    >
            <thead>
                <th>CustomerId</th>
                <th>status</th>
            </thead>
            @foreach ($orders as $order)  
            <tbody>
                <td>{{ $order->customer->company_name }}</td>
                <td>{{ $order->status->name }}</td>
            </tbody>
            @endforeach
        </table>
    </section>
</div>



@endsection

@section('scripts')

@endsection