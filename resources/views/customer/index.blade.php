@extends('layouts.app')


@section('content')
<div class="box">
	<section class="section">
		<div class="card">
			<div class="">
				<i class="fas fa-user fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
				{{-- <div class="float-right text-right p-12"> --}}
					
					<div class="card-body">
						<h4 class="card-title"><a>Customer Table</a></h4>
						<table class="table table-striped table-bordered" id="customers">
							<thead>
								<tr>
									<th>Company Name</th>
									<th>County</th>
									<th>State</th>
									<th>City</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@forelse($customers as $customer)
								@if($customer['status'] === 'message.active')
								<tr>
									<td>
										<a href="{{ $customer['path'] }}">{{ $customer['company_name'] }}</a>
									</td>
									<td>{{ $customer['country'] }}</td>
									<td>{{ $customer['state'] }}</td>
									<td>{{ $customer['city'] }}</td>
									<td style="width: 150px">
										@include('partials.actions', ['model' => $customer, 'modelo' => 'customer'])
									</td>
								</tr>
								@endif
								@empty
								<tr>
									<td colspan="5">Empty</td>
								</tr>
								@endforelse
							</tbody>
						</table>
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
		
