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
    <link href="{{ asset('admin/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />  
    <style> 
      .select2-container--default .select2-selection--single { height: 42px;    border: 1px solid #dee2e6; }
      .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 42px; }
      .select2-container--default .select2-selection--single .select2-selection__arrow { height: 42px;} 
  
        body, .btn {
            font-family: 'Prompt', sans-serif;  
            font-weight: 300;
        } 
        .bg-main {  
          background: #177ccc; 
        }
        strong {
          font-weight: 400;
        }
    </style> 
</head>

<body class="authentication-bg bg-primary authentication-bg-pattern d-flex align-items-center pb-0 vh-100"> 
    <div class="account-pages w-100 mt-5 mb-5">
        <div class="container"> 
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mb-0"> 
                        <div class="card-body p-4"> 
                            <div class="account-box">
                                <div class="account-logo-box">  
                                  <h5 class="text-uppercase mb-0">ทำการลงทะเบียนสมาชิก</h5>
                                  <p class="mb-0">By Farm chokchai</p>
                                </div>
                                @if(session("success"))
                                  <div class="alert alert-success text-success mt-2" role="alert" style="background: #ecffeb;"> 
                                    <i class="icon-check"></i> {{session("success")}} 
                                  </div> 
                                @endif 
                                @if(session("error"))
                                  <div class="alert alert-danger text-danger mt-2" role="alert" style="background: #ecffeb;"> 
                                    <i class="icon-check"></i> {{session("error")}} 
                                  </div> 
                                @endif 

                                <div class="account-content mt-3">
                                    <form class="form-horizontal" action="{{ route('registration') }}" method="POST"> 
                                    @csrf
                                        <div class="form-group row"> 
                                          <div class="col-md-12"> 
                                            <input class="form-control form-control-lg @error('usersname') is-invalid @enderror" type="text" id="usersname" name="usersname" required="" placeholder="ระบุชื่อ-นามสกุล" required
                                            value="{{ old('usersname') }}">
                                            @error('usersname')
                                              <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                              </span>
                                            @enderror
                                          </div>
                                        </div>

                                        <div class="form-group row"> 
                                          <div class="col-md-12"> 
                                            <input class="form-control form-control-lg @error('email') is-invalid @enderror" type="email" id="email" name="email" required="" placeholder="ระบุอีเมล" required
                                            value="{{ old('email') }}">
                                            @error('email')
                                              <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                              </span>
                                            @enderror
                                          </div>
                                        </div>

                                        <div class="form-group row"> 
                                          <div class="col-md-12"> 
                                            <select id="permission" name="permission" class="form-control" data-toggle="select2" required>
                                              <option value=""> เลือกสิทธิ์ผู้ใช้งาน </option> 
                                              @if(isset($data['Query_permission']))
                                                @foreach($data['Query_permission'] as $row)
                                                  <option title="{{ $row->detail }}" value="{{ $row->id }}"> {{ $row->name }} </option>
                                                @endforeach
                                              @endif  
                                            </select>   
                                            @error('permission')
                                              <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                              </span>
                                            @enderror
                                          </div>
                                        </div>

                                        <div class="form-group row"> 
                                          <div class="col-md-12"> 
                                            <input class="form-control form-control-lg @error('password') is-invalid @enderror" type="password" id="password" name="password" required="" placeholder="ระบุรหัสผ่านของท่าน" required>
                                            @error('password')
                                              <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                              </span>
                                            @enderror
                                          </div>
                                        </div>

                                        <div class="form-group row"> 
                                          <div class="col-md-12"> 
                                            <input class="form-control form-control-lg @error('passwordConfirm') is-invalid @enderror" type="password" id="passwordConfirm" name="password_confirmation" required="" placeholder="ยืนยันรหัสผ่านอีกครั้ง" required>
                                            @error('password_confirmation')
                                              <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                              </span>
                                            @enderror
                                          </div>
                                        </div>
 
                                        <div class="form-group row text-center">
                                          <div class="col-12">
                                            <button class="btn btn-md btn-block btn-dark waves-effect waves-light btn-lg" type="submit">ลงทะเบียน</button>
                                          </div>
                                        </div> 
                                    </form> 
                                    <div class="row pt-2">
                                        <div class="col-sm-12 text-center">
                                            <p class="text-muted mb-0">หากคุณมีบัญชีผู้ใช้งานอยู่แล้ว.<a href="{{ route('login') }}" class="text-dark ml-1"><b>ล็อกอิน</b></a></p>
                                        </div>
                                    </div>

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
    <script src="{{ asset('admin/libs/select2/select2.min.js') }}"></script> 
    <script> 
      $('#permission').select2();
      $( "form" ).submit(function( event ) { 
        $('.text-submit').html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
        $( "form" ).submit();  
      }); 
    </script>
</body>
 
</html>