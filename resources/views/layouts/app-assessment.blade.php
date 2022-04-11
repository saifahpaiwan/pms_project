<!DOCTYPE html>
  <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> 
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <meta name="csrf-token" content="{{ csrf_token() }}"> 
        <title> Humanresort | ระบบจัดการข้อมูลฝ่ายทรัพยากรมนุษย์</title>   
        <link rel="shortcut icon" href="{{ asset('images/logo.png') }}"> 
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@200;300;400;500;600&display=swap" rel="stylesheet">

        <!-- App css -->
        <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
        <link href="{{ asset('admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin/css/app.min.css') }}" rel="stylesheet" type="text/css"  id="app-stylesheet" />
        <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet" type="text/css"  id="app-stylesheet" /> 
        <style> 
            thead {
                background: #777777;
                color: #fff;
            }
        </style>
        @yield('style')
    </head>

    <body style="background: #177ccc;">
 
        <div id="wrapper">  
            <div class="container"> 
                @yield('content')    
            </div> 
        </div>  

        <script src="{{ asset('admin/js/vendor.min.js') }}"></script> 
        <script src="{{ asset('admin/js/app.min.js') }}"></script>  
        @yield('script')
    </body>
</html>