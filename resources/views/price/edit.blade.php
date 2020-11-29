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

<div class="container mt-5">
    <livewire:price.editprice :price="$price"/>
</div>

@endsection

{{-- @section('scripts')
<script>
    .form-group.is-invalid {
        .invalid-feedback {
            display: block;
        }
    }
</script>

<script>
    function toggle(ele) {
        var cont = document.getElementById('cont');
        if (cont.style.display == 'block') {
            cont.style.display = 'none';

            document.getElementById(ele.id).value = 'Show DIV';
        }
        else {
            cont.style.display = 'block';
            document.getElementById(ele.id).value = 'Hide DIV';
        }
    }
</script>

<script>
    $('.addrow').on('click', function(){
        addRow();
    })

    function addRow(){
        var tr =
        '<tr>'+
            '<td><input name="tier_name[]" type="text" class="form-control" id="tier_name" placeholder="" value="{{ $tier->name }}" required></td>'+
            '<td><input name="product_sku[]" type="text" class="form-control" id="product_sku" placeholder="" value="{{ $tier->product_sku }}" required></td>'+
            '<td><input name="min_quantity[]" type="number" class="form-control" id="min_quantity" placeholder="" value="{{ $tier->min_quantity }}" required></td>'+
            '<td><input name="max_quantity[]" type="number" class="form-control" id="max_quantity" placeholder="" value="{{ $tier->max_quantity }}" required></td>'+
            '<td><input name="price[]" type="number" class="form-control" id="price" placeholder="" value="{{ $tier->price }}" required></td>'+
            '<td><a href="" class="btn btn-danger remove">-</a></td>'+
            '</tr>';
            $('tbody').append(tr);
        };
        $('tbody').on('click', '.remove', function (){
            $(this).parent().parent().remove();
        });


    </script>

    @endsection
     --}}
