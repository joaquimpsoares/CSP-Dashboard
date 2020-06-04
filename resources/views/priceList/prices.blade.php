@extends('layouts.app')

@section('content')

<table class="table table-striped table-bordered" id="prices">
	<thead>
		<tr>
			<th>{{ ucwords(__('messages.product_sku')) }}</th>
			<th>{{ ucwords(__('messages.product_name')) }}</th>
			<th>{{ ucwords(trans_choice('messages.price', 1)) }}</th>
			<th>{{ ucwords(__('messages.msrp')) }}</th>
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