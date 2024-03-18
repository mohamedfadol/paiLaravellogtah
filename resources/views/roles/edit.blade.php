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
                                    <h2>Edit Role</h2>
                                </div>
                                <div class="pull-right">
                                    <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
                                </div>
                            </div>
                        </div>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                </ul>
                            </div>
                        @endif
                        {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Permission:</strong>
                                    <br/>
                                    @foreach($permission as $value)
                                        <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                        {{ $value->name }}</label>
                                    <br/>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
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
