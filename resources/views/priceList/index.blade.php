@extends('layouts.app')

@section('content')

<div class="container">
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
								<th>Company Name</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@forelse($priceLists as $priceList)
							<tr>
								<td><a href=" {{route('priceList.prices', $priceList['id'])}} ">{{ $priceList['name'] }}</a></td>
								<td>{{ $priceList['description'] }}</td>
								<td>{{$priceList['providers'][0]['company_name']}}</td>
								<td>
									<a href="{{route('priceList.clone', $priceList['id'])}}"><i class="fa fa-clone"></i></a>
									<a href="{{route('priceList.prices', $priceList['id'])}}"><i class="fa fa-list"></i></a>
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
<script>
	$(document).ready(function() {
		$('#priceLists').DataTable();
	} );
</script>

@endsection