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


<ul class="nav nav-pills md-tabs" id="myTabMD" role="tablist">
    <li class="nav-item">
        <a class="nav-link btn rgba-blue-light active" id="home-tab-md" data-toggle="tab" href="#home-md" role="tab" aria-controls="home-md"
        aria-selected="true">{{ ucwords(trans_choice('messages.home', 1)) }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link btn rgba-blue-light" id="contact-tab-md" data-toggle="tab" href="#contact-md" role="tab" aria-controls="contact-md"
        aria-selected="false">{{ ucwords(trans_choice('messages.price_list', 1)) }}</a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link btn rgba-blue-light" id="profile-tab-md" data-toggle="tab" href="#profile-md" role="tab" aria-controls="profile-md"
        aria-selected="false">{{ ucwords(trans_choice('messages.account', 1)) }}</a>
    </li> --}}
</ul>
<div class="tab-content pt-5" id="myTabContentMD">
    <div class="tab-pane fade show active" id="home-md" role="tabpanel" aria-labelledby="home-tab-md">

        @include('priceList.partials.details')

    </div>
    <div class="tab-pane fade" id="contact-md" role="tabpanel" aria-labelledby="contact-tab-md">
        @include('priceList.partials.pricetable')
    </div>
    <div class="tab-pane fade" id="profile-md" role="tabpanel" aria-labelledby="profile-tab-md">
    </div>
</div>



{{-- <script>
    //redirect to specific tab
    $(document).ready(function () {
        $('#tabMenu a[href="#{{ old('tab') }}"]').tab('show')
    });
</script>




<script type="text/javascript">
    $(document).ready(function (){
        var table = $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
            {
                text: 'Import',
                action: function ( e, dt, node, config ) {
                    alert( 'Button activated' );
                }
            },
            {
                text: 'Clone',
                action: function ( e, dt, node, config ) {
                    alert( 'Button activated' );
                }
            },
            {
                text: 'Delete',
                action: function ( e, dt, node, config ) {
                    alert( 'Button activated' );
                }
            }
            ],
            'columnDefs': [{
                'targets': 0,
                'searchable':false,
                'orderable':false,
                'className': 'dt-body-center',
                'render': function (data, type, full, meta){
                    return '<input type="checkbox" name="id[]" value="'
                    + $('<div/>').text(data).html() + '">';

                }

            }],
            'order': [2, 'asc']
        });

        // Handle click on "Select all" control
        $('#example-select-all').on('click', function(){
            // Check/uncheck all checkboxes in the table
            var rows = table.rows({ 'search': 'applied' }).nodes();
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });

        // Handle click on checkbox to set state of "Select all" control
        $('#example tbody').on('change', 'input[type="checkbox"]', function(){
            // If checkbox is not checked
            if(!this.checked){
                var el = $('#example-select-all').get(0);
                // If "Select all" control is checked and has 'indeterminate' property
                if(el && el.checked && ('indeterminate' in el)){
                    // Set visual state of "Select all" control
                    // as 'indeterminate'
                    el.indeterminate = true;
                }
            }
        });

        $('#frm-example').on('submit', function(e){
            var form = this;
            // Iterate over all checkboxes in the table
            table.$('input[type="checkbox"]').each(function(){
                // If checkbox doesn't exist in DOM
                if(!$.contains(document, this)){
                    // If checkbox is checked
                    if(this.checked){
                        // Create a hidden element
                        $(form).append(
                        $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', this.name)
                        .val(this.value)
                        );
                    }
                }
            });

            // FOR TESTING ONLY

            // Output form data to a console
            $('#example-console').text($(form).serialize());
            console.log("Form submission", $(form).serialize());

            // Prevent actual form submission
            e.preventDefault();
        });
    });
</script>
--}}

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
