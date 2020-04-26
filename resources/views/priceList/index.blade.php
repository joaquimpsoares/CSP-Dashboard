@extends('layouts.app')

@section('content')


<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
	<li class="nav-item">
	  <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
		aria-controls="pills-home" aria-selected="true">Price List</a>
	</li>
	<li class="nav-item">
	  <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
		aria-controls="pills-profile" aria-selected="false">Product</a>
	</li>
	<li class="nav-item">
	  <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab"
		aria-controls="pills-contact" aria-selected="false">Contact</a>
	</li>
  </ul>
  <div class="tab-content pt-2 pl-1" id="pills-tabContent">
	<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"><div class="box">
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
	</div></div>
	<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
		<table class="table table-striped table-bordered" id="prices">
			<thead>
				<tr>
					<th>{{ ucwords(__('messages.product_sku')) }}</th>
					<th>{{ ucwords(__('messages.product_name')) }}</th>
					<th>{{ ucwords(trans_choice('messages.price', 1)) }}</th>
					<th>{{ ucwords(__('messages.msrp')) }}</th>
					<th>{{ ucwords(trans_choice('messages.action', 2)) }}</th>
				</tr>
			</thead>
			<tbody>
				@forelse($prices as $price)
				<tr>
					<td>
						{{ $price['product_sku'] }}
					</td>
					<td>
						{{ $price['name'] }}
					</td>
					<td>
						{{ $price['price'] }}
					</td>
					<td>
						{{ $price['msrp'] }}
					</td>
					<td></td>
				</tr>
				@empty
				<tr>
					<td colspan="5">Empty</td>
				</tr>
				@endforelse
			</tbody>
		</table>
		
	</div>
	<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">Est
	  quis nulla laborum officia ad nisi ex nostrud culpa Lorem excepteur aliquip dolor aliqua irure ex.
	  Nulla ut duis ipsum nisi elit fugiat commodo sunt reprehenderit laborum veniam eu veniam. Eiusmod minim
	  exercitation fugiat irure ex labore incididunt do fugiat commodo aliquip sit id deserunt reprehenderit
	  aliquip nostrud. Amet ex cupidatat excepteur aute veniam incididunt mollit cupidatat esse irure officia
	  elit do ipsum ullamco Lorem. Ullamco ut ad minim do mollit labore ipsum laboris ipsum commodo sunt
	  tempor enim incididunt. Commodo quis sunt dolore aliquip aute tempor irure magna enim minim
	  reprehenderit. Ullamco consectetur culpa veniam sint cillum aliqua incididunt velit ullamco sunt
	  ullamco quis quis commodo voluptate. Mollit nulla nostrud adipisicing aliqua cupidatat aliqua pariatur
	  mollit voluptate voluptate consequat non.</div>
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