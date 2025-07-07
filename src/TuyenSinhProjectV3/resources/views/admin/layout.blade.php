<!--
=========================================================
* Material Dashboard 3 - v3.2.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets1/img/apple-icon.png')}}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.ico')}}">
  <title>@yield('title', 'TVU-Dashboard')</title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets1/css/nucleo-icons.css')}}" rel="stylesheet" />
  <link href="{{ asset('assets1/css/nucleo-svg.css')}}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets1/css/material-dashboard.css?v=3.2.0')}}" rel="stylesheet" />
  <!-- Custom Admin Dashboard CSS -->
  <link href="{{ asset('assets/css/admin-dashboard.css')}}" rel="stylesheet" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    .main-content {
      margin-left: 230px !important;
    }
  </style>
  <!-- Summernote CSS -->
  <link href="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.css" rel="stylesheet">
</head>
@yield('styles')
<body class="g-sidenav-show  bg-gray-100">
    @include('admin/partials/aside')
    @yield('content')
  <script src="{{ asset('assets1/js/core/popper.min.js')}}"></script>
  <script src="{{ asset('assets1/js/core/bootstrap.min.js')}}"></script>
  <script src="{{ asset('assets1/js/plugins/perfect-scrollbar.min.js')}}"></script>
  <script src="{{ asset('assets1/js/plugins/smooth-scrollbar.min.js')}}"></script>
  <!-- Chart.js CDN for reliable chart functionality -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="{{ asset('assets1/js/plugins/chartjs.min.js')}}"></script>
  <script src="{{ asset('assets1/js/material-dashboard.min.js?v=3.2.0')}}"></script>
  @yield('scripts')
  </body>
  </html>