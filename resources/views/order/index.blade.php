@extends('layouts.master')
@section('css')
<!---jvectormap css-->
<link href="{{URL::asset('assets/plugins/jvectormap/jqvmap.css')}}" rel="stylesheet" />
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<!--Daterangepicker css-->
<link href="{{URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
@endsection

@section('styles')
@endsection

@section('content')
<div class="container">
	<section class="section">
		<div class="card">
			<div class="">
				<i class="fas fa-file-invoice-dollar fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
				<div class="card-body">
                    <h4 class="card-title">{{ ucwords(trans_choice('messages.order_table', 2)) }} </h4>
					@include('order.partials.table', ['orders' => $orders])
				</div>
			</div>
		</div>
	</section>
</div>
@endsection
