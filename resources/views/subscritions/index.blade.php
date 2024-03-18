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
						<a href="{{route('packages.index')}}" class="btn btn-warning"><i class="fe fe-shopping-cart mr-1"></i> Ppackages </a>
					</div>
				</div>
			</div>
			<!--End Page header-->
		@endsection
				@section('content') 
				<!--Row-->
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Top Subscriptions</h3>
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
                                                <th>{{__('business.package_name')}}</th>
												<th>{{__('business.start_date')}}</th>
                                                <th>{{__('business.trial_end_date')}}</th>
                                                <th>{{__('business.end_date')}}</th>
                                                <th>{{__('business.status')}}</th>
                                                <th>{{__('business.package_price')}}</th>	
                                                <th>{{__('business.payment_transaction_id')}}</th>
												<th>{{__('business.paid_via')}}</th>
                                                <th>{{__('business.actions')}}</th>
											</tr>
										</thead>
										<tbody>
                                            @forelse ($subscriptions as $subscription)
                                            <tr>
                                                <td>{{$subscription->business->name}}</td>
                                                <td>{{$subscription->package->name}}</td>
                                                <td>{{$subscription->start_date}}</td>
                                                <td>{{$subscription->trial_end_date}}</td>
                                                <td>{{$subscription->end_date}}</td>
                                                <td>
                                                    @if ($subscription->status == "waiting")
                                                    <span class="bg-warning p-1 text-white border">{{$subscription->status}}</span>
                                                    @elseif($subscription->status == "approved")
                                                    <span class="bg-success p-1 text-white border">{{$subscription->status}}</span>
                                                    @else
                                                    <span class="bg-danger p-1 text-white border">{{$subscription->status}}</span>
                                                    @endif
                                                    
                                                </td>
                                                <td>{{$subscription->package_price}}</td>
                                                <td>{{$subscription->payment_transaction_id}}</td>
                                                <td>{{$subscription->paid_via}}</td>
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
