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
