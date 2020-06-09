@extends('layouts.app')

@section('content')

<div class="container">
	
<table id="prices" class="display responsive nowrap" width="100%">
	<thead>
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


@endsection

@section('scripts')
<script type="text/javascript">
	$(document).ready( function () {
		$('#prices').DataTable({
			"pagingType": "full_numbers",
			"order": [[ 0, "asc" ]]
		});
	} );
</script>
@endsection