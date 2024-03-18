		<!-- Title -->
		<title>@yield('title') - {{ config('app.name', 'Diligov') }}</title>

		<!--Favicon -->
		<link rel="icon" href="{{URL::asset('public_theme/assets/images/brand/favicon.ico')}}" type="image/x-icon"/>

		<!--Bootstrap css -->
		<link href="{{URL::asset('public_theme/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

		<!-- Style css -->
		<link href="{{URL::asset('public_theme/assets/css-rtl/style.css')}}" rel="stylesheet" />
		<link href="{{URL::asset('public_theme/assets/css-rtl/dark.css')}}" rel="stylesheet" />
		<link href="{{URL::asset('public_theme/assets/css-rtl/skin-modes.css')}}" rel="stylesheet" />

		<!-- Animate css -->
		<link href="{{URL::asset('public_theme/assets/css-rtl/animated.css')}}" rel="stylesheet" />
		<!---Icons css-->
		<link href="{{URL::asset('public_theme/assets/css-rtl/icons.css')}}" rel="stylesheet" />

        <!-- INTERNAl Data table css -->
        <link href="{{URL::asset('public_theme/assets/plugins/datatable/css/dataTables.bootstrap4.min-rtl.css')}}" rel="stylesheet" />
        <link href="{{URL::asset('public_theme/assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
        <link href="{{URL::asset('public_theme/assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />


        <!--- INTERNAL Sweetalert css-->
        <link href="{{URL::asset('public_theme/assets/plugins/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" />
        <link href="{{URL::asset('public_theme/assets/plugins/toastr/toastr.min.css')}}" rel="stylesheet" />

		@yield('css')
	    <!-- Color Skin css -->
		<link id="theme" href="{{URL::asset('public_theme/assets/colors-rtl/color1.css')}}" rel="stylesheet" type="text/css"/>
