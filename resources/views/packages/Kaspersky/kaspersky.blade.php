@extends('layouts.app')

@section('content')


<div class="container">
    <section class="section">
        <div class="card">
            <div class="">
                <i class="fab fa-microsoft fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
                <div class="card-body">
                    <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.edit_instance', 1)) }}</a></h4>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="row">
                                <form  method="POST" action="{{ route('instances.update', $instances->id) }}" class="col s12">
                                    @method('patch')
                                    @csrf
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <div class="md-form">
                                                <label for="name">{{ ucwords(trans_choice('messages.name', 1)) }}</label>
                                                <input type="text" id="name" name="name" class="form-control" value="{{ $instances->name }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <label for="basic-url">{{ ucwords(trans_choice('messages.endpoint_uri', 1)) }}</label>
                                            <div class="md-form">
                                                <div class="input-group-prepend">
                                                </div>
                                                <input type="text" name="external_url" class="form-control" id="basic-url" aria-describedby="basic-addon3" value=" {{  $instances->external_url }} ">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <div class="md-form">
                                                <label for="tenant_id">{{ ucwords(trans_choice('messages.distribuitor_code', 1)) }}</label>
                                                <input type="text" id="tenant_id" name="tenant_id" class="form-control" value="{{ $instances->tenant_id }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <div class="md-form">
                                                <label for="certificate">{{ ucwords(trans_choice('messages.certificate', 1)) }}</label>
                                                <textarea textarea name="certificate" id="" cols="450" rows="10" type="text" id="certificate" name="certificate" class="form-control" value="{{old('certificate')}}">{{ $certificate }} </textarea>
                                            </div>
                                        </div>      
                                    </div>
                                    <hr>
                                </div>
                                <button type="submit" class="btn submit_btn">{{ ucwords(trans_choice('messages.update', 1)) }}</button>
                                <a href="{{url()->previous()}}" type="submit" class="genric-btn primary">{{ ucwords(trans_choice('messages.cancel', 1)) }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection


@section('scripts')

@endsection

