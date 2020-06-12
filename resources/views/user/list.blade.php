@extends('layouts.app')


@section('content')
<div class="box">
	<section class="section">
		<div class="card">
			<div class="">
				<i class="fab fa-product-hunt fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
				<div class="float-right">
					<a href="{{route('invite')}}" class="btn btn-success float-right ">{{ ucwords(trans_choice('messages.invite', 2)) }}</a>
					{{-- <a type="submit" class="btn btn-success">{{ ucwords(__('messages.new_customer')) }}</a> --}}
				</div>
				<div class="card-body">
					{{-- <div class="card-header">
						List of users
					</div> --}}
					<h4 class="card-title"><a>{{ ucwords(trans_choice('messages.username', 2)) }}</a></h4>
					<table class="table table-striped table-responsive table-bordered" id="resellers">
						<thead>
							<th>{{ ucwords(trans_choice('messages.username', 2)) }}</th>
							<th>{{ ucwords(trans_choice('messages.first_name', 2)) }}</th>
							<th class="text-center">{{ ucwords(trans_choice('messages.last_name', 1)) }}</th>
							<th class="text-center">{{ ucwords(trans_choice('messages.owner', 1)) }}</th>
							<th class="text-center">{{ ucwords(trans_choice('messages.status', 1)) }}</th>
							{{-- <th class="text-center">{{ ucwords(trans_choice('messages.action', 2)) }}</th> --}}
						</thead>
						<tbody>
							{{dd($users)}}
							@forelse($users as $user)
							<tr>
								<td style="width: 1px; white-space: nowrap;">
									{{$user['username']}}
								</td>
								<td style="width: 1px; white-space: nowrap;">
									{{$user['first_name']}}
								</td>
								<td class="text-center">
									{{$user['last_name']}}
								</td>
								<td class="text-center">
                                    {{$user['provider']['company_name'] }}
                                    {{$user['reseller']['company_name'] }}
                                    {{$user['customer']['company_name'] }}
                                </td>
                                <td class="text-center">
									{{$user['status']}}
								</td>
								{{-- <td>
								</td> --}}
							</tr>
							@empty
							<tr>
								<td></td>
							</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection


@section('scripts')
<script type="text/javascript">
	$(document).ready( function () {
		$('#products').DataTable({
			"paging": false,
			"ordering": false,
			"search": false,
			"info": false
		});
	} );
	
</script>
<script type="text/javascript">
	$(document).ready( function () {
		$('#resellers').DataTable({
			"pagingType": "full_numbers",
			"order": [[ 0, "asc" ]]
		});
	} );
</script>
@endsection

