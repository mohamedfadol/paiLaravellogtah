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
                            <h3 class="card-title">Create New User</h3>
                            <div class="card-options">
                                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                            </div>
                        </div>
                        <div class="card-body">
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
                            {!! Form::open(array('route' => 'users.store','method'=>'POST' ,'id' => 'user_add_form')) !!}
                                <div class="form-row">
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <strong>nik_name:</strong>
                                            {!! Form::text('surname', null, array('placeholder' => 'Surname','class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <strong>first_name:</strong>
                                            {!! Form::text('first_name', null, array('placeholder' => 'First Name','class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <strong>last_name:</strong>
                                            {!! Form::text('last_name',null, array('placeholder' => 'last_name','class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <strong>Email:</strong>
                                            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control','id' => 'email')) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                          <div class="checkbox">
                                            <br/>
                                            <label>
                                                 {!! Form::checkbox('is_active', 'active', true, ['class' => 'input-icheck status']); !!} {{ __('lang_v1.status_for_user') }}
                                            </label>
                                          </div>
                                        </div>
                                      </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Permissions</h3>
                                    </div>
                                    <div class="card-body"> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="checkbox">
                                                  <label>
                                                    {!! Form::checkbox('allow_login', 1, true, 
                                                    [ 'class' => 'input-icheck', 'id' => 'allow_login']); !!} {{ __( 'lang_v1.allow_login' ) }}
                                                  </label>
                                                </div>
                                            </div>
                                          </div>
                                        <div class="form-row">
                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        {!! Form::label('username', __( 'business.username' ) . ':') !!}
                                                        @if(!empty($username_ext))
                                                          <div class="input-group">
                                                            {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => __( 'business.username' ) ]); !!}
                                                            <span class="input-group-addon">{{$username_ext}}</span>
                                                          </div>
                                                          <p class="help-block" id="show_username"></p>
                                                        @else
                                                            {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => __( 'business.username' ) ]); !!}
                                                        @endif
                                                        <p class="help-block">@lang('lang_v1.username_help')</p>
                                                      </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <strong>Password:</strong>
                                                    {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <strong>Confirm Password:</strong>
                                                    {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row-form"> 
                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <strong>Role:</strong>
                                                    {!! Form::select('role', $roles,[], array('class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                        </div>
                                            <div class="row-form"> 
                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <h4>@lang( 'role.access_locations' )  {{__('access_locations_permission')}}</h4>
         
                                                    <div class="col-md-6">
                                                        <div class="col-md-12">
                                                            <div class="checkbox">
                                                                <label>
                                                                {!! Form::checkbox('access_all_locations', 'access_all_locations', true, 
                                                                ['class' => 'input-icheck']); !!} {{ __( 'role.all_locations' ) }} 
                                                                </label>
                                                                {{ __('all_location_permission') }}
                                                            </div>
                                                        </div>
                                                        @foreach($locations as $location)
                                                        <div class="col-md-12">
                                                            <div class="checkbox">
                                                            <label>
                                                                {!! Form::checkbox('location_permissions[]', 'location.' . $location->id, false, 
                                                                [ 'class' => 'input-icheck']); !!} {{ $location->name }} @if(!empty($location->location_id))({{ $location->location_id}}) @endif
                                                            </label>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div> 
                                            </div> 
                                        </div> 
                                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
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
<script>
  $('form#user_add_form').validate({
                rules: {
                    first_name: {
                        required: true,
                    },
                    email: {
                        email: true,
                        remote: {
                            url: "/business/register/check-email",
                            type: "post",
                            data: {
                                email: function() {
                                    return $( "#email" ).val();
                                }
                            }
                        }
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                    confirm_password: {
                        equalTo: "#password"
                    },
                    username: {
                        minlength: 5,
                        remote: {
                            url: "/business/register/check-username",
                            type: "post",
                            data: {
                                username: function() {
                                    return $( "#username" ).val();
                                },
                                @if(!empty($username_ext))
                                  username_ext: "{{$username_ext}}"
                                @endif
                            }
                        }
                    }
                },
                messages: {
                    password: {
                        minlength: 'Password should be minimum 5 characters',
                    },
                    confirm_password: {
                        equalTo: 'Should be same as password'
                    },
                    username: {
                        remote: 'Invalid username or User already exist'
                    },
                    email: {
                        remote: '{{ __("validation.unique", ["attribute" => __("business.email")]) }}'
                    }
                }
            });
  $('#username').change( function(){
    if($('#show_username').length > 0){
      if($(this).val().trim() != ''){
        $('#show_username').html("{{__('lang_v1.your_username_will_be')}}: <b>" + $(this).val() + "{{$username_ext}}</b>");
      } else {
        $('#show_username').html('');
      }
    }
  });
</script>

@endsection
