<div class="container">
	<section class="section">
		<div class="row">
			<div class="col-md-2">
				<legend><h3>{{ ucwords(trans_choice('messages.filter', 1)) }}</h3></legend>				
				<form method="GET" action="{{ route('store.index') }}" style="padding-top: 15px;">
					<!-- Search form -->
					@if (isset($filters['quantity']))
					<input type="hidden" name="quantity" value="{{ $filters['quantity']}}" />
					@endif
					<div class="md-form active-purple active-purple-2 mb-3form-group" style="padding-top: 15px;">
						<i class="fas fa-search"></i>
						<input type="text" class="form-control" name="name" id="name" value="{{ $filters['name'] ?? '' }}" placeholder="{{ ucwords(trans_choice('messages.product_name', 1)) }}" />
					</div>
					<div class="form-group">
						<label for="vendor">{{ ucwords(trans_choice('messages.vendor', 1)) }}</label>
						<select class="custom-select" name="vendor" id="vendor">
							<option value="" {{ ( isset($filters['vendor']) && $filters['vendor'] === 'all' ) ? 'selected' : '' }}>{{ ucwords(__('messages.all')) }}</option>
							{{-- @foreach($vendors as $vendor)
							<option value="{{ $vendor->name }}" {{ ( isset($filters['vendor']) && $filters['vendor'] ===  $vendor->name ) ? 'selected' : '' }}>{{ ucwords($vendor->name) }}</option>
							@endforeach	 --}}
						</select>
					</div>
					<div class="text-right" style="padding-top: 15px;">
						<a href="{{ route('store.index') }}" class="btn btn-info">{{ ucwords(__('messages.clear_filter')) }}</a>
						<button class="btn btn-success">{{ ucwords(__('messages.apply_filter')) }}</button>
					</div>
				</form>	
			</div>
			<div class="col-md-10">
				<div class="row">
					<div class="col-3">
                        <form method="GET" action="{{ route('store.index') }}" style="padding-top: 15px;">
							@if (isset($filters['name']))
							<input type="hidden" name="name" value="{{ $filters['name']}}" />
							@endif
							@if (isset($filters['vendor']))
							<input type="hidden" name="vendor" value="{{ $filters['vendor']}}" />
							@endif
							<div class="input-group mb-3">
								<select name="quantity" class="custom-select " id="quantity">
                                    <option {{ (!isset($filters['quantity'])) ? 'selected' : ( isset($filters['quantity']) && $filters['quantity'] === '12' ) ? 'selected' : ''  }}>12</option>
									<option {{ ( isset($filters['quantity']) && $filters['quantity'] === '24' ) ? 'selected' : '' }}>24</option>
									<option {{ ( isset($filters['quantity']) && $filters['quantity'] === '36' ) ? 'selected' : '' }}>36</option>
								</select>
								<div class="input-group-append">
                                    <button class="input-group-text" type="submit" for="quantity">{{ ucwords(__('messages.apply_filter')) }}</button>
								</div>
							</div>
							<input type="hidden" name="search" value="1" />
						</form>
					</div>
				</div>
				@php
				$cont=0
				@endphp
				<div class="row">
                    @foreach($products as $product)
					<div class="col-sm-12 col-md-3" style="padding-top: 20px;">
						<div class="card" style="min-height: 230px;">
							<div class="card-body text-center">
								<div class="row mx-auto justify-content-center">
									{{-- <img src="{{ asset('images/vendors/' . $product->vendor . '.png') }}"  title="{{ $product->name }}" class="img-fuid" style="max-width: 120px;max-height: 120px;" /> --}}
								</div>
								<div class="row mx-auto justify-content-center" style="padding-top: 20px;">
									@if(strlen($product->name) <= 40)
									<div class="col-12" >&nbsp;</div>
									@endif
									<strong>{{ $product->name }}</strong>
									@if(strlen($product->name) <= 40 || strlen($product->name) < 70)
									<div class="col-12" >&nbsp;</div>
									@endif
									
								</div>
							</div>
							<div class="card-footer text-muted text-center">
								<div class="row">
									<div class="col-6">	
										<a class="btn btn-outline-dark" data-toggle="modal" data-target="#modal_product_{{$product->id}}">+ {{ $product->addons->count() }} {{ ucwords(trans_choice('messages.addon', 2)) }}</a>
									</div>
									<div class="col-6">
										<form method="POST" action="{{ route('cart.add_to_cart') }}">
											@csrf
											<input type="hidden" name="product_id" value="{{$product->id}}">
											<button type="submit" class="btn btn-outline-success">
												{{ ucwords(__('messages.add_to_cart')) }}
											</button>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					@php
					$cont++
					@endphp
					@if($cont === 4)
					@php
					$cont=0
					@endphp
				</div>
				<div class="row" >
					@endif
					@endforeach
				</div>
				<hr/>
				<div class="row">
					<div class="col">
						<span class="float-right">
							{{-- @include('partials.paginator', ['paginator' => $prices]) --}}
						</span>
					</div>
				</div>
			</div>
		</div>  
	</section>
</div>	