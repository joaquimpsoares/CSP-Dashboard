@extends('layouts.app')


@section('content')
<div class="container">
	<section class="section">
		<div class="card">
			<div class="">
				<i class="fas fa-dollar-sign fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
				<div class="float-right">
					@if(Auth::user()->userLevel->id=== 3)
					<a type="submit" href="{{route('reseller.create')}}" class="btn btn-success">{{ ucwords(__('messages.new_reseller')) }}</a>
					@endif
				</div>
				<div class="card-body">
					<h4 class="card-title">
						<a>
							{{ ucwords(trans_choice('messages.reseller_table', 2)) }}
						</a>
					</h4>
					@include('reseller.partials.table', ['resellers' => $resellers])
				</div>
			</div>
		</div>
	</section>
	
</div>
@endsection

@section('scripts')

<script>
	$(document).ready(function () {
		$('#dtBasicExample').DataTable();
		$('.dataTables_length').addClass('bs-select');
	});
</script>
@endsection