@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
						<!--Page header-->
						<div class="page-header">
							<div class="page-leftheader">
								<h4 class="page-title">Blog</h4>
							</div>
							<div class="page-rightheader ml-auto d-lg-flex d-none">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#" class="d-flex"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/><path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/></svg><span class="breadcrumb-icon"> Home</span></a></li>
									<li class="breadcrumb-item"><a href="#">Pages</a></li>
									<li class="breadcrumb-item"><a href="#">Blog</a></li>
									<li class="breadcrumb-item active" aria-current="page">Blog 01</li>
								</ol>
							</div>
						</div>
						<!--End Page header-->
@endsection
@section('content')
						<!-- Row -->
						<div class="row">
							<div class="col-xl-4 col-lg-6 col-md-12">
								<div class="card overflow-hidden">
									<div class="item7-card-img">
										<a href="#"></a>
										<img src="{{URL::asset('assets/images/photos/1.jpg')}}" alt="img" class="cover-image w-100">
									</div>
									<div class="card-body">
										<div class="item7-card-desc d-flex mb-5">
											<a href="#" class="d-flex"><svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"/><path d="M4 5.01h16V8H4z" opacity=".3"/></svg><div class="mt-0">Jan-18-2020</div></a>
											<div class="ml-auto">
												<a class="mr-0 d-flex" href="#"><svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 17.17V4H4v12h14.83L20 17.17zM18 14H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z" opacity=".3"/><path d="M4 18h14l4 4-.01-18c0-1.1-.89-2-1.99-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2zM4 4h16v13.17L18.83 16H4V4zm2 8h12v2H6zm0-3h12v2H6zm0-3h12v2H6z"/></svg><div class="mt-0">12 Comments</div></a>
											</div>
										</div>
										<a href="#" class="mt-4"><h5 class="font-weight-semibold">Excepteur  occaecat cupidatat</h5></a>
										<p>Lorem ipsum dolor quis exercitationem into enim ad minima nostrum itationem </p>
									</div>
									<div class="card-body">
										<div class="d-flex align-items-center mt-auto">
											<div class="avatar brround avatar-md mr-3" style="background-image: url({{URL::asset('assets/images/users/16.jpg')}})"></div>
											<div>
												<a href="{{ url('/' . $page='profile') }}" class="font-weight-semibold">Anna Ogden</a>
												<small class="d-block text-muted">2 days ago</small>
											</div>
											<div class="ml-auto text-muted">
												<a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.5 5c-1.54 0-3.04.99-3.56 2.36h-1.87C10.54 5.99 9.04 5 7.5 5 5.5 5 4 6.5 4 8.5c0 2.89 3.14 5.74 7.9 10.05l.1.1.1-.1C16.86 14.24 20 11.39 20 8.5c0-2-1.5-3.5-3.5-3.5z" opacity=".3"/><path d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zm-4.4 15.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z"/></svg></a>
												<a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none"/><path d="M21 12v-2h-9l1.34-5.34L9 9v10h9z" opacity=".3"/><path d="M9 21h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.58 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2zM9 9l4.34-4.34L12 10h9v2l-3 7H9V9zM1 9h4v12H1z"/></svg></a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6 col-md-12">
								<div class="card overflow-hidden">
									<div class="item7-card-img">
										<a href="#"></a>
										<img src="{{URL::asset('assets/images/photos/2.jpg')}}" alt="img" class="cover-image w-100">
									</div>
									<div class="card-body">
										<div class="item7-card-desc d-flex mb-5">
											<a href="#" class="d-flex"><svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"/><path d="M4 5.01h16V8H4z" opacity=".3"/></svg><div class="mt-0">Jan-22-2020</div></a>
											<div class="ml-auto">
												<a class="mr-0 d-flex" href="#"><svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 17.17V4H4v12h14.83L20 17.17zM18 14H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z" opacity=".3"/><path d="M4 18h14l4 4-.01-18c0-1.1-.89-2-1.99-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2zM4 4h16v13.17L18.83 16H4V4zm2 8h12v2H6zm0-3h12v2H6zm0-3h12v2H6z"/></svg><div class="mt-0">14 Comments</div></a>
											</div>
										</div>
										<a href="#" class="mt-4"><h5 class="font-weight-semibold">Lorem ipsum dolor quis</h5></a>
										<p>Lorem ipsum dolor quis exercitationem into enim ad minima nostrum itationem </p>
									</div>
									<div class="card-body">
										<div class="d-flex align-items-center mt-auto">
											<div class="avatar brround avatar-md mr-3" style="background-image: url({{URL::asset('assets/images/users/16.jpg')}})"></div>
											<div>
												<a href="{{ url('/' . $page='profile') }}" class="font-weight-semibold">Anna Ogden</a>
												<small class="d-block text-muted">2 days ago</small>
											</div>
											<div class="ml-auto text-muted">
												<a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.5 5c-1.54 0-3.04.99-3.56 2.36h-1.87C10.54 5.99 9.04 5 7.5 5 5.5 5 4 6.5 4 8.5c0 2.89 3.14 5.74 7.9 10.05l.1.1.1-.1C16.86 14.24 20 11.39 20 8.5c0-2-1.5-3.5-3.5-3.5z" opacity=".3"/><path d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zm-4.4 15.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z"/></svg></a>
												<a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none"/><path d="M21 12v-2h-9l1.34-5.34L9 9v10h9z" opacity=".3"/><path d="M9 21h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.58 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2zM9 9l4.34-4.34L12 10h9v2l-3 7H9V9zM1 9h4v12H1z"/></svg></a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6 col-md-12">
								<div class="card overflow-hidden">
									<div class="item7-card-img">
										<a href="#"></a>
										<img src="{{URL::asset('assets/images/photos/3.jpg')}}" alt="img" class="cover-image w-100">
									</div>
									<div class="card-body">
										<div class="item7-card-desc d-flex mb-5">
											<a href="#" class="d-flex"><svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"/><path d="M4 5.01h16V8H4z" opacity=".3"/></svg><div class="mt-0">Apr-16-2020</div></a>
											<div class="ml-auto">
												<a class="mr-0 d-flex" href="#"><svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 17.17V4H4v12h14.83L20 17.17zM18 14H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z" opacity=".3"/><path d="M4 18h14l4 4-.01-18c0-1.1-.89-2-1.99-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2zM4 4h16v13.17L18.83 16H4V4zm2 8h12v2H6zm0-3h12v2H6zm0-3h12v2H6z"/></svg><div class="mt-0">3 Comments</div></a>
											</div>
										</div>
										<a href="#" class="mt-4"><h5 class="font-weight-semibold">pleasure and praising pain</h5></a>
										<p>Lorem ipsum dolor quis exercitationem into enim ad minima nostrum itationem </p>
									</div>
									<div class="card-body">
										<div class="d-flex align-items-center mt-auto">
											<div class="avatar brround avatar-md mr-3" style="background-image: url({{URL::asset('assets/images/users/16.jpg')}})"></div>
											<div>
												<a href="{{ url('/' . $page='profile') }}" class="font-weight-semibold">Anna Ogden</a>
												<small class="d-block text-muted">2 days ago</small>
											</div>
											<div class="ml-auto text-muted">
												<a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.5 5c-1.54 0-3.04.99-3.56 2.36h-1.87C10.54 5.99 9.04 5 7.5 5 5.5 5 4 6.5 4 8.5c0 2.89 3.14 5.74 7.9 10.05l.1.1.1-.1C16.86 14.24 20 11.39 20 8.5c0-2-1.5-3.5-3.5-3.5z" opacity=".3"/><path d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zm-4.4 15.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z"/></svg></a>
												<a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none"/><path d="M21 12v-2h-9l1.34-5.34L9 9v10h9z" opacity=".3"/><path d="M9 21h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.58 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2zM9 9l4.34-4.34L12 10h9v2l-3 7H9V9zM1 9h4v12H1z"/></svg></a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6 col-md-12">
								<div class="card overflow-hidden">
									<div class="item7-card-img">
										<a href="#"></a>
										<img src="{{URL::asset('assets/images/photos/4.jpg')}}" alt="img" class="cover-image w-100">
									</div>
									<div class="card-body">
										<div class="item7-card-desc d-flex mb-5">
											<a href="#" class="d-flex"><svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"/><path d="M4 5.01h16V8H4z" opacity=".3"/></svg><div class="mt-0">Feb-16-2020</div></a>
											<div class="ml-auto">
												<a class="mr-0 d-flex" href="#"><svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 17.17V4H4v12h14.83L20 17.17zM18 14H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z" opacity=".3"/><path d="M4 18h14l4 4-.01-18c0-1.1-.89-2-1.99-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2zM4 4h16v13.17L18.83 16H4V4zm2 8h12v2H6zm0-3h12v2H6zm0-3h12v2H6z"/></svg><div class="mt-0">4 Comments</div></a>
											</div>
										</div>
										<a href="#" class="mt-4"><h5 class="font-weight-semibold">expound the actual teachings</h5></a>
										<p>Lorem ipsum dolor quis exercitationem into enim ad minima nostrum itationem </p>
									</div>
									<div class="card-body">
										<div class="d-flex align-items-center mt-auto">
											<div class="avatar brround avatar-md mr-3" style="background-image: url({{URL::asset('assets/images/users/16.jpg')}})"></div>
											<div>
												<a href="{{ url('/' . $page='profile') }}" class="font-weight-semibold">Anna Ogden</a>
												<small class="d-block text-muted">2 days ago</small>
											</div>
											<div class="ml-auto text-muted">
												<a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.5 5c-1.54 0-3.04.99-3.56 2.36h-1.87C10.54 5.99 9.04 5 7.5 5 5.5 5 4 6.5 4 8.5c0 2.89 3.14 5.74 7.9 10.05l.1.1.1-.1C16.86 14.24 20 11.39 20 8.5c0-2-1.5-3.5-3.5-3.5z" opacity=".3"/><path d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zm-4.4 15.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z"/></svg></a>
												<a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none"/><path d="M21 12v-2h-9l1.34-5.34L9 9v10h9z" opacity=".3"/><path d="M9 21h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.58 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2zM9 9l4.34-4.34L12 10h9v2l-3 7H9V9zM1 9h4v12H1z"/></svg></a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6 col-md-12">
								<div class="card overflow-hidden">
									<div class="item7-card-img">
										<a href="#"></a>
										<img src="{{URL::asset('assets/images/photos/5.jpg')}}" alt="img" class="cover-image w-100">
									</div>
									<div class="card-body">
										<div class="item7-card-desc d-flex mb-5">
											<a href="#" class="d-flex"><svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"/><path d="M4 5.01h16V8H4z" opacity=".3"/></svg><div class="mt-0">Jan-14-2020</div></a>
											<div class="ml-auto">
												<a class="mr-0 d-flex" href="#"><svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 17.17V4H4v12h14.83L20 17.17zM18 14H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z" opacity=".3"/><path d="M4 18h14l4 4-.01-18c0-1.1-.89-2-1.99-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2zM4 4h16v13.17L18.83 16H4V4zm2 8h12v2H6zm0-3h12v2H6zm0-3h12v2H6z"/></svg><div class="mt-0">8 Comments</div></a>
											</div>
										</div>
										<a href="#" class="mt-4"><h5 class="font-weight-semibold">great explorer of the truth</h5></a>
										<p>Lorem ipsum dolor quis exercitationem into enim ad minima nostrum itationem </p>
									</div>
									<div class="card-body">
										<div class="d-flex align-items-center mt-auto">
											<div class="avatar brround avatar-md mr-3" style="background-image: url({{URL::asset('assets/images/users/16.jpg')}})"></div>
											<div>
												<a href="{{ url('/' . $page='profile') }}" class="font-weight-semibold">Anna Ogden</a>
												<small class="d-block text-muted">2 days ago</small>
											</div>
											<div class="ml-auto text-muted">
												<a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.5 5c-1.54 0-3.04.99-3.56 2.36h-1.87C10.54 5.99 9.04 5 7.5 5 5.5 5 4 6.5 4 8.5c0 2.89 3.14 5.74 7.9 10.05l.1.1.1-.1C16.86 14.24 20 11.39 20 8.5c0-2-1.5-3.5-3.5-3.5z" opacity=".3"/><path d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zm-4.4 15.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z"/></svg></a>
												<a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none"/><path d="M21 12v-2h-9l1.34-5.34L9 9v10h9z" opacity=".3"/><path d="M9 21h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.58 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2zM9 9l4.34-4.34L12 10h9v2l-3 7H9V9zM1 9h4v12H1z"/></svg></a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6 col-md-12">
								<div class="card overflow-hidden">
									<div class="item7-card-img">
										<a href="#"></a>
										<img src="{{URL::asset('assets/images/photos/6.jpg')}}" alt="img" class="cover-image w-100">
									</div>
									<div class="card-body">
										<div class="item7-card-desc d-flex mb-5">
											<a href="#" class="d-flex"><svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"/><path d="M4 5.01h16V8H4z" opacity=".3"/></svg><div class="mt-0">Jan-14-2020</div></a>
											<div class="ml-auto">
												<a class="mr-0 d-flex" href="#"><svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 17.17V4H4v12h14.83L20 17.17zM18 14H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z" opacity=".3"/><path d="M4 18h14l4 4-.01-18c0-1.1-.89-2-1.99-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2zM4 4h16v13.17L18.83 16H4V4zm2 8h12v2H6zm0-3h12v2H6zm0-3h12v2H6z"/></svg><div class="mt-0">7 Comments</div></a>
											</div>
										</div>
										<a href="#" class="mt-4"><h5 class="font-weight-semibold">pursue pleasure rationally</h5></a>
										<p>Lorem ipsum dolor quis exercitationem into enim ad minima nostrum itationem </p>
									</div>
									<div class="card-body">
										<div class="d-flex align-items-center mt-auto">
											<div class="avatar brround avatar-md mr-3" style="background-image: url({{URL::asset('assets/images/users/16.jpg')}})"></div>
											<div>
												<a href="{{ url('/' . $page='profile') }}" class="font-weight-semibold">Anna Ogden</a>
												<small class="d-block text-muted">2 days ago</small>
											</div>
											<div class="ml-auto text-muted">
												<a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.5 5c-1.54 0-3.04.99-3.56 2.36h-1.87C10.54 5.99 9.04 5 7.5 5 5.5 5 4 6.5 4 8.5c0 2.89 3.14 5.74 7.9 10.05l.1.1.1-.1C16.86 14.24 20 11.39 20 8.5c0-2-1.5-3.5-3.5-3.5z" opacity=".3"/><path d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zm-4.4 15.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z"/></svg></a>
												<a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none"/><path d="M21 12v-2h-9l1.34-5.34L9 9v10h9z" opacity=".3"/><path d="M9 21h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.58 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2zM9 9l4.34-4.34L12 10h9v2l-3 7H9V9zM1 9h4v12H1z"/></svg></a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6 col-md-12">
								<div class="card overflow-hidden">
									<div class="item7-card-img">
										<a href="#"></a>
										<img src="{{URL::asset('assets/images/photos/7.jpg')}}" alt="img" class="cover-image w-100">
									</div>
									<div class="card-body">
										<div class="item7-card-desc d-flex mb-5">
											<a href="#" class="d-flex"><svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"/><path d="M4 5.01h16V8H4z" opacity=".3"/></svg><div class="mt-0">Jan-14-2020</div></a>
											<div class="ml-auto">
												<a class="mr-0 d-flex" href="#"><svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 17.17V4H4v12h14.83L20 17.17zM18 14H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z" opacity=".3"/><path d="M4 18h14l4 4-.01-18c0-1.1-.89-2-1.99-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2zM4 4h16v13.17L18.83 16H4V4zm2 8h12v2H6zm0-3h12v2H6zm0-3h12v2H6z"/></svg><div class="mt-0">8 Comments</div></a>
											</div>
										</div>
										<a href="#" class="mt-4"><h5 class="font-weight-semibold">consequences that are extremely</h5></a>
										<p>Lorem ipsum dolor quis exercitationem into enim ad minima nostrum itationem </p>
									</div>
									<div class="card-body">
										<div class="d-flex align-items-center mt-auto">
											<div class="avatar brround avatar-md mr-3" style="background-image: url({{URL::asset('assets/images/users/16.jpg')}})"></div>
											<div>
												<a href="{{ url('/' . $page='profile') }}" class="font-weight-semibold">Anna Ogden</a>
												<small class="d-block text-muted">2 days ago</small>
											</div>
											<div class="ml-auto text-muted">
												<a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.5 5c-1.54 0-3.04.99-3.56 2.36h-1.87C10.54 5.99 9.04 5 7.5 5 5.5 5 4 6.5 4 8.5c0 2.89 3.14 5.74 7.9 10.05l.1.1.1-.1C16.86 14.24 20 11.39 20 8.5c0-2-1.5-3.5-3.5-3.5z" opacity=".3"/><path d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zm-4.4 15.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z"/></svg></a>
												<a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none"/><path d="M21 12v-2h-9l1.34-5.34L9 9v10h9z" opacity=".3"/><path d="M9 21h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.58 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2zM9 9l4.34-4.34L12 10h9v2l-3 7H9V9zM1 9h4v12H1z"/></svg></a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6 col-md-12">
								<div class="card overflow-hidden">
									<div class="item7-card-img">
										<a href="#"></a>
										<img src="{{URL::asset('assets/images/photos/8.jpg')}}" alt="img" class="cover-image w-100">
									</div>
									<div class="card-body">
										<div class="item7-card-desc d-flex mb-5">
											<a href="#" class="d-flex"><svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"/><path d="M4 5.01h16V8H4z" opacity=".3"/></svg><div class="mt-0">Feb-14-2020</div></a>
											<div class="ml-auto">
												<a class="mr-0 d-flex" href="#"><svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 17.17V4H4v12h14.83L20 17.17zM18 14H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z" opacity=".3"/><path d="M4 18h14l4 4-.01-18c0-1.1-.89-2-1.99-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2zM4 4h16v13.17L18.83 16H4V4zm2 8h12v2H6zm0-3h12v2H6zm0-3h12v2H6z"/></svg><div class="mt-0">4 Comments</div></a>
											</div>
										</div>
										<a href="#" class="mt-4"><h5 class="font-weight-semibold">Excepteur  occaecat cupidatat</h5></a>
										<p>Lorem ipsum dolor quis exercitationem into enim ad minima nostrum itationem </p>
									</div>
									<div class="card-body">
										<div class="d-flex align-items-center mt-auto">
											<div class="avatar brround avatar-md mr-3" style="background-image: url({{URL::asset('assets/images/users/16.jpg')}})"></div>
											<div>
												<a href="{{ url('/' . $page='profile') }}" class="font-weight-semibold">Anna Ogden</a>
												<small class="d-block text-muted">2 days ago</small>
											</div>
											<div class="ml-auto text-muted">
												<a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.5 5c-1.54 0-3.04.99-3.56 2.36h-1.87C10.54 5.99 9.04 5 7.5 5 5.5 5 4 6.5 4 8.5c0 2.89 3.14 5.74 7.9 10.05l.1.1.1-.1C16.86 14.24 20 11.39 20 8.5c0-2-1.5-3.5-3.5-3.5z" opacity=".3"/><path d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zm-4.4 15.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z"/></svg></a>
												<a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none"/><path d="M21 12v-2h-9l1.34-5.34L9 9v10h9z" opacity=".3"/><path d="M9 21h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.58 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2zM9 9l4.34-4.34L12 10h9v2l-3 7H9V9zM1 9h4v12H1z"/></svg></a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6 col-md-12">
								<div class="card overflow-hidden">
									<div class="item7-card-img">
										<a href="#"></a>
										<img src="{{URL::asset('assets/images/photos/9.jpg')}}" alt="img" class="cover-image w-100">
									</div>
									<div class="card-body">
										<div class="item7-card-desc d-flex mb-5">
											<a href="#" class="d-flex"><svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 3h-1V1h-2v2H7V1H5v2H4c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 2v3H4V5h16zM4 21V10h16v11H4z"/><path d="M4 5.01h16V8H4z" opacity=".3"/></svg><div class="mt-0">Mar-21-2020</div></a>
											<div class="ml-auto">
												<a class="mr-0 d-flex" href="#"><svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 17.17V4H4v12h14.83L20 17.17zM18 14H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z" opacity=".3"/><path d="M4 18h14l4 4-.01-18c0-1.1-.89-2-1.99-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2zM4 4h16v13.17L18.83 16H4V4zm2 8h12v2H6zm0-3h12v2H6zm0-3h12v2H6z"/></svg><div class="mt-0">4 Comments</div></a>
											</div>
										</div>
										<a href="#" class="mt-4"><h5 class="font-weight-semibold">occasionally circumstances</h5></a>
										<p>Lorem ipsum dolor quis exercitationem into enim ad minima nostrum itationem </p>
									</div>
									<div class="card-body">
										<div class="d-flex align-items-center mt-auto">
											<div class="avatar brround avatar-md mr-3" style="background-image: url({{URL::asset('assets/images/users/16.jpg')}})"></div>
											<div>
												<a href="{{ url('/' . $page='profile') }}" class="font-weight-semibold">Anna Ogden</a>
												<small class="d-block text-muted">2 days ago</small>
											</div>
											<div class="ml-auto text-muted">
												<a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.5 5c-1.54 0-3.04.99-3.56 2.36h-1.87C10.54 5.99 9.04 5 7.5 5 5.5 5 4 6.5 4 8.5c0 2.89 3.14 5.74 7.9 10.05l.1.1.1-.1C16.86 14.24 20 11.39 20 8.5c0-2-1.5-3.5-3.5-3.5z" opacity=".3"/><path d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zm-4.4 15.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z"/></svg></a>
												<a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 0 24 24" width="18"><path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none"/><path d="M21 12v-2h-9l1.34-5.34L9 9v10h9z" opacity=".3"/><path d="M9 21h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.58 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2zM9 9l4.34-4.34L12 10h9v2l-3 7H9V9zM1 9h4v12H1z"/></svg></a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--End Row-->

					</div>
				</div><!-- end app-content-->
			</div>
@endsection
@section('js')
@endsection