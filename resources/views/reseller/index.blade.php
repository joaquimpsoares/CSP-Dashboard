@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/datatables_bootstrap.css') }}" rel="stylesheet" />
@endsection

@section('content')

<table class="table table-striped table-bordered" id="resellers">
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
		@forelse($resellers as $reseller)
		@if($reseller['status'] === 'message.active')
		<tr>
			<td>
				<a href="{{ $reseller['path'] }}">{{ $reseller['company_name'] }}</a>
			</td>
			<td>
				{{ $reseller['country'] }}
				
			</td>
			<td>{{ $reseller['state'] }}</td>
			<td>{{ $reseller['city'] }}</td>
			<td style="width: 150px">
				@include('partials.actions', ['model' => $reseller, 'modelo' => 'reseller'])
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
		$('#resellers').DataTable({
			"pagingType": "full_numbers",
			"order": [[ 0, "asc" ]]
		});
	} );
</script>
@endsection