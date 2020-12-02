@extends('layouts.master2')
@section('css')
@endsection
@section('content')
		<div class="page relative">
			<div class="page-content">
				<div class="container text-center">
					<div class="display-2 text-primary mb-5 font-weight-bold">Coming soon</div>
					<h1 class="h3  mb-3 font-weight-bold">Site Nearly Already Ready</h1>
					<p class="h5 font-weight-normal mb-4 leading-normal">You may have mistyped the address or the page may have moved.</p>
					<div class="row">
						<div class="col-md-6 d-block mx-auto mb-4">
							<div class="row">
								<div class="col text-left">
									<span class="badge badge-primary badge-pill">Working</span>
								</div>
								<div class="col col-auto">
									<div class="fs-18 font-weight-bold">60%</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="progress-wrapper mb-5 col-md-6 d-block mx-auto">
							<div class="progress progress-md">
								<div class="progress-bar-striped progress-bar-animated bg-primary" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
							</div>
						</div>
					</div>
					<div class="coming-footer border-top border-dark-transparent">
						<div class="d-block mx-auto">
							<p class="h5 mb-4 leading-normal">Notify Me When there's Some Action.</p>
							<div class="input-group mb-4">
								<span class="input-group-addon bg-white pr-0"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 8l-8 5-8-5v10h16zm0-2H4l8 4.99z" opacity=".3"/><path d="M4 20h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2zM20 6l-8 4.99L4 6h16zM4 8l8 5 8-5v10H4V8z"/></svg></span>
								<input type="text" class="form-control border-left-0 border-right-0" placeholder="Enter Your Email">
								<a href="#" class="input-group-append bg-white p-2 btn"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M4 8.25l7.51 1-7.5-3.22zm.01 9.72l7.5-3.22-7.51 1z" opacity=".3"></path><path d="M2.01 3L2 10l15 2-15 2 .01 7L23 12 2.01 3zM4 8.25V6.03l7.51 3.22-7.51-1zm.01 9.72v-2.22l7.51-1-7.51 3.22z"></path></svg></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection
@section('js')
@endsection