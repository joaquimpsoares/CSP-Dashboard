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
												@if($hasTenant)
												<li class="nav-item">
													<a class="nav-link"href="#" onclick="event.preventDefault(); document.getElementById('changeTenant').submit();">{{ ucwords(trans_choice('messages.tenant', 1)) }}</a>
													<form id="changeTenant" method="post" action="{{ route('cart.change.tenant') }}">
														@csrf
														<input type="hidden" name="cart" value="{{ $cart->token }}" />
													</form>
												</li>
												@endif
												<li class="nav-item">
													<a class="nav-link active" id="contact-tab" data-toggle="tab" href="#">{{ ucwords(trans_choice('messages.review', 1)) }}</a>
												</li>
											</ul>
										</div>
									</div>
									<div class="tab-content pt-4">
										<div class="row">
											<H1>{{ ucwords(trans_choice('messages.please_review_details', 1)) }}</H1>
										</div>
										
										<div class="bd-callout bd-callout-info">
											<h4>{{ ucwords(trans_choice('messages.customer_selected', 1)) }}</h4>
											<hr>
											<div class="card-body">
												{{ $cart->customer->company_name ?? __('messages.select_customer') }}
											</div>
										</div>
										
										<br>
										<div class="bd-callout bd-callout-info">
											<h4>{{ ucwords(trans_choice('messages.agreement_signed', 1)) }}</h4>
											<hr>
											<div class="card-body">
												<p id="firstName">{{ $cart->agreement_firstname }} <br>
													{{ $cart->agreement_lastname }}<br>
													{{ $cart->agreement_email }}<br>
													{{ $cart->agreement_phone }}
												</p>
											</div>
										</div>
										
										<br>
										<div class="row">
											<!-- Default disabled -->
											<!-- Default checked -->
											<div class="custom-control custom-switch">
												<input type="checkbox" class="custom-control-input" id="customSwitch1" checked>
												<label class="custom-control-label" for="customSwitch1">{{ ucwords(trans_choice('messages.send_email_to_customer', 1)) }}</label>
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

@endsection