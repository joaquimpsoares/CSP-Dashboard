@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/datatables_bootstrap.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="box">
	<section class="section">
		<div class="card">
			<div class="">
				<i class="fas fa-users fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
				<div class="card-body">
					<h4 class="card-title"><a>Resellers Table</a></h4>
					@include('reseller.partials.table', ['resellers' => $resellers])
				</div>
			</div>
		</div>
	</section>
</div>	
@endsection

@section('scripts')
<script type="text/javascript">
	$(document).ready( function () {
		$('#resellers').DataTable({
			"pagingType": "full_numbers",
			"order": [[ 0, "asc" ]]
		});
	} );
</script>
@endsection