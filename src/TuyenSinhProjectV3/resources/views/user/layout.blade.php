<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Tuyển Sinh TVU')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.ico')}}" type="image/x-icon">

    <!-- Font awesome -->
    <link href="{{ asset('assets/css/font-awesome.css')}}" rel="stylesheet">
    <!-- Font Awesome 6 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap -->
    <link href="{{ asset('assets/css/bootstrap.css')}}" rel="stylesheet">   
    <!-- Slick slider -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slick.css')}}">          
    <!-- Fancybox slider -->
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.fancybox.css')}}" type="text/css" media="screen" /> 
    <!-- Theme color -->
    <link id="switcher" href="{{ asset('assets/css/theme-color/default-theme.css')}}" rel="stylesheet">          

    <!-- Main style sheet -->
    <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,300,300italic,500,700' rel='stylesheet' type='text/css'>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Page specific styles -->
    @stack('styles')
    

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body> 
    @include('user/partials/header')
    <main style="margin-top: 0; padding-top: 0;">
        @yield('content')
    </main>
    @include('user/partials/footer')
      <script src="{{ asset('assets/js/jquery.min.js')}}"></script>  
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="{{ asset('assets/js/bootstrap.js')}}"></script>   
  <!-- Slick slider -->
  <script type="text/javascript" src="{{ asset('assets/js/slick.js')}}"></script>
  <!-- Counter -->
  <script type="text/javascript" src="{{ asset('assets/js/waypoints.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/jquery.counterup.js')}}"></script>  
  <!-- Mixit slider -->
  <script type="text/javascript" src="{{ asset('assets/js/jquery.mixitup.js')}}"></script>
  <!-- Add fancyBox -->        
  <script type="text/javascript" src="{{ asset('assets/js/jquery.fancybox.pack.js')}}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <!-- Custom js -->
  <script src="{{ asset('assets/js/custom.js')}}"></script>

  <!-- Page specific scripts -->
  @stack('scripts')
  </body>
  </html>