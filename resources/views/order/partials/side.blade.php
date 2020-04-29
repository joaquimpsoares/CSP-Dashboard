@php
$products = Session::get('cart')->items;
$totalPrice = 0;
@endphp
<div class="col-lg-4 mb-4">

	<a href="{{ route('store.place_order') }}" class="btn btn-primary btn-lg btn-block">Place order</a>

	<div class="card z-depth-0 border border-light rounded-0">

		<div class="card-body">
			<h4 class="mb-4 mt-1 h5 text-center font-weight-bold">Summary</h4>
			<hr>

			@foreach($products as $product)
			<dl class="row">
				<dd class="col-sm-8">
					{{ $product['item']->name }}
				</dd>
				<dd class="col-sm-4">
					@php
					$price = number_format(floatval($product['price']->msrp * $product['quantity']), 2);
					echo "$ " . $price;
					$totalPrice+= $price;
					@endphp
					
				</dd>
			</dl>
			<hr>
			@endforeach

			

			<dl class="row">
				<dt class="col-sm-8">
					Total
				</dt>
				<dt class="col-sm-4">
					$ {{ number_format(floatval($totalPrice), 2) }}
				</dt>
			</dl>
		</div>

	</div>

</div>