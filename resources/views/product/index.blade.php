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
        <h4 class="page-title">{{ ucwords(trans_choice('messages.new_provider', 1)) }}</h4>
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
@section('content')

<section class="section">
    <div class="card bd-callout-info">

        <div>
            <a type="submit" href="{{route('product.create')}}" class="btn submit_btn">{{ ucwords(__('messages.new_product')) }}</a>
        </div>
        <div class="card-body">
            <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.product_table', 2)) }}</a></h4>
            <div class="table-responsive">

                <table id="example" class="table table-bordered text-nowrap key-buttons">
                    <thead class="thead-dark">
                        <th class="th-sm">{{ ucwords(trans_choice('messages.product_sku', 2)) }}</th>
                        <th class="th-sm">{{ ucwords(trans_choice('messages.product_name', 2)) }}</th>
                        <th class="th-sm">{{ ucwords(trans_choice('messages.category', 2)) }}</th>
                        <th class="th-sm">{{ ucwords(trans_choice('messages.vendor', 1)) }}</th>
                        <th class="th-sm">{{ ucwords(trans_choice('messages.instance', 1)) }}</th>
                        <th class="th-sm">{{ ucwords(trans_choice('messages.action', 2)) }}</th>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td style="width: 1px;"><a  href="{{ route('product.edit' ,$product->id) }}">{{$product->sku}}</a></td>
                            <td >{{$product->name}}</td>
                            <td style="width: 1px; ; white-space: nowrap;">{{$product->category}}</td>
                            <td class="text-center">{{$product->vendor}}</td>
                            <td class="text-center">{{$product->instance->name}}</td>
                            <td>Actions</td>
                        </tr>
                        @empty
                        <tr>
                            <td>Empty</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>


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
