@extends('layouts.app')
@section('style')     
@endsection
@section('content')
    <div class="content"> 
      <div class="container-fluid"> 
        <div class="row">
          <div class="col-12">
              <div class="page-title-box"> 
                  <h4 class="page-title"> <i class="fe-settings"></i> ตั้งค่าข้อมูลส่วนตัว </h4>
              </div>
          </div>
        </div>  
        
        <div class="row">
          <div class="col-md-12"> 
            <div class="card-box"> 
              @if(session("success"))
                <div class="alert alert-success text-success mt-2" role="alert" style="background: #ecffeb;"> 
                  <i class="icon-check"></i> {{session("success")}} 
                </div> 
              @endif  
              <form method="POST" action="{{ route('save.profile') }}" id="form" enctype="multipart/form-data">
                @csrf
                <div class="row"> 
                  <div class="col-md-5 form-group"> 
                    <label class="ml-1" for="usersname"> ชื่อ-นามสกุล / ผู้ใช้งานระบบ <span class="text-danger">*</span></label>
                    <input id="usersname" type="text" class="form-control form-control-lg @error('usersname') invalid @enderror" name="usersname"  
                    value="{{ $data['users_find']->name }}"
                    required autocomplete="usersname" autofocus placeholder="โปรดระบุข้อมูล..."> 
                    @error('usersname')
                      <span class="invalid-feedback" role="alert">
                        <strong><i class="fa fa-times-circle" aria-hidden="true"></i> {{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="col-md-5 form-group"> 
                    <label class="ml-1" for="email"> อีเมล / ผู้ใช้งานระบบ <span class="text-danger">*</span></label>
                    <input id="email" type="text" class="form-control form-control-lg @error('email') invalid @enderror" name="email" disabled
                    value="{{ $data['users_find']->email }}"
                    required autocomplete="email" autofocus placeholder="โปรดระบุข้อมูล..."> 
                    @error('email')
                      <span class="invalid-feedback" role="alert">
                        <strong><i class="fa fa-times-circle" aria-hidden="true"></i> {{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="col-md-2 form-group"> 
                    <?php $permission="Users"; ?>
                    @if(Auth::user()->permission_id==1)
                      <?php $permission="Owner"; ?>
                    @elseif(Auth::user()->permission_id==2)
                      <?php $permission="Administrator"; ?>
                    @endif
                    <label class="ml-1" for="permission_id">  สิทธิ์ผู้ใช้งาน <span class="text-danger">*</span></label>
                    <input id="permission_id" type="text" class="form-control form-control-lg @error('permission_id') invalid @enderror" name="permission_id" disabled  
                    value="{{ $permission }}"
                    required autocomplete="permission_id" autofocus placeholder="โปรดระบุข้อมูล..."> 
                    @error('permission_id')
                      <span class="invalid-feedback" role="alert">
                        <strong><i class="fa fa-times-circle" aria-hidden="true"></i> {{ $message }}</strong>
                      </span>
                    @enderror
                  </div> 
                  <div class="col-md-3 pb-2"> 
                    <h4>Change Password</h4> 
                    <div class="custom-control custom-checkbox mt-1">
                        <input type="checkbox" class="custom-control-input" id="changepassCheck1" name="changepassCheck" value="Y">
                        <label class="custom-control-label" for="changepassCheck1"> ติ๊กเพื่อเปลี่ยนรหัสผ่าน </label>
                    </div>
                  </div> 
                  <div class="col-md-3"> 
                    <label class="ml-1" for="old_password"> รหัสผ่านเดิม  </label>
                    <input class="form-control form-control-lg @error('old_password') is-invalid @enderror" type="password" id="old_password" name="old_password" placeholder="ระบุรหัสผ่านของท่าน">
                    @error('old_password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong> 
                      </span>
                    @enderror
                  </div>
                  <div class="col-md-3"> 
                    <label class="ml-1" for="new_password"> รหัสผ่านใหม่  </label>
                    <input class="form-control form-control-lg @error('new_password') is-invalid @enderror" type="password" id="new_password" name="new_password" placeholder="ระบุรหัสผ่านของท่าน">
                    @error('new_password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="col-md-3"> 
                    <label class="ml-1" for="passwordConfirm"> ยืนยันรหัสผ่านใหม่อีกครั้ง  </label>
                    <input class="form-control form-control-lg @error('passwordConfirm') is-invalid @enderror" type="password" id="passwordConfirm" name="passwordConfirm" placeholder="ระบุรหัสผ่านของท่าน">
                    @error('passwordConfirm')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  <div class="col-md-3 form-group pt-2"> 
                    <label class="ml-1" for="status"> สถานะการเข้าใช้งาน <span class="text-danger">*</span></label>  
                    <div class="cc-selector"> 
                      <input id="status1" type="radio" name="status" value="0" {{ $data['users_find']->deleted_at == true ? $data['users_find']->deleted_at == 0 ? "checked" : ""  : "checked"  }}/>
                      <label class="drinkcard-cc bg-success" for="status1"> เปิดการเข้าใช้งาน </label>  

                      <input id="status2" type="radio" name="status" value="1" {{ $data['users_find']->deleted_at == 1 ? "checked" : "" }}/>
                      <label class="drinkcard-cc bg-danger" for="status2"> ปิดการเข้าใช้งาน </label> 
                    </div> 
                  </div>  
                </div>
                <hr>
                <div class="row"> 
                  <div class="col-md-12 form-group text-center">    
                    <button type="submit" class="btn btn-lg btn-primary waves-effect waves-light"> 
                      <span class="text-submit">บันทึกข้อมูล Profile</span>
                    </button> 
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
         
           
      </div>  
    </div>   
@endsection
@section('script')    
<script> 
  $( "form" ).submit(function( event ) { 
    $('.text-submit').html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
    $( "form" ).submit();  
  }); 

  $('#old_password').prop( "disabled", true );
  $('#new_password').prop( "disabled", true );
  $('#passwordConfirm').prop( "disabled", true ); 
  $(document).on('click', '#changepassCheck1', function(event) { 
    if($(this)[0].checked==true){
      $('#old_password').prop( "disabled", false  );
      $('#new_password').prop( "disabled", false  );
      $('#passwordConfirm').prop( "disabled", false  ); 
    } else {
      $('#old_password').prop( "disabled", true );
      $('#new_password').prop( "disabled", true );
      $('#passwordConfirm').prop( "disabled", true ); 
    }
  });
</script>
@endsection

