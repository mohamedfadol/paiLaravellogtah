<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Multi Bootstrap Template - Index</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('fornt_theme/assets/img/favicon.png')}}" rel="icon">
  <link href="{{ asset('fornt_theme/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('fornt_theme/assets/vendor/animate.css/animate.min.css')}}" rel="stylesheet">
  <link href="{{ asset('fornt_theme/assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{ asset('fornt_theme/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('fornt_theme/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{ asset('fornt_theme/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{ asset('fornt_theme/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{ asset('fornt_theme/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{ asset('fornt_theme/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('fornt_theme/assets/css/style.css')}}" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  @include('layouts.theme.web_theme.header')
  <!-- End Header -->

  <!-- ======= Hero Section ======= -->
  @include('layouts.theme.web_theme.crosual')
  
  <!-- End Hero -->

  <main id="main">
   
    @yield('content')

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
    @include('layouts.theme.web_theme.footer')
  <!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('fornt_theme/assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
  <script src="{{ asset('fornt_theme/assets/vendor/aos/aos.js')}}"></script>
  <script src="{{ asset('fornt_theme/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('fornt_theme/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{ asset('fornt_theme/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{ asset('fornt_theme/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{ asset('fornt_theme/assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('fornt_theme/assets/js/main.js')}}"></script>

</body>

</html>