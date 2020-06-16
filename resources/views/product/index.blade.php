@extends('layouts.app')



<style>
	.number-input input[type="number"] {
		-webkit-appearance: textfield;
		-moz-appearance: textfield;
		appearance: textfield;
	}
	
	.number-input input[type=number]::-webkit-inner-spin-button,
	.number-input input[type=number]::-webkit-outer-spin-button {
		-webkit-appearance: none;
	}
	
	.number-input {
		margin-bottom: 3rem;
	}
	
	.number-input button {
		-webkit-appearance: none;
		background-color: transparent;
		border: none;
		align-items: center;
		justify-content: center;
		cursor: pointer;
		margin: 0;
		position: relative;
	}
	
	.number-input button:before,
	.number-input button:after {
		display: inline-block;
		position: absolute;
		content: '';
		height: 2px;
		transform: translate(-50%, -50%);
	}
	
	.number-input button.plus:after {
		transform: translate(-50%, -50%) rotate(90deg);
	}
	
	.number-input input[type=number] {
		text-align: center;
	}
	
	.number-input.number-input {
		border: 1px solid #ced4da;
		width: 10rem;
		border-radius: .25rem;
	}
	
	.number-input.number-input button {
		width: 2.6rem;
		height: .7rem;
	}
	
	.number-input.number-input button.minus {
		padding-left: 10px;
	}
	
	.number-input.number-input button:before,
	.number-input.number-input button:after {
		width: .7rem;
		background-color: #495057;
	}
	
	.number-input.number-input input[type=number] {
		max-width: 4rem;
		padding: .5rem;
		border: 1px solid #ced4da;
		border-width: 0 1px;
		font-size: 1rem;
		height: 2rem;
		color: #495057;
	}
	
	@media not all and (min-resolution:.001dpcm) {
		@supports (-webkit-appearance: none) and (stroke-color:transparent) {
			
			.number-input.def-number-input.safari_only button:before,
			.number-input.def-number-input.safari_only button:after {
				margin-top: -.3rem;
			}
		}
	}   
</style>


@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>

<div class="box">
	<section class="section">
		<div class="card">
			<div class="">
				<i class="fab fa-product-hunt fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
				<div class="card-body">
					<h4 class="card-title"><a>{{ ucwords(trans_choice('messages.product_table', 2)) }}</a></h4>
				    <table class="table table-hover responsive" id="example">
						<thead class="thead-dark">
							<th><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>							
							<th class="th-sm">{{ ucwords(trans_choice('messages.product_sku', 2)) }}</th>
							<th class="th-sm">{{ ucwords(trans_choice('messages.product_name', 2)) }}</th>
							<th class="th-sm">{{ ucwords(trans_choice('messages.category', 2)) }}</th>
							<th class="th-sm">{{ ucwords(trans_choice('messages.vendor', 1)) }}</th>
							<th class="th-sm">{{ ucwords(trans_choice('messages.instance', 1)) }}</th>
							<th class="th-sm">{{ ucwords(trans_choice('messages.action', 2)) }}</th>
						</thead>
						<tbody>
							@forelse($products as $product)
							<tr>
								<td></td>
								<td style="width: 1px;"><a data-toggle="modal" data-target=".bd-example-modal-xl" href="{{ "product/" .$product->id }}">{{$product['sku']}}</a></td>
								<td style="width: 1px;">{{$product['name']}}</td>
								<td style="width: 1px; ; white-space: nowrap;">{{$product['category']}}</td>
								<td class="text-center">{{$product['vendor']}}</td>
								<td class="text-center">{{$product['instance']['name']}}</td>
								<td>Actions</td>
							</tr>
							@empty
							<tr>
								<td>Empty</td>
							</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
</div>



