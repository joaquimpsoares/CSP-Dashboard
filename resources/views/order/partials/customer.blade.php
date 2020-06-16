<form action="{{ route('cart.add_customer') }}" method="post">
	<div class="row">
		
		@csrf
		<div class="col">
			<select class="shipping_select" name="customer_id" style="display: none;">
				@foreach($customers as $customer)
				<option value="{{ $customer['id'] }}">{{ $customer['company_name'] }}</option>
				@endforeach	
			</select>
		</div>
		<div class="col">
			<button class="main_btn">{{ ucwords(trans_choice('messages.next', 1)) }}</button>
		</div>
	</div>
</form>



