@extends('layouts.app')
@section('style')      
  <link href="{{ asset('admin/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />   
  <link href="{{ asset('admin/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />  
  <style> 
    .select2-container--default .select2-selection--single { height: 42px;    border: 1px solid #dee2e6; }
    .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 42px; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height: 42px;} 
  </style>
@endsection
@section('content')
    <div class="content"> 
      <div class="container-fluid"> 
        <div class="row">
          <div class="col-12">
              <div class="page-title-box"> 
                  <h4 class="page-title"> <i class="fe-users"></i>  จัดการสิทธิ์ผู้ใช้งาน  </h4>
              </div>
          </div>
        </div>   
         
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header" style="background: #ddd;">  
                <div class="row">  
                  <div class="col-md-6"> 
                    <div class="m-0 h5"> เพิ่มข้อมูลผู้เข้าใช้งานระบบ  </div>
                  </div>
                  <div class="col-md-6 text-right"> 
                    <a href="{{ route('request.access') }}" class="m-0 h5"><i class="fe-chevron-left"></i> ย้อนกลับ </a> 
                  </div>   
                </div>
              </div>
              <div class="card-body">  
                @if(session("success"))
                  <div class="alert alert-success text-success mt-2" role="alert" style="background: #ecffeb;"> 
                    <i class="icon-check"></i> {{session("success")}} 
                  </div> 
                @endif  
                @if($errors->any())
                  <div class="alert alert-danger">
                      <p><strong>Opps Something went wrong</strong></p>
                      <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                      </ul>
                  </div>
              @endif
                <form method="POST" action="{{ route('save.permissions') }}" id="form" enctype="multipart/form-data">
                  @csrf  
                  <input type="hidden" id="statusData" name="statusData" value="C">
                  <input type="hidden" id="id" name="id" value="">

                  <div class="row"> 
                    <div class="col-md-6 form-group"> 
                      <label class="ml-1" for="usersname"> ชื่อ-นามสกุล <span class="text-danger">*</span></label>
                      <input id="usersname" type="text" class="form-control form-control-lg @error('usersname') invalid @enderror" name="usersname"  
                      value="{{ old('usersname') }}"
                      required autocomplete="usersname" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('usersname')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    <div class="col-md-6 form-group"> 
                      <label class="ml-1" for="email"> อีเมล <span class="text-danger">*</span></label>
                      <input id="email" type="email" class="form-control form-control-lg @error('email') invalid @enderror" name="email"  
                      value="{{ old('email') }}"
                      required autocomplete="email" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('email')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    <div class="col-md-6"> 
                      <label class="ml-1" for="permission"> เลือกสิทธิ์ผู้ใช้งาน <span class="text-danger">*</span></label>
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
                    <div class="col-md-3 form-group"> 
                      <label class="ml-1" for="password"> รหัสผ่าน <span class="text-danger">*</span></label>
                      <input id="password" type="password" class="form-control form-control-lg @error('password') invalid @enderror" name="password"  
                      required autocomplete="password" autofocus placeholder="โปรดระบุรหัสผ่าน ****"> 
                      @error('password')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    <div class="col-md-3 form-group"> 
                      <label class="ml-1" for="passwordConfirm"> ยืนยันรหัสผ่าน <span class="text-danger">*</span></label>
                      <input id="passwordConfirm" type="password" class="form-control form-control-lg @error('passwordConfirm') invalid @enderror" name="passwordConfirm"  
                      required autocomplete="passwordConfirm" autofocus placeholder="โปรดยืนยันรหัสผ่าน ****"> 
                      @error('passwordConfirm')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>


                    <div class="col-md-6 form-group"> 
                      <label class="ml-1" for="status"> สถานะการเข้าใช้งานระบบ <span class="text-danger">*</span></label>  
                      <div class="cc-selector"> 
                        <input id="status1" type="radio" name="status" value="0" {{ old('status') == true ? old('status') == 0 ? "checked" : ""  : "checked"  }}/>
                        <label class="drinkcard-cc bg-success" for="status1"> เปิดการเข้าใช้งานระบบ </label>  

                        <input id="status2" type="radio" name="status" value="1" {{ old('status') == 1 ? "checked" : "" }}/>
                        <label class="drinkcard-cc bg-danger" for="status2"> ปิดการเข้าใช้งานระบบ </label> 
                      </div> 
                    </div> 
                  </div>
                  <hr>
                  <div class="row">  
                    <div class="col-md-12 form-group text-right">   
                      <a href="{{ route('request.access') }}" class="btn btn-lg btn-secondary waves-effect waves-light"><i class="fe-chevron-left"></i> ย้อนกลับ </a>  
                      <button type="submit" class="btn btn-lg btn-primary waves-effect waves-light"> 
                        <span class="text-submit"><i class="fe-save"></i> บันทึกข้อมูล </span>
                      </button> 
                    </div>
                  </div>
                </form>
              </div> 
            </div>
          </div> 
        </div>   
      </div>  
    </div>   
  
@endsection
@section('script')    
<script src="{{ asset('admin/libs/sweetalert2/sweetalert2.min.js') }}"></script>    
<script src="{{ asset('admin/libs/select2/select2.min.js') }}"></script> 
<script> 
  $('#permission').select2();
  setTimeout(function(){ $('.alert-success').fadeOut(); }, 3000);
  $( "form" ).submit(function( event ) {  
    $('.text-submit').html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
    $( "form" ).submit();  
  }); 
</script>
@endsection