<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
aria-hidden="true" data-backdrop="false"> 
<div class="modal-dialog modal-xl">
	<div class="modal-content">
		<div class="box">
			<section class="section">
				<div class="card">
					<div class="">
						<i class="fab fa-product-hunt fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
						<div class="card-body">
							<h4 class="card-title"><a>{{ ucwords(trans_choice('messages.product_card', 2)) }}</a></h4>
							<div class="row">
								<div class="col-md-3"></div>
								<div class="col-md-6">
									<div class="row">
										<form class="col s12">
											<div class="row">
												<div class="input-field col s4">
													<div class="md-form">
														<input type="text" id="form1" class="form-control" value="{{$product->id}}">
														<label for="form1">{{ ucwords(trans_choice('messages.instance_id', 1)) }}</label>
													</div>
												</div>
												<div class="input-field col s4">
													<div class="md-form">
														<input type="text" id="instance_name" class="form-control" value="{{$product->instance->name}}">
														<label for="instance_name">{{ ucwords(trans_choice('messages.instance_name', 1)) }}</label>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="input-field col s4">
													<div class="md-form">
														<input type="text" id="form1" class="form-control" value="{{$product->vendor}}">
														<label for="form1">{{ ucwords(trans_choice('messages.product_vendor', 1)) }}</label>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="input-field col s4">
													<div class="md-form">
														<input type="text" id="form1" class="form-control" value="{{$product->sku}}">
														<label for="form1">{{ ucwords(trans_choice('messages.product_sku', 1)) }}</label>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="input-field col s4">
													<div class="md-form">
														<input type="text" id="form1" class="form-control" value="{{$product->name}}">
														<label for="form1">{{ ucwords(trans_choice('messages.product_name', 1)) }}</label>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="input-field col s4">
													<div class="md-form">
														<textarea type="text" id="defaultFormMessageModalEx" class="md-textarea form-control">{{$product->description}}</textarea>
														<label for="defaultFormMessageModalEx">{{ ucwords(trans_choice('messages.product_description', 1)) }}</label>
													</div>
												</div>
											</div>
											@if ($product->addons != "[]")
											<div class="row">
												<div class="input-field col s4">
													<div class="md-form">
														<input type="text" id="form1" class="form-control" value="{{$product->addons}}">
														<label for="form1">{{ ucwords(trans_choice('messages.product_name', 1)) }}</label>
													</div>
												</div>
											</div>
											@endif
											<div class="row">
												<div class="input-field col s4">
													<label for="defaultFormMessageModalEx">{{ ucwords(trans_choice('messages.product_mininum', 1)) }}</label>  
													<div class="def-number-input number-input safari_only">
														<button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"></button>
														<input class="quantity" min="0" name="quantity" value="{{$product->minimum_quantity}}" type="number">
														<button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
													</div>
												</div>
												<div class="input-field col s4">
													<label for="defaultFormMessageModalEx">{{ ucwords(trans_choice('messages.product_maximum', 1)) }}</label>  
													<div class="def-number-input number-input safari_only">
														<button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"></button>
														<input class="quantity" min="0" name="quantity" type="number" value="{{$product->maximum_quantity}}">
														<button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
													</div>
												</div>
											</div>
											{{-- {{dd($product)}} --}}
											@if ($product->price->price != null)
											<div class="row">
												<div class="input-field col s4">
													<div class="md-form">
														<input type="text" id="form1" class="form-control" value="{{$product->price->price}}">
														<label for="defaultFormMessageModalEx">{{ ucwords(trans_choice('messages.product_msrp_price', 1)) }}</label>
													</div>
												</div>
												<div class="input-field col s4">
													<div class="md-form">
														<input type="text" id="form1" class="form-control" value="{{$product->price->msrp}}">
														<label for="defaultFormMessageModalEx">{{ ucwords(trans_choice('messages.product_retail_price', 1)) }}</label>
													</div>
												</div>
											</div>
											@endif
											@if ($product->limit > 0)
											<div class="row">
												<div class="input-field col s4">
													<label for="defaultFormMessageModalEx">{{ ucwords(trans_choice('messages.subscription_limit', 1)) }}</label>  
													<div class="def-number-input number-input safari_only">
														<button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"></button>
														<input class="quantity" min="0" name="quantity" value="{{$product->limit}}" type="number">
														<button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
													</div>
												</div>
											</div>
											@endif
											<div class="row">
												<div class="input-field col s4">
													<div class="md-form">
														<input type="text" id="form1" class="form-control" value="{{$product->billing}}">
														<label for="form1">{{ ucwords(trans_choice('messages.product_billing_type', 1)) }}</label>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="input-field col s4">
													<div class="md-form">
														<input type="text" id="form1" class="form-control" value="{{$product->supported_billing_cycles}}">
														<label for="form1">{{ ucwords(trans_choice('messages.product_billing_cycle', 1)) }}</label>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="input-field col s4">
													<div class="md-form">
														<input type="text" id="form1" class="form-control" value="{{$product->category}}">
														<label for="form1">{{ ucwords(trans_choice('messages.product_category', 1)) }}</label>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="input-field col s4">
													<label for="defaultFormMessageModalEx">{{ ucwords(trans_choice('messages.trial', 1)) }}</label>  
													<div class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" id="defaultGroupExample1" name="groupOfDefaultRadios">
														<label class="custom-control-label" for="defaultGroupExample1">no</label>
													</div>
													<div class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" id="defaultGroupExample2" name="groupOfDefaultRadios" checked>
														<label class="custom-control-label" for="defaultGroupExample2">Yes</label>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="input-field col s4">
													<div class="md-form">
														<input type="text" id="defaultFormMessageModalEx" class="md-textarea form-control" value="{{$product->resellee_qualifications}}">
														<label for="defaultFormMessageModalEx">{{ ucwords(trans_choice('messages.product_reseller_qualification', 1)) }}</label>
													</div>
												</div>
											</div>
											
										</div>
									</div>
									<div class="col-md-3"></div>
								</div>
							</div>
						</div>	  
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	
	
	@endsection
	
	
	@section('scripts')
	
	
	
	<script type="text/javascript">
		$(document).ready(function (){   
			var table = $('#example').DataTable({
				'columnDefs': [{
					'targets': 0,
					'searchable':false,
					'orderable':false,
					'className': 'dt-body-center',
					'render': function (data, type, full, meta){
						return '<input type="checkbox" name="id[]" value="' 
						+ $('<div/>').text(data).html() + '">';
					}
				}],
				'order': [1, 'asc']
			});
			
			// Handle click on "Select all" control
			$('#example-select-all').on('click', function(){
				// Check/uncheck all checkboxes in the table
				var rows = table.rows({ 'search': 'applied' }).nodes();
				$('input[type="checkbox"]', rows).prop('checked', this.checked);
			});
			
			// Handle click on checkbox to set state of "Select all" control
			$('#example tbody').on('change', 'input[type="checkbox"]', function(){
				// If checkbox is not checked
				if(!this.checked){
					var el = $('#example-select-all').get(0);
					// If "Select all" control is checked and has 'indeterminate' property
					if(el && el.checked && ('indeterminate' in el)){
						// Set visual state of "Select all" control 
						// as 'indeterminate'
						el.indeterminate = true;
					}
				}
			});
			
			$('#frm-example').on('submit', function(e){
				var form = this;
				
				// Iterate over all checkboxes in the table
				table.$('input[type="checkbox"]').each(function(){
					// If checkbox doesn't exist in DOM
					if(!$.contains(document, this)){
						// If checkbox is checked
						if(this.checked){
							// Create a hidden element 
							$(form).append(
							$('<input>')
							.attr('type', 'hidden')
							.attr('name', this.name)
							.val(this.value)
							);
						}
					} 
				});
				
				// FOR TESTING ONLY
				
				// Output form data to a console
				$('#example-console').text($(form).serialize()); 
				console.log("Form submission", $(form).serialize()); 
				
				// Prevent actual form submission
				e.preventDefault();
			});
		});
	</script>
	
	
	@endsection