
<form method="POST" action="{{ route('business.postRegister') }}" id='business_register_form' enctype="multipart/form-data">
    <input id="language" type="hidden" name="language" value="{{request()->lang}}">
    @csrf
    <div id="wizard1">
        <h3>Business Information</h3>
        <section>
            <div class="control-group form-group">
                <label class="form-label">Business Name:*</label>
                <input type="text" name="name" value="{{old('name')}}" class="@error('name') is-invalid @enderror form-control required" placeholder="Business Name" required>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="control-group form-group">
                <label class="form-label">Business Details:*</label>
                <input type="text" name="business_details" value="{{old('business_details')}}" class="@error('business_details') is-invalid @enderror form-control required" placeholder="Business Short Details" required>
                @error('business_details')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                        <label class="form-label">Business Capital:*</label>
                            <input type="text" name="capital" value="{{old('capital')}}" class="@error('capital') is-invalid @enderror form-control required" placeholder="Business Capital" required>
                            @error('capital')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                        <label class="form-label">Business Registration Number:*</label>
                            <input type="text" name="registration_number" value="{{old('registration_number')}}" class="@error('registration_number') is-invalid @enderror form-control required" placeholder="Business Registration Number" required>
                            @error('registration_number')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                    </div>
                </div>
            </div>
            
            <!--<div class="control-group form-group"> -->
            <!--    <div class="form-group">-->
            <!--        <label class="form-label">Business Image Profile</label>-->
            <!--        <input type="file" name="logo" class="dropify" data-height="180" />-->
            <!--    </div>-->
            <!--</div> -->
                        
             
            <div class="control-group form-group">
                <label class="form-label">Start Date:</label>
                <input type="date" name="start_date"  value="{{old('start_date')}}" class="@error('start_date') is-invalid @enderror form-control required" required>
                @error('start_date')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            
        </section>
        <h3>Address Information</h3>
        <section>
            <div class="control-group form-group">
                <label class="form-label">Country:*</label>
                <input type="text" name="country" class="@error('country') is-invalid @enderror form-control required" required
                    placeholder="Country Name"  value="{{old('country')}}">
                    @error('country')<div class="alert alert-danger">{{ $message }}</div>@enderror
            </div>
            <div class="control-group form-group">
                <label class="form-label">State:*</label>
                <input type="text" name="state" class="@error('state') is-invalid @enderror form-control required" required
                     placeholder="State Name" value="{{old('state')}}">
                     @error('state')<div class="alert alert-danger">{{ $message }}</div>@enderror
            </div>
            <div class="control-group form-group">
                <label class="form-label">City:*</label>
                <input type="text" name="city" class="@error('city') is-invalid @enderror form-control required" required
                    placeholder="City Name" value="{{old('city')}}">
                    @error('city')<div class="alert alert-danger">{{ $message }}</div>@enderror
            </div>
            <div class="control-group form-group mb-0">
                <label class="form-label">Business contact number:</label>
                <input type="text" name="mobile"  value="{{old('mobile')}}" class="@error('mobile') is-invalid @enderror form-control required" placeholder="Business contact number" required>
                @error('mobile')<div class="alert alert-danger">{{ $message }}</div>@enderror
            </div>
            <div class="control-group form-group mb-0">
                <label class="form-label">Zip Code:*</label>
                <input type="text" name="zip_code" class="@error('zip_code') is-invalid @enderror form-control required" required
                    placeholder="Zip Code"  value="{{old('zip_code')}}">
                    @error('zip_code')<div class="alert alert-danger">{{ $message }}</div>@enderror
            </div>
            <div class="control-group form-group mb-0">
                <label class="form-label">Time zone:*</label>
                {!! Form::select('time_zone', $timezone_list, config('app.timezone'), ['class' => 'form-control select2_register','placeholder' => __('business.time_zone'), 'required']); !!}
            </div>
        </section>
        <h3>Personal Information</h3>
        <section>
            <div class="form-group">
                <label class="form-label" >Holder Name</label>
                <input type="text" name="surname" class="@error('surname') is-invalid @enderror form-control" id="name1" required
                    placeholder="surname" value="{{old('surname')}}">
                     @error('surname')<div class="alert alert-danger">{{ $message }}</div>@enderror
            </div>
             
            <div class="row">
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                        <label class="form-label">First Name <span class="text-red">*</span></label>
                        <input type="text" name="first_name" class="@error('first_name') is-invalid @enderror form-control" required
                            placeholder="first_name" value="{{old('first_name')}}">
                             @error('first_name')<div class="alert alert-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                        <label class="form-label">Last Name <span class="text-red">*</span></label>
                        <input type="text" name="last_name" class="@error('last_name') is-invalid @enderror form-control" required
                            placeholder="last_name" value="{{old('last_name')}}">
                             @error('last_name')<div class="alert alert-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                        <label class="form-label">Username <span class="text-red">*</span></label>
                        <input id="username" type="text" name="username" class="@error('username') is-invalid @enderror form-control" required
                            placeholder="username" value="{{old('username')}}">
                             @error('username')<div class="alert alert-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                        <label class="form-label">E-mail <span class="text-red">*</span></label>
                        <input id="email" type="text" name="email" class="@error('email') is-invalid @enderror form-control" required
                            placeholder="email" value="{{old('email')}}">
                             @error('email')<div class="alert alert-danger">{{ $message }}</div>@enderror
                    </div> 
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                        <label class="form-label">Password <span class="text-red">*</span></label>
                        <input id="password" type="password" autocomplete="new-password" autocomplete="off" name="password" class="@error('password') is-invalid @enderror form-control" 
                              required  placeholder="Password">
                               @error('password')<div class="alert alert-danger">{{ $message }}</div>@enderror
                    </div> 
                </div> 
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                        <label class="form-label"></label>Ppassword Confirmation <span class="text-red">*</span></label>
                            <input id="password_confirmation" type="password" name="password_confirmation" 
                                class="@error('password_confirmation') is-invalid @enderror form-control" required  placeholder="Password Confirmation" autocomplete="new-password" autocomplete="off">
                                 @error('password_confirmation')<div class="alert alert-danger">{{ $message }}</div>@enderror
                    </div> 
                </div>
            </div>

        </section>
    </div>
    <button type="submit" class="btn  btn-primary btn-block px-4">Create New Account</button>
</form>