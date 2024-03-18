@extends('layouts.theme.master')
		@section('page-header')
			<!--Page header-->
			<div class="page-header">
				<div class="page-leftheader">
					<h4 class="page-title mb-0">Hi! Welcome Back {{ auth()->user()->name}}</h4>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{url('/' . $page='#')}}"><i class="fe fe-home ml-2 fs-14 float-right "></i>Home</a></li>
						<li class="breadcrumb-item active" aria-current="page"><a href="{{url('/' . $page='#')}}">Sales Dashboard</a></li>
					</ol>
				</div>
				<div class="page-rightheader">
					<div class="btn btn-list">
						<a href="{{route('dashboard.index')}}" class="btn btn-info"><i class="fe fe-settings mr-1"></i> Dashboard </a>
						<a href="{{route('subscritions.index')}}" class="btn btn-danger"><i class="fe fe-printer mr-1"></i> Subscritions </a>
						<a href="{{route('packages.index')}}" class="btn btn-warning"><i class="fe fe-shopping-cart mr-1"></i> Packages </a>
					</div>
				</div>
			</div>
			<!--End Page header-->
		@endsection
				@section('content')
				<!-- Row-1 -->
				<div class="row">
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden dash1-card border-0">
							<div class="card-body">
								<p class=" mb-1 ">Total Sales</p>
								<h2 class="mb-1 number-font">$3,257</h2>
								<small class="fs-12 text-muted">Compared to Last Month</small>
								<span class="ratio bg-warning">76%</span>
								<span class="ratio-text text-muted">Goals Reached</span>
							</div>
							<div id="spark1"></div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden dash1-card border-0">
							<div class="card-body">
								<p class=" mb-1 ">Total User</p>
								<h2 class="mb-1 number-font">1,678</h2>
								<small class="fs-12 text-muted">Compared to Last Month</small>
								<span class="ratio bg-info">85%</span>
								<span class="ratio-text text-muted">Goals Reached</span>
							</div>
							<div id="spark2"></div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden dash1-card border-0">
							<div class="card-body">
								<p class=" mb-1 ">Total Income</p>
								<h2 class="mb-1 number-font">$2,590</h2>
								<small class="fs-12 text-muted">Compared to Last Month</small>
								<span class="ratio bg-danger">62%</span>
								<span class="ratio-text text-muted">Goals Reached</span>
							</div>
							<div id="spark3"></div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden dash1-card border-0">
							<div class="card-body">
								<p class=" mb-1">Total Tax</p>
								<h2 class="mb-1 number-font">$1,954</h2>
								<small class="fs-12 text-muted">Compared to Last Month</small>
								<span class="ratio bg-success">53%</span>
								<span class="ratio-text text-muted">Goals Reached</span>
							</div>
							<div id="spark4"></div>
						</div>
					</div>
				</div>
				<!-- End Row-1 -->
				<!--Row-->
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Top Product Sales Overview</h3>
								<div class="card-options">
									<a href="{{url('/' . $page='#')}}" class="option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-horizontal fs-20"></i></a>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item" href="{{url('/' . $page='#')}}">Today</a>
										<a class="dropdown-item" href="{{url('/' . $page='#')}}">Last Week</a>
										<a class="dropdown-item" href="{{url('/' . $page='#')}}">Last Month</a>
										<a class="dropdown-item" href="{{url('/' . $page='#')}}">Last Year</a>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-vcenter text-nowrap mb-0 table-striped table-bordered border-top">
										<thead class="">
											<tr>
												<th>{{__('business.business_name')}}</th>
												<th>{{__('business.start_date')}}</th>
                                                <th>{{__('business.ownre_name')}}</th>	
                                                <th>{{__('business.email')}}</th>											<th>Stock</th>
												<th>{{__('business.address')}}</th>
												<th>{{__('business.status')}}</th>
                                                <th>{{__('business.current_subcription')}}</th>
                                                <th>{{__('business.actions')}}</th>
											</tr>
										</thead>
										<tbody>
                                            @forelse ($businesses as $business)
                                            <tr>
                                                <td>{{$business->name}}</td>
                                                <td>{{$business->start_date}}</td>
                                                <td>{{$business->owner->name}}</td>
                                                <td>{{$business->owner->email}}</td>
                                                <td>{{$business->getBusinessAddressAttribute()}}</td>
                                                <td>{{$business->created_at}}</td>
                                                <td>
                                                    @if ($business->is_active == 1)
                                                        <span class="bg-success p-1 border">{{__('business.active')}}</span>
                                                    @else
                                                    <span class="bg-danger p-1 border">{{__('business.in_active')}}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($business->subscriptions)
                                                        @forelse ($business->subscriptions as $subscription)
                                                        {{$subscription->paid_via}} <br>
                                                            ({{$subscription->start_date .' - '. $subscription->end_date}})
                                                        @empty
                                                            
                                                        @endforelse 
                                                    @endif
                                                    
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary">Edit</button>
                                                    <button type="button" class="btn btn-danger">delete</button>
                                                </td>
											</tr>
                                            @empty
                                                
                                            @endforelse
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--End row-->

			</div>
		</div>
		<!-- End app-content-->
	</div>
@endsection
@section('js')

	<!--INTERNAL Peitychart js-->
	<script src="{{URL::asset('public_theme/assets/plugins/peitychart/jquery.peity.min.js')}}"></script>
	<script src="{{URL::asset('public_theme/assets/plugins/peitychart/peitychart.init.js')}}"></script>

	<!--INTERNAL Apexchart js-->
	<script src="{{URL::asset('public_theme/assets/js/apexcharts.js')}}"></script>

	<!--INTERNAL ECharts js-->
	<script src="{{URL::asset('public_theme/assets/plugins/echarts/echarts.js')}}"></script>

	<!--INTERNAL Chart js -->
	<script src="{{URL::asset('public_theme/assets/plugins/chart/chart.bundle.js')}}"></script>
	<script src="{{URL::asset('public_theme/assets/plugins/chart/utils.js')}}"></script>

	<!-- INTERNAL Select2 js -->
	<script src="{{URL::asset('public_theme/assets/plugins/select2/select2.full.min.js')}}"></script>
	<script src="{{URL::asset('public_theme/assets/js/select2.js')}}"></script>

	<!--INTERNAL Moment js-->
	<script src="{{URL::asset('public_theme/assets/plugins/moment/moment.js')}}"></script>

	<!--INTERNAL Index js-->
	<script src="{{URL::asset('public_theme/assets/js/index1.js')}}"></script>

@endsection
