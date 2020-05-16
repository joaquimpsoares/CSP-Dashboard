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
                @foreach ($customers as $customer)
                <td> {{$customer->company_name}} </td>
                @endforeach
                <td> {{$order->status['name']}} </td>
            </tbody>
            @endforeach
        </table>
    </section>
</div>



@endsection

@section('scripts')

@endsection