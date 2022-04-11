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
                    <div class="m-0 h5"> เพิ่มข้อมูลตำแหน่ง </div>
                  </div>
                  <div class="col-md-6 text-right"> 
                    <a href="{{ route('positions.list') }}" class="m-0 h5"><i class="fe-chevron-left"></i> ย้อนกลับ </a> 
                  </div>  
                </div>
              </div>
              <div class="card-body">  
                @if(session("success"))
                  <div class="alert alert-success text-success mt-2" role="alert" style="background: #ecffeb;"> 
                    <i class="icon-check"></i> {{session("success")}} 
                  </div> 
                @endif  
                <form method="POST" action="{{ route('save.positions') }}" id="form" enctype="multipart/form-data">
                  @csrf  
                  <input type="hidden" id="statusData" name="statusData" value="C">
                  <input type="hidden" id="id" name="id" value="">

                  <div class="row"> 
                    <div class="col-md-6 form-group"> 
                      <label class="ml-1" for="name"> ชื่อตำแหน่ง <span class="text-danger">*</span></label>
                      <input id="name" type="text" class="form-control form-control-lg @error('name') invalid @enderror" name="name"  
                      value="{{ old('name') }}"
                      required autocomplete="name" autofocus placeholder="โปรดระบุข้อมูล..."> 
                      @error('name')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div>
                    <div class="col-md-3"> 
                      <label class="ml-1" for="departments_id"> เลือกแผนก <span class="text-danger">*</span></label>
                      <select id="departments_id" name="departments_id" class="form-control mb-1 @error('departments_id') invalid @enderror" data-toggle="select2" required>
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
                    <div class="col-md-3"> 
                      <label class="ml-1" for="sub_departments_id"> เลือกแผนกย่อย <span class="text-danger">*</span></label>
                      <select id="sub_departments_id" name="sub_departments_id" class="form-control mb-1 @error('sub_departments_id') invalid @enderror" data-toggle="select2" required>
                        <option value=""> เลือกแผนกย่อย </option>  
                      </select>   
                      @error('sub_departments_id')
                        <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                      @enderror
                    </div> 
                    <div class="col-md-6 form-group"> 
                      <label class="ml-1" for="status"> สถานะการแสดงผล <span class="text-danger">*</span></label>  
                      <div class="cc-selector"> 
                        <input id="status1" type="radio" name="status" value="0" {{ old('status') == true ? old('status') == 0 ? "checked" : ""  : "checked"  }}/>
                        <label class="drinkcard-cc bg-success" for="status1"> เปิดการแสดงผล </label>  

                        <input id="status2" type="radio" name="status" value="1" {{ old('status') == 1 ? "checked" : "" }}/>
                        <label class="drinkcard-cc bg-danger" for="status2"> ปิดการแสดงผล </label> 
                      </div> 
                    </div> 
                  </div>
                  <hr>
                  <div class="row">  
                    <div class="col-md-12 form-group text-right">   
                      <a href="{{ route('positions.list') }}" class="btn btn-lg btn-secondary waves-effect waves-light"><i class="fe-chevron-left"></i> ย้อนกลับ </a>  
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
  setTimeout(function(){ $('.alert-success').fadeOut(); }, 3000);
  $('#departments_id').select2(); 
  $('#sub_departments_id').select2();
  $(document).on('change', '#departments_id', function(event) { 
    var id=$(this).val();
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
  });

  $( "form" ).submit(function( event ) {  
    $('.text-submit').html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
    $( "form" ).submit();  
  }); 
</script>
@endsection

