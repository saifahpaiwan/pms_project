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
                    <div class="m-0 h5"> เพิ่มข้อมูลพนักงาน </div>
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
                  <input type="hidden" id="statusData" name="statusData" value="C">
                  <input type="hidden" id="id" name="id" value="">

                  <div class="row"> 
                    <div class="col-md-2 form-group"> 
                      <label class="ml-1" for="code"> รหัสพนักงาน <span class="text-danger">*</span></label>
                      <input id="code" type="text" class="form-control form-control-lg @error('code') invalid @enderror" name="code"  
                      value="{{ old('code') }}"
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
                            <option value="{{ $row->id }}"> {{ $row->name }} </option>
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
                      value="{{ old('name') }}"
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
                            <option value="{{ $row->id }}"> {{ $row->name }} </option>
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
                            <option value="{{ $row->id }}"> {{ $row->name }} </option>
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
                            <option value="{{ $row->id }}"> {{ $row->number." | ".$row->name }} </option>
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
                        <input id="status1" type="radio" name="status" value="0" {{ old('status') == true ? old('status') == 0 ? "checked" : ""  : "checked"  }}/>
                        <label class="drinkcard-cc bg-primary" for="status1"> สถานะทำงานอยู่ </label>  

                        <input id="status2" type="radio" name="status" value="1" {{ old('status') == 1 ? "checked" : "" }}/>
                        <label class="drinkcard-cc bg-danger" for="status2"> ปิดการแสดงผล </label> 

                        <input id="status3" type="radio" name="status" value="2" {{ old('status') == 2 ? "checked" : "" }}/>
                        <label class="drinkcard-cc bg-dark" for="status3"> พ้นสภาพพนักงาน </label> 
                      </div> 
                    </div> 
                  </div>
                  <hr>
                  <div class="row">  
                    <div class="col-md-12 form-group text-right">   
                      <a href="{{ route('employees.list') }}" class="btn btn-lg btn-secondary waves-effect waves-light"><i class="fe-chevron-left"></i> ย้อนกลับ </a>  
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
  $('#branche_id').select2();
  $('#status').select2();
  $('#departments_id').select2(); 
  $('#sub_departments_id').select2();
  $('#positions_id').select2();
  $('#levels_id').select2();
  $('#title_id').select2();
  
  setTimeout(function(){ $('.alert-success').fadeOut(); }, 3000);
  $( "form" ).submit(function( event ) {  
    $('.text-submit').html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
    $( "form" ).submit();  
  }); 


  $(document).on('change', '#departments_id', function(event) { 
    var id=$(this).val();
    seleted_sub_departments(id);
    seleted_sub_positions(id, null);
  }); 

  $(document).on('change', '#sub_departments_id', function(event) { 
    var id=$(this).val();
    var d_id=$('#departments_id').val(); 
    seleted_sub_positions(d_id, id);
  }); 

  function seleted_sub_departments(id){
    var html="";
    $.post("{{ route('ajax.sub_departments') }}", {
      _token: "{{ csrf_token() }}",  
      id: id, 
    })
    .done(function(data, status, error){   
      if(error.status==200){     
        html+='<option value=""> เลือกแผนกย่อย </option>';
        $.each( data, function( key, val ) { 
          html += '<option value="'+val.id+'"> '+val.name+' </option>'; 
        });
        $('#sub_departments_id').html(html);
      }
    })
    .fail(function(xhr, status, error) { 
      alert('An error occurred, please try again.'); 
      location.reload();
    }); 
  }

  function seleted_sub_positions(id, sub_id){
    var html="";
    $.post("{{ route('ajax.positions') }}", {
      _token: "{{ csrf_token() }}",  
      id: id, 
      sub_id: sub_id,
    })
    .done(function(data, status, error){   
      if(error.status==200){     
        html+='<option value=""> เลือกตำแหน่ง </option>';
        $.each( data, function( key, val ) { 
          html += '<option value="'+val.id+'"> '+val.name+' </option>'; 
        });
        $('#positions_id').html(html);
      }
    })
    .fail(function(xhr, status, error) { 
      alert('An error occurred, please try again.'); 
      location.reload();
    }); 
  }
</script>
@endsection

