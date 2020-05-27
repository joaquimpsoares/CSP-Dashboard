@extends('layouts.app')

@section('styles')
@endsection

@section('content')
<div class="box">
	<section class="section">
		<div class="card">
			<div class="">
				<i class="fas fa-file-invoice-dollar fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
				<div class="card-body">
                    <h4 class="card-title">{{ ucwords(trans_choice('messages.subscription_table', 2)) }} </h4>
					@include('subscriptions.partials.table', ['subscriptions' => $subscriptions])
				</div>
			</div>
		</div>
	</section>
</div>	
@endsection

@section('scripts')

<script>
	$(document).ready(function () {
		$('#dtBasicExample').DataTable();
		$('.dataTables_length').addClass('bs-select');
	});
</script>