@extends('layouts.master')
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">{{ ucwords(trans_choice('messages.provider_table', 1)) }}</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#" class="d-flex"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/><path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/></svg><span class="breadcrumb-icon"> Home</span></a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item"><a href="#">Blog</a></li>
            <li class="breadcrumb-item active" aria-current="page">Blog 01</li>
        </ol>
    </div>
</div>
<!--End Page header-->
@endsection

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
                    <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.product_card', 2)) }}</a></h4>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="row">
                                <form class="col s12">
                                    <div class="row">
                                        <form method="POST" action="{{ route('product.update', $product) }}" class="col s12">
                                            @method('PATCH')
                                            @csrf
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="form1">{{ ucwords(trans_choice('messages.instance_id', 1)) }}</label>
                                                    <input type="text" name="instance_id" id="form1" class="form-control" value="{{$product->instance->id}}">
                                                </div>
                                            </div>
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="instance_name">{{ ucwords(trans_choice('messages.instance_name', 1)) }}</label>
                                                    <input type="text"i name="instance_name" id="instance_name" class="form-control" value="{{$product->instance->name}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="form1">{{ ucwords(trans_choice('messages.product_vendor', 1)) }}</label>
                                                    <input type="text" id="form1" name="vendor" class="form-control" value="{{$product->vendor}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="form1">{{ ucwords(trans_choice('messages.product_sku', 1)) }}</label>
                                                    <input type="text" id="form1" name="sku" class="form-control" value="{{$product->sku}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="form1">{{ ucwords(trans_choice('messages.product_name', 1)) }}</label>
                                                    <input type="text" id="form1" name="name" class="form-control" value="{{$product->name}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="defaultFormMessageModalEx">{{ ucwords(trans_choice('messages.product_description', 1)) }}</label>
                                                    <textarea type="text" id="defaultFormMessageModalEx" name="description" class="md-textarea form-control">{{$product->description}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="form1">{{ ucwords(trans_choice('messages.product_category', 1)) }}</label>
                                                    <input type="text" id="form1" name="category"  class="form-control" value="{{$product->category}}">
                                                </div>
                                            </div>
                                        </div>
                                        @if ($product->addons != "[]")
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="form1">{{ ucwords(trans_choice('messages.addon', 2)) }}</label>
                                                    @foreach ($addons as $item)
                                                    <input type="text" id="form1"   name="addons"  class="form-control" value="{{$item->name}}">
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="form1">{{ ucwords(trans_choice('messages.addon', 2)) }}</label>
                                                    <input type="text" id="form1"   name="addons"  class="form-control" value="{{$product->conversion_target_offers}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <label for="defaultFormMessageModalEx">{{ ucwords(trans_choice('messages.product_mininum', 1)) }}</label>
                                                <div class="def-number-input number-input safari_only">
                                                    <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"></button>
                                                    <input class="quantity" min="0" name="minimum_quantity" value="{{$product->minimum_quantity}}" type="number">
                                                    <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
                                                </div>
                                            </div>
                                            <div class="input-field col s4">
                                                <label for="defaultFormMessageModalEx">{{ ucwords(trans_choice('messages.product_maximum', 1)) }}</label>
                                                <div class="def-number-input number-input safari_only">
                                                    <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"></button>
                                                    <input class="quantity" min="0" name="maximum_quantity" type="number" value="{{$product->maximum_quantity}}">
                                                    <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($product->limit > 0)
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <label for="defaultFormMessageModalEx">{{ ucwords(trans_choice('messages.subscription_limit', 1)) }}</label>
                                                <div class="def-number-input number-input safari_only">
                                                    <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"></button>
                                                    <input class="quantity" min="0" name="quantity" value="{{$product->limit}}" type="number">
                                                    <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="form1">{{ ucwords(trans_choice('messages.product_billing_type', 1)) }}</label>
                                                    <input type="text" id="form1"  name="billing"  class="form-control" value="{{$product->billing}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="form1">{{ ucwords(trans_choice('messages.product_billing_cycle', 1)) }}</label>
                                                    <input type="text" id="form1"  name="supported_billing_cycles"  class="form-control" value="{{$product->supported_billing_cycles}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="limit">{{ ucwords(trans_choice('messages.limit', 1)) }}</label>
                                                    <input type="text" id="form1" name="limit"  class="form-control" value="{{$product->limit}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="input-field col s4">
                                                <label for="defaultFormMessageModalEx">{{ ucwords(trans_choice('messages.trial', 1)) }}</label>
                                                <div class="custom-control custom-radio">
                                                    <label class="custom-control-label" for="defaultGroupExample1">no</label>
                                                    <input type="radio" class="custom-control-input" id="defaultGroupExample1" name="groupOfDefaultRadios">
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <label class="custom-control-label" for="defaultGroupExample2">Yes</label>
                                                    <input type="radio" class="custom-control-input" id="defaultGroupExample2" name="groupOfDefaultRadios" checked>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <div class="md-form">
                                                    <label for="defaultFormMessageModalEx">{{ ucwords(trans_choice('messages.product_reseller_qualification', 1)) }}</label>
                                                    <input type="text" id="defaultFormMessageModalEx" name="resellee_qualifications"  class="md-textarea form-control" value="{{$product->resellee_qualifications}}">
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection


@section('js')
<!-- Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/js/datatables.js')}}"></script>
<!-- Select2 js -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
@endsection
