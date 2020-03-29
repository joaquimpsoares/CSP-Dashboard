@extends('layouts.app')


@section('content')

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
		@if($customer->status->name === 'message.active')
		<tr>
			<td>
				<a href="{{ $customer->path() }}">{{ $customer->company_name }}</a>
			</td>
			<td>{{ $customer->country->name }}</td>
			<td>{{ $customer->state }}</td>
			<td>{{ $customer->city }}</td>
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

