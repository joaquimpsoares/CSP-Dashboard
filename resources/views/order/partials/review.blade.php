<H1>{{ ucwords(trans_choice('messages.please_review_details', 1)) }}</H1>
<hr>

<h3>{{ ucwords(trans_choice('messages.customer_selected', 1)) }}</h3>

<p>
    {{ $cart->customer->company_name ?? __('messages.select_customer') }}
</p>

<h3>{{ ucwords(trans_choice('messages.agreement_signed', 1)) }}</h3>

<div class="mb-0 md-form">
    <p id="firstName">{{ $cart->agreement_firstname }}</p>
</div>

<div class="mb-0 md-form">
    <p id="lastName">{{ $cart->agreement_lastname }}</p>
</div>

<div class="mb-0 md-form">
    <p id="email">{{ $cart->agreement_email }}</p>
</div>

<div class="mb-0 md-form">
    <p id="phoneNumber">{{ $cart->agreement_phone }}</p>
</div>
<div>
    <h1 class="mb-4 font-black text-center text-gray-700">STEPS</h1>
    <div class="flex">
      <div class="w-1/3 px-6 text-center">
        <div class="flex items-center justify-center bg-gray-300 border border-gray-200 rounded-lg">
          <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M23.995 24h-1.995c0-3.104.119-3.55-1.761-3.986-2.877-.664-5.594-1.291-6.584-3.458-.361-.791-.601-2.095.31-3.814 2.042-3.857 2.554-7.165 1.403-9.076-1.341-2.229-5.413-2.241-6.766.034-1.154 1.937-.635 5.227 1.424 9.025.93 1.712.697 3.02.338 3.815-.982 2.178-3.675 2.799-6.525 3.456-1.964.454-1.839.87-1.839 4.004h-1.995l-.005-1.241c0-2.52.199-3.975 3.178-4.663 3.365-.777 6.688-1.473 5.09-4.418-4.733-8.729-1.35-13.678 3.732-13.678 4.983 0 8.451 4.766 3.732 13.678-1.551 2.928 1.65 3.624 5.09 4.418 2.979.688 3.178 2.143 3.178 4.663l-.005 1.241zm-13.478-6l.91 2h1.164l.92-2h-2.994zm2.995 6l-.704-3h-1.615l-.704 3h3.023z"/></svg>
          </div>
          <div class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-gray-200 rounded-r-lg body-step">
            <h2 class="text-sm font-bold">Personal Info</h2>
            <p class="text-xs text-gray-600">
              Just your personal information
            </p>
          </div>
        </div>
      </div>
      <div class="flex items-center justify-center flex-1">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M14 2h-7.229l7.014 7h-13.785v6h13.785l-7.014 7h7.229l10-10z"/></svg>
      </div>
      <div class="w-1/3 px-6 text-center">
        <div class="flex items-center justify-center bg-gray-300 border border-gray-200 rounded-lg">
          <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M24 22h-24v-20h24v20zm-1-19h-22v18h22v-18zm-4 13v1h-4v-1h4zm-6.002 1h-10.997l-.001-.914c-.004-1.05-.007-2.136 1.711-2.533.789-.182 1.753-.404 1.892-.709.048-.108-.04-.301-.098-.407-1.103-2.036-1.305-3.838-.567-5.078.514-.863 1.448-1.359 2.562-1.359 1.105 0 2.033.488 2.545 1.339.737 1.224.542 3.033-.548 5.095-.057.106-.144.301-.095.41.14.305 1.118.531 1.83.696 1.779.41 1.773 1.503 1.767 2.56l-.001.9zm-9.998-1h8.999c.003-1.014-.055-1.27-.936-1.473-1.171-.27-2.226-.514-2.57-1.267-.174-.381-.134-.816.119-1.294.921-1.739 1.125-3.199.576-4.111-.332-.551-.931-.855-1.688-.855-.764 0-1.369.31-1.703.871-.542.91-.328 2.401.587 4.09.259.476.303.912.13 1.295-.342.757-1.387.997-2.493 1.252-.966.222-1.022.478-1.021 1.492zm18-3v1h-6v-1h6zm0-3v1h-6v-1h6zm0-3v1h-6v-1h6z"/></svg>
          </div>
          <div class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-gray-200 rounded-r-lg body-step">
            <h2 class="text-sm font-bold">Account Info</h2>
            <p class="text-xs text-gray-600">
              Anything you want for your credentials
            </p>
          </div>
        </div>
      </div>
      <div class="flex items-center justify-center flex-1">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M14 2h-7.229l7.014 7h-13.785v6h13.785l-7.014 7h7.229l10-10z"/></svg>
      </div>
      <div class="w-1/3 px-6 text-center">
        <div class="flex items-center justify-center bg-gray-300 border border-gray-200 rounded-lg">
          <div class="flex items-center justify-center w-1/3 h-20 bg-transparent icon-step">
            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M21 6.285l-11.16 12.733-6.84-6.018 1.319-1.49 5.341 4.686 9.865-11.196 1.475 1.285z"/></svg>
          </div>
          <div class="flex flex-col items-center justify-center w-2/3 h-24 px-1 bg-gray-200 rounded-r-lg body-step">
            <h2 class="text-sm font-bold">Confirmation</h2>
            <p class="text-xs text-gray-600">
              Finish it!
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- Default disabled -->
<!-- Default checked -->
<div class="custom-control custom-switch">
    <input type="checkbox" class="custom-control-input" id="customSwitch1" checked>
    <label class="custom-control-label" for="customSwitch1">{{ ucwords(trans_choice('messages.send_email_to_customer', 1)) }}</label>
</div>

<div class="float-right row">
    <button type="button" class="btn btn-warning" id="test" >{{ ucwords(trans_choice('messages.back', 1)) }}</button>
    <button type="button" class="btn btn-primary" id="test" >{{ ucwords(trans_choice('messages.next', 1)) }}</button>
</div>








