<div class="row">
	<div class="col-md-12">
		<div class="md-form">
			<hr>
			<h3>{{ ucwords(trans_choice('messages.user_info', 1)) }}</h3>
		</div>
	</div>
</div>

<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-lg-12">
				<i class="fas fa-user fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<div class="md-form">
								<div style="display: flex;">
									<div style="flex-grow: 31;">
									</div>
									@if (Route::current()->getName() === "provider.show")
									<div>
										<a href="{{route('user.create', ['level' => 'provider', 'customer_id' => $provider->id] )}}" style = "font-color:fffff" class="btn submit_btn">new user</a>
									</div>
									@endif
									@if (Route::current()->getName() === "reseller.show")
									<div>
										<a href="{{route('user.create', ['level' => 'reseller', 'customer_id' => $reseller->id] )}}" style = "font-color:fffff" class="btn submit_btn">new user</a>
									</div>
									@endif
									@if (Route::current()->getName() === "customer.show")
									<div>
										<a href="{{route('user.create', ['level' => 'customer', 'customer_id' => $customer->id] )}}" style = "font-color:fffff" class="btn submit_btn">new user</a>
									</div>
									@endif	
								</div>
								<h2 class="card-title"><a>{{ ucwords(trans_choice('messages.user_table', 1)) }}</a></h2>
								<table class="table table-striped table-bordered" id="customers">
									<thead>
										<tr>
											<th>{{ ucwords(trans_choice('messages.avatar', 1)) }}</th>
											<th>{{ ucwords(trans_choice('messages.email', 1)) }}</th>
											<th>{{ ucwords(trans_choice('messages.username', 1)) }}</th>
											<th>{{ ucwords(trans_choice('messages.first_name', 1)) }}</th>
											<th>{{ ucwords(trans_choice('messages.last_name', 1)) }}</th>
											<th>{{ ucwords(trans_choice('messages.status', 1)) }}</th>
											<th>{{ ucwords(trans_choice('messages.action', 1)) }}</th>
										</tr>
									</thead>
									<tbody>
										{{-- @if ($users == null) --}}
										@foreach($users as $user)
										<tr>
											<td><img src="{{$user->avatar}}" class="rounded-circle z-depth-0" alt="avatar image"  width='50' Height ='auto'></td>
											<td><a href="/user/{{$user->id }}">{{ $user['email'] }}</a></td>
											<td><a href="/user/{{$user->id }}">{{ $user['username'] }}</a></td>
											<td>{{ $user['first_name'] }}</td>
											<td>{{ $user['last_name'] }}</td>
											<td>{{ ucwords(trans_choice($user->status->name, 1)) }}</td>
											<td>Actions</td>
										</tr>								
										@endforeach
										{{-- @endif	 --}}
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>