@php
$totalPrice = null;
@endphp

<div class="col-lg-4 mb-4">

	<ul class="nav nav-tabs" id="myTab" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" id="home-tab" data-toggle="tab" href="{{ route('order.place_order', ['token' => $cart->token]) }}" role="tab" aria-controls="home" aria-selected="true">{{ ucwords(trans_choice('messages.place_order', 1)) }}</a>
		</li>
	</ul>


	<div class="card z-depth-0 border border-light rounded-0">

		<div class="card-body">
			<h4 class="mb-4 mt-1 h5 text-center font-weight-bold">Summary</h4>
			<hr>

			@foreach($cart->products as $product)
			<dl class="row">
				<dd class="col-sm-6">
					<small>{{ $product->name }}</small>
				</dd>
				<dd class="col-sm-2">
					<small>{{ $product->pivot->quantity }}</small>
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