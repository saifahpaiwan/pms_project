@extends('layouts.app')
@section('style')      
  <link href="{{ asset('admin/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />   
  <link href="{{ asset('admin/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />  
  <link href="{{ asset('admin/libs/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('admin/libs/datatables/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('admin/libs/datatables/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
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
                  <h4 class="page-title"> <i class="fe-file-text"></i>  แบบประเมินผลออนไลน์  </h4>
              </div>
          </div>
        </div>   
         
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header" style="background: #ddd;">  
                <div class="row">   
                  <div class="col-md-6"> 
                    <div class="m-0 h5"> กำหนดการประเมินผลออนไลน์ [แก้ไข] </div>
                  </div>
                  <div class="col-md-6 text-right"> 
                    <a href="{{ route('assessment.list') }}" class="m-0 h5"><i class="fe-chevron-left"></i> ย้อนกลับ </a> 
                  </div>   
                </div>
              </div>
              <div class="card-body">  
                @if(session("success"))
                  <div class="alert alert-success text-success mt-2" role="alert" style="background: #ecffeb;"> 
                    <i class="icon-check"></i> {{session("success")}} 
                  </div> 
                @endif  
                <form method="POST" action="{{ route('save.assessment') }}" enctype="multipart/form-data" id="default-wizard">
                  @csrf  
                  <input type="hidden" id="statusData" name="statusData" value="U">
                  <input type="hidden" id="id" name="id" value="{{ $data['assessment_find']->id }}">
  
                    <fieldset title="1">
                      <legend> กำหนดการประเมินผลออนไลน์ </legend> 
                      <div class="row">
                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="l1_name"> หัวข้อการประเมินผล <span class="text-danger">*</span></label>
                          <input id="l1_name" type="text" class="form-control form-control-lg @error('l1_name') invalid @enderror" name="l1_name"  
                          value="{{ $data['assessment_find']->name }}"
                          required autocomplete="l1_name" autofocus placeholder="โปรดระบุข้อมูล..."> 
                          <input type="hidden" id="l1_tems_id" name="l1_tems_id" value="{{ $data['assessment_find']->id }}">
                          @error('name')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div>
                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="l1_detail"> รายละเอียดการประเมินผล <span class="text-danger">*</span></label>
                          <input id="l1_detail" type="text" class="form-control form-control-lg @error('l1_detail') invalid @enderror" name="l1_detail"  
                          value="{{ $data['assessment_find']->detail }}"
                          required autocomplete="l1_detail" autofocus placeholder="โปรดระบุข้อมูล..."> 
                          @error('l1_detail')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div>

                        <div class="col-md-3"> 
                          <label class="ml-1" for="l1_employees_id"> กำหนดผู้ประเมินฝ่าย <span class="text-danger">*</span></label>
                          <select id="l1_employees_id" name="l1_employees_id" class="form-control mb-1 @error('l1_employees_id') invalid @enderror" data-toggle="select2" required>
                            <option value=""> กำหนดผู้ประเมินฝ่าย </option> 
                            @if(isset($data['Query_employee']))
                              @foreach($data['Query_employee'] as $row)
                                <option @if( $data['assessment_find']->employees_id==$row->id) {{ __('selected') }} @endif value="{{ $row->id }}"> {{ $row->name }} </option>
                              @endforeach
                            @endif 
                          </select>  
                          <span class="txt-l1_employees_id"> </span> 
                          @error('l1_employees_id')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div>
                        <div class="col-md-3 form-group"> 
                          <label class="ml-1" for="l1_email"> อีเมลผู้ประเมินฝ่าย <span class="text-danger">*</span></label>
                          <input id="l1_email" type="email" class="form-control form-control-lg @error('l1_email') invalid @enderror" name="l1_email"  
                          value="{{ $data['assessment_find']->email }}"
                          required autocomplete="l1_email" autofocus placeholder="example@gmail.com"> 
                          @error('l1_email')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div>

                        <div class="col-md-6 form-group"> 
                          <label class="ml-1" for="l1_password"> กำหนดรหัสการเข้าประเมิน <span class="text-danger">*</span></label>
                          <input id="l1_password" type="password" class="form-control form-control-lg @error('l1_password') invalid @enderror" name="l1_password"  
                          value="{{ $data['assessment_find']->password }}"
                          required autocomplete="l1_password" autofocus placeholder="โปรดระบุข้อมูล..."> 
                          @error('l1_password')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div>
                        
                      </div> 
                    </fieldset>  
                    <fieldset title="2">
                      <legend> กำหนดกลุ่มการประเมิน </legend> 
                      <div class="row"> 
                        <div class="col-md-6"> 
                          <div class="row">
                            <div class="col-md-12 form-group"> 
                              <label class="ml-1" for="l2_name"> หัวข้อกลุ่มการประเมิน </label>
                              <input id="l2_name" type="text" class="form-control form-control-lg @error('l2_name') invalid @enderror" name="l2_name"  
                              value="{{ old('l2_name') }}"
                              autocomplete="l2_name" autofocus placeholder="โปรดระบุข้อมูล..."> 
                              <input type="hidden" id="l2_tems_id" name="l2_tems_id" value="0">
                              @error('name')
                                <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                              @enderror
                            </div>
                            <div class="col-md-12 form-group"> 
                              <label class="ml-1" for="l2_detail"> รายละเอียดกลุ่มการประเมิน </label>
                              <input id="l2_detail" type="text" class="form-control form-control-lg @error('l2_detail') invalid @enderror" name="l2_detail"  
                              value="{{ old('l2_detail') }}"
                              autocomplete="l2_detail" autofocus placeholder="โปรดระบุข้อมูล..."> 
                              @error('l2_detail')
                                <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                              @enderror
                            </div>

                            <div class="col-md-3"> 
                              <label class="ml-1" for="l2_employees_id"> กำหนดผู้ประเมินกลุ่ม </label>
                              <select id="l2_employees_id" name="l2_employees_id" class="form-control mb-1 @error('l2_employees_id') invalid @enderror" data-toggle="select2" required>
                                <option value="0"> กำหนดผู้ประเมินกลุ่ม </option> 
                                @if(isset($data['Query_employee']))
                                  @foreach($data['Query_employee'] as $row)
                                    <option value="{{ $row->id }}"> {{ $row->name }} </option>
                                  @endforeach
                                @endif 
                              </select>   
                              <span class="txt-l2_employees_id"> </span>
                              @error('l2_employees_id')
                                <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                              @enderror
                            </div>
                            <div class="col-md-3 form-group"> 
                              <label class="ml-1" for="l2_email"> อีเมลผู้ประเมินกลุ่ม </label>
                              <input id="l2_email" type="email" class="form-control form-control-lg @error('l2_email') invalid @enderror" name="l2_email"  
                              value="{{ old('l2_email') }}"
                              autocomplete="l2_email" autofocus placeholder="example@gmail.com"> 
                              @error('l2_email')
                                <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                              @enderror
                            </div>

                            <div class="col-md-6 form-group"> 
                              <label class="ml-1" for="l2_password"> กำหนดรหัสการเข้าประเมิน </label>
                              <input id="l2_password" type="password" class="form-control form-control-lg @error('l2_password') invalid @enderror" name="l2_password"  
                              value="{{ old('l2_password') }}"
                              autocomplete="l2_password" autofocus placeholder="โปรดระบุข้อมูล..."> 
                              @error('l2_password')
                                <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                              @enderror
                            </div>

                            <div class="col-md-12 form-group text-right"> 
                              <button type="button" class="btn btn-lg btn-secondary waves-effect waves-light" id="add-row"> <i class="fe-plus-circle"></i> เพิ่มรายการ </button> 
                            </div>   
                          </div> 
                        </div>
                        <div class="col-md-6"> 
                          <div> ตารางรายการผู้ประเมินกลุ่ม</div>
                          <div class="table-responsive"> 
                            <table class="table table-borderless dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="tbl-assessmentGroup">
                              <thead>
                                <tr> 
                                  <th style="width: 5%">  # </th>  
                                  <th style="width: 80%;"> ชื่อกลุ่ม </th>  
                                  <th style="width: 20%;"> ผู้ประเมินกลุ่ม </th> 
                                </tr>
                              </thead> 
                              <tbody>  
                              </tbody>
                            </table> 
                          </div> 
                          <div class="alert-group"> </div> 
                        </div>
                      </div>
                    </fieldset> 
                    <fieldset title="3">
                      <legend> กำหนดผู้ถูกประเมิน </legend> 
                      <div class="row"> 
                        <div class="col-md-6"> 
                          <div class="row">  
                            <div class="col-md-6 form-group"> 
                              <label class="ml-1" for="l3_assessmentGroups_id"> เลือกกลุ่มการประเมิน </label>
                              <select id="l3_assessmentGroups_id" name="l3_assessmentGroups_id" class="form-control mb-1 @error('l3_assessmentGroups_id') invalid @enderror" data-toggle="select2" required>
                              </select>   
                              <span class="txt-l3_assessmentGroups_id"> </span>
                              @error('l3_assessmentGroups_id')
                                <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                              @enderror
                            </div>  
                            <div class="col-md-6 form-group"> 
                              <label class="ml-1" for="l3_assessmentFrom_id"> เลือกแบบฟอร์มการประเมิน </label>
                              <select id="l3_assessmentFrom_id" name="l3_assessmentFrom_id" class="form-control mb-1 @error('l3_assessmentFrom_id') invalid @enderror" data-toggle="select2" required>
                                <option value="0"> เลือกแบบฟอร์มการประเมิน </option> 
                                @if(isset($data['Query_assessmentForms']))
                                  @foreach($data['Query_assessmentForms'] as $row)
                                    <option value="{{ $row->id }}"> {{ $row->title }} </option>
                                  @endforeach
                                @endif 
                              </select>   
                              <span class="txt-l3_assessmentFrom_id"> </span>
                              @error('l3_assessmentFrom_id')
                                <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                              @enderror
                            </div>  
                            <div class="col-md-12 form-group"> 
                              <label class="ml-1" for="l3_employees_id"> กำหนดผู้ถูกประเมิน </label>
                              <select id="l3_employees_id" name="l3_employees_id" class="form-control mb-1 @error('l3_employees_id') invalid @enderror" data-toggle="select2" required>
                                <option value="0"> กำหนดผู้ถูกประเมิน </option> 
                                @if(isset($data['Query_employee']))
                                  @foreach($data['Query_employee'] as $row)
                                    <option value="{{ $row->id }}"> {{ $row->name }} </option>
                                  @endforeach
                                @endif 
                              </select>   
                              <span class="txt-l3_employees_id"> </span>
                              @error('l3_employees_id')
                                <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                              @enderror
                            </div>  
                             
                            <div class="col-md-12 form-group"> 
                              <label class="ml-1" for="l3_note"> อธิบายเพิ่มเติม (ถ้ามี) </label>
                              <input id="l3_note" type="text" class="form-control form-control-lg @error('l3_note') invalid @enderror" name="l3_note"  
                              value="{{ old('l3_note') }}"
                              autocomplete="l3_note" autofocus placeholder="โปรดระบุข้อมูล..."> 
                              <input type="hidden" id="l3_tems_id" name="l3_tems_id" value="0">
                              @error('name')
                                <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                              @enderror
                            </div>
                            <div class="col-md-12 form-group text-right"> 
                              <button type="button" class="btn btn-lg btn-secondary waves-effect waves-light" id="add-row-emp"> <i class="fe-plus-circle"></i> เพิ่มรายการ </button> 
                            </div>   
                          </div> 
                        </div>
                        <div class="col-md-6"> 
                          <div> ตารางรายการผู้ถูกประเมิน</div>
                          <div class="table-responsive"> 
                            <table class="table table-borderless dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="tbl-data-emp">
                              <thead>
                                <tr> 
                                  <th style="width: 5%">  # </th>   
                                  <th> ผู้ถูกประเมิน </th>
                                  <th> แบบประเมิน </th> 
                                </tr>
                              </thead> 
                              <tbody>  
                              </tbody>
                            </table> 
                          </div>
                        </div>
                      </div>
                    </fieldset> 
                    <button type="submit" class="btn btn-lg btn-primary waves-effect waves-light stepy-finish"> 
                      <span class="text-submit"><i class="fe-save"></i> บันทึกข้อมูล </span>
                    </button>  
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
<script src="{{ asset('admin/libs/stepy/jquery.stepy.js') }}"></script>
<script src="{{ asset('admin/libs/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables/responsive.bootstrap4.min.js') }}"></script> 
<script> 
  $('#l1_employees_id').select2();
  $('#l2_employees_id').select2();
  $('#l3_employees_id').select2();
  $('#l3_assessmentFrom_id').select2();
  $('#l3_assessmentGroups_id').select2();
  
  $("#default-wizard").stepy({ 
    back: function(index, total) {
      // console.log(index);
      if(index==2){  
        $('#tbl-assessmentGroup').DataTable().destroy();
        datatable_1(); 
      }
    },
    next: function(index) {
      // console.log(index);
      if(index==2){  
        var invalid_count=0;
        var arrinput = ['l1_name', 'l1_detail', 'l1_employees_id', 'l1_email', 'l1_password'];
        $(arrinput).each(function( key, value ) { 
          if(value=="l1_employees_id"){
            val=$('#l1_employees_id').val(); 
          } else {
            val=$('input[name='+value+']').val();
          }
          
          if(val==""){ 
            if(value=="l1_employees_id"){
              $(".txt-"+value).html("<span class='text-danger'> โปรดกำหนดผู้ประเมินฝ่าย </span>");
              $('.select2-container--default .select2-selection--single').css("border", "1px solid #f44336"); 
            } else {
              $('input[name='+value+']').addClass('parsley-error');
            } 
            invalid_count++;
          } else {
            if(value=="l1_employees_id"){
              $(".txt-"+value).html("");
              $('.select2-container--default .select2-selection--single').css("border", "1px solid #dee2e6");
            } else {
              $('input[name='+value+']').removeClass('parsley-error'); 
            } 
          }
        });
        if(invalid_count>0){ return false;}
        var form = $('form');
        $.ajax("{{ route('save.assessment.tems') }}", {
          _token: "{{ csrf_token() }}",  
          type: "POST",
          data: form.serialize(),  
        }).done(function(data, status, error){   
          if(error.status==200){  
            $('#l1_tems_id').val(data);   
          }
        });  
      } else if(index==3){   
        $('.alert-group').html("");
        if($('.l_group').length==0){ 
          var html="";
          html+='<div class="alert alert-danger text-danger alert-dismissible" role="alert mt-2">';
          html+='  <button type="button" class="close" data-dismiss="alert" aria-label="Close">';
          html+='       <span aria-hidden="true">×</span>';
          html+='  </button>';
          html+='  <strong>ผิดผลาด!</strong> โปรดระบุข้อมูลรายการผู้ประเมินกลุ่ม !';
          html+='</div>';
          $('.alert-group').html(html);
          return false;
        }
        var form = $('form');
        $.ajax("{{ route('save.assessment.group.tems') }}", {
          _token: "{{ csrf_token() }}",  
          type: "POST",
          data: form.serialize(),  
        }).done(function(data, status, error){   
          if(error.status==200){  
            $('#l2_tems_id').val(data);  
            ajax_assessment_groups($('#l1_tems_id').val());
          }
        });  
      }
    } 
  });

  $(".button-next").addClass("btn btn-lg btn-primary waves-effect waves-light m-1");
  $(".button-back").addClass("btn btn-lg btn-secondary waves-effect waves-light m-1");

  setTimeout(function(){ $('.alert-success').fadeOut(); }, 3000);
  $( "form" ).submit(function( event ) {  
    $('.text-submit').html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
    $( "form" ).submit();  
  });  

  // ============================== Data Table 1 ============================== // 
  datatable_1();
  function datatable_1(){  
    var id=$('#id').val();
    var table = $('#tbl-assessmentGroup').DataTable({
      "processing":false,  
      "serverSide":false,  
      "searching": false,
      "lengthChange": true,  
      ajax: {
        url:"{{ route('datatable.assessmentGroup.edit') }}", 
        data:{
          id: id,  
        }
      },      
      columns: [  
        {data: 'buttonMg', name: 'buttonMg'},
        {data: 'name', name: 'name'},   
        {data: 'employees', name: 'employees'},  
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

  $(document).on('click', '#add-row', function(event) {   
    $('.alert-group').html(""); 
    var table = $('#tbl-assessmentGroup').DataTable(); 
    var invalid_count=0;
    var arrinput = ['l2_name', 'l2_detail', 'l2_employees_id', 'l2_email', 'l2_password'];
    $(arrinput).each(function( key, value ) {
      if(value=="l2_employees_id"){
        val=$('#l2_employees_id').val(); 
      } else {
        val=$('input[name='+value+']').val();
      }
      
      if(val=="" || val==0){ 
        if(value=="l2_employees_id"){
          $(".txt-"+value).html("<span class='text-danger'> โปรดกำหนดผู้ประเมินกลุ่ม </span>");
          $('.select2-container--default .select2-selection--single').css("border", "1px solid #f44336");  
        } else {
          $('input[name='+value+']').addClass('parsley-error');
        } 
        invalid_count++;
      } else {
        if(value=="l2_employees_id"){
          $(".txt-"+value).html("");
          $('.select2-container--default .select2-selection--single').css("border", "1px solid #dee2e6");
        } else {
          $('input[name='+value+']').removeClass('parsley-error'); 
        } 
      }
    });
    
    if(invalid_count>0){ return false;}
    let count = (Math.random() + 1).toString(36).substring(7); 
    var buttonMg="";
    buttonMg+='<button type="button" class="btn btn-icon waves-effect waves-light btn-danger delete-row" data-id="0"> <i class="fas fa-times"></i> </button>';
    buttonMg+='<input type="hidden" class="l_group" name="arrayGroup['+count+'][id]" value="0">';
    buttonMg+='<input type="hidden" name="arrayGroup['+count+'][name]" value="'+$('#l2_name').val()+'">';
    buttonMg+='<input type="hidden" name="arrayGroup['+count+'][detail]" value="'+$('#l2_detail').val()+'">';
    buttonMg+='<input type="hidden" name="arrayGroup['+count+'][employees]" value="'+$('#l2_employees_id').val()+'">';
    buttonMg+='<input type="hidden" name="arrayGroup['+count+'][email]" value="'+$('#l2_email').val()+'">';
    buttonMg+='<input type="hidden" name="arrayGroup['+count+'][password]" value="'+$('#l2_password').val()+'">'; 
    table.row.add({
      "buttonMg" : buttonMg,
      "name" : $('#l2_name').val(),
      "employees"  : $('#l2_employees_id option:selected')[0].innerHTML,
    }).draw(false);
    var arrinput = ['l2_name', 'l2_detail', 'l2_employees_id', 'l2_email', 'l2_password'];
    $(arrinput).each(function( key, value ) {
      if(value=="l2_employees_id"){
        val=$('#l2_employees_id').select2("val", "0"); 
      } else {
        val=$('input[name='+value+']').val("");
      }
    });
  });

  $(document).on('click', '.delete-row', function(event) {
    var id=$(this)[0].dataset.id; 
    var vthis=$(this);
    vthis[0].innerHTML='<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...';
    var parents=$(this).parents('tr');
    var assessment_id=$('#id').val();
    Swal.fire({
        title: 'ยืนยันการยกเลิกรายการ หรือไม่?',
        text: "เมื่อทำการยกเลิกรายการแล้วจะไม่สามารถนำกลับได้ !",
        type:"warning",
        showCancelButton:!0,
        confirmButtonText:"Yes",
        cancelButtonText:"No",
        confirmButtonClass:"btn btn-primary btn-lg",
        cancelButtonClass:"btn btn-secondary btn-lg ml-1",
        buttonsStyling:!1
    }).then((result) => {  
        if (result.value) {  
          $.post("{{ route('close.assessmentgroup') }}", {
            _token: "{{ csrf_token() }}",  
            assessment_id: assessment_id,
            id: id,
          })
          .done(function(data, status, error){   
            if(error.status==200){     
              if(data==true){
                var table = $('#tbl-assessmentGroup').DataTable();
                table.row(parents)
                .remove()
                .draw(); 
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

  // ============================== Data Table 2 ============================== //
  datatable_2();
  function datatable_2(){  
    var id=$('#id').val();
    var table = $('#tbl-data-emp').DataTable({
      "processing":false,  
      "serverSide":false,  
      "searching": false,
      "lengthChange": true,  
      ajax: {
        url:"{{ route('datatable.assessmentEmp.edit') }}", 
        data:{
          id1: id,  
        }
      },  
      columns: [  
        {data: 'buttonMg', name: 'buttonMg'}, 
        {data: 'employees', name: 'employees'},  
        {data: 'assessment_from', name: 'assessment_from'},
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

  $(document).on('click', '#add-row-emp', function(event) { 
    console.log($(this));  
    var table = $('#tbl-data-emp').DataTable(); 
    var invalid_count=0; 
    var arrinput = ['l3_employees_id', 'l3_assessmentFrom_id', 'l3_assessmentGroups_id'];
    $(arrinput).each(function( key, value ) {
      val=$('#'+value).val();   
      if(val=="" || val==0){  
        $('.select2-container--default .select2-selection--single').css("border", "1px solid #f44336");  
        invalid_count++;
      } else { 
        $('.select2-container--default .select2-selection--single').css("border", "1px solid #dee2e6");
      } 
    });

    if(invalid_count>0){ return false;}
    let count = (Math.random() + 1).toString(36).substring(7); 
    var buttonMg="";
    buttonMg+='<button type="button" class="btn btn-icon waves-effect waves-light btn-danger delete-row-emp" data-id="0"> <i class="fas fa-times"></i> </button>';
    buttonMg+='<input type="hidden" class="l_emp" name="arrayEmp['+count+'][id]" value="0">';
    buttonMg+='<input type="hidden" name="arrayEmp['+count+'][note]" value="'+$('#l3_note').val()+'">'; 
    buttonMg+='<input type="hidden" name="arrayEmp['+count+'][employees]" value="'+$('#l3_employees_id').val()+'">'; 
    buttonMg+='<input type="hidden" name="arrayEmp['+count+'][assessment_from]" value="'+$('#l3_assessmentFrom_id').val()+'">'; 
    buttonMg+='<input type="hidden" name="arrayEmp['+count+'][assessment_groups]" value="'+$('#l3_assessmentGroups_id').val()+'">'; 
    
    table.row.add({
      "buttonMg" : buttonMg,
      "employees"  : $('#l3_employees_id option:selected')[0].innerHTML,
      "assessment_from"  : $('#l3_assessmentFrom_id option:selected')[0].innerHTML, 
    }).draw(false);

    $('#l3_employees_id').select2("val", "0"); 
    $('#l3_assessmentFrom_id').select2("val", "0"); 
    $('#l3_assessmentGroups_id').select2("val", "0"); 
    $('#l3_note').val(""); 
  });

  $(document).on('click', '.delete-row-emp', function(event) {
    var id=$(this)[0].dataset.id;
    var vthis=$(this);
    vthis[0].innerHTML='<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...';
    var parents=$(this).parents('tr');
    var assessment_id=$('#id').val();
    Swal.fire({
        title: 'ยืนยันการยกเลิกรายการ หรือไม่?',
        text: "เมื่อทำการยกเลิกรายการแล้วจะไม่สามารถนำกลับได้ !",
        type:"warning",
        showCancelButton:!0,
        confirmButtonText:"Yes",
        cancelButtonText:"No",
        confirmButtonClass:"btn btn-primary btn-lg",
        cancelButtonClass:"btn btn-secondary btn-lg ml-1",
        buttonsStyling:!1
    }).then((result) => {   
        if (result.value) {  
          $.post("{{ route('close.assessmentemp') }}", {
            _token: "{{ csrf_token() }}",  
            assessment_id: assessment_id,
            id: id,
          })
          .done(function(data, status, error){   
            if(error.status==200){     
              if(data==true){
                var table = $('#tbl-data-emp').DataTable();
                table.row(parents)
                .remove()
                .draw(); 
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

  function ajax_assessment_groups(id){ 
    var html="";
    $.post("{{ route('ajax.assessment_groups') }}", {
      _token: "{{ csrf_token() }}",  
      id: id, 
    })
    .done(function(data, status, error){   
      if(error.status==200){  
        // console.log(data);   
        html+='<option value="0"> เลือกกลุ่มการประเมิน </option>';
        $.each( data, function( key, val ) { 
          html += '<option value="'+val.id+'"> '+val.name+' </option>'; 
        });
        $('#l3_assessmentGroups_id').html(html);
      }
    })
    .fail(function(xhr, status, error) { 
      alert('An error occurred, please try again.'); 
      location.reload();
    }); 
  }
 
</script>
@endsection

