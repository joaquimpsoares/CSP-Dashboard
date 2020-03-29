@extends('layouts.app')


@section('content')

@include('partials.messages')

<div class="row">
	<div class="col-2"></div>
	<div class="col-10">
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
						<div class="card" style="min-height: 300px;">
							<div class="card-body">
								<div class="row mx-auto justify-content-center">
									<img src="{{ asset('images/vendors/' . $product->vendor . '.png') }}"  title="{{ $product->name }}" class="img-fuid" style="max-width: 120px;max-height: 120px;" />
								</div>
								<div class="row mx-auto justify-content-center" style="padding-top: 20px;">
									{{ $product->name }}
									<p class="text-muted" style="padding-top: 10px;"><small>{{ Str::limit($product->description, 100) }}...</small></p>
								</div>
							</div>
							<div class="card-footer text-muted">
								<button type="submit" class="btn btn-outline-success">{{ ucwords(__('messages.add_to_cart')) }}</button>
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
	</div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">
	$(document).ready( function () {
		$('#products').DataTable({
			"pagingType": "full_numbers",
			"ordering": false
		});
	} );
</script>
@endsection

