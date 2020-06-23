@extends('layouts.app')


@section('content')

@if($cart)

<section class="product_description_area">
	<div class="container">
		<div class="align-self-center">
			<div class="row justify-content-center">
				<div class="col">
					<div class="card">
						<div class="card-body">

							<div class="row">
								<div class="col-lg-8">
									<div class="row">
										<div class="col">
											<ul class="nav nav-tabs" id="myTab" role="tablist">
												<li class="nav-item">
													<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home">{{ ucwords(trans_choice('messages.customer', 1)) }}</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" id="profile-tab" data-toggle="tab" href="#">{{ ucwords(trans_choice('messages.tenant', 1)) }}</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" id="contact-tab" data-toggle="tab" href="#">{{ ucwords(trans_choice('messages.review', 1)) }}</a>
												</li>
											</ul>
										</div>

									</div>
									<div class="tab-content pt-4">
										<div class="row">
											<div class="col">
												<form action="{{ route('cart.add_customer') }}" method="post">
													<div class="row">

														@csrf
														<input type="hidden" name="cart" value="{{ $cart->token }}">
														<div class="col">
															<select class="" name="customer_id" >
																@foreach($customers as $customer)
																<option value="{{ $customer['id'] }}" @if($cart->customer && $cart->customer->id == $customer['id']) selected="selected" @endif>{{ $customer['company_name'] }}</option>
																@endforeach	
															</select>
														</div>
														<div class="col">
															<button class="main_btn">{{ ucwords(trans_choice('messages.next', 1)) }}</button>
														</div>
													</div>
												</form>
											</div>
										</div>
										<div class="row">
											<div class="col">
												<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createCustomer">
													{{ ucwords(trans_choice('messages.new_customer', 1)) }}
												</button>
												
												<!-- Modal -->
												<div class="modal fade" id="createCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog modal-xl">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">
																	{{ ucwords(trans_choice('messages.new_customer', 1)) }}
																</h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																@include('order.partials.create_customer')
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																<button type="button" class="btn btn-primary">Save changes</button>
															</div>
														</div>
													</div>
												</div>

											</div>
										</div>
									</div>
								</div>
								@include('order.partials.side')
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@else

@endif




@endsection

@section('scripts')
<script>
	$('#createCustomer').on('shown.bs.modal', function () {
		//$('#myInput').trigger('focus')
	})
</script>
@endsection