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
									<div>
									<a href="{{route('user.create' )}}" style = "font-color:fffff" class="btn submit_btn">new user</a>
									</div>
								</div>
								<h2 class="card-title"><a>{{ ucwords(trans_choice('messages.user_table', 1)) }}</a></h2>
								<table class="table table-striped table-bordered" id="customers">
									<thead>
										<tr>
											<th>{{ ucwords(trans_choice('messages.avatar', 1)) }}</th>
											<th>{{ ucwords(trans_choice('messages.username', 1)) }}</th>
											<th>{{ ucwords(trans_choice('messages.first_name', 1)) }}</th>
											<th>{{ ucwords(trans_choice('messages.last_name', 1)) }}</th>
											<th>{{ ucwords(trans_choice('messages.status', 1)) }}</th>
											<th>{{ ucwords(trans_choice('messages.action', 1)) }}</th>
										</tr>
									</thead>
									<tbody>
										@if ($users != null)
										@forelse($users as $user)
										<tr>
											<td>
												<img src="{{$user->avatar}}" class="rounded-circle z-depth-0" alt="avatar image"  width='50' Height ='auto'>
											</td>
											<td>
												<a href="/user/{{$user->id }}">    {{ $user['username'] }}</a>
											</td>
											<td>{{ $user['first_name'] }}</td>
											<td>{{ $user['last_name'] }}</td>
											<td>{{ ucwords(trans_choice($user->status->name, 1)) }}</td>
										</tr>
										@empty
										<tr>
											<td colspan="5">Empty</td>
										</tr>									
										@endforelse
										@endif	
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