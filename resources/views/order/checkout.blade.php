@extends('layouts.master')
@section('css')
<!---jvectormap css-->
<link href="{{URL::asset('assets/plugins/jvectormap/jqvmap.css')}}" rel="stylesheet" />
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<!--Daterangepicker css-->
<link href="{{URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
						<!--Page header-->
						<div class="page-header">
							<div class="page-leftheader">
								<h4 class="page-title">Sales Dashboard</h4>
							</div>
							<div class="page-rightheader ml-auto d-lg-flex d-none">
								<div class="ml-5 mb-0">
									<a class="btn btn-white date-range-btn" href="#" id="daterange-btn">
										<svg class="header-icon2 mr-3" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
											<path d="M5 8h14V6H5z" opacity=".3"/><path d="M7 11h2v2H7zm12-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2zm-4 3h2v2h-2zm-4 0h2v2h-2z"/>
										</svg> <span>Select Date
										<i class="fa fa-caret-down"></i></span>
									</a>
								</div>
							</div>
						</div>
						<!--End Page header-->
@endsection
@section('content')

@if($cart)

<section class="product_description_area">
	<div class="container">
		<section class="section">
			<div class="row">
				<div class="col-sm-12">
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
												@if($hasTenant)
												<li class="nav-item">
													<a class="nav-link" id="profile-tab" data-toggle="tab" href="#">{{ ucwords(trans_choice('messages.tenant', 1)) }}</a>
												</li>
												@endif
												<li class="nav-item">
													<a class="nav-link" id="contact-tab" data-toggle="tab" href="#">{{ ucwords(trans_choice('messages.review', 1)) }}</a>
												</li>
											</ul>
										</div>
									</div>
									<div class="tab-content pt-4">
										<div class="row">
											<div class="col-sm-6">
												<hr>
												<h5>
													Create new customer for this purchase</label>
												</h5>
												<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createCustomer">
													{{ ucwords(trans_choice('messages.new_customer', 1)) }}
												</button>
												<hr>

												<!-- Modal -->
												<div class="modal fade" id="createCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog modal-xl">
														<div class="modal-content">
															<form method="POST" action="{{ route('cart.customer.store') }}" class="col s12" id="createCustomer">
																@csrf
																<input type="hidden" name="cart" value="{{ $cart->token }}">
																<div class="modal-header">
																	<h5 class="modal-title" id="exampleModalLabel">
																		{{ ucwords(trans_choice('messages.new_customer', 1)) }}
																	</h5>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
																	@include('partials.messages')
																	@include('order.partials.create_customer')
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																	<button type="submit" class="btn btn-primary" >Save changes</button>
																</div>
															</form>
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<form action="{{ route('cart.add_customer') }}" method="post">
													<div class="row">
														@csrf
														<input type="hidden" name="cart" value="{{ $cart->token }}">
														<div class="col">
															<hr>
															<h5>
																Select existing customer for this purchase</label>
															</h5>
															<select class="" name="customer_id" >
																@foreach($customers as $customer)
																<option value="{{ $customer['id'] }}" @if($cart->customer && $cart->customer->id == $customer['id']) selected="selected" @endif>{{ $customer['company_name'] }}</option>
																@endforeach
															</select>

														</div>
													</div>
													<hr>
													<br>
													<br>
													<br>
													<br>
													<br>
													<div class="float-sm-right">
														<div class="col-sm-6">
															<button class="main_btn">{{ ucwords(trans_choice('messages.next', 1)) }}</button>
														</div>
													</div>
												</form>
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
