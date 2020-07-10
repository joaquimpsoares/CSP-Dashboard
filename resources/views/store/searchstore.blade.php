@extends('layouts.app')

<style>
	
	
</style>
@section('content')
<div class="container">
	{{-- {{dd($vendor)}} --}}
	<livewire:searchstore  :vendor="$vendor" :category="$category"/>
	
</div>	


@endsection

@section('scripts')


@endsection
