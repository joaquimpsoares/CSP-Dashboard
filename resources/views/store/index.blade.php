@extends('layouts.app')

<style>
	@import url('https://fonts.googleapis.com/css?family=Roboto:400,500,700');
	*
	{
		-webkit-box-sizing: border-box;
		box-sizing: border-box;
		margin: 0;
		padding: 0;
	}
	
	
	/* body
	{
		font-family: 'Roboto', sans-serif;
	}
	a
	{
		text-decoration: none;
	} */
	.product-card {
		width: 350px;
		position: relative;
		box-shadow: 0 5px 10px #dfdfdf;
		margin: 30px auto;
		background: #fafafa;
	}
	
	.badge {
		position: absolute;
		left: 0;
		top: 20px;
		text-transform: uppercase;
		font-size: 13px;
		font-weight: 700;
		background: rgb(145, 255, 0);
		color: rgb(0, 0, 0);
		padding: 3px 10px;
	}
	
	/* .badge {
		position: absolute;
		left: 0;
		top: 20px;
		text-transform: uppercase;
		font-size: 13px;
		font-weight: 700;
		background: red;
		color: #fff;
		padding: 3px 10px;
	} */
	
	.product-tumb {
		display: flex;
		align-items: center;
		justify-content: center;
		height: 250px;
		padding: 50px;
		background: #f0f0f0;
	}
	
	/* .text {
		/* display: block; */
		/* width: 100px; */
		max-width: 200px;
		overflow: hidden;
		/* white-space: nowrap; */
		text-overflow: ellipsis;
	}
	*/
	.product-tumb img {
		max-width: 100%;
		max-height: 100%;
	}
	
	.product-details {
		padding: 30px;
	}
	
	.product-catagory {
		display: block;
		font-size: 12px;
		font-weight: 700;
		text-transform: uppercase;
		color: #ccc;
		margin-bottom: 18px;
	}
	
	.product-details h4 a {
		font-weight: 500;
		display: block;
		margin-bottom: 18px;
		text-transform: uppercase;
		color: #363636;
		text-decoration: none;
		transition: 0.3s;
	}
	
	.product-details h4 a:hover {
		color: #fbb72c;
	}
	
	.product-details p {
		font-size: 15px;
		line-height: 22px;
		margin-bottom: 18px;
		color: #999;
	}
	
	.product-bottom-details {
		overflow: hidden;
		border-top: 1px solid #eee;
		padding-top: 20px;
	}
	
	.product-bottom-details div {
		float: left;
		width: 50%;
	}
	
	.product-price {
		font-size: 18px;
		color: #fbb72c;
		font-weight: 600;
	}
	
	.product-price small {
		font-size: 80%;
		font-weight: 400;
		text-decoration: line-through;
		display: inline-block;
		margin-right: 5px;
	}
	
	.product-links {
		text-align: right;
	}
	
	.product-links button {
		display: inline-block;
		margin-left: 5px;
		color: #e1e1e1;
		transition: 0.3s;
		font-size: 17px;
	}
	
	.product-links button:hover {
		color: #fbb72c;
	}
	.product-links button:border-color {
		color: #000000;
	}
	.product-links button {
		border: none;
		background: none;
	}
</style>
@section('content')
<div class="container">
	<section class="section">
		<div class="row">
			<livewire:searchstore/>
		</div>
	</section>
</div>	


@endsection

@section('scripts')


@endsection

