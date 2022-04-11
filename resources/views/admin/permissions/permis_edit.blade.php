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
                  <h4 class="page-title"> <i class="fe-users"></i>  จัดการสิทธิ์ผู้ใช้งาน </h4>
              </div>
          </div>
        </div>   
         
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header" style="background: #ddd;">  
                <div class="row">    
                  <div class="col-md-6"> 
                    <div class="m-0 h5"> แก้ไขข้อมูลผู้เข้าใช้งานระบบ  </div>
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
                <form method="POST" action="{{ route('save.permissions') }}" id="form" enctype="multipart/form-data">
                  @csrf  
                  <input type="hidden" id="statusData" name="statusData" value="U">
                  <input type="hidden" id="id" name="id" value="{{ $data['users_find']->id }}">

                  <div class="row"> 
                    <div class="col-md-6 form-group"> 
                      <label class="ml-1" for="usersname"> ชื่อ-นามสกุล <span class="text-danger">*</span></label>
                      <input id="usersname" type="text" class="form-control form-control-lg @error('usersname') invalid @enderror" name="usersname"  
                      value="{{ $data['users_find']->name }}"
                      required autocomplete="usersname" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('usersname')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    <div class="col-md-6 form-group"> 
                      <label class="ml-1" for="email"> อีเมล <span class="text-danger">*</span></label>
                      <input id="email" type="email" class="form-control form-control-lg @error('email') invalid @enderror" name="email"  
                      value="{{ $data['users_find']->email }}" disabled
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
                            <option @if($data['users_find']->permission_id==$row->id) {{ __('selected') }} @endif title="{{ $row->detail }}" value="{{ $row->id }}"> {{ $row->name }} </option>
                          @endforeach
                        @endif  
                      </select>   
                      @error('permission')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                    <div class="col-md-2 form-group"> 
                      <label class="ml-1" for="old_password"> รหัสผ่านเดิม </label>
                      <input id="old_password" type="password" class="form-control form-control-lg @error('old_password') invalid @enderror" name="old_password"  
                      value="{{ old('old_password') }}"
                      autocomplete="old_password" autofocus placeholder="********"> 
                      @error('old_password')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror 
                      <small class="text-danger"> *กรณีเปลียนรหัสผ่าน </small>
                    </div>
                    <div class="col-md-2 form-group"> 
                      <label class="ml-1" for="new_password"> รหัสผ่านใหม่  </label>
                      <input id="new_password" type="password" class="form-control form-control-lg @error('new_password') invalid @enderror" name="new_password"  
                      value="{{ old('new_password') }}"
                      autocomplete="new_password" autofocus placeholder="********"> 
                      @error('new_password')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    <div class="col-md-2 form-group"> 
                      <label class="ml-1" for="passwordConfirm"> ยืนยันรหัสผ่าน  </label>
                      <input id="passwordConfirm" type="password" class="form-control form-control-lg @error('passwordConfirm') invalid @enderror" name="passwordConfirm"  
                      value="{{ old('passwordConfirm') }}"
                      autocomplete="passwordConfirm" autofocus placeholder="********"> 
                      @error('passwordConfirm')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div> 
                    <div class="col-md-6 form-group"> 
                      <label class="ml-1" for="status"> สถานะการเข้าใช้งานระบบ <span class="text-danger">*</span></label>  
                      <div class="cc-selector"> 
                        <input id="status1" type="radio" name="status" value="0" {{ $data['users_find']->deleted_at == true ? $data['users_find']->deleted_at == 0 ? "checked" : ""  : "checked"  }}/>
                        <label class="drinkcard-cc bg-success" for="status1"> เปิดการเข้าใช้งานระบบ </label>  

                        <input id="status2" type="radio" name="status" value="1" {{ $data['users_find']->deleted_at == 1 ? "checked" : "" }}/>
                        <label class="drinkcard-cc bg-danger" for="status2"> ปิดการเข้าใช้งานระบบ </label> 

                        <input id="status3" type="radio" name="status" value="3" {{ $data['users_find']->deleted_at == 3 ? "checked" : "" }}/>
                        <label class="drinkcard-cc bg-primary" for="status3"> ขอเข้าใช้งานระบบ </label> 
                      </div> 
                    </div> 
                  </div>
                  <hr>
                  <div class="row">  
                    <div class="col-md-12 form-group text-right">   
                      <a href="{{ route('request.access') }}" class="btn btn-lg btn-secondary waves-effect waves-light"><i class="fe-chevron-left"></i> ย้อนกลับ </a>  
                      @if(session('session_close'))
                        @if(session('session_close')=="Y")
                          <button type="button" class="btn btn-lg btn-danger waves-effect waves-light" id="close" data-id="{{ $data['users_find']->id }}"><i class="fe-trash"></i> ยกเลิกข้อมูล </button>
                        @endif
                      @endif 
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

  $(document).on('click', '#close', function(event) { 
    var id=$(this)[0].dataset.id; 
    var vthis=$(this);
    vthis[0].innerHTML='<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...';
    Swal.fire({
        title: 'ยืนยันการยกเลิกข้อมูล หรือไม่?',
        text: "ระบบจะทำการยกเลิกข้อมูล และจะไม่สามารถนำกลับได้ !",
        type:"warning",
        showCancelButton:!0,
        confirmButtonText:"Yes",
        cancelButtonText:"No",
        confirmButtonClass:"btn btn-primary btn-lg",
        cancelButtonClass:"btn btn-secondary btn-lg ml-1",
        buttonsStyling:!1
    }).then((result) => { 
        if (result.value) {  
          $.post("{{ route('close.permissions') }}", {
            _token: "{{ csrf_token() }}",  
            id: id, 
          })
          .done(function(data, status, error){   
            if(error.status==200){     
              if(data==true){
                location.href = "{{ route('request.access') }}";
              } 
            }
          })
          .fail(function(xhr, status, error) { 
            alert('An error occurred, please try again.'); 
            location.reload();
          });  
        } else {
          vthis[0].innerHTML='<i class="fe-trash"></i> ยกเลิกข้อมูล'; 
        }
    }); 
  }); 
</script>
@endsection

