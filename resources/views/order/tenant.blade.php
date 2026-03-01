@extends('layouts.master')
@section('css')
<!---jvectormap css-->
<link href="{{URL::asset('assets/plugins/jvectormap/jqvmap.css')}}" rel="stylesheet" />
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<!--Daterangepicker css-->
<link href="{{URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
@endsection

@section('content')
@if($cart)
<section class="product_description_area">
    <div class="container">
        <div class="align-self-center">
            <div class="row justify-content-center">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col">
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                {{-- <li class="nav-item">
                                                    <a class="nav-link" href="#home" onclick="event.preventDefault(); document.getElementById('changeCustomer').submit();">{{ ucwords(trans_choice('messages.customer', 1)) }}</a>
                                                    <form id="changeCustomer" method="post" action="{{ route('cart.change.customer') }}">
                                                        @csrf
                                                        <input type="hidden" name="cart" value="{{ $cart->token }}" />
                                                    </form>
                                                </li> --}}
                                                <li class="nav-item">
                                                    <a class="nav-link active">{{ ucwords(trans_choice('messages.tenant', 1)) }}</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact">{{ ucwords(trans_choice('messages.review', 1)) }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="tab-content">
                                                @if($canChangeTenant)
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3 input-group">
                                                            @php($tenantPrefix = $cart->domain ? explode('.onmicrosoft.com', $cart->domain)[0] : null)
                                                            <input type="text" id="tenant" class="form-control" placeholder="tenant" name="tenant" value="{{ $tenantPrefix }}">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text" id="basic-addon2">{{ ucwords(trans_choice('messages.onmicrosoft', 1)) }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="float-sm-right">
                                                            <button type="button" id="validateButton" class="btn btn-primary" onclick="checkDomainAvailability()">{{ ucwords(trans_choice('messages.validate', 1)) }}</button>
                                                        </div>
                                                        <div id="tenantAlreadyExists" style="visibility: hidden;">
                                                            Tenant validation status
                                                            <div id="tenantAlreadyExistsButton"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col">
                                                        <div id="agreement" @if(empty($cart->domain)) style="display: none" @endif>
                                                            <form action="{{ route('cart.add_mca_user') }}" id="mca_user" method="post">
                                                                @csrf
                                                                <input type="hidden" name="token" value="{{ $cart->token }}" />
                                                                <h2>{{ ucwords(trans_choice('messages.sign_agreement_microsoft', 1)) }}</h2>
                                                                <div class="mb-0 md-form">
                                                                    <label for="firstName">{{ ucwords(trans_choice('messages.name', 1)) }}</label>
                                                                    <input type="text" name="firstName" id="firstName" class="form-control" required="required" value="{{ $cart->agreement_firstname ?? null }}"/>
                                                                </div>
                                                                <div class="mb-0 md-form">
                                                                    <label for="lastName">{{ ucwords(trans_choice('messages.last_name', 1)) }}</label>
                                                                    <input type="text" name="lastName" id="lastName" class="form-control" required="required" value="{{ $cart->agreement_lastname ?? null }}" />
                                                                </div>
                                                                <div class="mb-0 md-form">
                                                                    <label for="email">{{ ucwords(trans_choice('messages.email', 1)) }}</label>
                                                                    <input type="email" name="email" id="email" class="form-control" required="required" value="{{ $cart->agreement_email ?? null }}" />
                                                                </div>
                                                                <div class="mb-0 md-form">
                                                                    <label for="phoneNumber">{{ ucwords(trans_choice('messages.phone_number', 1)) }}</label>
                                                                    <input type="text" name="phoneNumber" id="phoneNumber" class="form-control" value="{{ $cart->agreement_phone ?? null }}" />
                                                                </div>
                                                                <br>
                                                                <div class="float-sm-right">
                                                                    <button type="submit" class="btn btn-secondary" id="test">
                                                                        {{ ucwords(trans_choice('messages.review', 1)) }} <i class="fe fe-arrow-right"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                @else
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="mb-3 input-group">
                                                            @php($tenantPrefix = $cart->domain ? explode('.onmicrosoft.com', $cart->domain)[0] : null)
                                                            <input type="text" id="tenant" class="form-control" placeholder="tenant" name="tenant" value="{{ $tenantPrefix }}" disabled="disabled">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text" id="basic-addon2">{{ ucwords(trans_choice('messages.onmicrosoft', 1)) }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div id="agreement" @if(empty($cart->domain)) style="display: none" @endif>
                                                            <form action="{{ route('cart.add_mca_user') }}" id="mca_user" method="post">
                                                                @csrf
                                                                <input type="hidden" name="token" value="{{ $cart->token }}" />
                                                                <h2>{{ ucwords(trans_choice('messages.sign_agreement_microsoft', 1)) }}</h2>
                                                                <div class="mb-0 md-form">
                                                                    <label for="firstName">{{ ucwords(trans_choice('messages.name', 1)) }}</label>
                                                                    <input type="text" name="firstName" id="firstName" class="form-control" required="required" value="{{ $cart->agreement_firstname ?? null }}" style="pointer-events: none; background-color: #f2f6f9;" />
                                                                </div>
                                                                <div class="mb-0 md-form">
                                                                    <label for="lastName">{{ ucwords(trans_choice('messages.last_name', 1)) }}</label>
                                                                    <input type="text" name="lastName" id="lastName" class="form-control" required="required" value="{{ $cart->agreement_lastname ?? null }}" style="pointer-events: none; background-color: #f2f6f9;" />
                                                                </div>
                                                                <div class="mb-0 md-form">
                                                                    <label for="email">{{ ucwords(trans_choice('messages.email', 1)) }}</label>
                                                                    <input type="email" name="email" id="email" class="form-control" required="required" value="{{ $cart->agreement_email ?? null }}" style="pointer-events: none; background-color: #f2f6f9;" />
                                                                </div>
                                                                <div class="mb-0 md-form">
                                                                    <label for="phoneNumber">{{ ucwords(trans_choice('messages.phone_number', 1)) }}</label>
                                                                    <input type="text" name="phoneNumber" id="phoneNumber" class="form-control" value="{{ $cart->agreement_phone ?? null }}" style="pointer-events: none; background-color: #f2f6f9;" />
                                                                </div>
                                                                <br>
                                                                <div class="float-sm-right">
                                                                    <button type="submit" class="btn btn-secondary" id="test">
                                                                        {{ ucwords(trans_choice('messages.review', 1)) }} <i class="fe fe-arrow-right"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @include('order.partials.side')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@else

