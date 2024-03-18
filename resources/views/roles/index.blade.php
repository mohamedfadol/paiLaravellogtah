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
                                <div class="row">
                                    <div class="col-lg-12 margin-tb">
                                        <div class="pull-left">
                                            <h2>Role Management</h2>
                                        </div>
                                        <div class="pull-right">
                                        @can('role-create')
                                            <a class="btn btn-success" href="{{ route('roles.create') }}"> Create New Role</a>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success">
                                        <p>{{ $message }}</p>
                                    </div>
                                @endif
                                <table class="table table-bordered">
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th width="280px">Action</th>
                                    </tr>
                                    
                                    @foreach ($roles as $key => $role)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>
                                            @can('role-edit')
                                                <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                                            @endcan
                                            @can('role-delete')
                                                {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                                {!! $roles->render() !!}
                                <p class="text-center text-primary"><small>Tutorial by LaravelTuts.com</small></p>
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


@endsection
