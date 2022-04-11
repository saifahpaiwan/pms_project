@extends('layouts.app-assessment')
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
    .span-title {
      background: #c9e7ff;
      color: #177ccc;
      padding: 0.25rem 0.5rem;
      margin-right: 0.1rem;
      font-size: 11px;
      font-weight: 500; 
    }
    .box-btn-mg {
      background: #ddd;
      padding: 1rem;
      border-top: 2px solid #777777;
      border-bottom: 2px solid #777777;
    }
    .box-verse {
      background: #177ccc;
      color: #fff;
      padding: 0 0.5rem;
      margin-right: 0.5rem;
    }
  </style>
@endsection
@section('content')
    <div class="content"> 
      <div class="container-fluid"> 
        <div class="row mt-5">
          <div class="col-12">
              <div class="card"> 
                <div class="card-body">
                  <div class="row"> 
                    <div class="col-md-7"> 
                      <h4 class="m-0"> <i class="fe-file-text"></i>  การประเมินประจำปีฝ่ายสำนักงาน CI ปี 2565  </h4> 
                    </div>
                    <div class="col-md-5 text-right"> 
                      <div> 
                        <span class="span-title"> ผู้ประเมินฝ่าย : นาย สายฟ้า ไพรวรรณ์ </span> 
                        <span class="span-title"> อีเมล : saifah@gmail.com </span>  
                      </div>
                    </div>
                  </div>  
                </div>
              </div>
          </div>
        </div>   
         
        <div class="row">
          <div class="col-lg-12">
            <div class="card"> 
              <div class="card-body">  
                @if(session("success"))
                  <div class="alert alert-success text-success mt-2" role="alert" style="background: #ecffeb;"> 
                    <i class="icon-check"></i> {{session("success")}} 
                  </div> 
                @endif  
                <input type="hidden" id="id1" name="id1" value="1"> 
                <input type="hidden" id="id2" name="id2" value="1"> 

                <?php 
                  $mgButton="";
                  $mgButton.='<a href="'.route('assessment.group.view', [1]).'" class="btn btn-lg btn-dark waves-effect waves-light"><i class="fe-chevron-left"></i> ย้อนกลับ</a> '; 
                  $mgButton.='<button type="submit" class="btn btn-lg btn-primary waves-effect waves-light"> 
                    <span class="text-submit"><i class="fe-check-circle"></i> Finish </span>
                  </button>';
                  $mgButton.='<button type="button" class="btn btn-lg btn-secondary waves-effect waves-light"> 
                    <span class="text-button"><i class="fe-edit"></i> แก้ไขการประเมินกลุ่ม </span>
                  </button>';
                ?>
                <div class="row"> 
                  <div class="col-md-6">  
                    <h4> แบบประเมินกลุ่ม : กลุ่มธุรการสำนักงาน CI </h4> 
                  </div>
                  <div class="col-md-6 text-right">  
                    <div class="h5 m-0"> วันที่สร้าง 17/03/2022 </div> 
                    <div class="mt-1"> <span class="badge badge-warning"><i class="fe-clock"></i> รอการประเมินผล </span> </div> 
                  </div>
                </div>
                 
                <div class="row">
                  <div class="col-md-12">  
                    <div class="table-responsive"> 
                      <table class="table table-borderless dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="tbl-data-emp">
                        <thead>
                          <tr> 
                            <th style="width: 5%">  #รหัสพนักงาน </th>   
                            <th> ชื่อ-นามสกุล </th>
                            <th style="width: 10%"> แผนก </th> 
                            <th style="width: 10%"> แผนกย่อย </th> 
                            <th style="width: 10%"> ตำแหน่ง </th> 
                            <th style="width: 10%"> สาขา </th> 
                            <th style="width: 10%"> สถานะ </th> 
                            <th style="width: 0%"> จัดการ </th> 
                          </tr>
                        </thead> 
                        <tbody>  
                        </tbody>
                      </table> 
                    </div>
                  </div>
                </div> 
                
                <div class="row mt-4">  
                  <div class="col-md-12 text-center"> 
                    <div class="box-btn-mg">  
                      <?php echo $mgButton; ?>
                    </div>
                  </div>
                </div>  

              </div> 
            </div>
          </div> 
        </div>   
      </div>  
    </div>   
 
    <div id="modal-assessment-forms" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content"> 
              
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
  $(document).on('click', '#bnt-assessment-forms', function(event) {   
    var from_id=$(this)[0].dataset.fromid;
    var emp_id=$(this)[0].dataset.empid; 
    $('.modal-content').html("");
    $.post("{{ route('ajax.assessmentForms') }}", {
      _token: "{{ csrf_token() }}",  
      from_id: from_id, 
      emp_id: emp_id,
    })
    .done(function(data, status, error){   
      if(error.status==200){      
        $('.modal-content').html(data.html_from);
      }
    })
    .fail(function(xhr, status, error) { 
      alert('An error occurred, please try again.'); 
      // location.reload();
    });  


    $('#modal-assessment-forms').modal({
      backdrop: 'static', 
      keyboard: false, 
      show: true,
    });
  });


  // ============================== Data Table 1 ============================== // 
  datatable_1();
  function datatable_1(){ 
    var id1=$('#id1').val(); 
    var id2=$('#id2').val(); 
    var table = $('#tbl-data-emp').DataTable({
      "processing":false,  
      "serverSide":false,  
      "searching": false,
      "lengthChange": true,   
      ajax: {
        url:"{{ route('datatable.assessment.emp') }}", 
        data:{
          id1: id1,  
          id2: id2,  
        }
      },  
      columns: [   
        {data: 'employee_code', name: 'employee_code'},   
        {data: 'employees_name', name: 'employees_name'},  
        {data: 'departments_name', name: 'departments_name'},   
        {data: 'sub_departments_name', name: 'sub_departments_name'},   
        {data: 'positions_name', name: 'positions_name'},   
        {data: 'branches_name', name: 'branches_name'},  
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

