@extends('layouts.app')
@section('style')       
  <link href="{{ asset('admin/libs/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('admin/libs/datatables/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('admin/libs/datatables/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
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
                  <h4 class="page-title"> <i class="fe-user"></i> ข้อมูลพนักงาน </h4>
              </div>
          </div>
        </div>   
         
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header" style="background: #ddd;">  
                <div class="row">   
                  <div class="col-md-6"> 
                    <div class="m-0 h5"> แก้ไขข้อมูลพนักงาน </div>
                  </div>
                  <div class="col-md-6 text-right"> 
                    <a href="{{ route('employees.list') }}" class="m-0 h5"><i class="fe-chevron-left"></i> ย้อนกลับ </a> 
                  </div>  
                </div>
              </div>
              <div class="card-body">  
                @if(session("success"))
                  <div class="alert alert-success text-success mt-2" role="alert" style="background: #ecffeb;"> 
                    <i class="icon-check"></i> {{session("success")}} 
                  </div> 
                @endif  
                <form method="POST" action="{{ route('save.employees') }}" id="form" enctype="multipart/form-data">
                  @csrf  
                  <input type="hidden" id="statusData" name="statusData" value="U">
                  <input type="hidden" id="id" name="id" value="{{ $data['employee_find']->id }}">

                  <div class="row"> 
                    <div class="col-md-12 text-right form-group">  
                      <a href="javascript:void(0);" data-toggle="modal" data-target="#modal-social" class="btn btn-dark waves-effect waves-light btn-xs"> ข้อมูลการล็อกอิน Social </a> 
                    </div>
                    <div class="col-md-2 form-group"> 
                      <label class="ml-1" for="code"> รหัสพนักงาน <span class="text-danger">*</span></label>
                      <input id="code" type="text" class="form-control form-control-lg @error('code') invalid @enderror" name="code"  
                      value="{{ $data['employee_find']->employee_code }}"
                      required autocomplete="code" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('code')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    <div class="col-md-1 form-group pr-1"> 
                      <label class="ml-1" for="title_id"> คำนำหน้า <span class="text-danger">*</span></label>
                      <select id="title_id" name="title_id" class="form-control @error('title_id') invalid @enderror mb-1" data-toggle="select2"
                      required autocomplete="title_id">
                        <option value=""> เลือกคำนำหน้า </option> 
                        @if(isset($data['Query_title']))
                          @foreach($data['Query_title'] as $row)
                            <option @if($data['employee_find']->title_id==$row->id) {{ __('selected') }} @endif  value="{{ $row->id }}"> {{ $row->name }} </option>
                          @endforeach
                        @endif 
                      </select>  
                      @error('title_id')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    <div class="col-md-6 form-group pl-1"> 
                      <label class="ml-1" for="name"> ชื่อ-นามสกุล <span class="text-danger">*</span></label>
                      <input id="name" type="text" class="form-control form-control-lg @error('name') invalid @enderror" name="name"  
                      value="{{ $data['employee_find']->name }}"
                      required autocomplete="name" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('name')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    <div class="col-md-3 form-group"> 
                      <label class="ml-1" for="branche_id"> เลือกสาขา <span class="text-danger">*</span></label>
                      <a href="{{ route('branches.add') }}" class="float-right"> <i class="fe-plus-circle"></i> เพิ่มข้อมูล </a>
                      <select id="branche_id" name="branche_id" class="form-control @error('branche_id') invalid @enderror" data-toggle="select2"
                      required autocomplete="branche_id">
                        <option value=""> เลือกสาขา </option> 
                        @if(isset($data['Query_branch']))
                          @foreach($data['Query_branch'] as $row)
                            <option @if($data['employee_find']->branche_id==$row->id) {{ __('selected') }} @endif value="{{ $row->id }}"> {{ $row->name }} </option>
                          @endforeach
                        @endif 
                      </select>
                      @error('branche_id')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    <div class="col-md-6 form-group"> 
                      <label class="ml-1" for="departments_id"> เลือกแผนก <span class="text-danger">*</span> </label>
                      <a href="{{ route('departments.add') }}" class="float-right"> <i class="fe-plus-circle"></i> เพิ่มข้อมูล </a>
                      <select id="departments_id" name="departments_id" class="form-control @error('departments_id') invalid @enderror" data-toggle="select2"
                      required autocomplete="departments_id">
                        <option value=""> เลือกแผนก </option> 
                        @if(isset($data['Query_department']))
                          @foreach($data['Query_department'] as $row)
                            <option @if($data['employee_find']->departments_id==$row->id) {{ __('selected') }} @endif value="{{ $row->id }}"> {{ $row->name }} </option>
                          @endforeach
                        @endif 
                      </select>   
                      @error('departments_id')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    <div class="col-md-6 form-group"> 
                      <label class="ml-1" for="sub_departments_id"> เลือกแผนกย่อย <span class="text-danger">*</span></label>
                      <a href="{{ route('sub.departments.add') }}" class="float-right"> <i class="fe-plus-circle"></i> เพิ่มข้อมูล </a>
                      <select id="sub_departments_id" name="sub_departments_id" class="form-control @error('sub_departments_id') invalid @enderror" data-toggle="select2"
                      required autocomplete="sub_departments_id">
                        <option value=""> เลือกแผนกย่อย </option> 
                      </select>   
                      @error('sub_departments_id')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    <div class="col-md-6 form-group"> 
                      <label class="ml-1" for="positions_id"> เลือกตำแหน่ง <span class="text-danger">*</span></label>
                      <a href="{{ route('positions.add') }}" class="float-right"> <i class="fe-plus-circle"></i> เพิ่มข้อมูล </a>
                      <select id="positions_id" name="positions_id" class="form-control @error('positions_id') invalid @enderror" data-toggle="select2"
                      required autocomplete="positions_id">
                        <option value=""> เลือกตำแหน่ง </option> 
                      </select>   
                      @error('positions_id')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    <div class="col-md-6 form-group"> 
                      <label class="ml-1" for="levels_id"> เลือกระดับ <span class="text-danger">*</span></label> 
                      <select id="levels_id" name="levels_id" class="form-control @error('levels_id') invalid @enderror" data-toggle="select2"
                      required autocomplete="levels_id">
                        <option value=""> เลือกระดับ </option> 
                        @if(isset($data['Query_level']))
                          @foreach($data['Query_level'] as $row)
                            <option @if($data['employee_find']->level_id==$row->id) {{ __('selected') }} @endif value="{{ $row->id }}"> {{ $row->number." | ".$row->name }} </option>
                          @endforeach
                        @endif 
                      </select>   
                      @error('levels_id')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    <div class="col-md-6 form-group"> 
                      <label class="ml-1" for="status"> สถานะการแสดงผล <span class="text-danger">*</span></label>  
                      <div class="cc-selector"> 
                        <input id="status1" type="radio" name="status" value="0" {{$data['employee_find']->deleted_at == true ? $data['employee_find']->deleted_at == 0 ? "checked" : ""  : "checked"  }}/>
                        <label class="drinkcard-cc bg-primary" for="status1"> สถานะทำงานอยู่ </label>  

                        <input id="status2" type="radio" name="status" value="1" {{$data['employee_find']->deleted_at == 1 ? "checked" : "" }}/>
                        <label class="drinkcard-cc bg-danger" for="status2"> ปิดการแสดงผล </label> 

                        <input id="status3" type="radio" name="status" value="2" {{$data['employee_find']->deleted_at == 2 ? "checked" : "" }}/>
                        <label class="drinkcard-cc bg-dark" for="status3"> พ้นสภาพพนักงาน </label> 
                      </div> 
                    </div>  
                  </div>
                  <hr>
                  <div class="row">  
                    <div class="col-md-12 form-group text-right">   
                      <a href="{{ route('employees.list') }}" class="btn btn-lg btn-secondary waves-effect waves-light"><i class="fe-chevron-left"></i> ย้อนกลับ </a> 
                      @if(session('session_close'))
                        @if(session('session_close')=="Y")
                          <button type="button" class="btn btn-lg btn-danger waves-effect waves-light" id="close" data-id="{{ $data['employee_find']->id }}"><i class="fe-trash"></i> ยกเลิกข้อมูล </button>
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

    <div id="modal-social" class="modal" tabindex="-1" role="dialog"  aria-modal="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="modal-socialLabel"> ข้อมูลการล็อกอิน Social </h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive"> 
              <table class="table table-borderless dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="tbl-social">
                <thead>
                  <tr> 
                    <th style="width: 5%">  #รหัส </th>  
                    <th> Username </th>    
                    <th> Token </th>  
                    <th style="width: 10%;"> Email </th>  
                    <th style="width: 10%;"> Type </th>  
                    <th style="width: 0%;"> ลบ </th>  
                  </tr>
                </thead> 
                <tbody>  
                </tbody>
              </table>
            </div> 
          </div> 
        </div> 
      </div> 
    </div>
