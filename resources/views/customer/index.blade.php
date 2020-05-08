@extends('layouts.app')



@section('content')
	<div class="bc-icons-2">
	
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb indigo lighten-4">
			<li class="breadcrumb-item"><a class="black-text" href="#">Home</a><i class="fas fa-caret-right mx-2"
				aria-hidden="true"></i></li>
			<li class="breadcrumb-item"><a class="black-text" href="#">Library</a><i class="fas fa-caret-right mx-2"
				aria-hidden="true"></i></li>
			<li class="breadcrumb-item active">Data</li>
		  </ol>
		</nav>
	</div>
<div class="box">
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

