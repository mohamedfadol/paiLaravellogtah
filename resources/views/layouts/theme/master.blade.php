<!DOCTYPE html>
<html lang="en" dir="rtl">
	<head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="Admitro - Admin Panel HTML template" name="description">
		<meta content="Spruko Technologies Private Limited" name="author">
		<meta name="keywords" content="admin panel ui, user dashboard template, web application templates, premium admin templates, html css admin templates, premium admin templates, best admin template bootstrap 4, dark admin template, bootstrap 4 template admin, responsive admin template, bootstrap panel template, bootstrap simple dashboard, html web app template, bootstrap report template, modern admin template, nice admin template"/>
		@include('layouts.theme.head')

		</head>

		<body class="app sidebar-mini "> 
	<div id="global-loader" >
		<img src="{{URL::asset('public_theme/assets/images/svgs/loader.svg')}}" alt="loader">
	</div>
	<!--- End Global-loader-->

	<!-- Page -->
	<div class="page">
		<div class="page-main">
				@include('layouts.theme.aside-menu')
				<!-- App-Content -->
				<div class="app-content main-content">
					<div class="side-app">
						@include('layouts.theme.header')
						@can('superadmin')
							@yield('page-header')
						@endcan
						@yield('content')
						@include('layouts.theme.footer')
		</div><!-- End Page -->
			@include('layouts.theme.footer-scripts')
	</body>
</html>
