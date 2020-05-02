@extends('layouts.app')

<style>
    .number-input input[type="number"] {
        -webkit-appearance: textfield;
        -moz-appearance: textfield;
        appearance: textfield;
    }
    
    .number-input input[type=number]::-webkit-inner-spin-button,
    .number-input input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
    }
    
    .number-input {
        margin-bottom: 3rem;
    }
    
    .number-input button {
        -webkit-appearance: none;
        background-color: transparent;
        border: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        margin: 0;
        position: relative;
    }
    
    .number-input button:before,
    .number-input button:after {
        display: inline-block;
        position: absolute;
        content: '';
        height: 2px;
        transform: translate(-50%, -50%);
    }
    
    .number-input button.plus:after {
        transform: translate(-50%, -50%) rotate(90deg);
    }
    
    .number-input input[type=number] {
        text-align: center;
    }
    
    .number-input.number-input {
        border: 1px solid #ced4da;
        width: 10rem;
        border-radius: .25rem;
    }
    
    .number-input.number-input button {
        width: 2.6rem;
        height: .7rem;
    }
    
    .number-input.number-input button.minus {
        padding-left: 10px;
    }
    
    .number-input.number-input button:before,
    .number-input.number-input button:after {
        width: .7rem;
        background-color: #495057;
    }
    
    .number-input.number-input input[type=number] {
        max-width: 4rem;
        padding: .5rem;
        border: 1px solid #ced4da;
        border-width: 0 1px;
        font-size: 1rem;
        height: 2rem;
        color: #495057;
    }
    
    @media not all and (min-resolution:.001dpcm) {
        @supports (-webkit-appearance: none) and (stroke-color:transparent) {
            
            .number-input.def-number-input.safari_only button:before,
            .number-input.def-number-input.safari_only button:after {
                margin-top: -.3rem;
            }
        }
    }   
</style>
@section('content')
<div class="box">
    <section class="section">
        <div class="card">
            <div class="">
                <i class="fab fa-product-hunt fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
                <div class="card-body">
                    <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.product_card', 2)) }}</a></h4>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="row">
                                <form method="POST" action="{{ route('instances.store') }}" class="col s12">
                                    @csrf
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <div class="md-form">
                                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
                                                <label for="name">{{ ucwords(trans_choice('messages.name', 1)) }}</label>
                                            </div>
                                        </div>
                                        <div class="input-field col s4">
                                            <div class="md-form">
                                                <input type="text" id="provider" name="provider" class="form-control" value="{{ old('provider') }}">
                                                <label for="provider">{{ ucwords(trans_choice('messages.provider', 1)) }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <div class="md-form">
                                                <input type="text" id="external_id" name="external_id" class="form-control" value="{{ old('external_id') }}">
                                                <label for="external_id">{{ ucwords(trans_choice('messages.external_id', 1)) }}</label>
                                            </div>
                                        </div>
                                        <div class="input-field col s4">
                                            <div class="md-form">
                                                <input type="text" id="external_type" name="external_type" class="form-control" value="{{ old('external_type') }}">
                                                <label for="external_type">{{ ucwords(trans_choice('messages.external_type', 1)) }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="mb-0 ml-2" for="material-url">{{ ucwords(trans_choice('messages.external_type', 1)) }}</label>
                                        <div class="md-form input-group mt-0 mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text md-addon" id="external_url">https://</span>
                                            </div>
                                            <input type="text" name="external_url" class="form-control" id="material-url" aria-describedby="external_url">
                                        </div>
                                        {{-- <div class="input-field col s4">
                                            <div class="md-form">
                                                <input type="text" id="external_url" name="external_url" class="form-control" value="{{ old('external_url') }}">
                                                <label for="external_url">{{ ucwords(trans_choice('messages.external_url', 1)) }}</label>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                                <button type="submit" class="button is-rounded is-primary is-outlined">Create</button>
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

