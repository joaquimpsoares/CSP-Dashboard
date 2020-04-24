@extends('layouts.app')


@section('content')
<div class="box">
	<section class="section">
		<div class="card">
			<div class="">
				<i class="fab fa-product-hunt fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
				<div class="card-body">
					<h4 class="card-title"><a>Products Table</a></h4>
					<table class="table table-striped table-bordered" id="resellers">
						<thead>
							<th>{{ ucwords(trans_choice('messages.product_sku', 2)) }}</th>
							<th>{{ ucwords(trans_choice('messages.product_name', 2)) }}</th>
							<th class="text-center">{{ ucwords(trans_choice('messages.vendor', 1)) }}</th>
							<th class="text-center">{{ ucwords(trans_choice('messages.price', 1)) }}</th>
							<th class="text-center">{{ ucwords(trans_choice('messages.action', 2)) }}</th>
						</thead>
						<tbody>
							@forelse($products as $product)
							<tr>
								<td style="width: 1px; white-space: nowrap;">
									{{$product['sku']}}
								</td>
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
		</div>
	</section>
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
<script type="text/javascript">
	$(document).ready( function () {
		$('#resellers').DataTable({
			"pagingType": "full_numbers",
			"order": [[ 0, "asc" ]]
		});
	} );
</script>
@endsection

