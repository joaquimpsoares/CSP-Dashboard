@extends('layouts.app')

@section('content')

<div class="box">
	<section class="section">
		<div class="card">
			<div class="">
				<i class="fas fa-money-check-alt fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
				<div class="card-body">
					<h4 class="card-title"><a>Price List Table</a></h4>
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
									<a href="#">{{ $priceList['name'] }}</a>
								</td>
								<td>
									{{ $priceList['description'] }}
								</td>
								<td>
									<a href="{#"><i class="fa fa-list"></i></a>
								</td>
							</tr>
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
	</section>
</div>

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