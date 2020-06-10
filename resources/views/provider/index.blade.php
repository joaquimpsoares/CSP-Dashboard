
@extends('layouts.app')

@section('styles')
@endsection

@section('content')

<div class="container">
	<section class="section">
		<div class="card">
			<div class="">
				<i class="fas fa-dollar-sign fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
				<div class="float-right">
					<a type="submit" href="{{route('provider.create')}}" class="btn submit_btn">{{ ucwords(__('messages.new_provider')) }}</a>
				</div>
				<div class="card-body">
					<h4 class="card-title"><a>{{ ucwords(trans_choice('messages.provider_table', 1)) }}</a></h4>
					@include('provider.partials.table')
				</div>
			</div>
		</div>
	</section>
	
</div>



@endsection

