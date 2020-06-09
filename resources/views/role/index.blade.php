@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/datatables_bootstrap.css') }}" rel="stylesheet" />
@endsection

@section('content')


@if($errors->any())
{{ implode('', $errors->all('<div>:message</div>')) }}
@endif

<form method="post" action="{{ route('roles.update.all') }}">
	@csrf
	<div class="container">
		<section class="section">
			<div class="card">
				<div class="">
					<i class="fas fa-sliders-h fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
					<div class="card-body">
						<h4 class="card-title"><a>Roles Table</a></h4>	
						<table class="table table-striped table-bordered" id="roles">
							<thead>
								<th>&nbsp</th>
								@foreach ($roles as $role)
								<th class="text-center">{{ $role->name }}</th>
								@endforeach
							</thead>
							@forelse ($permissions as $permission)
							<tr style="{{ str_contains($permission->name, 'delete') ? 'background: rgba(255,0,0,0.1);' : '' }}">
								<th><span class="{{ str_contains($permission->name, 'delete') ? 'has-text-danger' : 'has-text-grey' }}">{{ $permission->name }}</span></th>
								@foreach ($roles as $role)
								<?php
								$hasPermission = false;
								if ($role->hasPermissionTo($permission->name) || Auth::user()->hasDirectPermission($permission->name)) $hasPermission = true;
								?>
								<td class="text-center">
									<div class="form-check">
										<input class="form-check-input position-static" type="checkbox" id="permission[{{ $role->id }}][{{ $permission->id }}]" name="permission[{{ $role->id }}][{{ $permission->id }}]" aria-label="..." {{ $hasPermission ? 'checked' : '' }}  {{ $role->name === "Super Admin" ? 'disabled' : '' }}>
									</div>
								</td>
								@endforeach
							</tr>
							@empty
							@endforelse
						</table>
					</div>
				</div>
			</div>
		</section>
	</div>
</form>

@endsection

@section('scripts')


@endsection
