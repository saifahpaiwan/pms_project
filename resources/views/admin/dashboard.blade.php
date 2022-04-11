@extends('layouts.app')
@section('style')    
  <!-- Treeview css -->
  <link href="{{ asset('admin/libs/treeview/style.css') }}" rel="stylesheet" type="text/css" /> 
  <style> 
    .tree-or {
      padding: 0.5rem;
      background: #177ccc;
      color: #FFF;
    }
    .a-mg {
      padding: 0.5rem;
      background: #6c757d;
      color: #fff;
    }
  </style>
@endsection
@section('content')
    <div class="content"> 
      <div class="container-fluid"> 
        <div class="row">
          <div class="col-12">
              <div class="page-title-box"> 
                  <h4 class="page-title"> <i class="fe-airplay"></i> แดชบอร์ด  </h4>
              </div>
          </div>
        </div>   
        <div class="row">
          <div class="col-lg-4"> 
            <div class="card-box widget-box-two widget-two-custom ">
                <div class="media">
                    <div class="avatar-lg rounded-circle bg-primary widget-two-icon align-self-center">
                        <i class="mdi mdi-account-multiple avatar-title font-30 text-white"></i>
                    </div>

                    <div class="wigdet-two-content media-body">
                        <p class="m-0 text-uppercase font-weight-medium text-truncate" title="Statistics">จำนวนพนักงานทั้งหมด</p>
                        <h3 class="font-weight-medium my-2"> <span data-plugin="counterup">{{$data['count_employee']}}</span> คน </h3>
                        <p class="m-0">Date : {{ date('m/d/Y') }}</p>
                    </div>
                </div>
            </div>
          </div>
          <div class="col-lg-4"> 
            <div class="card-box widget-box-two widget-two-custom ">
                <div class="media">
                    <div class="avatar-lg rounded-circle bg-primary widget-two-icon align-self-center">
                        <i class="mdi mdi-home-account avatar-title font-30 text-white"></i>
                    </div>

                    <div class="wigdet-two-content media-body">
                        <p class="m-0 text-uppercase font-weight-medium text-truncate" title="Statistics">จำนวนแผนกทั้งหมด</p>
                        <h3 class="font-weight-medium my-2"> <span data-plugin="counterup">{{$data['count_department']}}</span> แผนก </h3>
                        <p class="m-0">Date : {{ date('m/d/Y') }}</p>
                    </div>
                </div>
            </div>
          </div>
          <div class="col-lg-2"> 
            <div class="card card-body text-center" style="background: #177ccc;"> 
                <div style="font-size: 35px; " class="text-white"> <i class="mdi mdi-file-document-box-search"></i> </div>  
                <a href="#" class="btn btn-primary waves-effect waves-light">ดูข้อมูลพนักงาน</a>
            </div>
          </div>
          <div class="col-lg-2"> 
            <div class="card card-body text-center" style="background: #177ccc;"> 
                <div style="font-size: 35px; " class="text-white"> <i class="mdi mdi-account-multiple-plus"></i> </div>  
                <a href="#" class="btn btn-primary waves-effect waves-light">เพิ่มพนักงาน</a>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="card-box">
              <h4 class="m-0">
                รายการการลางาน
                <button type="button" class="btn btn-dark waves-effect width-md waves-light float-right"> จัดการข้อมูล </button>
              </h4>
              <div class="mb-1"> ตารางข้อมูลการลางานที่ยังไม่อนุมัติ </div>
              <div class="table-responsive"> 
                <table class="table mb-0 table-sm">
                    <thead>
                      <tr>
                          <th>#</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Username</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                          <th scope="row">1</th>
                          <td>Mark</td>
                          <td>Otto</td>
                          <td>@mdo</td>
                      </tr>
                      <tr>
                          <th scope="row">2</th>
                          <td>Jacob</td>
                          <td>Thornton</td>
                          <td>@fat</td>
                      </tr> 
                    </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="card-box">
              <h4 class="m-0">รายการผู้สมัครงานใหม่
                <button type="button" class="btn btn-dark waves-effect width-md waves-light float-right"> จัดการข้อมูล </button>
              </h4>
              <div class="mb-1"> ตารางข้อมูลผู้สมัครงานใหม่ที่ยังไม่อนุมัติ </div>
              <div class="table-responsive"> 
                <table class="table mb-0 table-sm">
                    <thead>
                      <tr>
                          <th>#</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Username</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                          <th scope="row">1</th>
                          <td>Mark</td>
                          <td>Otto</td>
                          <td>@mdo</td>
                      </tr>
                      <tr>
                          <th scope="row">2</th>
                          <td>Jacob</td>
                          <td>Thornton</td>
                          <td>@fat</td>
                      </tr> 
                    </tbody>
                </table>
              </div>
            </div>
          </div> 
          <div class="col-lg-6"> 
            <div class="card-box">  
              <div class="h4"> ลำดับจัดการ Level </div>
              <div class="text-left mt-3"> 
                <ul> 
                  <li class="mt-3"> 
                    <span class="tree-or"> ลำดับผู้บริหาร จำนวน 5 คน</span> 
                    <span class="a-mg"> <i class="fe-more-vertical"></i>  </span> 
                    <ul> 
                      <li class="mt-3"> 
                        <span class="tree-or"> ลำดับผู้จัดการ จำนวน 20 คน</span> 
                        <span class="a-mg"> <i class="fe-more-vertical"></i>  </span>
                        <ul> 
                          <li class="mt-3"> 
                            <span class="tree-or"> ลำดับหัวหน้างาน จำนวน 50 คน</span> 
                            <span class="a-mg"> <i class="fe-more-vertical"></i>  </span>
                            <ul> 
                              <li class="mt-3"> 
                                <span class="tree-or"> ลำดับพนักงาน จำนวน 400 คน</span> 
                                <span class="a-mg"> <i class="fe-more-vertical"></i>  </span>
                              </li>
                            </ul>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-6"> 
            <div class="card-box">  
              <div class="h4"> โครงสร้างข้อมูลพนักงาน </div>


                <div class="mt-3" id="basicTree">
                  <ul>
                      <li>ผู้บริหาร
                          <ul>
                              <li data-jstree='{"selected":true, "opened":true}'>ฝ่ายสำนักงาน CI	
                                  <ul>
                                      <li data-jstree='{"type":"file"}'>ส่วนงานธุรการสำนักงาน</li>
                                      <li data-jstree='{"type":"file"}'>ส่วนงานซ่อมบำรุงรักษา / ช่าง</li>
                                      <li data-jstree='{"type":"file"}'>ส่วนงานสาธารณูปโภค</li>
                                      <li data-jstree='{"type":"file"}'>ส่วนงาน it/suport, Programer</li> 
                                  </ul>
                              </li>
                              <li data-jstree='{"selected":flase, "opened":true}'>ฝ่ายการเงินและการบัญชี
                                  <ul>
                                      <li data-jstree='{"type":"file"}'>ส่วนงานธุรการสำนักงาน</li>
                                      <li data-jstree='{"type":"file"}'>ส่วนงานซ่อมบำรุงรักษา / ช่าง</li>
                                      <li data-jstree='{"type":"file"}'>ส่วนงานสาธารณูปโภค</li>
                                      <li data-jstree='{"type":"file"}'>ส่วนงาน it/suport, Programer</li> 
                                  </ul>
                              </li> 
                          </ul>
                      </li> 
                  </ul>
                </div> 
              </div>
            </div>
          </div>
        </div>   
      </div>  
    </div>   
@endsection
@section('script')   
<!-- Tree view js -->
<script src="{{ asset('admin/libs/treeview/jstree.min.js') }}"></script>
<script src="{{ asset('admin/js/pages/treeview.init.js') }}"></script>
<script> 
</script>
@endsection

