<H1>{{ ucwords(trans_choice('messages.please_review_details', 1)) }}</H1>
<hr>

<h3>{{ ucwords(trans_choice('messages.customer_selected', 1)) }}</h3>

<p>
    {{ $cart->customer->company_name ?? __('messages.select_customer') }}
</p>

<h3>{{ ucwords(trans_choice('messages.agreement_signed', 1)) }}</h3>

<div class="md-form mb-0">
    <p id="firstName">{{ $cart->agreement_firstname }}</p>
</div>

<div class="md-form mb-0">
    <p id="lastName">{{ $cart->agreement_lastname }}</p>
</div>

<div class="md-form mb-0">
    <p id="email">{{ $cart->agreement_email }}</p>
</div>

<div class="md-form mb-0">
    <p id="phoneNumber">{{ $cart->agreement_phone }}</p>
</div>

<!-- Default disabled -->
<!-- Default checked -->
<div class="custom-control custom-switch">
    <input type="checkbox" class="custom-control-input" id="customSwitch1" checked>
    <label class="custom-control-label" for="customSwitch1">{{ ucwords(trans_choice('messages.send_email_to_customer', 1)) }}</label>
</div>

<div class="row float-right">
    <button type="button" class="btn btn-warning" id="test" >{{ ucwords(trans_choice('messages.back', 1)) }}</button>    
    <button type="button" class="btn btn-primary" id="test" >{{ ucwords(trans_choice('messages.next', 1)) }}</button>
</div>








