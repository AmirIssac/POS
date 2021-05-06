<!--
=========================================================
 Material Dashboard - v2.1.2
=========================================================

 Product Page: https://www.creative-tim.com/product/material-dashboard
 Copyright 2020 Creative Tim (https://www.creative-tim.com)
 Licensed under MIT (https://github.com/creativetimofficial/material-dashboard/blob/master/LICENSE.md)

 Coded by Creative Tim

=========================================================

 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
 <!DOCTYPE html>
 <html lang="fa" dir="rtl">
 
 <head>
   <meta charset="utf-8" />
   <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/apple-icon.png')}}">
   <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}">
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
   <title>
    Dani App 
  </title>
   <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
   <!-- Extra details for Live View on GitHub Pages -->
   <!-- Canonical SEO -->
  
   <!--     Fonts and icons     -->
   <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
   <!-- Markazi Text font include just for persian demo purpose, don't include it in your project -->
   <link href="https://fonts.googleapis.com/css?family=Cairo&amp;subset=arabic" rel="stylesheet">
   <!-- CSS Files -->
   <link href="{{asset('css/material-dashboard.min.css?v=2.1.2')}}" rel="stylesheet" />
   <link href="{{asset('css/material-dashboard-rtl.min.css?v=1.1')}}" rel="stylesheet" />
   <!-- CSS Just for demo purpose, don't include it in your project -->
   <link href="{{asset('demo/demo.css')}}" rel="stylesheet" />
   <style>
     body{
       text-align: right !important;
       direction: rtl !important;
     }
     form a:hover{
       color: white !important;
     }
     .ps-scrollbar-x{
       display: none !important;   /* hide scroll bar */
     }
    </style>
   @yield('links')
 
   <!-- End Google Tag Manager -->
   <!-- Style Just for persian demo purpose, don't include it in your project -->
   <style>
     body,
     h1,
     h2,
     h3,
     h4,
     h5,
     h6,
     .h1,
     .h2,
     .h3,
     .h4 {
       font-family: "Cairo";
     }
   </style>
 </head>
 <body class="">
    <!-- Extra details for Live View on GitHub Pages -->
  
    <div class="wrapper ">
      <div class="sidebar" data-color="purple" data-background-color="white" data-image="{{asset('img/sidebar-1.jpg')}}">
        <!--
          Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"
  
          Tip 2: you can also add an image using data-image tag
      -->
        <div class="logo">
          <a href="http://www.creative-tim.com" class="simple-text logo-normal">
           Dani App
          </a>
        </div>
        <div class="sidebar-wrapper">
          <ul class="nav">
            @can('لوحة التحكم')
            <li class="nav-item {{ request()->is('dashboard')||request()->is('/') ? 'active' : '' }}">
              <a class="nav-link" href="/">
                <i class="material-icons">dashboard</i>
                <p>لوحة التحكم</p>
              </a>
            </li>
            @endcan
            @can('المناصب')
            <li class="nav-item {{ request()->is('roles')||request()->is('role/add/form')||request()->is('edit/role/permissions/*') ? 'active' : '' }}">
             <a class="nav-link" href="{{route('roles')}}">
               <i class="material-icons">
                 work </i>
               <p> المناصب</p>
             </a>
           </li>
           @endcan
           @can('صلاحيات الوصول')
           <li class="nav-item {{ request()->is('permissions')||request()->is('permission/add/form') ? 'active' : '' }} ">
            <a class="nav-link" href="{{route('permissions')}}">
              <i class="material-icons">
                accessibility</i>
              <p> صلاحيات الوصول</p>
            </a>
          </li>
          @endcan
  
          @can('المخازن')
          <li class="nav-item {{ request()->is('repositories')||request()->is('repositories/create')? 'active' : ''}}">
            <a class="nav-link" href="{{route('repositories.index')}}">
              <i class="material-icons">storefront</i>
              <p>المخازن</p>
            </a>
          </li>
           @endcan 
           @can('لوحة تحكم مالك-مخزن')
            <li class="nav-item {{ request()->is('dashboard')||request()->is('/') ? 'active' : '' }}">
              <a class="nav-link" href="/">
                <i class="material-icons">dashboard</i>
                <p>لوحة تحكم مالك-مخزن</p>
              </a>
            </li>
            @endcan
            @can('المبيعات')
           <li class="nav-item {{ request()->is('sales')? 'active' : ''}}">
            <a class="nav-link" href="{{route('sales.index')}}">
              <i class="material-icons">shopping_bag</i>
              <p>المبيعات</p>
            </a>
          </li>
          @endcan
          @can('التقارير')
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="material-icons">receipt_long</i>
              <p>التقارير</p>
            </a>
          </li>
         @endcan
          @can('المخزون')
          <li class="nav-item {{ request()->is('repository')||request()->is('add/product/form/*')||request()->is('show/products/*')||request()->is('import/products/excel/*')? 'active' : ''}}">
            <a class="nav-link" href="{{route('repository.index')}}">
              <i class="material-icons">store</i>
              <p>المخزون</p>
            </a>
          </li>
          @endcan








            

















           
          </ul>
        </div>
      </div>
       <!-- Navbar -->

    <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
      <div class="container-fluid">
        <div class="navbar-wrapper">
         
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
          <span class="sr-only">Toggle navigation</span>
          <span class="navbar-toggler-icon icon-bar"></span>
          <span class="navbar-toggler-icon icon-bar"></span>
          <span class="navbar-toggler-icon icon-bar"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end">
          <form class="navbar-form">
            <div class="input-group no-border">
              <input type="text" value="" class="form-control" placeholder="Search...">
              <button type="submit" class="btn btn-white btn-round btn-just-icon">
                <i class="material-icons">search</i>
                <div class="ripple-container"></div>
              </button>
            </div>
          </form>
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="javascript:;">
                <i class="material-icons">email</i>
                <p class="d-lg-none d-md-block">
                  صندوق البريد
                </p>
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="material-icons">notifications</i>
                <span class="notification">1</span>
                <p class="d-lg-none d-md-block">
                  الإشعارات
                </p>
              </a>
              <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="#"> سنضع الإشعارات هنا </a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="material-icons">account_circle</i>
                <p class="d-lg-none d-md-block">
                  الحساب
                </p>
              </a>
              <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdownProfile">
                <a class="dropdown-item" href="#">الحساب</a>
                <a class="dropdown-item" href="#">الاعدادات</a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{route('logout')}}">
                  @csrf
                  <a style="cursor: pointer;color:red;" onclick="this.parentNode.submit();" class="dropdown-item">تسجيل الخروج</a>
                </form>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
 <!-- End Navbar -->
 @yield('body')
  <!--   Core JS Files   -->
  <script src="{{asset('js/core/jquery.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('js/core/popper.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('js/core/bootstrap-material-design.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
  <!--  Google Maps Plugin    -->
  {{--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2Yno10-YTnLjjn_Vtk0V8cdcY5lC4plU"></script>--}}
  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Chartist JS -->
  <script src="{{asset('js/plugins/chartist.min.js')}}"></script>
  <!--  Notifications Plugin    -->
  <script src="{{asset('js/plugins/bootstrap-notify.js')}}"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{asset('js/material-dashboard.min.js?v=2.1.2')}}" type="text/javascript"></script>
  
 
 @yield('scripts')
    </body>
 </html>