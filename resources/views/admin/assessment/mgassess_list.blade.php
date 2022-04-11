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
                  <h4 class="page-title"> <i class="fe-file-text"></i> แบบประเมินผลออนไลน์ </h4>
              </div>
          </div>
        </div>   
         
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header" style="background: #ddd;">  
                <div class="row">   
                  <div class="col-md-3"> 
                    <input class="form-control mb-1" type="text" id="keywrod" name="keywrod" placeholder="ค้นหาเพิ่มเติม..."/>
                  </div>
                  <div class="col-md-2"> 
                    <select id="employees_id" name="employees_id" class="form-control mb-1" data-toggle="select2">
                      <option value=""> เลือกผู้ประเมินฝ่าย  </option>  
                      @if(isset($data['Query_employee']))
                        @foreach($data['Query_employee'] as $row)
                          <option value="{{ $row->id }}"> {{ $row->name }} </option>
                        @endforeach
                      @endif 
                    </select>   
                  </div>
                  <div class="col-md-2"> 
                    <input class="form-control mb-1" type="date" id="date" name="date"/>
                  </div>
                  <div class="col-md-2"> 
                    <select id="status" name="status" class="form-control mb-1" data-toggle="select2">
                      <option value=""> เลือกสถานะการ </option> 
                      <option value="1"> รอการประเมินผล </option> 
                      <option value="2"> รอการตรวจสอบ </option> 
                      <option value="3"> การประเมินผลสำเร็จ </option> 
                      <option value="4"> ส่งกลับแก้ไข	 </option> 
                    </select>  
                  </div>
                  <div class="col-md-3 text-right"> 
                    <button type="button" class="btn btn-dark waves-effect waves-light" id="search"><i class="fe-search"></i> ค้นหา</button> 
                    <button type="button" class="btn btn-secondary waves-effect waves-light" id="reset"><i class="fe-rotate-cw"></i> รีเซ็ต</button>
                    <a href="{{ route('assessment.add') }}" class="btn btn-primary waves-effect waves-light"><i class="fe-plus-square"></i> เพิ่ม </a> 
                  </div>
                </div>
              </div>
              <div class="card-body">  
                <div class="h5"> ตารางข้อมูลประเมินผลออนไลน์ </div> 
                <div class="table-responsive"> 
                  <table class="table table-borderless dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="tbl-data">
                    <thead>
                      <tr> 
                        <th style="width: 1%">  #รหัส </th>  
                        <th> ชื่อการประเมินผล </th>   
                        <th style="width: 15%;"> ผู้ประเมินฝ่าย </th>   
                        <th style="width: 5%;"> เมื่อ </th>
                        <th style="width: 5%;"> สถานะ </th> 
                        <th style="width: 0%;"> จัดการ </th>   
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
  $('#status').select2();
  $('#employees_id').select2();
  
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
          $.post("{{ route('close.branches') }}", {
            _token: "{{ csrf_token() }}",  
            id: id, 
          })
          .done(function(data, status, error){   
            if(error.status==200){     
              if(data==true){
                $('#tbl-data').DataTable().destroy();
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

  $(document).on('click', '#search', function(event) { 
    var status=$('#status').val(); 
    var keywrod=$('#keywrod').val();
    var employees_id=$('#employees_id').val();
    var date=$('#date').val();  
    $('#tbl-data').DataTable().destroy();
    datatable(keywrod, status, employees_id, date);
  });

  $(document).on('click', '#reset', function(event) {
    $('input').val(""); 
    $("select").val("").change(); 
    $('#tbl-data').DataTable().destroy();
    datatable();
  });

  datatable();
  function datatable(keywrod, status, employees_id, date){  
    var table = $('#tbl-data').DataTable({
      "processing":false,  
      "serverSide":false,  
      "searching": false,
      "lengthChange": true,  
      ajax: {
        url:"{{ route('datatable.assessment') }}", 
        data:{
          keywrod: keywrod, 
          status: status,
          employees_id: employees_id,
          date: date,
        }
      },   
      columns: [  
        {data: 'id', name: 'id'},
        {data: 'name', name: 'name'},  
        {data: 'employees', name: 'employees'},  
        {data: 'created_at', name: 'created_at'},  
        {data: 'status', name: 'status'},  
        {data: 'buttonMg', name: 'buttonMg'},  
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

