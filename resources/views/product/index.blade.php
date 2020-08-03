@extends('layouts.app')

@section('content')

<div class="container">
	<section class="section">
		<div class="card bd-callout-info">
			<div class="card-body">
				<div class="md-form">
					<div style="display: flex;">
						<div style="flex-grow: 31;">
						</div>
						<div>
							<a type="submit" href="{{route('product.create')}}" class="btn submit_btn">{{ ucwords(__('messages.new_product')) }}</a>
						</div>
					</div>
				</div>
				<div class="card-body">

					<h4 class="card-title"><a>{{ ucwords(trans_choice('messages.product_table', 2)) }}</a></h4>
					<div class="container col-xm-12">
						<section class="dark-grey-text">
							<table class="table table-hover responsive" id="product">
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
						</section>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>

@endsection


@section('scripts')



<script type="text/javascript">
	$(document).ready( function () {
		$('#product').DataTable({
			"pagingType": "full_numbers",
			"order": [[ 0, "desc" ]]
		});
	} );
</script>


@endsection
