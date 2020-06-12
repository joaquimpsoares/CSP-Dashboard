@extends('layouts.app')



@section('content')

<div class="container">
	<section class="section">
		<div class="card">
			<div class="card-body">
				@if(Auth::user()->userLevel->id === 4)
				<div class="md-form">
					<div style="display: flex;">
						<div style="flex-grow: 31;">
						</div>
						<div>
							<a type="submit" href="{{route('customer.create')}}" class="btn submit_btn">{{ ucwords(__('messages.new_customer')) }}</a>
						</div>
					</div>
					@endif
					<h4 class="card-title"><a>{{ ucwords(trans_choice('messages.customer_table', 1)) }}</a></h4>
					@include('customer.partials.table', ['customers' => $customers])
				</div>
			</div>
		</div>
	</section>
</div>


@endsection


@section('scripts')
<script type="text/javascript">
	$(document).ready( function () {
		$('#customers').DataTable({
			"pagingType": "full_numbers",
			"order": [[ 0, "asc" ]]
		});
	} );
</script>
@endsection

