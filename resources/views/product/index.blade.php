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
