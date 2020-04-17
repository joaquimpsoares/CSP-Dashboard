@extends('layouts.app')


@section('content')

<div class="row table-responsive">
	<div class="col-12">
		<table class="table" id="products">
			<thead>
				<th>{{ ucwords(trans_choice('messages.product_name', 2)) }}</th>
				<th class="text-center">{{ ucwords(trans_choice('messages.vendor', 1)) }}</th>
				<th class="text-center">{{ ucwords(trans_choice('messages.price', 1)) }}</th>
				<th class="text-center">{{ ucwords(trans_choice('messages.action', 2)) }}</th>
			</thead>
			<tbody>
				@forelse($products as $product)
				<tr>
					<td style="width: 1px; white-space: nowrap;">
						{{$product['name']}}
					</td>
					<td class="text-center">
						{{$product['vendor']}}
					</td>
					<td class="text-center">
						{{$product['price']['price'] ?? '-'}}
					</td>
					<td>
					</td>
				</tr>
				@empty
				<tr>
					<td></td>
				</tr>
				@endforelse
			</tbody>
		</table>
	</div>
</div>
<div class="row">
	<div class="col">
		<span class="float-right">
			@include('partials.paginator', ['paginator' => $products])
		</span>
	</div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">
	$(document).ready( function () {
		$('#products').DataTable({
			"paging": false,
			"ordering": false,
			"search": false,
			"info": false
		});
	} );

</script>
@endsection

