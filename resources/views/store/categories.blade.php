@extends('layouts.app')

<style>
	
	
</style>
@section('content')
	
    <div class="container">
        <h1>Select</h1>
        <div class="row">
            <div class="card-columns">
                @foreach ($categories as $category)
                {{-- @if ($product->vendor == 'microsoft') --}}
                <a href="{{'/store/searchstore/'. $category->category}}">
                <div class="card bd-callout-info">
                    <img class="card-img-top" src="https://img.pngio.com/microsoft-corporate-logo-guidelines-trademarks-microsoft-logo-png-2008_900.jpg" height="170" alt="Card image cap">
                    {{-- @endif --}}
                    {{-- @if ($product->vendor == 'kaspersky')
                    <a href="{{'/store/categories/'. $product->vendor}}">
                    <div class="card bd-callout-info">
                        <img  class="card-img-top" src="https://media.kasperskydaily.com/wp-content/uploads/sites/88/2019/07/19124650/kaspersky-rebranding-in-details-featured.jpg" height="170" alt="Card image cap">
                        @endif --}}
                        <div class="card-body">
                            <h5 class="card-title">{{ucfirst($category->category)}}</h5>
                        </div>
                        <div class="p-3 text-right">
                        </div>
                    </div>
                    @endforeach
                </div>
                </a>
            </div>
        </div>
	
</div>	


@endsection

@section('scripts')


@endsection

