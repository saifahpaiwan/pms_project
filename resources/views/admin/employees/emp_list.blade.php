@extends('layouts.app')
@section('style')      
  <link href="{{ asset('admin/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />  
  <link href="{{ asset('admin/libs/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('admin/libs/datatables/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('admin/libs/datatables/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('admin/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />  
  <style> 
    .select2-container--default .select2-selection--single { height: 36px;    border: 1px solid #dee2e6; }
    .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 36px; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height: 36px;} 
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
                  <div class="col-md-2 pb-1"> 
                    <select id="branche_id" name="branche_id" class="form-control" data-toggle="select2">
                      <option value=""> เลือกสาขา </option> 
                      @if(isset($data['Query_branch']))
                        @foreach($data['Query_branch'] as $row)
                          <option value="{{ $row->id }}"> {{ $row->name }} </option>
                        @endforeach
                      @endif 
                    </select>   
                  </div>
                  <div class="col-md-2 pb-1"> 
                    <select id="departments_id" name="departments_id" class="form-control" data-toggle="select2">
                      <option value=""> เลือกแผนก </option> 
                      @if(isset($data['Query_department']))
                        @foreach($data['Query_department'] as $row)
                          <option value="{{ $row->id }}"> {{ $row->name }} </option>
                        @endforeach
                      @endif 
                    </select>   
                  </div>
                  <div class="col-md-2 pb-1"> 
                    <select id="sub_departments_id" name="sub_departments_id" class="form-control" data-toggle="select2">
                      <option value=""> เลือกแผนกย่อย </option> 
                    </select>   
                  </div>
                  <div class="col-md-2 pb-1"> 
                    <select id="positions_id" name="positions_id" class="form-control" data-toggle="select2">
                      <option value=""> เลือกตำแหน่ง </option> 
                    </select>   
                  </div>
                  <div class="col-md-2 pb-1"> 
                    <select id="levels_id" name="levels_id" class="form-control" data-toggle="select2">
                      <option value=""> ระดับ </option> 
                      @if(isset($data['Query_level']))
                        @foreach($data['Query_level'] as $row)
                          <option value="{{ $row->id }}"> {{ $row->number." | ".$row->name }} </option>
                        @endforeach
                      @endif 
                    </select>   
                  </div>
                  <div class="col-md-2 pb-1"> 
                    <select id="status" name="status" class="form-control mb-1" data-toggle="select2">
                      <option value=""> เลือกสถานะการแสดงผล </option>
                      <option value="0"> สถานะทำงานอยู่ </option> 
                      <option value="1"> ปิดการแสดงผล </option>
                      <option value="2"> พ้นสภาพพนักงาน </option> 
                    </select>  
                  </div>
                  <div class="col-md-4"> 
                    <input class="form-control" type="date" id="date" name="date"/>
                  </div>
                  <div class="col-md-4"> 
                    <input class="form-control" type="text" id="keywrod" name="keywrod" placeholder="ค้นหาเพิ่มเติม..."/>
                  </div>
                  <div class="col-md-4 text-right"> 
                    <button type="button" class="btn btn-dark waves-effect waves-light" id="search"><i class="fe-search"></i> ค้นหา</button> 
                    <button type="button" class="btn btn-secondary waves-effect waves-light" id="reset"><i class="fe-rotate-cw"></i> รีเซ็ต</button>
                    <a href="{{ route('employees.add') }}" class="btn btn-primary waves-effect waves-light"><i class="fe-plus-square"></i> เพิ่ม </a>
                    <button type="button" class="btn btn-warning waves-effect waves-light" id="export"><i class="fe-printer"></i> ปริ้น</button> 
                  </div>
                </div>
              </div>
              <div class="card-body">  
                <div class="h5"> ตารางข้อมูลพนักงานประจำวันที่ {{ date('m/d/Y') }} </div> 
                <div class="table-responsive"> 
                  <table class="table table-borderless dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="tbl-employees">
                    <thead>
                      <tr> 
                        <th style="width: 5%">  #รหัส </th>  
                        <th> ชื่อ-นามสกุล </th>    
                        <th style="width: 10%;"> สาขา </th> 
                        <th style="width: 10%;"> แผนก </th> 
                        <th style="width: 10%;"> แผนกย่อย </th>  
                        <th style="width: 10%;"> ตำแหน่ง </th>  
                        <th style="width: 10%;"> ระดับ </th>  
                        <th style="width: 5%;"> สถานะ </th>
                        <th style="width: 0%;">  </th>   
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
  $('#branche_id').select2();
  $('#status').select2();
  $('#departments_id').select2(); 
  $('#sub_departments_id').select2();
  $('#positions_id').select2();
  $('#levels_id').select2();

  $(document).on('click', '#close', function(event) { 
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
          $.post("{{ route('close.employees') }}", {
            _token: "{{ csrf_token() }}",  
            id: id, 
          })
          .done(function(data, status, error){   
            if(error.status==200){     
              if(data==true){
                $('#tbl-employees').DataTable().destroy();
                datatable(null, null);
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

  $(document).on('click', '#export', function(event) { 
    var status=$('#status').val(); 
    var keywrod=$('#keywrod').val();
    var departments_id=$('#departments_id').val();
    var sub_departments_id=$('#sub_departments_id').val(); 
    var positions_id=$('#positions_id').val();
    var levels_id=$('#levels_id').val();
    var branche_id=$('#branche_id').val(); 
    var url='{{ url("employees-export/") }}';
    window.open(url+'?keywrod='+keywrod+"&status="+status+"&departments_id="+departments_id+"&sub_departments_id="+sub_departments_id+"&positions_id="+positions_id+"&levels_id="+levels_id+"&branche_id="+branche_id);   
  });

  $(document).on('click', '#search', function(event) { 
    var status=$('#status').val(); 
    var keywrod=$('#keywrod').val();
    var departments_id=$('#departments_id').val();
    var sub_departments_id=$('#sub_departments_id').val(); 
    var positions_id=$('#positions_id').val();
    var levels_id=$('#levels_id').val();
    var branche_id=$('#branche_id').val(); 
    $('#tbl-employees').DataTable().destroy();
    datatable(keywrod, status, departments_id, sub_departments_id, positions_id, levels_id, branche_id);
  });  

  $(document).on('click', '#reset', function(event) { 
    $('input').val(""); 
    $("select").val("").change();
    $('#tbl-employees').DataTable().destroy();
    datatable(null, null, null, null, null, null, null);
  });

  datatable();
  function datatable(keywrod, status, departments_id, sub_departments_id, positions_id, levels_id, branche_id){  
    var table = $('#tbl-employees').DataTable({
      "processing":false,  
      "serverSide":false,  
      "searching": false,
      "lengthChange": true,  
      ajax: {
        url:"{{ route('datatable.employees') }}", 
        data:{
          keywrod: keywrod, 
          status: status, 
          departments_id: departments_id,
          sub_departments_id: sub_departments_id,
          positions_id: positions_id,
          levels_id: levels_id,
          branche_id: branche_id,
        }
      },     
      columns: [  
        {data: 'employees_code', name: 'employees_code'},
        {data: 'employees_name', name: 'employees_name'}, 
        {data: 'branches_name', name: 'branches_name'},  
        {data: 'departments_name', name: 'departments_name'}, 
        {data: 'sub_departments_name', name: 'sub_departments_name'},   
        {data: 'positions_name', name: 'positions_name'},
        {data: 'levels_name', name: 'levels_name'},  
        {data: 'deleted_at', name: 'deleted_at'},  
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