@endif
@endsection

@section('js')

<script type="text/javascript">

    function checkDomainAvailability() {
        const prefix = ($("#tenant").val() || "").trim();

        $("#tenantAlreadyExists").css('visibility', 'hidden');
        $("#tenantAlreadyExistsButton").html('');

        $("#validateButton").prop('disabled', true);

        $.get("/cart/checkDomainAvailability", {
            token: "{{ urlencode($cart->token) }}",
            domain: prefix
        })
        .done(function(resp) {
            // resp: { ok:true, tenantId, tenantDomain }
            if (resp && resp.ok) {
                $("#tenant").prop('disabled', true);
                $("#validateButton").hide();
                $("#agreement").show();
                getMainUserFromCustomer();
            }
        })
        .fail(function(xhr) {
            $("#validateButton").prop('disabled', false);

            let resp = null;
            try { resp = xhr.responseJSON; } catch(e) {}

            // Backward compatibility if server returns plain text
            if (!resp || typeof resp !== 'object') {
                $("#tenantAlreadyExists").css('visibility', 'visible');
                $("#tenantAlreadyExistsButton").text("Validation failed. Please try again.");
                return;
            }

            const code = resp.error || resp.code || "UNKNOWN_ERROR";
            $("#tenantAlreadyExists").css('visibility', 'visible');

            if (code === "TENANT_NOT_FOUND") {
                $("#tenantAlreadyExistsButton").html("Tenant not found. Please check the tenant prefix and try again.");
                return;
            }

            if (code === "TENANT_ALREADY_LINKED") {
                $("#tenantAlreadyExistsButton").html("This tenant is already linked to another customer. Please contact support.");
                return;
            }

            if (code === "MCA_NOT_ACCEPTED") {
                const tenantId = resp.tenantId || resp.tenant_id;
                if (!tenantId) {
                    $("#tenantAlreadyExistsButton").html("Microsoft Customer Agreement is not accepted. Please ask an admin to grant consent.");
                    return;
                }

                const consentUrl = "https://login.microsoftonline.com/common/oauth2/authorize"
                    + "?client_id=" + encodeURIComponent(tenantId)
                    + "&response_type=code"
                    + "&redirect_uri=" + encodeURIComponent("https://partnerconsent.tagydes.com/")
                    + "&prompt=admin_consent";

                $("#tenantAlreadyExistsButton").html(
                    'Please accept delegated admin consent before continuing. '
                    + '<a class="btn btn-success btn-small" target="_blank" href="' + consentUrl + '">Consent here</a>'
                );
                return;
            }

            $("#tenantAlreadyExistsButton").html("Validation failed: " + code);
        });
    }

    function getMainUserFromCustomer() {

        $.get( "/cart/customer/mainUser?token={{ $cart->token }}", function() {
            //action begining
        })
        .done(function(data) {
            console.log('success');

            $('#firstName').val(data['name']);
            $('#lastName').val(data['last_name']);
            $('#email').val(data['email']);
            $('#phoneNumber').val(data['phone']);
        })
        .fail(function(data) {
            console.log("erro");
            console.log(data);
        });
    }

    @if(! empty($cart->domain))
    getMainUserFromCustomer();
    @endif
</script>
@endsection
