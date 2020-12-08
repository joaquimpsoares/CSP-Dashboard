<div class="row text-nowrap">
    <div class="btn-group align-top">
        @if(Auth::user()->can($modelo . '.edit'))
        <button class="btn btn-sm btn-white btn-svg" type="button" data-toggle="modal" data-target="#user-form-modal">Edit</button>
        <button class="btn btn-sm btn-white btn-svg" type="button"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M8 9h8v10H8z" opacity=".3"/><path d="M15.5 4l-1-1h-5l-1 1H5v2h14V4zM6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM8 9h8v10H8V9z"/></svg></button>
        @endif
        @canImpersonate
        @if(!empty($model['mainUser']))
            <a class="btn btn-sm btn-white btn-svg" href="{{ route('impersonate', $model['mainUser']->id) }}"><i class="fa fa-user-secret text-muted"></i></a>
        @endif
        @endCanImpersonate
    </div>




	{{-- @if(Auth::user()->can($modelo . '.edit'))
	<div class="col-2">
		<i class="fa {{ $model['status'] === 'Active' ? 'fa-eye-slash text-primary' : 'fa-eye text-info' }}"></i>
	</div>
	@endif

	@if(Auth::user()->can($modelo . '.delete'))
	<div class="col-2">
		<i class="fa fa-trash-restore-alt text-danger"></i>
	</div>
	@endif

	@if ($modelo === "reseller")
	<div class="col-2">
		<a href="{{ route('reseller.customers', [$model['id'], Str::slug($model['company_name'], ' ')]) }}" data-toggle="tooltip" data-placement="left" title="{{ ucwords(trans_choice('messages.customer', 2)) }}" class="text-primary"></a>
	</div>
	@endif --}}



</div>
