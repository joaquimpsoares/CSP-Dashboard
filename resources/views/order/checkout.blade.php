@extends('layouts.app')


@section('content')




@if(Session::has('cart'))

<div class="box col-12 align-self-center">
<div class="row justify-content-center">
	<div class="col-10">

		<div class="card">
			<div class="card-body">


				<div class="row">
					<div class="col-lg-8">
						<ul class="nav md-pills nav-justified pills-primary font-weight-bold">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#selectCustomer" role="tab">{{ ucwords(trans_choice('messages.select_customer', 1)) }}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#selectTenant" role="tab">{{ ucwords(trans_choice('messages.tenant', 1)) }}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#tabCheckoutPayment123" role="tab">{{ ucwords(trans_choice('messages.review', 1)) }}</a>
							</li>

						</ul>
						<div class="tab-content pt-4">
							<div class="tab-pane fade in show active" id="selectCustomer" role="tabpanel">
								@include('order.partials.customer', ['customers' => $customers, 'test' => 'test'])
								
							</div>
							<div class="tab-pane fade" id="selectTenant" role="tabpanel">
								@include('order.partials.tenant')
							</div>

							<div class="tab-pane fade" id="tabCheckoutPayment123" role="tabpanel">
								@include('order.partials.review')
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
@else

@endif




@endsection

@section('scripts')
<script>

	function verifyCustomer() {
		//var customer = $('#customers').val();
		var customer =  $( "#customers option:selected" ).val();
		
		$.get( "/cart/customer/" + customer + "/add/", function() {
            //action begining
        })
        .done(function(data) {
            console.log('success');
        })
        .fail(function(data) {
            console.log(data);
            // some error
        });
	}

	function checkDomainAvailability() {
		var domain = $("#tenant").val();

		$("#validateButton").prop('disabled', true);

		$.get( "/cart/checkDomainAvailability/" + domain, function() {
            //action begining            
        })
        .done(function(data) {
            // console.log('success');
            $("#validateButton").hide();
            $("#agreement").show();
        })
        .fail(function(data) {
            //console.log(data);
            $("#validateButton").prop('disabled', false);
            // some error
        });
	}

	
</script>
@endsection