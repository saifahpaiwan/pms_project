@extends('layouts.app')
@section('style')     
  <link href="{{ asset('admin/libs/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('admin/libs/datatables/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('admin/libs/datatables/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
  <style>  
    
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
                    <div class="m-0 h5"> Export ข้อมูลพนักงาน </div>
                  </div>
                  <div class="col-md-6 text-right"> 
                    <a href="{{ route('employees.list') }}" class="m-0 h5"><i class="fe-chevron-left"></i> ย้อนกลับ </a> 
                  </div> 
                </div>
              </div>
              <div class="card-body">   
                <div class="table-responsive"> 
                  <table class="table table-borderless dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="tbl-export">
                    <thead>
                      <tr> 
                        <th style="width: 5%">  #รหัส </th>  
                        <th style="width: 40%;"> ชื่อ-นามสกุล </th>    
                        <th style="width: 10%;"> สาขา </th> 
                        <th style="width: 10%;"> แผนก </th> 
                        <th style="width: 10%;"> แผนกย่อย </th>  
                        <th style="width: 10%;"> ตำแหน่ง </th>  
                        <th style="width: 10%;"> ระดับ </th>   
                      </tr>
                    </thead> 
                    <tbody>  
                      @if(isset($data['Query_export']))
                        @foreach($data['Query_export'] as $row)
                          <tr> 
                            <td>{{ $row->employees_code }}</td>  
                            <td>{{ $row->titles_name." ".$row->employees_name }}</td> 
                            <td>{{ $row->branches_name }}</td> 
                            <td>{{ $row->departments_name }}</td> 
                            <td>{{ $row->sub_departments_name }}</td> 
                            <td>{{ $row->positions_name }}</td> 
                            <td>{{ $row->levels_name }}</td>  
                          </tr>
                        @endforeach
                      @endif
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
<script src="{{ asset('admin/libs/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables/responsive.bootstrap4.min.js') }}"></script>  

<!-- Buttons examples -->
<script src="{{ asset('admin/libs/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('admin/libs/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('admin/libs/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('admin/libs/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('admin/libs/datatables/buttons.colVis.js') }}"></script>
<script>
  $(document).ready(function() {
    pdfMake.fonts = {
      THSarabun: {
        normal: 'THSarabun.ttf',
        bold: 'THSarabun-Bold.ttf',
        italics: 'THSarabun-Italic.ttf',
        bolditalics: 'THSarabun-BoldItalic.ttf'
      }
    }
    $('#tbl-export').DataTable( {
      "processing":false,  
      "serverSide":false,  
      "searching": false,
      "lengthChange": false,  
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
        {
          "extend": 'excel',
          "text": '<i class="far fa-file-excel"></i> Excel',
        },
        {
          "extend": 'pdf',
          "text": '<i class="far fa-file-pdf"></i> PDF',
          "pageSize": 'A4',  
          "customize":function(doc){
            doc.defaultStyle = {
              font:'THSarabun',
              fontSize:13,                          
            };   
            doc.content[1].table.widths = ['auto', '*', 'auto', 'auto', 'auto', 'auto', 'auto'];
            doc.content[0].text="รายการข้อมูลพนักงาน";
            doc.styles.tableHeader.fontSize = 13; 
            doc.styles.tableBodyOdd.fillColor = "#FFF"; 
            var rowCount = doc.content[1].table.body.length; 
            for (i = 1; i < rowCount; i++) { 
              doc.content[1].table.body[i][0].alignment = 'left';
              doc.content[1].table.body[i][1].alignment = 'left';
              doc.content[1].table.body[i][2].alignment = 'left';
              doc.content[1].table.body[i][3].alignment = 'left';
            };  
          }
        }, 
      ], 
    });
  });
</script>
@endsection

