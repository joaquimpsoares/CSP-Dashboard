@extends('layouts.app')


@section('content')

<div class="container">
	<section class="section">
		<div class="card">
			<div class="card-body">
				<div class="md-form">
					<div style="display: flex;">
						<div style="flex-grow: 31;">
						</div>
						<div>
							@if(Auth::user()->userLevel->id=== 3)
							<a type="submit" href="{{route('reseller.create')}}" class="btn submit_btn">{{ ucwords(__('messages.new_reseller')) }}</a>
							@endif						</div>
					</div>
				</div>
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