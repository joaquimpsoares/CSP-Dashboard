

<div class="input-group mb-3">
	<input type="text" id="tenant" class="form-control" placeholder="tenant" name="tenant">
	<div class="input-group-append">
		<span class="input-group-text" id="basic-addon2">.onmicrosoft.com</span>
	</div>
</div>

<button type="button" id="validateButton" class="btn btn-success" onclick="return checkDomainAvailability()">Validate</button>

<div id="agreement" style="display: none">

	<form action="tenant_submit" method="get" accept-charset="utf-8">
		<label for="firstName">firstName</label>
		<input type="text" name="firstName" id="firstName" class="form-control" required="required" />
		
		<label for="lastName">lastName</label>
		<input type="text" name="lastName" id="lastName" class="form-control" required="required" />
		
		<label for="email">email</label>
		<input type="email" name="email" id="email" class="form-control" required="required" />
		
		<label for="phoneNumber">phoneNumber</label>
		<input type="text" name="phoneNumber" id="phoneNumber" class="form-control" />
		
		<button type="button" class="btn btn-primary" id="test" >Seguir</button>
	</form>
	
</div>



