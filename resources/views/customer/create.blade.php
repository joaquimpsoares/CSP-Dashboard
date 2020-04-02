@extends('layouts.app')


@section('content')

<div class="container" >
    <div class="row py-10">
        <div class="w-100">
            <div class="box col-xs-12">
                <div>
                    <h1>Customer Account</h1>
                </div>
            </div>
        </div>
        {{-- {{dd($customers->company_name)}} --}}
        <customer-create :customers='{!!$customers!!}'></customer-create>
    </div>
</div>


@endsection

