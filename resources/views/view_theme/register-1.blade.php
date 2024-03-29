@extends('layouts.theme.master4')
@section('css')
@endsection
@section('content')
<div class="page h-100">
			<div class="page-single">
				<div class="container">
					<div class="row">
						<div class="col mx-auto">
							<div class="row justify-content-center">
								<div class="col-md-5">
									<div class="card">
										<div class="card-body">
											<div class="text-center title-style mb-6">
												<h1 class="mb-2">Register</h1>
												<hr>
												<p class="text-muted">Create New Account</p>
											</div>
											<div class="btn-list d-flex">
												<a href="https://www.google.com/gmail/" class="btn btn-google btn-block"><i class="fa fa-google fa-1x mr-2"></i> Google</a>
												<a href="https://twitter.com/" class="btn btn-twitter"><i class="fa fa-twitter fa-1x"></i></a>
												<a href="https://www.facebook.com/" class="btn btn-facebook"><i class="fa fa-facebook fa-1x"></i></a>
											</div>
											<hr class="divider my-6">
											<div class="input-group mb-4">
												<div class="input-group-prepend">
													<div class="input-group-text">
														<i class="fe fe-user"></i>
													</div>
												</div>
												<input type="text" class="form-control" placeholder="Username">
											</div>
											<div class="input-group mb-4">
												<div class="input-group-prepend">
													<div class="input-group-text">
														<i class="fe fe-mail"></i>
													</div>
												</div>
												<input type="text" class="form-control" placeholder="Enetr Email">
											</div>
											<div class="input-group mb-4">
												<div class="input-group-prepend">
													<div class="input-group-text">
														<i class="fe fe-lock"></i>
													</div>
												</div>
												<input type="password" class="form-control" placeholder="Password">
											</div>
											<div class="form-group">
												<label class="custom-control custom-checkbox">
													<input type="checkbox" class="custom-control-input" />
													<span class="custom-control-label"><a href="{{url('/' . $page='terms')}}"> Agree the Terms and policy</a></span>
												</label>
											</div>
											<div class="row">
												<div class="col-12">
													<button type="button" class="btn  btn-primary btn-block px-4">Create New Account</button>
												</div>
											</div>
											<div class="text-center pt-4">
												<div class="font-weight-normal fs-16">You Already have an account <a class="btn-link font-weight-normal" href="#">Login Here</a></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
@endsection
@section('js')
@endsection