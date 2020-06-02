@extends('layouts.app')

@section('styles')
{{-- <link href="{{ asset('css/datatables_bootstrap.css') }}" rel="stylesheet" /> --}}
@endsection

@section('content')

<div class="box">
	<section class="section">
		<div class="card">
			<div class="">
				<i class="fas fa-dollar-sign fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
				<div class="float-right">
					<a type="submit" href="{{route('provider.create')}}" class="btn btn-success">{{ ucwords(__('messages.new_provider')) }}</a>
				</div>
				<div class="card-body">
					<h4 class="card-title"><a>{{ ucwords(trans_choice('messages.provider_table', 1)) }}</a></h4>
					<table id="providers" class="table" width="100%">
						<thead>
							<tr>
								<th>{{ ucwords(trans_choice('messages.company_name', 1)) }}</th>
								<th>{{ ucwords(trans_choice('messages.country', 1)) }}</th>
								<th>{{ ucwords(trans_choice('messages.state', 1)) }}</th>
								<th>{{ ucwords(trans_choice('messages.city', 1)) }}</th>
								<th>{{ ucwords(trans_choice('messages.action', 1)) }}</th>
							</tr>
						</thead>
						<tbody>
							@forelse($providers as $provider)
							
							@if($provider['status'] === 'message.active')
							<tr>
								<td><a href="{{ $provider['path'] }}">{{ $provider['company_name'] }}</a></td>
								<td>{{ $provider['country'] }}</td>
								<td>{{ $provider['state'] }}</td>
								<td>{{ $provider['city'] }}</td>
								<td style="width: 150px">
									@include('partials.actions', ['model' => $provider, 'modelo' => 'provider'])
								</td>
							</tr>
							@endif
							@empty
							<tr>
								<td colspan="5">Empty</td>
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
		$('#providers').DataTable({
			"pagingType": "full_numbers",
			"order": [[ 0, "asc" ]]
		});
	} );
</script>
@endsection