@extends('layouts.app')


@section('content')

<div class="row table-responsive">
	<div class="col-12">
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
	{{-- <div class="col-md-10">
		<div class="row">
			<div class="col-3">
				<form method="GET" action="{{ route('products.index') }}" style="padding-top: 15px;">
					@if (isset($filters['name']))
					<input type="hidden" name="name" value="{{ $filters['name']}}" />
					@endif
					@if (isset($filters['vendor']))
					<input type="hidden" name="vendor" value="{{ $filters['vendor']}}" />
					@endif
					<div class="input-group mb-3">
						<select name="quantity" class="custom-select " id="quantity">
							<option {{ (!isset($filters['quantity'])) ? 'selected' : ( isset($filters['quantity']) && $filters['quantity'] === '12' ) ? 'selected' : ''  }}>12</option>
							<option {{ ( isset($filters['quantity']) && $filters['quantity'] === '24' ) ? 'selected' : '' }}>24</option>
							<option {{ ( isset($filters['quantity']) && $filters['quantity'] === '36' ) ? 'selected' : '' }}>36</option>
						</select>
						<div class="input-group-append">
							<button class="input-group-text" type="submit" for="quantity">{{ ucwords(__('messages.apply_filter')) }}</button>
						</div>
					</div>
					
					<input type="hidden" name="search" value="1" />
					
				</form>
			</div>
		</div>
		@php
		$cont=0
		@endphp
		<div class="row">
			@foreach($products as $product)
			<div class="col-sm-12 col-md-3" style="padding-top: 20px;">
				<div class="card" style="min-height: 230px;">
					<div class="card-body text-center">
						<div class="row mx-auto justify-content-center">
							<img src="{{ asset('images/vendors/' . $product->vendor . '.png') }}"  title="{{ $product->name }}" class="img-fuid" style="max-width: 120px;max-height: 120px;" />
						</div>
						<div class="row mx-auto justify-content-center" style="padding-top: 20px;">
							@if(strlen($product->name) <= 40)
							<div class="col-12" >&nbsp;</div>
							@endif
							<strong>{{ $product->name }}</strong>
							@if(strlen($product->name) <= 40 || strlen($product->name) < 70)
							<div class="col-12" >&nbsp;</div>
							@endif
							
						</div>
					</div>
					<div class="card-footer text-muted text-center">
						<div class="row">
							<div class="col-6">
								
								<a class="btn btn-outline-dark" data-toggle="modal" data-target="#modal_product_{{$product->id}}">+ {{ $product->addons->count() }} {{ ucwords(trans_choice('messages.addon', 2)) }}</a>
							</div>
							<div class="col-6">
								<a href="{{ route('cart.add_product', $product->id) }}" class="btn btn-outline-success">{{ ucwords(__('messages.add_to_cart')) }}</a>
							</div>
						</div>
					</div>
					
					
					
					<!-- Modal -->
					<div class="modal fade" id="modal_product_{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">{{ $product->name }} - {{ ucwords(trans_choice('messages.addon', 2)) }}</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<table class="table table-striped">
										@foreach($product->getAddons() as $addon)
										<tr>
											<td class="align-middle"><small>{{ $addon->name }}</small></td>
											<td><button class="btn btn-sm btn-info"><i class="fa fa-plus"></i>{{ ucwords(__('messages.add')) }}</button></td>
										</tr>
										@endforeach
									</table>
									
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
					
					
					
				</div>
			</div>
			@php
			$cont++
			@endphp
			@if($cont === 4)
			@php
			$cont=0
			@endphp
		</div>
		<div class="row" >
			@endif
			@endforeach
		</div>
		<hr/>
		<div class="row">
			<div class="col">
				<span class="float-right">
					@include('partials.paginator', ['paginator' => $products])
				</span>
			</div>
		</div>
	</div> --}}
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

