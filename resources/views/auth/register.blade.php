{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ml-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout> --}}

@extends('layouts.theme.master3')
@section('css')
		<!-- INTERNAl Forn-wizard css-->
		<link href="{{URL::asset('public_theme/assets/plugins/forn-wizard/css/forn-wizard.css')}}" rel="stylesheet" />
		<link href="{{URL::asset('public_theme/assets/plugins/formwizard/smart_wizard.css')}}" rel="stylesheet">
		<link href="{{URL::asset('public_theme/assets/plugins/formwizard/smart_wizard_theme_dots-rtl.css')}}" rel="stylesheet">
@endsection
@section('content') 
<div class="page">
			<div class="page-single">
				<div class="p-5">
					<div class="row">
						<div class="col mx-auto">
							<div class="row justify-content-center">
								<div class="col-md-12">
									<div class="card-group mb-0">
										<div class="card p-4">
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
                                        
                                            {{-- star form  --}}

                                             
                                                    <div id="wizard1">
                                                        <h3>Business Information</h3>
                                                        <section>
                                                            <div class="control-group form-group">
                                                                <label class="form-label">Business Name:*</label>
                                                                <input type="text" name="name" class="form-control required" placeholder="Name">
                                                            </div>
                                                            <div class="control-group form-group">
                                                                <label class="form-label">Email</label>
                                                                <input type="email" class="form-control required" placeholder="Email Address">
                                                            </div>
                                                            <div class="control-group form-group">
                                                                <label class="form-label">Phone Number</label>
                                                                <input type="number" class="form-control required" placeholder="Number">
                                                            </div>
                                                            <div class="control-group form-group mb-0">
                                                                <label class="form-label">Address</label>
                                                                <input type="text" class="form-control required" placeholder="Address">
                                                            </div>
                                                        </section>
                                                        <h3>Tax Information</h3>
                                                        <section>
                                                            <div class="table-responsive mg-t-20">
                                                                <table class="table table-bordered">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>Cart Subtotal</td>
                                                                            <td class="text-right">$792.00</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><span>Totals</span></td>
                                                                            <td class="text-right text-muted"><span>$792.00</span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><span>Order Total</span></td>
                                                                            <td><h2 class="price text-right mb-0">$792.00</h2></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </section>
                                                        <h3>Personal Information</h3>
                                                        <section>
                                                            <div class="form-group">
                                                                <label class="form-label" >CardHolder Name</label>
                                                                <input type="text" class="form-control" id="name1" placeholder="First Name">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Card number</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" placeholder="Search for...">
                                                                    <span class="input-group-append">
                                                                        <button class="btn btn-info" type="button"><i class="fa fa-cc-visa"></i> &nbsp; <i class="fa fa-cc-amex"></i> &nbsp;
                                                                        <i class="fa fa-cc-mastercard"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-8">
                                                                    <div class="form-group mb-sm-0">
                                                                        <label class="form-label">Expiration</label>
                                                                        <div class="input-group">
                                                                            <input type="number" class="form-control" placeholder="MM" name="expiremonth">
                                                                            <input type="number" class="form-control" placeholder="YY" name="expireyear">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4 ">
                                                                    <div class="form-group mb-0">
                                                                        <label class="form-label">CVV <i class="fa fa-question-circle"></i></label>
                                                                        <input type="number" class="form-control" required="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </section>
                                                    </div>
                                                 

                                            {{-- end form --}}
											<div class="text-center pt-4">
												<div class="font-weight-normal fs-16">You Already have an account 
                                                    <a class="btn-link font-weight-normal" href="{{route('login')}}">Login Here</a></div>
											</div>
											</div>
										</div>
										{{-- <div class="card text-white bg-primary py-5 d-md-down-none page-content mt-0">
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
										</div> --}}
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
		<!-- INTERNAl Jquery.steps js -->
		<script src="{{URL::asset('public_theme/assets/plugins/jquery-steps/jquery.steps.min.js')}}"></script>
		<script src="{{URL::asset('public_theme/assets/plugins/parsleyjs/parsley.min.js')}}"></script>

		<!-- INTERNAl Forn-wizard js-->
		<script src="{{URL::asset('public_theme/assets/plugins/formwizard/jquery.smartWizard.js')}}"></script>
		<script src="{{URL::asset('public_theme/assets/plugins/formwizard/fromwizard.js')}}"></script>

		<!-- INTERNAl Accordion-Wizard-Form js-->
		<script src="{{URL::asset('public_theme/assets/plugins/accordion-Wizard-Form/jquery.accordion-wizard.min.js')}}"></script>
		<script src="{{URL::asset('public_theme/assets/js/form-wizard-rtl.js')}}"></script>
		<script src="{{URL::asset('public_theme/assets/js/form-wizard2.js')}}"></script>
@endsection