@endsection
@section('script')     
<script src="{{ asset('admin/libs/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables/responsive.bootstrap4.min.js') }}"></script> 
<script src="{{ asset('admin/libs/sweetalert2/sweetalert2.min.js') }}"></script>    
<script src="{{ asset('admin/libs/select2/select2.min.js') }}"></script> 
<script> 
  $('#branche_id').select2();
  $('#status').select2();
  $('#departments_id').select2(); 
  $('#sub_departments_id').select2();
  $('#positions_id').select2();
  $('#levels_id').select2();
  $('#title_id').select2();
  seleted_sub_departments("{{ $data['employee_find']->departments_id }}", "{{ $data['employee_find']->sub_departments_id }}");
  seleted_sub_positions("{{ $data['employee_find']->departments_id }}", "{{ $data['employee_find']->sub_departments_id }}", "{{ $data['employee_find']->position_id }}");

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
          $.post("{{ route('close.employees') }}", {
            _token: "{{ csrf_token() }}",  
            id: id, 
          })
          .done(function(data, status, error){   
            if(error.status==200){     
              if(data==true){
                location.href = "{{ route('employees.list') }}";
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

  $(document).on('click', '#close-social', function(event) { 
    var id=$(this)[0].dataset.id; 
    var vthis=$(this);
    vthis[0].innerHTML='<i class="mdi mdi-spin mdi-loading"></i>';
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
          $.post("{{ route('close.employees.social') }}", {
            _token: "{{ csrf_token() }}",  
            id: id,
          })
          .done(function(data, status, error){   
            if(error.status==200){     
              if(data==true){
                $('#tbl-social').DataTable().destroy();
                datatable();
              } 
            }
          })
          .fail(function(xhr, status, error) { 
            alert('An error occurred, please try again.'); 
            location.reload();
          });  
        } else {
          vthis[0].innerHTML='<i class="mdi mdi-delete"></i>'; 
        }
    }); 
  }); 

  $(document).on('change', '#departments_id', function(event) { 
    var id=$(this).val();
    seleted_sub_departments(id, null);
    seleted_sub_positions(id, null, null);
  }); 

  $(document).on('change', '#sub_departments_id', function(event) { 
    var id=$(this).val();
    var d_id=$('#departments_id').val(); 
    seleted_sub_positions(d_id, id, null);
  }); 

  function seleted_sub_departments(id, sub_id){
    var html="";
    $.post("{{ route('ajax.sub_departments') }}", {
      _token: "{{ csrf_token() }}",  
      id: id, 
    })
    .done(function(data, status, error){   
      if(error.status==200){   
        var selected="";  
        html+='<option value=""> เลือกแผนกย่อย </option>';
        $.each( data, function( key, val ) { 
          selected=(sub_id!=null)? (sub_id==val.id)? "selected" : "" : "";
          html += '<option '+selected+' value="'+val.id+'"> '+val.name+' </option>'; 
        });
        $('#sub_departments_id').html(html);
      }
    })
    .fail(function(xhr, status, error) { 
      alert('An error occurred, please try again.'); 
      location.reload();
    }); 
  }

  function seleted_sub_positions(id, sub_id, get_id){
    var html="";
    $.post("{{ route('ajax.positions') }}", {
      _token: "{{ csrf_token() }}",  
      id: id, 
      sub_id: sub_id,
    })
    .done(function(data, status, error){   
      if(error.status==200){     
        var selected="";  
        html+='<option value=""> เลือกตำแหน่ง </option>';
        $.each( data, function( key, val ) { 
          selected=(get_id!=null)? (get_id==val.id)? "selected" : "" : "";
          html += '<option '+selected+' value="'+val.id+'"> '+val.name+' </option>'; 
        });
        $('#positions_id').html(html);
      }
    })
    .fail(function(xhr, status, error) { 
      alert('An error occurred, please try again.'); 
      location.reload();
    }); 
  }
 
  datatable();
  function datatable(){  
    var table = $('#tbl-social').DataTable({
      "processing":false,  
      "serverSide":false,  
      "searching": false,
      "lengthChange": true,  
      ajax: {
        url:"{{ route('datatable.employees.social') }}", 
        data:{
          id: 1,  
        }
      },     
      columns: [   
        {data: 'id', name: 'id'}, 
        {data: 'username', name: 'username'}, 
        {data: 'social_token', name: 'social_token'}, 
        {data: 'email', name: 'email'},
        {data: 'social', name: 'social'}, 
        {data: 'bntManger', name: 'bntManger'}, 
      ],
      "order":[], 
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

