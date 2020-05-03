@php
//dd($cart);
$totalPrice = null;
@endphp
<div class="col-lg-4 mb-4">

	<a href="{{ route('store.place_order') }}" class="btn btn-primary btn-lg btn-block">Place order</a>

	<div class="card z-depth-0 border border-light rounded-0">

		<div class="card-body">
			<h4 class="mb-4 mt-1 h5 text-center font-weight-bold">Summary</h4>
			<hr>

			@foreach($cart->products as $product)
			<dl class="row">
				<dd class="col-sm-8">
					{{ $product->name }}
				</dd>
				<dd class="col-sm-4">
					@php
					$price = floatval($product->pivot->retail_price * $product->pivot->quantity);
					echo "$ " . number_format($price, 2);
					
					$totalPrice+=$price;
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