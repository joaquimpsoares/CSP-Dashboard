<div class="row text-nowrap">

	@if(Auth::user()->can($modelo . '.edit'))
	<div class="col-2">
		<i class="fas fa-edit text-success"></i>
	</div>
	@endif
	@if(Auth::user()->can($modelo . '.edit'))
	<div class="col-2">
		<i class="fas {{ $model['status'] === 'Active' ? 'fa-eye-slash text-primary' : 'fa-eye text-info' }}"></i>		
	</div>
	@endif
	@if(Auth::user()->can($modelo . '.delete'))
	<div class="col-2">
		<i class="fas fa-trash-restore-alt text-danger"></i>
	</div>
	@endif
	@if ($modelo === "reseller") 
	<div class="col-2">
		<a href="{{ route('reseller.customers', [$model['id'], Str::slug($model['company_name'], ' ')]) }}" 
			data-toggle="tooltip" 
			data-placement="left" 
			title="{{ ucwords(trans_choice('messages.customer', 2)) }}" 
			class="text-primary">

			<i class="fas fa-user-friends text-primary"></i>

		</a>	
	</div>
	@endif
	
	<div class="col-2">
		<a href="{{ route($modelo . '.price_lists', $model['id']) }}" 
			data-toggle="tooltip" 
			data-placement="left" 
			title="{{ ucwords(trans_choice('messages.price_list', 1)) }}" 
			class="text-dark">

			<i class="fas fa-dollar-sign"></i>

		</a>	
	</div>
	
	@canImpersonate
	<div class="col-2">
		<i class="fas fa-user-secret text-muted"></i>
	</div>
	@endCanImpersonate
</div>
