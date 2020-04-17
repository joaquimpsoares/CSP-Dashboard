@extends('layouts.app')

@section('content')

<table class="table table-striped table-bordered" id="priceLists">
	<thead>
		<tr>
			<th>Name</th>
			<th>Description</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		@forelse($priceLists as $priceList)
		
		<tr>
			<td>
				<a href="{{ route('priceList.edit', $priceList['id']) }}">{{ $priceList['name'] }}</a>
			</td>
			<td>
				{{ $priceList['description'] }}
			</td>
			<td>
				<a href="{{ route('priceList.prices', $priceList['id']) }}"><i class="fa fa-list"></i></a>
			</td>
		</tr>
		
		
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