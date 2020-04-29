<H1>{{ ucwords(trans_choice('messages.please_review_details', 1)) }}</H1>
<hr>

<h3>{{ ucwords(trans_choice('messages.customer_selected', 1)) }}</h3>

<p>
    @php
    $cart = Session::get('cart');
    echo $cart->customer['company_name'];
    @endphp
</p>

<h3>{{ ucwords(trans_choice('messages.agreement_signed', 1)) }}</h3>

<div class="md-form mb-0">
    <p id="firstName">{{ $cart->mcaUser["firstName"] }}</p>
</div>

<div class="md-form mb-0">
    <p id="lastName">{{ $cart->mcaUser["lastName"] }}</p>
</div>

<div class="md-form mb-0">
    <p id="email">{{ $cart->mcaUser["email"] }}</p>
</div>

<div class="md-form mb-0">
    <p id="phoneNumber">{{ $cart->mcaUser["phoneNumber"] }}</p>
</div>

<!-- Default disabled -->
<!-- Default checked -->
<div class="custom-control custom-switch">
    <input type="checkbox" class="custom-control-input" id="customSwitch1" checked>
    <label class="custom-control-label" for="customSwitch1">{{ ucwords(trans_choice('messages.send_email_to_customer', 1)) }}</label>
</div>
<button type="button" class="btn btn-warning" id="test" >{{ ucwords(trans_choice('messages.back', 1)) }}</button>

<button type="button" class="btn btn-primary" id="test" >{{ ucwords(trans_choice('messages.next', 1)) }}</button>

<pre>

</pre>






