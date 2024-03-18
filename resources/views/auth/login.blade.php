{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
 
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button class="ml-3">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout> --}}


@extends('layouts.theme.master3')
@section('css')
@endsection
@section('content')
<div class="page">
			<div class="page-single">
				<div class="p-5">
					<div class="row">
						<div class="col mx-auto">
							<div class="row justify-content-center">
								<div class="col-lg-9 col-xl-8">
									<div class="card-group mb-0">
										<div class="card p-4">
											<div class="card-body">
												<div class="text-center title-style mb-6">
													<h1 class="mb-2">Login</h1>
													<hr>
													<p class="text-muted">Sign In to your account</p>
                                                    <x-auth-session-status class="mb-3 text-danger" :status="session('status')" />
												</div>
												<div class="btn-list d-flex">
													<a href="https://www.google.com/gmail/" class="btn btn-google btn-block"><i class="fa fa-google fa-1x mr-2"></i> Google</a>
													<a href="https://twitter.com/" class="btn btn-twitter"><i class="fa fa-twitter fa-1x"></i></a>
													<a href="https://www.facebook.com/" class="btn btn-facebook"><i class="fa fa-facebook fa-1x"></i></a>
												</div>
												<hr class="divider my-6">
                                                <!-- Session Status -->
                                                <form method="POST" action="{{ route('login') }}">
                                                    @csrf
												<div class="input-group mb-4">
													<div class="input-group-prepend">
														<div class="input-group-text">
															<i class="fe fe-user"></i>
														</div>
													</div>
													<input  id="email"
                                                                type="email" 
                                                                    name="email" 
                                                                        class="form-control" 
                                                                            placeholder="Enter Email"
                                                                                value="{{old('email')}}" required autofocus>
                                                                
												</div>
                                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
												<div class="input-group mb-4">
													<div class="input-group-prepend">
														<div class="input-group-text">
															<i class="fe fe-lock"></i>
														</div>
													</div>
													<input id="password" type="password" 
                                                                name="password" 
                                                                    class="form-control" 
                                                                        placeholder="Enter Password"
                                                                            required autocomplete="current-password">
												</div>
                                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
												<div class="row">
													<div class="col-12">
														<button type="submit" class="btn btn-primary btn-block px-4">{{ __('Log in') }}</button>
													</div>
                                                    <!-- Remember Me -->
                                                <div class="block mt-4">
                                                    <label for="remember_me" class="inline-flex items-center">
                                                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                                                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                                    </label>
                                                </div>
													<div class="col-12 text-center">
                                                        @if (Route::has('password.request'))
                                                            <a href="{{ route('password.request') }}" class="btn btn-link box-shadow-0 px-0">{{ __('Forgot your password?') }}</a>
                                                        @endif
													</div>
												</div>
                                                </form>
												<div class="text-center pt-4">
													<div class="font-weight-normal fs-16">You Don't have an account <a class="btn-link font-weight-normal" href="{{route('business.getRegister')}}">Register Here</a></div>
												</div>
											</div>
										</div>
										<div class="card text-white bg-primary py-5 d-md-down-none page-content mt-0">
											<div class="text-center justify-content-center page-single-content">
												<div class="box">
													<div></div>
													<div></div>
													<div></div>
													<div></div>
													<div></div>
													<div></div>
													<div></div>
													<div></div>
													<div></div>
													<div></div>
												</div>
												<img src="{{URL::asset('public_theme/assets/images/png/login.png')}}" alt="img">
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