@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> 
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

<div class="container">
    
    <div class="box">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.new_product', 2)) }}</a></h4>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="row">
                                <form method="POST" action="{{ route('product.store') }}" class="col s12">
                                    @method('POST')
                                    @csrf    
                                    <form class="col s12">
                                        <div class="row">
                                            <div class="input-field col s4">
                                                
                                                <div class="form-group">
                                                    <div class="single-element-widget">
                                                        <label for="my-select">{{ ucwords(trans_choice('messages.instance', 2)) }}</label>
                                                        <div class="default-select" id="default-select">
                                                            <select>
                                                                @foreach ($instances as $instance)
                                                                <option {{$instance->id}}>{{$instance->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    {{-- <select name="instance_id" class="country_select" id="country_select" style="width: 95%" required>
                                                        @foreach ($instances as $instance)
                                                        <option {{$instance->id}}>{{$instance->name}}</option>
                                                        @endforeach
                                                    </select> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="form1">{{ ucwords(trans_choice('messages.product_vendor', 1)) }}</label>
                                                    <input type="text" id="form1" name="vendor" class="form-control" value="{{old('vendor')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="form1">{{ ucwords(trans_choice('messages.product_sku', 1)) }}</label>
                                                    <input type="text" id="form1" name="sku" class="form-control" value="{{old('sku')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="form1">{{ ucwords(trans_choice('messages.product_name', 1)) }}</label>
                                                    <input type="text" id="form1" name="name" class="form-control" value="{{old('name')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="defaultFormMessageModalEx">{{ ucwords(trans_choice('messages.product_description', 1)) }}</label>
                                                    <textarea type="text" id="defaultFormMessageModalEx" name="description" class="md-textarea form-control">{{old('description')}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="form1">{{ ucwords(trans_choice('messages.addon', 2)) }}</label>
                                                    <input type="text" id="form1"   name="addons"  class="form-control" value="{{old('name')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="form1">{{ ucwords(trans_choice('messages.addon', 2)) }}</label>
                                                    <input type="text" id="form1"   name="addons"  class="form-control" value="{{old('conversion_target_offers')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <label for="defaultFormMessageModalEx">{{ ucwords(trans_choice('messages.product_mininum', 1)) }}</label>  
                                                <div class="def-number-input number-input safari_only">
                                                    <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"></button>
                                                    <input class="quantity" min="0" name="minimum_quantity" value="{{old('minimum_quantity')}}" type="number">
                                                    <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
                                                </div>
                                            </div>
                                            <div class="input-field col s4">
                                                <label for="defaultFormMessageModalEx">{{ ucwords(trans_choice('messages.product_maximum', 1)) }}</label>  
                                                <div class="def-number-input number-input safari_only">
                                                    <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"></button>
                                                    <input class="quantity" min="0" name="maximum_quantity" type="number" value="{{old('maximum_quantity')}}">
                                                    <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <label for="defaultFormMessageModalEx">{{ ucwords(trans_choice('messages.subscription_limit', 1)) }}</label>  
                                                <div class="def-number-input number-input safari_only">
                                                    <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"></button>
                                                    <input class="limit" min="0" name="quantity" value="{{old('limit')}}" type="number">
                                                    <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="form1">{{ ucwords(trans_choice('messages.product_billing_type', 1)) }}</label>
                                                    <input type="text" id="form1"  name="billing"  class="form-control" value="{{old('billing')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="form1">{{ ucwords(trans_choice('messages.product_billing_cycle', 1)) }}</label>
                                                    <input type="text" id="form1"  name="supported_billing_cycles"  class="form-control" value="{{old('supported_billing_cycles')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="limit">{{ ucwords(trans_choice('messages.limit', 1)) }}</label>
                                                    <input type="text" id="form1" name="limit"  class="form-control" value="{{old('limit')}}">
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="form1">{{ ucwords(trans_choice('messages.product_category', 1)) }}</label>
                                                    <input type="text" id="form1" name="category"  class="form-control" value="{{old('category')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <label for="defaultFormMessageModalEx">{{ ucwords(trans_choice('messages.trial', 1)) }}</label>  
                                                <div class="primary-switch">
                                                    <input type="checkbox" id="default-switch">
                                                    <label for="default-switch"></label>
                                                </div>
                                                {{-- <div class="custom-control custom-radio">
                                                    <label class="custom-control-label" for="defaultGroupExample1">no</label>
                                                    <input type="radio" class="custom-control-input" id="defaultGroupExample1" name="groupOfDefaultRadios">
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <label class="custom-control-label" for="defaultGroupExample2">Yes</label>
                                                    <input type="radio" class="custom-control-input" id="defaultGroupExample2" name="groupOfDefaultRadios" checked>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="defaultFormMessageModalEx">{{ ucwords(trans_choice('messages.product_reseller_qualification', 1)) }}</label>
                                                    <input type="text" id="defaultFormMessageModalEx" name="resellee_qualifications"  class="md-textarea form-control" value="{{old('resellee_qualifications')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <button class="button submit_btn right" type="submit">{{ucwords(trans_choice('messages.update', 1))}}</button>
                        </div>
                    </div>	  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')


<script>
    $(document).ready(function() {
        $('.country_select').select2();
    });
</script>

@endsection
