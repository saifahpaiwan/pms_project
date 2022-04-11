@extends('layouts.app')
@section('style')      
  <link href="{{ asset('admin/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />  
  <link href="{{ asset('admin/libs/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('admin/libs/datatables/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('admin/libs/datatables/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
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
                    <div class="m-0 h5"> แก้ไขข้อมูลบทบาทผู้ใช้งาน </div>
                  </div>
                  <div class="col-md-6 text-right"> 
                    <a href="{{ route('roles.list') }}" class="m-0 h5"><i class="fe-chevron-left"></i> ย้อนกลับ </a> 
                  </div>   
                </div>
              </div>
              <div class="card-body">  
                @if(session("success"))
                  <div class="alert alert-success text-success mt-2" role="alert" style="background: #ecffeb;"> 
                    <i class="icon-check"></i> {{session("success")}} 
                  </div> 
                @endif  
                <form method="POST" action="{{ route('save.roles') }}" id="form" enctype="multipart/form-data">
                  @csrf  
                  <input type="hidden" id="statusData" name="statusData" value="U">
                  <input type="hidden" id="id" name="id" value="{{ $data['permission_find']->id }}">

                  <div class="row"> 
                    <div class="col-md-4 form-group"> 
                      <div class=""> 
                        <label class="ml-1" for="name"> ชื่อสิทธิ์การใช้งานระบบ <span class="text-danger">*</span></label>
                        <input id="name" type="text" class="form-control form-control-lg @error('name') invalid @enderror" name="name"  
                        value="{{ $data['permission_find']->name }}"
                        required autocomplete="name" autofocus placeholder="โปรดระบุข้อมูล..."> 
                        @error('name')
                          <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                        @enderror
                      </div>
                      <div class="mt-2"> 
                        <label class="ml-1" for="detail"> รายละเอียด <span class="text-danger">*</span></label>
                        <input id="detail" type="text" class="form-control form-control-lg @error('detail') invalid @enderror" name="detail"  
                        value="{{ $data['permission_find']->name }}"
                        required autocomplete="detail" autofocus placeholder="โปรดระบุข้อมูล..."> 
                        @error('detail')
                          <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                        @enderror
                      </div>
                      <div class="mt-2"> 
                        <label class="ml-1" for="status"> สถานะการแสดงผล <span class="text-danger">*</span></label>  
                        <div class="cc-selector"> 
                          <input id="status1" type="radio" name="status" value="0" {{ $data['permission_find']->deleted_at == true ? $data['permission_find']->deleted_at == 0 ? "checked" : ""  : "checked"  }}/>
                          <label class="drinkcard-cc bg-success" for="status1"> เปิดการแสดงผล </label>  

                          <input id="status2" type="radio" name="status" value="1" {{ $data['permission_find']->deleted_at == 1 ? "checked" : "" }}/>
                          <label class="drinkcard-cc bg-danger" for="status2"> ปิดการแสดงผล </label> 
                        </div> 
                      </div>
                    </div>
                    <div class="col-md-8 form-group">  
                      <div class="row"> 
                        <div class="col-md-6">
                          <b> ตารางรายการบทบาทผู้ใช้งาน <span class="text-danger">*</span></b>  
                        </div>
                        <div class="col-md-6 text-right">
                          <div class=""> 
                            <a href="{{ route('rolessystems.add') }}"> <i class="fe-plus-circle"></i> เพิ่มข้อมูลบทบาท </a>
                          </div>  
                        </div>
                        <div class="col-md-12"> 
                          <div class="table-responsive"> 
                            <table class="table table-borderless dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="tbl-roles">
                                <thead>
                                  <tr> 
                                    <th>#ชื่อบทบาทผู้ใช้งาน</th>
                                    <th>โมดูล</th>
                                    <th width="5%"> View </th>
                                    <th width="5%"> Add </th>
                                    <th width="5%"> Edit </th>
                                    <th width="5%"> Delete </th>
                                    <th width="5%"> Export </th>
                                  </tr>
                                </thead>
                                <tbody> 
                                </tbody>
                            </table>
                            </div>
                        </div>
                      </div>
                      @if($errors->any())
                        <div class="alert alert-danger mt-1"> 
                          <div><strong> มีบางอย่างผิดพลาด โปรดตรวจสอบข้อมูล !</strong></div>
                          <ul>
                            @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                            @endforeach
                          </ul>
                        </div>
                      @endif
                    </div> 
                  </div>
                  <hr>
                  <div class="row"> 
                    <div class="col-md-12 form-group text-right">   
                      <a href="{{ route('roles.list') }}" class="btn btn-lg btn-secondary waves-effect waves-light"><i class="fe-chevron-left"></i> ย้อนกลับ </a>  
                      @if(session('session_close'))
                        @if(session('session_close')=="Y")
                          <button type="button" class="btn btn-lg btn-danger waves-effect waves-light" id="close" data-id="{{ $data['permission_find']->id }}"><i class="fe-trash"></i> ยกเลิกข้อมูล </button>
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
<script src="{{ asset('admin/libs/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables/responsive.bootstrap4.min.js') }}"></script> 
<script src="{{ asset('admin/libs/select2/select2.min.js') }}"></script> 
<script> 
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
          $.post("{{ route('close.roles') }}", {
            _token: "{{ csrf_token() }}",  
            id: id, 
          })
          .done(function(data, status, error){   
            if(error.status==200){     
              location.href = "{{ route('roles.list') }}";
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

  datatable();
  function datatable(){  
    var id=$('#id').val();
    var table = $('#tbl-roles').DataTable({
      "processing":false,  
      "serverSide":false,  
      "searching": false,
      "lengthChange": true,  
      "order":[], 
      ajax: {
        url:"{{ route('datatable.roles') }}", 
        data:{
          id: id,
        }
      },    
      columns: [   
        {data: 'name', name: 'name'},  
        {data: 'detail', name: 'detail'},  
        {data: 'view', name: 'view'},  
        {data: 'add', name: 'add'},  
        {data: 'edit', name: 'edit'},  
        {data: 'delete', name: 'delete'},  
        {data: 'export', name: 'export'},   
      ],
      "columnDefs":[  
        {  
          "targets":0,  
          "orderable":false,  
        },  
      ],
      dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
          "<'row'<'col-sm-12'tr>>" +
          "<'row'<'col-sm-4'i><'col-sm-4 text-center'l><'col-sm-4'p>>",
      buttons: [
          'copy', 'excel', 'print',
      ], 
    });  
  } 
</script>
@endsection

