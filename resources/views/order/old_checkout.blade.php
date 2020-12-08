@extends('layouts.app')


@section('content')

@if($cart)

<div class="container">
	<div class="align-self-center">
		<div class="row justify-content-center">
			<div class="col">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-lg-8">
								<ul class="nav nav-pills md-tabs nav-justified pills-primary " id="myTabMD" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#selectCustomer" role="tab">
											{{ ucwords(trans_choice('messages.select_customer', 1)) }}
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#selectTenant" role="tab">
											{{ ucwords(trans_choice('messages.tenant', 1)) }}
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#tabreview" role="tab">
											{{ ucwords(trans_choice('messages.review', 1)) }}
										</a>
									</li>
								</ul>
								<div class="tab-content pt-4">
									<div class="tab-pane fade in show active" id="selectCustomer" role="tabpanel">
										@include('order.partials.customer', ['customers' => $customers])
									</div>
									<div class="tab-pane fade" id="selectTenant" role="tabpanel">
										@include('order.partials.tenant')
									</div><div class="tab-pane fade" id="tabreview" role="tabpanel">
										@include('order.partials.review')
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
@else

@endif




@endsection

@section('scripts')
<script>
	var customer = null;

	$( document ).ready(function() {

		@if (! $cart->customer)
		console.log('customer');
		$('[href="#selectCustomer"]').tab('show');
		@elseif (empty($cart->domain))
		console.log('tenant');
		$('[href="#selectTenant"]').tab('show');
		@elseif (empty($cart->agreement_firstname))
		console.log('review');
		$("#validateButton").hide();
		getMainUserFromCustomer();
		$('[href="#selectTenant"]').tab('show');
		$("#agreement").show();
		@else
		$('[href="#tabreview"]').tab('show');
		@endif

	});

	function verifyCustomer() {

		customer =  $( "#customers option:selected" ).val();

		$.get( "/cart/customer/" + customer + "/add/", function() {

		})
		.done(function(data) {
				//console.log('success');
				$('[href="#selectTenant"]').tab('show');

			})
		.fail(function(data) {
			console.log(data);

		});
	}

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

	function sendMCAUser() {
		var form = $("#mca_user");

		$.ajax({
			type: "POST",
			url: "{{ route('cart.add_mca_user') }}",
			data: form.serialize(),
			success: function (data) {
				console.log("success");
				console.log(data);
				$('[href="#tabreview"]').tab('show');
			},
			error: function (data) {
				console.log("error");
				console.log(data);
			}
		})

	}


</script>
@endsection