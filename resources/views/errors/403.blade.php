<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title> Humanresort | ระบบจัดการข้อมูลฝ่ายทรัพยากรมนุษย์</title>   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">  
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@100;200;300;400;500&display=swap" rel="stylesheet">

    <!-- App css -->
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <link href="{{ asset('admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/css/app.min.css') }}" rel="stylesheet" type="text/css"  id="app-stylesheet" />
    <style> 
        body, .btn {
            font-family: 'Prompt', sans-serif;  
            font-weight: 400;
            font-size: 14px;
        }  
        .bg-main {  
          background: #177ccc; 
        }
        strong {
          font-weight: 400;
        }
 
    </style> 
</head>

<body class="authentication-bg bg-main authentication-bg-pattern d-flex align-items-center pb-0 vh-100">   
    <div class="account-pages w-100 mt-5 mb-5">
        <div class="container"> 
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mb-0"> 
                        <div class="card-body"> 
                            <div class="account-box">
                                <div class="account-logo-box text-center">  
                                  <h1 class="text-uppercase mb-0"> Oops! </h1>
                                  <h4 class="text-uppercase mb-0">403 | FORBIDDEN</h4>
                                  <div class="mt-2">ขออภัยเกิดข้อผิดพลาดไม่พบหน้าที่ร้องขอ <br>หรือสิทธ์การเข้าถึงไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง</div>
                                  
                                  <a href="{{ route('dashboard') }}" class="btn btn-md btn-block btn-primary waves-effect waves-light btn-lg mt-2">
                                  ย้อนกลับหน้าหลัก
                                  </a> 
                                </div>  
                            </div>
                        </div> 
                    </div> 
                </div> 
        </div> 
    </div> 
  </div> 
    <script src="{{ asset('admin/js/vendor.min.js') }}"></script> 
    <script src="{{ asset('admin/js/app.min.js') }}"></script>  
</body>
 
</html>