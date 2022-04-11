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
                        <h4 class="m-0"> <i class="fe-file-text"></i>  แบบประเมินผลออนไลน์  </h4> 
                      </div>
                      <div class="col-md-5 text-right"> 
                        <div> 
                          <span class="span-title"> ผู้ประเมินฝ่าย : {{ $data['assessmentGroup_first']->employees_name }} </span> 
                          <span class="span-title"> อีเมล : {{ $data['assessmentGroup_first']->email }} </span> 
                          <span class="span-title"> {{ $data['assessmentGroup_first']->levels_name }} </span>
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
                <input type="hidden" id="id" name="id" value="{{ $data['assessmentGroup_first']->id }}"> 

                <div class="row"> 
                  <div class="col-md-6">  
                    <h4 class="m-0"> {{ $data['assessmentGroup_first']->name }} </h4>
                    <div class="mb-2"> {{ $data['assessmentGroup_first']->detail }} </div> 
                  </div>
                  <div class="col-md-6 text-right">  
                    <div class="h5 m-0"> วันที่สร้าง {{ date("m/d/Y", strtotime($data['assessmentGroup_first']->created_at)) }} </div>  
                    <?php 
                      $status=""; $mgButton="";
                      if($data['assessmentGroup_first']->assessments_status==1){
                          $msg="'โปรดตรวจสอบข้อมูลให้แน่ใจว่าข้อมูลถูกต้องหรือไม่ Yes/No'";
                          $status='<span class="badge badge-warning"> รอการประเมินผล </span>';
                          $mgButton.='<a href="'.route('assessment.list').'" class="btn btn-lg btn-dark waves-effect waves-light"><i class="fe-chevron-left"></i> ย้อนกลับ</a> '; 
                          $mgButton.='<button type="button" class="btn btn-lg btn-danger waves-effect waves-light mr-1" id="close" data-id=""><i class="fe-trash"></i> ยกเลิกข้อมูล </button>'; 
                          $mgButton.='<button type="button" class="btn btn-lg btn-primary waves-effect waves-light" onclick="buttonsummit(1, '.$msg.')"> 
                            <span class="text-button"><i class="fe-check-circle"></i> ยืนยันการตรวจสอบจาก (เจ้าหน้าที่) </span>
                          </button>';
                      } else  if($data['assessmentGroup_first']->assessments_status==2){ 
                          $msg="'กรุณาตรวจสอบให้แน่ใจว่าข้อมูลการประเมินถูกต้องแล้วหรือไม่  Yes/No !'";
                          $status='<span class="badge badge-warning"> รอการตรวจสอบ </span>';
                          $mgButton.='<a href="'.route('assessment.list').'" class="btn btn-lg btn-dark waves-effect waves-light"><i class="fe-chevron-left"></i> ย้อนกลับ</a> '; 
                          
                          if($data['assessmentGroup_first']->users_id==Auth::user()->id){
                            if($data['assessmentGroup_first']->send_mail=="N"){
                              $mgButton.='<button type="button" class="btn btn-googleplus waves-effect waves-light btn-lg mr-1" id="email" data-type="M" data-userid="'.$data['assessmentGroup_first']->employees_id.'"><i class="fe-mail"></i>  ส่ง email ให้ผู้ประเมินฝ่าย</button>';  
                            } else if($data['assessmentGroup_first']->send_mail=="Y"){
                              $mgButton.='<button type="button" class="btn btn-googleplus waves-effect waves-light btn-lg mr-1" id="email" data-type="M" data-userid="'.$data['assessmentGroup_first']->employees_id.'"><i class="fe-mail"></i>  ส่ง email อีกครั้งให้ผู้ประเมินฝ่าย</button>';  
                            }
                          }
                          
                          $mgButton.='<button type="button" class="btn btn-lg btn-primary waves-effect waves-light" onclick="buttonsummit(2, '.$msg.')"> 
                            <span class="text-button"><i class="fe-check-circle"></i> ยืนยันความถูกต้อง (สำหรับผู้ประเมินฝ่าย) </span>
                          </button>';
                      } else  if($data['assessmentGroup_first']->assessments_status==3){ 
                          $status='<span class="badge badge-success"> การประเมินผลสำเร็จ </span>';
                          $mgButton.='<i class="fe-check-circle" style="font-size: 2.5rem; color: #777;"></i>';
                          $mgButton.='<div class="mt-1 mb-0 h4" style="color: #777;"> ทำการประเมินผลสำเร็จ </div>';
                          $mgButton.='<div class="mb-2" style="color: #777;"> เมื่อ 1 week ago </div>';
                          $mgButton.='<a href="'.route('assessment.list').'" class="btn btn-lg btn-dark waves-effect waves-light"><i class="fe-chevron-left"></i> ย้อนกลับ</a> '; 
                          $mgButton.='<button type="button" class="btn btn-lg btn-warning waves-effect waves-light mr-1" id="export" data-id=""><i class="fe-printer"></i> ออกรายงานผลการประเมิน </button>'; 
                      }  
                    ?>
                    <div class="mt-1">  <?php echo '<span class="badge badge-dark mr-1"> สถานะ : </span>'.$status; ?> </div> 
                  </div>
                  <div class="col-md-12">  
                    <div class="table-responsive"> 
                      <table class="table table-borderless dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="tbl-data-group">
                        <thead>
                          <tr> 
                            <th style="width: 5%">  #รหัส </th>   
                            <th> หัวข้อกลุ่มการประเมิน </th>
                            <th style="width: 20%"> ผู้ประเมินกลุ่ม </th> 
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
  function buttonsummit(status, msg){
    var id=$('#id').val(); 
    Swal.fire({
        title: 'ยืนยันความถูกต้อง หรือไม่?',
        text: msg,
        type:"warning",
        showCancelButton:!0,
        confirmButtonText:"Yes",
        cancelButtonText:"No",
        confirmButtonClass:"btn btn-primary btn-lg",
        cancelButtonClass:"btn btn-secondary btn-lg ml-1",
        buttonsStyling:!1
    }).then((result) => {  
      if (result.value) {  
        $.post("{{ route('changestatus.assessment') }}", {
          _token: "{{ csrf_token() }}",  
          id: id, 
          status: status, 
        })
        .done(function(data, status, error){   
          if(error.status==200){     
            if(data==true){
              location.reload();
            } 
          }
        })
        .fail(function(xhr, status, error) { 
          alert('An error occurred, please try again.'); 
          location.reload();
        });  
        } 
    });  
  }

  $(document).on('click', '#close', function(event) { 
    var id=$('#id').val(); 
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
          $.post("{{ route('close.assessment') }}", {
            _token: "{{ csrf_token() }}",  
            id: id, 
          })
          .done(function(data, status, error){   
            if(error.status==200){     
              if(data==true){
                location.href = "{{ route('assessment.list') }}";
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

  $(document).on('click', '#email', function(event) { 
    var employees_id=$(this)[0].dataset.userid; 
    var type=$(this)[0].dataset.type; 
    var vthis=$(this); 
    var id=$('#id').val(); 
    Swal.fire({
        title: 'ยืนยันความถูกต้อง หรือไม่?',
        text: "ตรวจสอบให้แน่ใจว่า สถานะการประเมินกลุ่มนั้นประเมินผลสำเร็จแล้วหรือไม่ Yes/No !",
        type:"warning",
        showCancelButton:!0,
        confirmButtonText:"Yes",
        cancelButtonText:"No",
        confirmButtonClass:"btn btn-primary btn-lg",
        cancelButtonClass:"btn btn-secondary btn-lg ml-1",
        buttonsStyling:!1
    }).then((result) => { 
        if (result.value) { 
          vthis[0].innerHTML='<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...';
          $.post("{{ route('email.assessment') }}", {
            _token: "{{ csrf_token() }}",  
            id: id,
            employees_id: employees_id, 
            type: type
          })
          .done(function(data, status, error){   
            if(error.status==200){     
              location.reload();
            }
          })
          .fail(function(xhr, status, error) { 
            alert('An error occurred, please try again.'); 
            // location.reload();
          });  
        }  
    }); 
  });  
  
  // ============================== Data Table 1 ============================== // 
  datatable_1();
  function datatable_1(){ 
    var id=$('#id').val(); 
    var table = $('#tbl-data-group').DataTable({
      "processing":false,  
      "serverSide":false,  
      "searching": false,
      "lengthChange": true,   
      ajax: {
        url:"{{ route('datatable.assessment.group') }}", 
        data:{
          id: id,   
        }
      },   
      columns: [   
        {data: 'id', name: 'id'},   
        {data: 'name', name: 'name'},  
        {data: 'employees', name: 'employees'},   
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

