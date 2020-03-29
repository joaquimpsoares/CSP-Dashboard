
<table class="table table-borderless" id="products">
	<thead>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</thead>
	<tbody>
		<tr>

			@php
			$i = 0;
			@endphp
			@foreach($products as $product)

			@if ($i === 4)
		</tr>
		<tr>
			@php
			$i = 0;
			@endphp
			@endif

			<td class="text-center" align="center">
				<div class="card" style="min-height: 190px;">
					<div class="card-body">
						<div class="row mx-auto justify-content-center">
							<img src="{{ asset('images/vendors/' . $product->vendor . '.png') }}"  title="{{ $product->name }}" class="img-fuid" style="max-width: 120px;max-height: 120px;" />
						</div>
						<div class="row mx-auto justify-content-center" style="padding-top: 15px;">
							{{ $product->name }}
						</div>
					</div>
					<div class="card-footer text-muted">
						<button type="submit" class="btn btn-success">{{ ucwords(__('messages.add_to_cart')) }}</button>
					</div>
				</div>
			</td>

			@php
			$i++;
			@endphp
			@endforeach

			@if($i !== 4)
			@for($j=1; $j <= (4-$i); $j++)
			<td>&nbsp</td>
			@endfor
			@endif
		</tr>


	</tbody>
</table>