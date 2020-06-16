
<form method="post" action="#">
	<div class="row">
		
		<label for="customer">{{ ucwords(trans_choice('messages.select_customer', 1)) }}</label>
		<br/>
		<select name="customer" id="customers" class="custom-select" required="required">
			<option value="" selected="selected">{{ ucwords(trans_choice('messages.select_customer', 1)) }}</option>
			@foreach($customers as $customer)
			<option value="{{ $customer['id'] }}">{{ $customer['company_name'] }}</option>
			@endforeach				
		</select>
		
	</div>	
	<div class="row float-right">
		<a class="btn btn-primary" onclick="verifyCustomer()">{{ ucwords(trans_choice('messages.tenant', 1)) }}</a>
	</div>

	

</form>



