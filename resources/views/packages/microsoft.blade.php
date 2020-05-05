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
                    <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.instance', 1)) }}</a></h4>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="row">
                                <form method="POST" action="{{ route('provider.store') }}" class="col s12">
                                    @csrf
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <div class="md-form">
                                                <input type="text" id="name" name="name" class="form-control" value="{{ $instances->name }}">
                                                <label for="name">{{ ucwords(trans_choice('messages.name', 1)) }}</label>
                                            </div>
                                        </div>
                                        <div class="input-field col s4">
                                            <div class="md-form">
                                                <input type="text" id="p" name="provider" class="form-control" value="{{ $instances->provider->company_name }}">
                                                <label for="provider">{{ ucwords(trans_choice('messages.provider', 1)) }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    
									<div class="row">
                                        <div class="input-field col s4">
                                            <div class="md-form">
                                                <input type="text" id="address_1" name="address_1" class="form-control" value="{{ old('address_1') }}">
                                                <label for="address_1">{{ ucwords(trans_choice('messages.address_1', 1)) }}</label>
                                            </div>
                                        </div>
                                                                        {{--     <div class="input-field col s4">
                                            <div class="md-form">
                                                <input type="text" id="address_2" name="address_2" class="form-control" value="{{ old('address_2') }}">
                                                <label for="address_2">{{ ucwords(trans_choice('messages.address_2', 1)) }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <div class="md-form">
                                                <input type="text" id="city" name="city" class="form-control" value="{{ old('city') }}">
                                                <label for="city">{{ ucwords(trans_choice('messages.city', 1)) }}</label>
                                            </div>
                                        </div>
                                        <div class="input-field col s4">
                                            <div class="md-form">
                                                <input type="text" id="state" name="state" class="form-control" value="{{ old('state') }}">
                                                <label for="state">{{ ucwords(trans_choice('messages.state', 1)) }}</label>
                                            </div>
                                        </div>
                                        <div class="input-field col s4">
                                            <div class="md-form">
                                                <input type="text" id="postal_code" name="postal_code" class="form-control" value="{{ old('postal_code') }}">
                                                <label for="postal_code">{{ ucwords(trans_choice('messages.postal_code', 1)) }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <label for="status">{{ ucwords(trans_choice('messages.status', 1)) }}</label>
                                            <select name="status" class="browser-default custom-select">
                                                <option selected></option>
                                                @foreach ($statuses as $status)    
                                                <option value="{{$status->id}}">{{ucwords(trans_choice($status->name, 1))}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <h3>Invite Provider</h3>
                                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <h3>Send Notification?</h3>
                                            <input type="checkbox" name="sendInvitation" value="1" class="form-control" value="{{ old('sendInvitation') }}" checked="checked">
                                        </div>
                                    </div> --}}
                                </div>
                                <button type="submit" class="button is-rounded is-primary is-outlined">{{ ucwords(trans_choice('messages.create', 1)) }}</button>
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

