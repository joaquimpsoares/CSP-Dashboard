
@extends('layouts.app')

@section('styles')
@endsection

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
							<a type="submit" href="{{route('provider.create')}}" class="btn submit_btn">{{ ucwords(__('messages.new_provider')) }}</a>
						</div>
					</div>
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

