@extends('layouts.app')


@section('content')

<h1>Current Tasks</h1>

<table class="table table-striped table-bordered" id="customers">
	<thead>
		<tr>
			<th>id</th>
			<th>Queue Name</th>
			<th>Payload</th>
			<th>Attemps</th>
			<th>Reserved At</th>
		</tr>
	</thead>
	<tbody>
		@forelse($jobs as $job)
		{{-- @if($customer->status->name === 'message.active') --}}
		<tr>
			<td>
				<a href="·">{{ $job->id }}</a>
			</td>
			<td>{{ $job->queue }}</td>
			<td>{{ $job->payload }}</td>
            <td>{{ $job->attempts }}</td>
            <td>{{ date('d, m , Y', strtotime($job->reserved_at))}}</td>
			{{-- <td style="width: 150px">
				@include('partials.actions', ['model' => $jo, 'modelo' => 'customer'])
			</td> --}}
		</tr>
		{{-- @endif --}}
		@empty
		<tr>
			<td colspan="5">Empty</td>
		</tr>
		@endforelse
	</tbody>
</table>

<h1>Failed Tasks</h1>

<table class="table table-striped table-bordered" id="customers">
	<thead>
		<tr>
			<th>id</th>
			<th>Queue Name</th>
			<th>Payload</th>
			<th>Attemps</th>
			{{-- <th>Actions</th> --}}
		</tr>
	</thead>
	<tbody>
		@forelse($failedJobs as $failedJob)
		{{-- @if($customer->status->name === 'message.active') --}}
		<tr>
			<td>
				<a href="·">{{ $job->id }}</a>
			</td>
			<td>{{ $failedJob->queue }}</td>
			<td>{{ $failedJob->payload }}</td>
			<td>{{ $failedJob->attempts }}</td>
			{{-- <td style="width: 150px">
				@include('partials.actions', ['model' => $jo, 'modelo' => 'customer'])
			</td> --}}
		</tr>
		{{-- @endif --}}
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

