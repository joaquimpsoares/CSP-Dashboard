@extends('layouts.master3')
@section('css')
@endsection
@section('content')
		<div class="page">
			<div class="page-content">
				<div class="container text-center ">
					<img src="{{URL::asset('assets/images/svgs/404.svg')}}" alt="img" class="w-30 mb-6">
					<h1 class="h3  mb-3 font-weight-bold">Sorry, an error has occured, Requested Page not found!</h1>
					<p class="h5 font-weight-normal mb-7 leading-normal">You may have mistyped the address or the page may have moved.</p>
					<a class="btn btn-primary" href="{{ url('/' . $page='index') }}"><i class="fe fe-arrow-left-circle mr-1"></i>Back to Home</a>
				</div>
			</div>
		</div>
@endsection
@section('js')
@endsection