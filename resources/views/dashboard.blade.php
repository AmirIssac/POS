@extends('layouts.main')
@section('body')

     <div class="main-panel">
      
       <div class="content">
         <div class="container-fluid">
           <div class="row">
             <div class="col-lg-3 col-md-6 col-sm-6">
               <div class="card card-stats">
                 <div class="card-header card-header-warning card-header-icon">
                   <div class="card-icon">
                     <i class="material-icons">content_copy</i>
                   </div>
                   <p class="card-category">فضا مصرف شده</p>
                   <h3 class="card-title">49/50
                     <small>GB</small>
                   </h3>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons text-danger">warning</i>
                     <a href="#pablo">فضای بیشتری داشته باشید...</a>
                   </div>
                 </div>
               </div>
             </div>
             <div class="col-lg-3 col-md-6 col-sm-6">
               <div class="card card-stats">
                 <div class="card-header card-header-success card-header-icon">
                   <div class="card-icon">
                     <i class="material-icons">store</i>
                   </div>
                   <p class="card-category">سود</p>
                   <h3 class="card-title">$34,245</h3>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">date_range</i>۲۴ ساعت اخیر
                   </div>
                 </div>
               </div>
             </div>
             <div class="col-lg-3 col-md-6 col-sm-6">
               <div class="card card-stats">
                 <div class="card-header card-header-danger card-header-icon">
                   <div class="card-icon">
                     <i class="material-icons">info_outline</i>
                   </div>
                   <p class="card-category">مشکلات حل شده</p>
                   <h3 class="card-title">75</h3>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">local_offer</i> توسط گیت‌هاب
                   </div>
                 </div>
               </div>
             </div>
             <div class="col-lg-3 col-md-6 col-sm-6">
               <div class="card card-stats">
                 <div class="card-header card-header-info card-header-icon">
                   <div class="card-icon">
                     <i class="fa fa-twitter"></i>
                   </div>
                   <p class="card-category">دنبال‌کننده</p>
                   <h3 class="card-title">+245</h3>
                 </div>
                 <div class="card-footer">
                   <div class="stats">
                     <i class="material-icons">update</i> هم‌اکنون
                   </div>
                 </div>
               </div>
             </div>
           </div>
           
     <script>
       $(document).ready(function() {
         // Javascript method's body can be found in assets/js/demos.js
         md.initDashboardPageCharts();
 
       });
     </script>
     <!-- Sharrre libray -->
     <script src="{{asset('demo/jquery.sharrre.js')}}"></script>
     <script>
       $(document).ready(function() {
 
         $('#facebook').sharrre({
           share: {
             facebook: true
           },
           enableHover: false,
           enableTracking: false,
           enableCounter: false,
           click: function(api, options) {
             api.simulateClick();
             api.openPopup('facebook');
           },
           template: '<i class="fab fa-facebook-f"></i> Facebook',
           url: 'https://demos.creative-tim.com/material-dashboard/examples/dashboard.html'
         });
 
         $('#google').sharrre({
           share: {
             googlePlus: true
           },
           enableCounter: false,
           enableHover: false,
           enableTracking: true,
           click: function(api, options) {
             api.simulateClick();
             api.openPopup('googlePlus');
           },
           template: '<i class="fab fa-google-plus"></i> Google',
           url: 'https://demos.creative-tim.com/material-dashboard/examples/dashboard.html'
         });
 
         $('#twitter').sharrre({
           share: {
             twitter: true
           },
           enableHover: false,
           enableTracking: false,
           enableCounter: false,
           buttons: {
             twitter: {
               via: 'CreativeTim'
             }
           },
           click: function(api, options) {
             api.simulateClick();
             api.openPopup('twitter');
           },
           template: '<i class="fab fa-twitter"></i> Twitter',
           url: 'https://demos.creative-tim.com/material-dashboard/examples/dashboard.html'
         });
 
         // Facebook Pixel Code Don't Delete
         ! function(f, b, e, v, n, t, s) {
           if (f.fbq) return;
           n = f.fbq = function() {
             n.callMethod ?
               n.callMethod.apply(n, arguments) : n.queue.push(arguments)
           };
           if (!f._fbq) f._fbq = n;
           n.push = n;
           n.loaded = !0;
           n.version = '2.0';
           n.queue = [];
           t = b.createElement(e);
           t.async = !0;
           t.src = v;
           s = b.getElementsByTagName(e)[0];
           s.parentNode.insertBefore(t, s)
         }(window,
           document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
 
         try {
           fbq('init', '111649226022273');
           fbq('track', "PageView");
 
         } catch (err) {
           console.log('Facebook Track Error:', err);
         }
 
       });
     </script>
     <noscript>
       <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=111649226022273&ev=PageView&noscript=1" />
     </noscript>
     <script>
       $(document).ready(function() {
         $().ready(function() {
           $sidebar = $('.sidebar');
           $sidebar_img_container = $sidebar.find('.sidebar-background');
 
           $full_page = $('.full-page');
 
           $sidebar_responsive = $('body > .navbar-collapse');
           sidebar_mini_active = true;
 
           window_width = $(window).width();
 
           fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();
 
           // if( window_width > 767 && fixed_plugin_open == 'Dashboard' ){
           //     if($('.fixed-plugin .dropdown').hasClass('show-dropdown')){
           //         $('.fixed-plugin .dropdown').addClass('show');
           //     }
           //
           // }
 
           $('.fixed-plugin a').click(function(event) {
             // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
             if ($(this).hasClass('switch-trigger')) {
               if (event.stopPropagation) {
                 event.stopPropagation();
               } else if (window.event) {
                 window.event.cancelBubble = true;
               }
             }
           });
 
           $('.fixed-plugin .background-color span').click(function() {
             $(this).siblings().removeClass('active');
             $(this).addClass('active');
 
             var new_color = $(this).data('color');
 
             if ($sidebar.length != 0) {
               $sidebar.attr('data-color', new_color);
             }
 
             if ($full_page.length != 0) {
               $full_page.attr('filter-color', new_color);
             }
 
             if ($sidebar_responsive.length != 0) {
               $sidebar_responsive.attr('data-color', new_color);
             }
           });
 
           $('.fixed-plugin .img-holder').click(function() {
             $full_page_background = $('.full-page-background');
 
             $(this).parent('li').siblings().removeClass('active');
             $(this).parent('li').addClass('active');
 
 
             var new_image = $(this).find("img").attr('src');
 
             if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
               $sidebar_img_container.fadeOut('fast', function() {
                 $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
                 $sidebar_img_container.fadeIn('fast');
               });
             }
 
             if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
               var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');
 
               $full_page_background.fadeOut('fast', function() {
                 $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
                 $full_page_background.fadeIn('fast');
               });
             }
 
             if ($('.switch-sidebar-image input:checked').length == 0) {
               var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
               var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');
 
               $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
               $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
             }
 
             if ($sidebar_responsive.length != 0) {
               $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
             }
           });
 
           $('.switch-sidebar-image input').on("switchChange.bootstrapSwitch", function() {
             $full_page_background = $('.full-page-background');
 
             $input = $(this);
 
             if ($input.is(':checked')) {
               if ($sidebar_img_container.length != 0) {
                 $sidebar_img_container.fadeIn('fast');
                 $sidebar.attr('data-image', '#');
               }
 
               if ($full_page_background.length != 0) {
                 $full_page_background.fadeIn('fast');
                 $full_page.attr('data-image', '#');
               }
 
               background_image = true;
             } else {
               if ($sidebar_img_container.length != 0) {
                 $sidebar.removeAttr('data-image');
                 $sidebar_img_container.fadeOut('fast');
               }
 
               if ($full_page_background.length != 0) {
                 $full_page.removeAttr('data-image', '#');
                 $full_page_background.fadeOut('fast');
               }
 
               background_image = false;
             }
           });
 
           $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function() {
             var $btn = $(this);
 
             if (sidebar_mini_active == true) {
               $('body').removeClass('sidebar-mini');
               sidebar_mini_active = false;
               materialDashboard.showSidebarMessage('Sidebar mini deactivated...');
             } else {
               $('body').addClass('sidebar-mini');
               sidebar_mini_active = true;
               materialDashboard.showSidebarMessage('Sidebar mini activated...');
             }
 
             // we simulate the window Resize so the charts will get updated in realtime.
             var simulateWindowResize = setInterval(function() {
               window.dispatchEvent(new Event('resize'));
             }, 180);
 
             // we stop the simulation of Window Resize after the animations are completed
             setTimeout(function() {
               clearInterval(simulateWindowResize);
             }, 1000);
           });
         });
         if (window_width > 767) {
           if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
             $('.fixed-plugin .dropdown').addClass('show');
             $('.fixed-plugin .dropdown-menu').addClass('show');
           }
         }
       });
     </script>
 </body>
 @endsection