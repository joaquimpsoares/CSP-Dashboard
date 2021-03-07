@extends('layouts.master')


@section('content')


<div class="box">
    <section class="section">
        <div class="card">
            <div class="">
                <i class="p-4 ml-2 text-white rounded fab fa-product-hunt fa-lg primary-color z-depth-2 mt-n3"></i>
                <div class="card-body">
                    <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.product_card', 2)) }}</a></h4>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="row">
                                <form action="{{ route('invite') }}" method="post">
                                    {{ csrf_field() }}
                                    <input hidden="hiden" name="provider" value="{{Auth::user()->id}}">
                                    <input type="email" name="email" />
                                    <button type="submit">Send invite</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


@endsection


@section('scripts')

@endsection
