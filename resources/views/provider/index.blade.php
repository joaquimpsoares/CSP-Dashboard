@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/datatables_bootstrap.css') }}" rel="stylesheet" />
@endsection

@section('content')

<table class="table table-striped table-bordered" id="providers">
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
		@forelse($providers as $provider)
		@if($provider['status'] === 'message.active')
		<tr>
			<td>
				<a href="{{ $provider['path'] }}">{{ $provider['company_name'] }}</a>
			</td>
			<td>
				{{ $provider['country'] }}
				
			</td>
			<td>{{ $provider['state'] }}</td>
			<td>{{ $provider['city'] }}</td>
			<td style="width: 150px">
				 @include('partials.actions', ['model' => $provider, 'modelo' => 'provider'])
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
		$('#providers').DataTable({
			"pagingType": "full_numbers",
			"order": [[ 0, "asc" ]]
		});
	} );
</script>
@endsection