@extends('layouts.master')
@section('css')
<!--Daterangepicker css-->
<link href="{{URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
						<!--Page header-->
						<div class="page-header">
							<div class="page-leftheader">
								<h4 class="page-title">Hr Dashboard</h4>
							</div>
							<div class="page-rightheader ml-auto d-lg-flex d-none">
								<div class="ml-5 mb-0">
									<a class="btn btn-white date-range-btn" href="#" id="daterange-btn">
										<svg class="header-icon2 mr-3" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
											<path d="M5 8h14V6H5z" opacity=".3"/><path d="M7 11h2v2H7zm12-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2zm-4 3h2v2h-2zm-4 0h2v2h-2z"/>
										</svg> <span>Select Date
										<i class="fa fa-caret-down"></i></span>
									</a>
								</div>
							</div>
						</div>
						<!--End Page header-->
@endsection
@section('content')
						<!--Row-->
						<div class="row">
							<div class="col-lg-4">
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col">
												<div class="mb-2 fs-18 text-muted">
													Total Application
												</div>
												<h1 class="font-weight-bold mb-1">45,675</h1>
												<span class="text-primary"><i class="fa fa-arrow-up mr-1"></i> +1.4%</span>
											</div>
											<div class="col col-auto">
												<div class="mx-auto chart-circle chart-circle-md chart-circle-primary mt-sm-0 mb-0" data-value="0.85" data-thickness="12" data-color="#4454c3">
													<div class="mx-auto chart-circle-value text-center fs-20">85%</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col">
												<div class="mb-2 fs-18 text-muted">
													Shortlisted
												</div>
												<h1 class="font-weight-bold mb-1">30,175</h1>
												<span class="text-success"><i class="fa fa-arrow-up mr-1"></i> +1.8%</span>
											</div>
											<div class="col col-auto">
												<div class="mx-auto chart-circle chart-circle-md chart-circle-success mt-sm-0 mb-0" data-value="0.60" data-thickness="12" data-color="#2dce89">
													<div class="mx-auto chart-circle-value text-center fs-20">60%</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="card">
									<div class="card-body">
										<div class="row">
											<div class="col">
												<div class="mb-2 fs-18 text-muted">
													Rejected
												</div>
												<h1 class="font-weight-bold mb-1">7,745</h1>
												<span class="text-danger"><i class="fa fa-arrow-down mr-1"></i> -2.4%</span>
											</div>
											<div class="col col-auto">
												<div class="mx-auto chart-circle chart-circle-md chart-circle-secondary mt-sm-0 mb-0" data-value="0.45" data-thickness="12" data-color="#f7346b">
													<div class="mx-auto chart-circle-value text-center fs-20">25%</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row row-deck">
							<div class="col-xl-8 col-md-12 col-lg-7">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Project Tracked</h3>
										<div class="d-flex ml-auto">
											<div class="btn-group mb-0">
												<button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">This Year</button>
												<div class="dropdown-menu p-0">
													<a class="dropdown-item" href="#">last Year</a>
													<a class="dropdown-item" href="#">2018</a>
													<a class="dropdown-item" href="#">2017</a>
												</div>
											</div>
										</div>
									</div>
									<div class="card-body">
										<div id="echart5" class="h-300 overflow-hidden"></div>
									</div>
									<div class="card-footer text-left">
										<div class="row">
											<div class="col-xl-4 col-lg-4 col-sm-4 mb-4 mb-sm-0 text-center">
												<h2 class="font-weight-normal text-dark mb-0">1,897</h2>
												<div class="text-muted mb-1 fs-13 d-inline-flex"><div class="w-3 h-3 bg-primary mr-2 mt-1 br-3"></div> Project In</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-sm-4 mb-4 mb-sm-0 text-center">
												<h2 class="font-weight-normal text-dark mb-0">3,785</h2>
												<div class="text-muted mb-1 fs-13 d-inline-flex"><div class="w-3 h-3 bg-secondary mr-2 mt-1 br-3"></div> Project Take</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-sm-4 text-center">
												<h2 class="font-weight-normal text-dark mb-0">16,897</h2>
												<div class="text-muted mb-1 fs-13 d-inline-flex"><div class="w-3 h-3 bg-light-color mr-2 mt-1 br-3"></div> On Hold</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-md-12 col-lg-5">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Best Employees</h3>
										<div class="card-options ">
											<div class="btn-group ml-5 mb-0">
												<a class="option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="#"> Download Print</a>
													<a class="dropdown-item" href="#">Last Week</a>
													<a class="dropdown-item" href="#">Last Month</a>
													<a class="dropdown-item" href="#">Yearly</a>
													<div class="dropdown-divider"></div>
													<a class="dropdown-item" href="#"><i class="fa fa-cog mr-2"></i> Settings</a>
												</div>
											</div>
										</div>
									</div>
									<div class="card-body p-3">
										<div class="table-responsive">
											<table class="table transaction-table mb-0 text-nowrap">
												<tbody>
													<tr>
														<td class="d-flex">
															<img class="w-7 h-7 rounded shadow mr-3" src="{{URL::asset('assets/images/users/1.jpg')}}" alt="media1">
															<div class="mt-1">
																<h6 class="mb-1 font-weight-semibold">John Wisely</h6>
																<small class="text-muted">Angular Developer</small>
															</div>
														</td>
														<td class="text-right">
															<a class="btn btn-white" href="#">Profile</a>
														</td>
													</tr>
													<tr>
														<td class="d-flex">
															<img class="w-7 h-7 rounded shadow mr-3" src="{{URL::asset('assets/images/users/4.jpg')}}" alt="media1">
															<div class="mt-1">
																<h6 class="mb-1 font-weight-semibold">Nicki Fanning</h6>
																<small class="text-muted">Php Developer</small>
															</div>
														</td>
														<td class="text-right">
															<a class="btn btn-white" href="#">Profile</a>
														</td>
													</tr>
													<tr>
														<td class="d-flex">
															<img class="w-7 h-7 rounded shadow mr-3" src="{{URL::asset('assets/images/users/5.jpg')}}" alt="media1">
															<div class="mt-1">
																<h6 class="mb-1 font-weight-semibold">Lula Malone</h6>
																<small class="text-muted">Ui Designer</small>
															</div>
														</td>
														<td class="text-right">
															<a class="btn btn-white" href="#">Profile</a>
														</td>
													</tr>
													<tr>
														<td class="d-flex">
															<img class="w-7 h-7 rounded shadow mr-3" src="{{URL::asset('assets/images/users/2.jpg')}}" alt="media1">
															<div class="mt-1">
																<h6 class="mb-1 font-weight-semibold">Rina Summa</h6>
																<small class="text-muted">Java Developer</small>
															</div>
														</td>
														<td class="text-right">
															<a class="btn btn-white" href="#">Profile</a>
														</td>
													</tr>
													<tr>
														<td class="d-flex">
															<img class="w-7 h-7 rounded shadow mr-3" src="{{URL::asset('assets/images/users/10.jpg')}}" alt="media1">
															<div class="mt-1">
																<h6 class="mb-1 font-weight-semibold">Yadira Acklin</h6>
																<small class="text-muted">Web Developer</small>
															</div>
														</td>
														<td class="text-right">
															<a class="btn btn-white" href="#">Profile</a>
														</td>
													</tr>
													<tr>
														<td class="d-flex">
															<img class="w-7 h-7 rounded shadow mr-3" src="{{URL::asset('assets/images/users/12.jpg')}}" alt="media1">
															<div class="mt-1">
																<h6 class="mb-1 font-weight-semibold">Joanna Latta</h6>
																<small class="text-muted">Angular Developer</small>
															</div>
														</td>
														<td class="text-right">
															<a class="btn btn-white" href="#">Profile</a>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--End Row-->

						<div class="row row-deck">
							<div class="col-xl-4 col-lg-5">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Project Status</h3>
										<div class="d-flex ml-auto">
											<div class="btn-group mb-0">
												<button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">This Year</button>
												<div class="dropdown-menu p-0">
													<a class="dropdown-item" href="#">last Year</a>
													<a class="dropdown-item" href="#">2018</a>
													<a class="dropdown-item" href="#">2017</a>
												</div>
											</div>
										</div>
									</div>
									<div class="card-body mx-auto text-center">
										<div class="overflow-hidden">
											<canvas class="canvasDoughnut" height="240" width="240"></canvas>
										</div>
									</div>
									<div class="card-body p-0">
										<table class="table table-hover mb-0">
											<tbody>
												<tr class="border-bottom">
													<td class="p-3 d-flex"><div class="w-3 h-3 bg-primary mr-2 mt-1 brround"></div> Applications</td>
													<td class="p-3">4,678</td>
													<td class="p-3">68%</td>
												</tr>
												<tr class="border-bottom">
													<td class="p-3 d-flex"><div class="w-3 h-3 bg-secondary mr-2 mt-1 brround"></div> Shortlisted</td>
													<td class="p-3">3,789</td>
													<td class="p-3">55%</td>
												</tr>
												<tr class="border-bottom">
													<td class="p-3 d-flex"><div class="w-3 h-3 bg-success mr-2 mt-1 brround"></div> Rejected</td>
													<td class="p-3">2,137</td>
													<td class="p-3">45%</td>
												</tr>
												<tr class="border-bottom">
													<td class="p-3 d-flex"><div class="w-3 h-3 bg-info mr-2 mt-1 brround"></div> On Hold</td>
													<td class="p-3">1,786</td>
													<td class="p-3">34%</td>
												</tr>
												<tr class="border-bottom">
													<td class="p-3 d-flex"><div class="w-3 h-3 bg-warning mr-2 mt-1 brround"></div> Finalised</td>
													<td class="p-3">897</td>
													<td class="p-3">27%</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="col-xl-8 col-lg-7">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Application Status</h3>
									</div>
									<div class="p-5">
										<div class="row">
											<div class="col">
												<input type="text" class="form-control" placeholder="Search">
											</div>
											<div class="col">
												<input type="text" class="form-control" placeholder="Date">
											</div>
											<div class="col">
												<input type="text" class="form-control" placeholder="Reason">
											</div>
											<div class="col">
												<a class="btn btn-primary btn-block" href="#">Search</a>
											</div>
										</div>
									</div>
									<div class="card-body table-responsive p-0 mx-313 scroll-3">
										<table class="table card-table table-vcenter text-nowrap table-borderedless border-0 inde4-table">
											<thead>
												<tr>
													<th>Code</th>
													<th>Date</th>
													<th>Employee</th>
													<th>Leave</th>
													<th>Period</th>
													<th>Reason</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>2548</td>
													<td>3rd Feb 2019</td>
													<td>Emp-2312</td>
													<td>PL</td>
													<td>1 Day</td>
													<td>Sick</td>
													<td><span class="badge badge-success badge-pill">Approved</span></td>
												</tr>
												<tr>
													<td>4536</td>
													<td>23rd Mar 2019</td>
													<td>Emp-6754</td>
													<td>PL</td>
													<td>1 Day</td>
													<td>Hospital</td>
													<td><span class="badge badge-success badge-pill">Approved</span></td>
												</tr>
												<tr>
													<td>2567</td>
													<td>4th Feb 2019</td>
													<td>Emp-1432</td>
													<td>PL</td>
													<td>1 Day</td>
													<td>Outside</td>
													<td><span class="badge badge-primary badge-pill">Pending</span></td>
												</tr>
												<tr>
													<td>7654</td>
													<td>13th Mar 2019</td>
													<td>Emp-1254</td>
													<td>PL</td>
													<td>1 Day</td>
													<td>Normal</td>
													<td><span class="badge badge-danger badge-pill">Rejected</span></td>
												</tr>
												<tr>
													<td>8754</td>
													<td>28th Feb 2019</td>
													<td>Emp-8765</td>
													<td>PL</td>
													<td>1 Day</td>
													<td>Sick</td>
													<td><span class="badge badge-success badge-pill">Approved</span></td>
												</tr>
												<tr>
													<td>1232</td>
													<td>23rd Apr 2019</td>
													<td>Emp-7643</td>
													<td>PL</td>
													<td>1 Day</td>
													<td>Other Work</td>
													<td><span class="badge badge-danger badge-pill">Rejected</span></td>
												</tr>
												<tr>
													<td>8765</td>
													<td>16th Feb 2019</td>
													<td>Emp-2431</td>
													<td>PL</td>
													<td>1 Day</td>
													<td>Sick</td>
													<td><span class="badge badge-primary badge-pill">Pending</span></td>
												</tr>
												<tr>
													<td>7654</td>
													<td>23rd Mar 2019</td>
													<td>Emp-5643</td>
													<td>PL</td>
													<td>1 Day</td>
													<td>Outside</td>
													<td><span class="badge badge-danger badge-pill">Rejected</span></td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="card-footer text-center">
										<a class="btn-link" href="#">View All</a>
									</div>
								</div>
							</div>
						</div>

						<!-- Row-->
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Employee Details</h3>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-vcenter text-nowrap mb-0 border">
												<thead>
													<tr>
														<th class="border-bottom-0">Employee</th>
														<th class="text-center">Occupation</th>
														<th class="text-center">Projects</th>
														<th class="text-center">Performance</th>
														<th></th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td class="d-flex">
															<img class="avatar-lg rounded-circle mr-3" src="{{URL::asset('assets/images/users/1.jpg')}}" alt="Image description">
															<div class="ml-3 mt-2">
																<h5 class="mb-0 text-dark">Lillian Blake</h5>
																<p class="mb-0  fs-13 text-muted">lillianblake@gmail.com</p>
															</div>
														</td>
														<td class="text-center">Angular Developer</td>
														<td class="text-center">876</td>
														<td>
															<div class="mx-auto chart-circle chart-circle-xs chart-circle-secondary mt-sm-0 mb-0 icon-dropshadow-secondary" data-value="0.45" data-thickness="5" data-color="#f72d66">
																<div class="mx-auto chart-circle-value text-center">45%</div>
															</div>
														</td>
														<td class="text-right"><a class="btn btn-light" href="#"> View Details</a></td>
													</tr>
													<tr>
														<td class="d-flex">
															<img class="avatar-lg rounded-circle mr-3" src="{{URL::asset('assets/images/users/2.jpg')}}" alt="Image description">
															<div class="ml-3 mt-2">
																<h5 class="mb-0 text-dark">Georgine Earle</h5>
																<p class="mb-0  fs-13 text-muted">georgineearle@gmail.com</p>
															</div>
														</td>
														<td class="text-center">Php Developer</td>
														<td class="text-center">342</td>
														<td>
															<div class="mx-auto chart-circle chart-circle-xs chart-circle-primary mt-sm-0 mb-0 icon-dropshadow-primary" data-value="0.55" data-thickness="5" data-color="#4454c3">
																<div class="mx-auto chart-circle-value text-center">55%</div>
															</div>
														</td>
														<td class="text-right"><a class="btn btn-light" href="#"> View Details</a></td>
													</tr>
													<tr>
														<td class="d-flex">
															<img class="avatar-lg rounded-circle mr-3" src="{{URL::asset('assets/images/users/3.jpg')}}" alt="Image description">
															<div class="ml-3 mt-2">
																<h5 class="mb-0 text-dark">Veta Willson</h5>
																<p class="mb-0  fs-13 text-muted">vetawillson@gmail.com</p>
															</div>
														</td>
														<td class="text-center">Web Developer</td>
														<td class="text-center">564</td>
														<td>
															<div class="mx-auto chart-circle chart-circle-xs chart-circle-success mt-sm-0 mb-0 icon-dropshadow-success" data-value="0.85" data-thickness="5" data-color="#2dce89">
																<div class="mx-auto chart-circle-value text-center">85%</div>
															</div>
														</td>
														<td class="text-right"><a class="btn btn-light" href="#"> View Details</a></td>
													</tr>
													<tr>
														<td class="d-flex">
															<img class="avatar-lg rounded-circle mr-3" src="{{URL::asset('assets/images/users/4.jpg')}}" alt="Image description">
															<div class="ml-3 mt-2">
																<h5 class="mb-0 text-dark">Kayleigh Throneberry</h5>
																<p class="mb-0  fs-13 text-muted">kayleighthroneberry@gmail.com</p>
															</div>
														</td>
														<td class="text-center">Web Designer</td>
														<td class="text-center">345</td>
														<td>
															<div class="mx-auto chart-circle chart-circle-xs chart-circle-success mt-sm-0 mb-0 icon-dropshadow-success" data-value="0.90" data-thickness="5" data-color="#2dce89">
																<div class="mx-auto chart-circle-value text-center">90%</div>
															</div>
														</td>
														<td class="text-right"><a class="btn btn-light" href="#"> View Details</a></td>
													</tr>
													<tr>
														<td class="d-flex">
															<img class="avatar-lg rounded-circle mr-3" src="{{URL::asset('assets/images/users/5.jpg')}}" alt="Image description">
															<div class="ml-3 mt-2">
																<h5 class="mb-0 text-dark">Gretta Perro</h5>
																<p class="mb-0  fs-13 text-muted">grettaperro@gmail.com</p>
															</div>
														</td>
														<td class="text-center">Angular Developer</td>
														<td class="text-center">123</td>
														<td>
															<div class="mx-auto chart-circle chart-circle-xs chart-circle-primary mt-sm-0 mb-0 icon-dropshadow-primary" data-value="0.65" data-thickness="5" data-color="#4454c3">
																<div class="mx-auto chart-circle-value text-center">65%</div>
															</div>
														</td>
														<td class="text-right"><a class="btn btn-light" href="#"> View Details</a></td>
													</tr>
													<tr>
														<td class="d-flex">
															<img class="avatar-lg rounded-circle mr-3" src="{{URL::asset('assets/images/users/6.jpg')}}" alt="Image description">
															<div class="ml-3 mt-2">
																<h5 class="mb-0 text-dark">Emelina Poisson</h5>
																<p class="mb-0  fs-13 text-muted">emelinapoisson@gmail.com</p>
															</div>
														</td>
														<td class="text-center">Web Developer</td>
														<td class="text-center">456</td>
														<td>
															<div class="mx-auto chart-circle chart-circle-xs chart-circle-secondary mt-sm-0 mb-0 icon-dropshadow-secondary" data-value="0.40" data-thickness="5" data-color="#f72d66">
																<div class="mx-auto chart-circle-value text-center">40%</div>
															</div>
														</td>
														<td class="text-right"><a class="btn btn-light" href="#"> View Details</a></td>
													</tr>
													<tr>
														<td class="d-flex">
															<img class="avatar-lg rounded-circle mr-3" src="{{URL::asset('assets/images/users/7.jpg')}}" alt="Image description">
															<div class="ml-3 mt-2">
																<h5 class="mb-0 text-dark">Marleen Sohn</h5>
																<p class="mb-0  fs-13 text-muted">marleensohn@gmail.com</p>
															</div>
														</td>
														<td class="text-center">Web Designer</td>
														<td class="text-center">876</td>
														<td class="text-center">
															<div class="mx-auto chart-circle chart-circle-xs chart-circle-primary mt-sm-0 mb-0 icon-dropshadow-primary" data-value="0.65" data-thickness="5" data-color="#4454c3">
																<div class="mx-auto chart-circle-value text-center">65%</div>
															</div>
														</td>
														<td class="text-right"><a class="btn btn-light" href="#"> View Details</a></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- End Row -->
					</div>
				</div><!-- end app-content-->
			</div>
@endsection
@section('js')
<!--Moment js-->
<script src="{{URL::asset('assets/plugins/moment/moment.js')}}"></script>
<!-- Daterangepicker js-->
<script src="{{URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{URL::asset('assets/js/daterange.js')}}"></script>
<!-- ECharts js-->
<script src="{{URL::asset('assets/plugins/echarts/echarts.js')}}"></script>
<!--Chart js -->
<script src="{{URL::asset('assets/plugins/chart/chart.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/chart/chart.extension.js')}}"></script>
<script src="{{URL::asset('assets/plugins/chartjs/chart.js')}}"></script>
<!-- Index js-->
<script src="{{URL::asset('assets/js/index4.js')}}"></script>
@endsection
