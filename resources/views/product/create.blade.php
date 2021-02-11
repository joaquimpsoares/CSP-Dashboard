@extends('layouts.master')
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection
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
                                                            <select name="instance_id">
                                                                @foreach ($instances as  $instance)
                                                                <option value="{{$instance->id}}">{{$instance->name}}</option>
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
                                                    {{-- <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"></button> --}}
                                                    <input class="quantity" min="0" name="minimum_quantity" value="{{old('minimum_quantity')}}" type="number">
                                                    {{-- <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button> --}}
                                                </div>
                                            </div>
                                            <div class="input-field col s4">
                                                <label for="defaultFormMessageModalEx">{{ ucwords(trans_choice('messages.product_maximum', 1)) }}</label>
                                                <div class="def-number-input number-input safari_only">
                                                    {{-- <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"></button> --}}
                                                    <input class="quantity" min="0" name="maximum_quantity" type="number" value="{{old('maximum_quantity')}}">
                                                    {{-- <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s4">
                                                <label for="defaultFormMessageModalEx">{{ ucwords(trans_choice('messages.subscription_limit', 1)) }}</label>
                                                <div class="def-number-input number-input safari_only">
                                                    {{-- <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"></button> --}}
                                                    <input class="limit" min="0" name="quantity" value="{{old('limit')}}" type="number">
                                                    {{-- <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button> --}}
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
