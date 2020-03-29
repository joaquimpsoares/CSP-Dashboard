<div class="row">
	<div class="col">
		@if(Session::get('alert'))
		<div class="alert alert-{{ Session::get('alert') }} alert-dismissible fade show" role="alert">
			<strong>{{ ucfirst(Session::get('alert')) }}</strong> {{ Session::get('message') }}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		@endif

		@if(isset ($errors) && count($errors) > 0)
		@foreach($errors->all() as $error)
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>Alert: </strong> {{ $error }}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		@endforeach
		@endif
	</div>
</div>