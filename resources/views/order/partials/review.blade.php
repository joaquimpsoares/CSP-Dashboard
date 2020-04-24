<H1>{{ ucwords(trans_choice('messages.please_review_details', 1)) }}</H1>
<hr>

<h3>{{ ucwords(trans_choice('messages.customer_selected', 1)) }}</h3>

<p>Reseller 1</p>

<h3>{{ ucwords(trans_choice('messages.agreement_signed', 1)) }}</h3>
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

<!-- Default disabled -->
<!-- Default checked -->
<div class="custom-control custom-switch">
    <input type="checkbox" class="custom-control-input" id="customSwitch1" checked>
    <label class="custom-control-label" for="customSwitch1">{{ ucwords(trans_choice('messages.send_email_to_customer', 1)) }}</label>
</div>
<button type="button" class="btn btn-warning" id="test" >{{ ucwords(trans_choice('messages.back', 1)) }}</button>

<button type="button" class="btn btn-primary" id="test" >{{ ucwords(trans_choice('messages.next', 1)) }}</button>






