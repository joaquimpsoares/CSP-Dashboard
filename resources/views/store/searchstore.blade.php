@extends('layouts.app')

<style>
	
	
</style>
@section('content')
<div class="container">
	<livewire:store.searchstore  :vendor="$vendor" :category="$category"/>
	
</div>	


@endsection

@section('scripts')


@endsection
