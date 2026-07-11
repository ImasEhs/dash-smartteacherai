<!DOCTYPE html>
<!-- saved from url=(0014)about:internet -->
<html lang="en" class="fontawesome-i2svg-active fontawesome-i2svg-complete" data-menu-color="light">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="@yield('meta_desc')">
      <meta name="author" content="CMS">
      <title>@yield('title') - {{ config('app.name') }}</title>
      
      @include('layout.style')
      @yield('style_additional')
      

   </head>
   <body class="show">
      
      <div class="wrapper">

        
        <!-- ========== Topbar Start ========== -->
        @include('layout.top_nav')
        <!-- ========== Topbar End ========== -->

        <!-- ========== Left Sidebar Start ========== -->
        @include('layout.sidebar_and_nav')
        <!-- ========== Left Sidebar End ========== -->

        <!-- ============================================================== -->
        <!-- Start Page Content Here -->
        <!-- ============================================================== -->

        <div class="content-page">
            

            <div class="content">
                @yield('content')
            </div>

            <!-- content -->

            <!-- Footer Start -->
            @include('layout.footer')
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>

      @include('layout.script')
   </body>
</html>