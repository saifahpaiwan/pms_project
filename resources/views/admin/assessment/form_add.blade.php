@extends('layouts.app')
@section('style')      
  <link href="{{ asset('admin/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />  
  <link href="{{ asset('admin/libs/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('admin/libs/datatables/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('admin/libs/datatables/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
  <style> 
    .text-area {
      background: #d8eeff;
      color: #177ccc;
      border: 1px solid #177ccc;
      text-align: center;
      padding: 0.4rem;
     }
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
                    <div class="m-0 h5"> เพิ่มหัวข้อแบบประเมิน </div>
                  </div>
                  <div class="col-md-6 text-right"> 
                    <a href="{{ route('assessmentform.add') }}" class="m-0 h5"><i class="fe-chevron-left"></i> ย้อนกลับ </a> 
                  </div>   
                </div>
              </div>
              <div class="card-body">  
                @if(session("success"))
                  <div class="alert alert-success text-success mt-2" role="alert" style="background: #ecffeb;"> 
                    <i class="icon-check"></i> {{session("success")}} 
                  </div> 
                @endif  
                @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul class="m-0">
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
                @endif
                <form method="POST" action="{{ route('save.assessmentform') }}" id="form" enctype="multipart/form-data">
                  @csrf  
                  <input type="hidden" id="statusData" name="statusData" value="C">
                  <input type="hidden" id="id" name="id" value="">
                  <div class="row"> 
                    <div class="col-md-5"> 
                      <div class="row"> 
                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="title"> หัวข้อแบบประเมิน <span class="text-danger">*</span></label>
                          <input id="title" type="text" class="form-control form-control-lg @error('title') invalid @enderror" name="title"  
                          value="{{ old('title') }}"
                          required autocomplete="title" autofocus placeholder="โปรดระบุข้อมูล..."> 
                          @error('title')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div>
                        <div class="col-md-12 form-group"> 
                          <label class="ml-1" for="sub_title"> หัวข้อย่อย <span class="text-danger">*</span></label>
                          <input id="sub_title" type="text" class="form-control form-control-lg @error('sub_title') invalid @enderror" name="sub_title"  
                          value="{{ old('sub_title') }}"
                          required autocomplete="sub_title" autofocus placeholder="โปรดระบุข้อมูล..."> 
                          @error('sub_title')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div>
                        <div class="col-md-4 form-group"> 
                          <label class="ml-1" for="sum_average"> คะแนนเฉลี่ย <span class="text-danger">*</span></label>
                          <input id="sum_average" type="number" class="form-control form-control-lg @error('sum_average') invalid @enderror" name="sum_average"  
                          value="{{ old('sum_average') }}"
                          required autocomplete="sum_average" autofocus placeholder="คะแนนเฉลี่ย">  
                          @error('sum_average')
                            <ul class="parsley-errors-list filled" ><li class="parsley-required">{{ $message }}</li></ul>
                          @enderror
                        </div>
                        <div class="col-md-8 form-group text-right"> 
                          <label class="ml-1" for="status"> สถานะการแสดงผล <span class="text-danger">*</span></label>  
                          <div class="cc-selector"> 
                            <input id="status1" type="radio" name="status" value="0" {{ old('status') == true ? old('status') == 0 ? "checked" : ""  : "checked"  }}/>
                            <label class="drinkcard-cc bg-success" for="status1"> เปิดการแสดงผล </label>  

                            <input id="status2" type="radio" name="status" value="1" {{ old('status') == 1 ? "checked" : "" }}/>
                            <label class="drinkcard-cc bg-danger" for="status2"> ปิดการแสดงผล </label> 
                          </div> 
                        </div> 
                      </div>
                    </div>
                    <div class="col-md-7"> 
                      <div class="row"> 
                        <div class="col-md-6">  
                          <div class="cc-selector"> 
                            <input id="type1" type="radio" name="type" value="1" checked/>
                            <label class="drinkcard-cc mb-0 bg-primary" for="type1"> แบบระบุคะแนน </label>  

                            <input id="type2" type="radio" name="type" value="2"/>
                            <label class="drinkcard-cc mb-0 bg-primary" for="type2"> แบบอธิบายเป็นข้อ </label> 
                          </div> 
                        </div> 
                        <div class="col-md-6 text-right"> 
                          <button type="button" class="btn btn-lg btn-secondary waves-effect waves-light" id="add-row"> <i class="fe-plus-circle"></i> เพิ่มแถว </button> 
                        </div>
                        <div class="col-md-6 pt-2"> <span class="text-danger alert-text"> </span> </div>
                      </div>
                      <div class="table-responsive"> 
                        <table class="table table-borderless dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="tbl-data">
                          <thead>
                            <tr> 
                              <th style="width: 5%">  # </th>  
                              <th style="width: 80%;"> หัวข้อ </th>  
                              <th style="width: 15%;"> คะแนน </th> 
                            </tr>
                          </thead> 
                          <tbody>  
                          </tbody>
                        </table> 
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="row">  
                    <div class="col-md-12 form-group text-right">   
                      <a href="{{ route('assessmentform.add') }}" class="btn btn-lg btn-secondary waves-effect waves-light"><i class="fe-chevron-left"></i> ย้อนกลับ </a>  
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
<script> 
  setTimeout(function(){ $('.alert-success').fadeOut(); }, 3000);
  $( "form" ).submit(function( event ) {  
    $('.text-submit').html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
    $( "form" ).submit();  
  }); 

  datatable();
  function datatable(keywrod, status){  
    var table = $('#tbl-data').DataTable({
      "processing":false,  
      "serverSide":false,  
      "searching": false,
      "lengthChange": true,   
      columns: [  
        {data: 'buttonMg', name: 'buttonMg'},
        {data: 'name', name: 'name'},   
        {data: 'average', name: 'average'},  
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
    var checked=$('input[name=type]:checked').val();
    if($('#sum_average').val()==""){
      $('#sum_average').addClass("parsley-error");
      return false;
    } else {
      $('#sum_average').removeClass("parsley-error");
    }
    var average="";
    var table = $('#tbl-data').DataTable(); 
    let count = (Math.random() + 1).toString(36).substring(7);
    if(checked==1){
      average='<input id="average" type="number" class="form-control average" name="array['+count+'][average]" value="" required="" autocomplete="average" autofocus="" placeholder="คะแนน">';
    } else if(checked==2){
      average='<div class="text-area"> Text area </div>';
    } 
    buttonMg='<button type="button" class="btn btn-icon waves-effect waves-light btn-danger delete-row" data-id="0"> <i class="fas fa-times"></i> </button>';
    table.row.add({
      "buttonMg" : buttonMg,
      "name" : '<input id="name" type="text" class="form-control" name="array['+count+'][name]" value="" required="" autocomplete="name" autofocus="" placeholder="หัวข้อ">',
      "average"  : average,
    }).draw(false);
  });

  $(document).on('click', '.delete-row', function(event) {
    var id=$(this)[0].dataset.id;
    var parents=$(this).parents('tr');
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
          var table = $('#tbl-data').DataTable();
          table.row(parents)
          .remove()
          .draw(); 
        } 
    });  
  });


  var delayID=null;
  $(document).on('keyup', '.average', function(event) {
    if(delayID==null){
      delayID=setTimeout(function(){
        input_average_keyup(); 
        delayID=null;
      },1500);                            
    }else{
      if(delayID){
        clearTimeout(delayID);
        delayID=setTimeout(function(){
          input_average_keyup(); 
          delayID=null;
        },1500);                        
      }       
    }   
  });
  
  function input_average_keyup(){
    var length = $('.average').length;
    var sum=0;
    for(var i=1; i<=length; i++){
      console.log("-->> "+$('.average')[i-1].value);
      sum+=parseInt($('.average')[i-1].value);
    } 

    var sum_average=parseInt($('#sum_average').val());
    console.log(sum+" > "+sum_average);
    if(sum>sum_average){
      $('.alert-text').html('<i class="fe-alert-circle"></i> กรุณาระบุคะแนนไม่เกินคะเเนนเฉลี่ยที่กำหนดไว้ !');
    } else {
      $('.alert-text').html('');
    }
  }
</script>
@endsection

