@extends('layouts.app')


@section('content')


<div class="box">
	<section class="section">
		<div class="card">
			<div class="">
				<i class="fab fa-product-hunt fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
				<div class="card-body">
                    <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.instance_table', 1)) }}</a></h4>
					<div class="table-responsive">
						<table id="dt-basic-checkbox" class="table" cellspacing="0" width="100%">
							<thead>
								<th></th>
								<th class="th-sm">{{ ucwords(trans_choice('messages.id', 2)) }}</th>
								<th class="th-sm">{{ ucwords(trans_choice('messages.name', 2)) }}</th>
								<th class="th-sm">{{ ucwords(trans_choice('messages.provider', 1)) }}</th>
								
							</thead>
							<tbody>
								@forelse($instances as $instance)
								<tr>
									<td></td>
									<td>
										<a href="{{ "instances/" .$instance->id }}">{{$instance['id']}}</a>
									</td>
									<td>
										{{$instance['name']}}
									</td>
									<td>
										{{$instance['provider']}}
									</td>
								
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

<script>
	$(document).ready(function () {
		$('#dt-basic-checkbox').dataTable({
			
			columnDefs: [{
				orderable: false,
				className: 'select-checkbox',
				targets: 0
			}],
			select: {
				style: 'os',
				selector: 'td:first-child'
			}
		});
	});
</script>
@endsection

