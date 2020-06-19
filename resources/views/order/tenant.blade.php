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
													<a class="nav-link" href="#home" onclick="event.preventDefault(); document.getElementById('changeCustomer').submit();">{{ ucwords(trans_choice('messages.customer', 1)) }}</a>
													<form id="changeCustomer" method="post" action="{{ route('cart.change.customer') }}">
														@csrf
														<input type="hidden" name="cart" value="{{ $cart->token }}" />
													</form>
												</li>
												<li class="nav-item">
													<a class="nav-link active">{{ ucwords(trans_choice('messages.tenant', 1)) }}</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact">{{ ucwords(trans_choice('messages.review', 1)) }}</a>
												</li>
											</ul>
										</div>

									</div>
									<div class="row">
										<div class="col">
											<div class="tab-content">
												<div class="row">
													<div class="col">
														<div class="input-group mb-3">
															<input type="text" id="tenant" class="form-control" placeholder="tenant" name="tenant" value="{{ $cart->domain ?? null }}">
															<div class="input-group-append">
																<span class="input-group-text" id="basic-addon2">{{ ucwords(trans_choice('messages.onmicrosoft', 1)) }}</span>
															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col">
														<div class="row float-right">
															<button type="button" id="validateButton" class="btn btn-success" onclick="checkDomainAvailability()">{{ ucwords(trans_choice('messages.validate', 1)) }}</button>
														</div>
													</div>
												</div>
												<div class="row">
													<div id="agreement" @if(empty($cart->domain)) style="display: none" @endif>
														<form action="{{ route('cart.add_mca_user') }}" id="mca_user" method="post">
															@csrf
															<input type="hidden" name="token" value="{{ $cart->token }}" />
															<h2>{{ ucwords(trans_choice('messages.sign_agreement_microsoft', 1)) }}</h2>
															<div class="md-form mb-0">
																<label for="firstName">{{ ucwords(trans_choice('messages.first_name', 1)) }}</label>
																<input type="text" name="firstName" id="firstName" class="form-control" required="required" value="{{ $cart->agreement_firstname ?? null }}"/>
															</div>

															<div class="md-form mb-0">
																<label for="lastName">{{ ucwords(trans_choice('messages.last_name', 1)) }}</label>
																<input type="text" name="lastName" id="lastName" class="form-control" required="required" value="{{ $cart->agreement_lastname ?? null }}" />
															</div>
															<div class="md-form mb-0">
																<label for="email">{{ ucwords(trans_choice('messages.email', 1)) }}</label>
																<input type="email" name="email" id="email" class="form-control" required="required" value="{{ $cart->agreement_email ?? null }}" />
															</div>
															<div class="md-form mb-0">
																<label for="phoneNumber">{{ ucwords(trans_choice('messages.phone_number', 1)) }}</label>
																<input type="text" name="phoneNumber" id="phoneNumber" class="form-control" value="{{ $cart->agreement_phone ?? null }}" />
															</div>

															<div class="row float-right">
																<button type="submit" class="btn btn-primary" id="test">
																	{{ ucwords(trans_choice('messages.review', 1)) }}
																</button>
															</div>

														</form>
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
<script type="text/javascript">
	
	function checkDomainAvailability() {
		var domain = $("#tenant").val();

		$("#validateButton").prop('disabled', true);

		$.get( "/cart/checkDomainAvailability/?token={{ urlencode($cart->token) }}&domain=" + domain, function() {

		})
		.done(function(data) {

			getMainUserFromCustomer();
			$("#validateButton").hide();
			$("#agreement").show();

		})
		.fail(function(data) {
			console.log(data);
			$("#validateButton").prop('disabled', false);

		});
	}

	function getMainUserFromCustomer() {

		$.get( "/cart/customer/mainUser?token={{ $cart->token }}", function() {
					//action begining            
				})
		.done(function(data) {
			console.log('success');

			$('#firstName').val(data['first_name']);
			$('#lastName').val(data['last_name']);
			$('#email').val(data['email']);
			$('#phoneNumber').val(data['phone']);

		})
		.fail(function(data) {
			console.log("erro");
			console.log(data);
		});
	}

	@if(! empty($cart->domain))
	getMainUserFromCustomer();
	@endif
</script>
@endsection