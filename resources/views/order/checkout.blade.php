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
													<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{ ucwords(trans_choice('messages.customer', 1)) }}</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{ ucwords(trans_choice('messages.tenant', 1)) }}</a>
												</li>
												<li class="nav-item">
													<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">{{ ucwords(trans_choice('messages.review', 1)) }}</a>
												</li>
											</ul>
										</div>

									</div>
									<div class="tab-content pt-4">
										<div class="row">
											<div class="col">
												
												<select class="shipping_select" name="customer" style="display: none;">
													@foreach($customers as $customer)
													<option value="{{ $customer['id'] }}">{{ $customer['company_name'] }}</option>
													@endforeach	
												</select>
											</div>
											<div class="col">
												<button class="main_btn">{{ ucwords(trans_choice('messages.next', 1)) }}</button>
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