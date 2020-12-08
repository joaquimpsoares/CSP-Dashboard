@extends('layouts.master2')
@section('css')
@endsection
@section('content')
		<div class="page relative">
			<div class="page-content">
				<div class="container text-center">
					<div class="display-1 text-primary mb-5 font-weight-bold">400</div>
					<h1 class="h3  mb-3 font-weight-bold">Bad Request Error!</h1>
					<p class="h5 font-weight-normal mb-7 leading-normal">You may have mistyped the address or the page may have moved.</p>
					<a class="btn btn-primary" href="{{ url('/' . $page='index') }}"><i class="fe fe-arrow-left-circle mr-1"></i>Back to Home</a>
				</div>
			</div>
		</div>
@endsection
@section('js')
@endsection