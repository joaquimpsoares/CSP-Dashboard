

<div class="input-group mb-3">
	<input type="text" id="tenant" class="form-control" placeholder="tenant" name="tenant">
	<div class="input-group-append">
		<span class="input-group-text" id="basic-addon2">{{ ucwords(trans_choice('messages.onmicrosoft', 1)) }}</span>
	</div>
</div>

<button type="button" id="validateButton" class="btn btn-success" onclick="return checkDomainAvailability()">{{ ucwords(trans_choice('messages.validate', 1)) }}</button>

<div id="agreement" style="display: none">
	
	<form action="tenant_submit" method="get" accept-charset="utf-8">
		<h2>{{ ucwords(trans_choice('messages.sign_agreement_microsoft', 1)) }}</h2>
		<div class="md-form mb-0">
			<label for="firstName">{{ ucwords(trans_choice('messages.first_name', 1)) }}</label>
			<input type="text" name="firstName" id="firstName" class="form-control" required="required" />
		</div>
			
			<div class="md-form mb-0">
				<label for="lastName">{{ ucwords(trans_choice('messages.last_name', 1)) }}</label>
				<input type="text" name="lastName" id="lastName" class="form-control" required="required" />
			</div>
			<div class="md-form mb-0">
				<label for="email">{{ ucwords(trans_choice('messages.email', 1)) }}</label>
				<input type="email" name="email" id="email" class="form-control" required="required" />
			</div>
			<div class="md-form mb-0">
				<label for="phoneNumber">{{ ucwords(trans_choice('messages.phone_number', 1)) }}</label>
				<input type="text" name="phoneNumber" id="phoneNumber" class="form-control" />
			</div>

			<div class="row float-right">
				<button type="button" data-toggle="tab" href="#tabreview" role="tab" class="btn btn-primary" id="test" >{{ ucwords(trans_choice('messages.review', 1)) }}</button>
			</div>
		</form>
		
	</div>
	
	
	
