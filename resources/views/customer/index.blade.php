@extends('layouts.app')



@section('content')

<div class="container">
	<section class="section">
		<div class="card">
			<div class="">
				<i class="fas fa-user fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
				<div class="float-right">
					<a type="submit" class="btn btn-success">{{ ucwords(__('messages.new_customer')) }}</a>
				</div>
				<div class="card-body">
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

