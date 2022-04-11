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
                  <h4 class="page-title"> <i class="fe-users"></i> จัดการสิทธิ์ผู้ใช้งาน </h4>
              </div>
          </div>
        </div>  
        
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header" style="background: #ddd;">  
                <div class="row">  
                  <div class="col-md-2"> 
                    <select id="status" name="status" class="form-control" data-toggle="select2"> 
                      <option value="">  เลือกสถานะ </option> 
                      <option value="0"> ผู้เข้าใช้งานระบบ </option> 
                      <option value="1"> ปิดการแสดงผล </option> 
                      <option value="2"> ยกเลิกข้อมูล </option> 
                      <option value="3"> ขอเข้าใช้งานระบบ </option> 
                    </select>  
                  </div>
                  <div class="col-md-2"> 
                    <select id="permission" name="permission" class="form-control" data-toggle="select2">
                      <option value=""> เลือกสิทธิ์ผู้ใช้งาน </option> 
                      @if(isset($data['Query_permission']))
                        @foreach($data['Query_permission'] as $row)
                          <option title="{{ $row->detail }}" value="{{ $row->id }}"> {{ $row->name }} </option>
                        @endforeach
                      @endif  
                    </select>  
                  </div>
                  <div class="col-md-5"> 
                    <input class="form-control form-control-lg" type="text" id="keywrod" name="keywrod" placeholder="ค้นหาเพิ่มเติม..."/>
                  </div>
                  <div class="col-md-3 text-right"> 
                    <button type="button" class="btn btn-dark waves-effect waves-light" id="search"><i class="fe-search"></i> ค้นหา</button> 
                    <button type="button" class="btn btn-secondary waves-effect waves-light" id="reset"><i class="fe-rotate-cw"></i> รีเซ็ต</button>
                    <a href="{{ route('permissions.add') }}" class="btn btn-primary waves-effect waves-light"><i class="fe-plus-square"></i> เพิ่ม </a> 
                  </div>
                </div>
              </div>
              <div class="card-body">  
                <div class="h5"> ตารางข้อมูลผู้เข้าใช้งานระบบประจำวันที่ {{ date('m/d/Y') }} </div> 
                <div class="table-responsive"> 
                  <table class="table table-borderless dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="tbl-request-access">
                    <thead>
                      <tr> 
                        <th style="width: 1%">  #รหัส </th>  
                        <th> ชื่อ-นามสกุล </th>
                        <th> อีเมล </th>   
                        <th style="width: 20%;"> ขอสิทธิ์ </th>
                        <th style="width: 5%;"> สถานะ </th>
                        <th style="width: 10%;"> </th>   
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
  $('#permission').select2();
  $('#status').select2();
  
  $( "form" ).submit(function( event ) { 
    $('.text-submit').html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
    $( "form" ).submit();  
  }); 

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
          $.post("{{ route('close.permissions') }}", {
            _token: "{{ csrf_token() }}",  
            id: id, 
          })
          .done(function(data, status, error){   
            if(error.status==200){     
              if(data==true){
                $('#tbl-request-access').DataTable().destroy();
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
   
  $(document).on('click', '#search', function(event) { 
    var permission=$('#permission').val(); 
    var status=$('#status').val(); 
    var keywrod=$('#keywrod').val();
    $('#tbl-request-access').DataTable().destroy();
    datatable(keywrod, permission, status);
  });

  $(document).on('click', '#reset', function(event) {
    $('input').val(""); 
    $("select").val("").change(); 
    $('#tbl-request-access').DataTable().destroy();
    datatable();
  });

  datatable();
  function datatable(keywrod, permission, status){  
    var table = $('#tbl-request-access').DataTable({
      "processing":false,  
      "serverSide":false,  
      "searching": false,
      "lengthChange": true,  
      ajax: {
        url:"{{ route('datatable.request.access') }}", 
        data:{
          keywrod: keywrod, 
          permission: permission,
          status: status
        }
      },    
      columns: [  
        {data: 'id', name: 'id'},
        {data: 'name', name: 'name'},  
        {data: 'email', name: 'email'},  
        {data: 'permissions_name', name: 'permissions_name'},  
        {data: 'status', name: 'status'},  
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

