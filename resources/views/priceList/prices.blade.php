@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>


<div class="container">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title"><a>Price List Table</a></h4>
			<table class="table table-hover responsive" id="example">
				<thead class="thead-dark">
					<tr>
						<th>{{ ucwords(trans_choice('messages.product_sku', 1)) }}</th>
						<th>{{ ucwords(trans_choice('messages.product_name', 1)) }}</th>
						<th>{{ ucwords(trans_choice('messages.price', 1)) }}</th>
						<th>{{ ucwords(trans_choice('messages.msrp' ,1)) }}</th>
						<th>{{ ucwords(trans_choice('messages.action', 2)) }}</th>
					</tr>
				</thead>
				<tbody>
					@forelse($prices as $price)
					
					<tr>
						<td>{{ $price['product_sku'] }}</td>
						<td>{{ $price['name'] }}</td>
						<td>{{ $price['price'] }}</td>
						<td>{{ $price['msrp'] }}</td>
						<td></td>
					</tr>
					@empty
					<tr>
						<td colspan="5">Empty</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>




<script type="text/javascript">
	$(document).ready(function (){   
		var table = $('#example').DataTable({
			dom: 'Bfrtip',
			buttons: [
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


@endsection
