$(function(e) {
    //file export datatable
    var table = $('#example').DataTable({
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf'],
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ ',
        },
        columnDefs: [ {
            orderable: true,
        } ],
        select: {
            style:    'os',
            selector: 'td:first-child'
        }

    });

    table.buttons().container()
    .appendTo('#example_wrapper .col-md-6:eq(0)');

    $('#example1').DataTable({
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_',
        }
    });


    $('#tagydes_table_buttons').DataTable({
        responsive: true,
        lengthChange: false,
        dom: 'Blfrtip',
        buttons: [
            'copy', 'excel', 'pdf'
        ],
        select: {
            style:    'os',
            selector: 'td:first-child'
        }
    }).columns.adjust().responsive.recalc();


    $('#tagydes_table').DataTable({
        responsive: true,
        dom: 'Blfrtip'
    }).columns.adjust().responsive.recalc();

    $('#example2').DataTable({
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_',
        }
    });
    var table = $('#example-delete').DataTable({
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_',
        }
    });
    $('#example-delete tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );

    $('#button').click( function () {
        table.row('.selected').remove().draw( false );
    } );

    //Details display datatable
    $('#example-1').DataTable( {
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_',
        },
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                        return 'Details for '+data[0]+' '+data[1];
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                    tableClass: 'table border mb-0'
                } )
            }
        }
    });

} );
