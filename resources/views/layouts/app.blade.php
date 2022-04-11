<!DOCTYPE html>
  <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> 
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <meta name="csrf-token" content="{{ csrf_token() }}"> 
        <title> Humanresort | ระบบจัดการข้อมูลฝ่ายทรัพยากรมนุษย์</title>   
        <link rel="shortcut icon" href="{{ asset('images/logo.png') }}"> 
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@200;300;400;500;600&display=swap" rel="stylesheet">

        <!-- App css -->
        <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
        <link href="{{ asset('admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin/css/app.min.css') }}" rel="stylesheet" type="text/css"  id="app-stylesheet" />
        <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet" type="text/css"  id="app-stylesheet" /> 
        @yield('style')
    </head>

    <body>
 
        <div id="wrapper"> 
            <div class="navbar-custom">
                @guest 
                @else 
                    <?php 
                        $Query_notifications=DB::select('select * 
                        from `notifications`
                        where  notifications.status = 0
                        order by notifications.id DESC'); 
                    ?>
                   <ul class="list-unstyled topnav-menu float-right mb-0">   
                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle  waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="dripicons-bell noti-icon"></i>
                                <span class="badge badge-pink rounded-circle noti-icon-badge" style="padding: 0.25em 0.4em; font-weight: 300;">@if(isset($Query_notifications)) {{ count($Query_notifications) }} @endif</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                                <div class="dropdown-header noti-title">
                                    <h5 class="text-overflow m-0"><span class="float-right">
                                        <span class="badge badge-danger float-right">@if(isset($Query_notifications)) {{ count($Query_notifications) }} @endif</span>
                                        </span>Notification</h5>
                                </div>

                                <div class="slimscroll noti-scroll">

                                @if(isset($Query_notifications))
                                    @foreach($Query_notifications as $row) 
                                    <a href="javascript: void(0);" class="dropdown-item notify-item notify-view" data-id="{{ $row->id }}">
                                        <div class="notify-icon bg-warning">
                                            @if($row->message_type==1)
                                                <i class="fe-user-plus"></i>
                                            @endif
                                        </div>
                                        <p class="notify-details">{{ $row->message }}<small class="text-muted"> {{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</small></p>
                                    </a>
                                    @endforeach
                                @endif
 
                                </div> 
                            </div>
                        </li>

                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <span class="pro-user-name ml-1"> 
                                    {{ Auth::user()->name }}   <i class="mdi mdi-chevron-down"></i> 
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                
                                <div class="dropdown-header noti-title">
                                    <?php 
                                        $authPessminName="";
                                        if(Auth::user()->permission_id==1){ 
                                            $authPessminName="Owner";
                                        } else if(Auth::user()->permission_id==2){
                                            $authPessminName="Administrator";
                                        } else {
                                            $authPessminName="Users";
                                        }
                                    ?>
                                    <h6 class="text-overflow m-0"> สิทธิ์ผู้ใช้งาน : {{ $authPessminName }} </h6>
                                </div>  
                                 
                                <a href="{{ route('profile') }}" class="dropdown-item notify-item">
                                    <i class="fe-settings"></i>
                                    <span>ตั้งค่าข้อมูลส่วนตัว</span>
                                </a> 

                                <div class="dropdown-divider"></div>  
                                <a href="#" class="dropdown-item notify-item" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    <i class="fe-log-out"></i>
                                    <span>ออกจากระบบ</span>
                                </a> 
                                <form id="logout-form" action="{{ route('signOut') }}" method="POST" class="d-none">
                                    @csrf
                                </form> 
                            </div>
                        </li> 
                   </ul> 
                @endguest
 
                <div class="logo-box">
                    <a href="{{ route('dashboard') }}" class="logo text-center">
                      <span class="logo-lg"> 
                          <span class="logo-lg-text-light">Farm Chokchai</span>
                      </span>
                      <span class="logo-sm">
                          <span class="text-light">F.CHOKCHAI</span> 
                      </span>
                    </a>
                </div>

                <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                  <li>
                    <button class="button-menu-mobile waves-effect waves-light">
                        <i class="fe-menu"></i>
                    </button>
                  </li> 
                </ul>
            </div>
            
            <div class="left-side-menu"> 
                <div class="slimscroll-menu"> 
                    <div id="sidebar-menu"> 
                        <ul class="metismenu" id="side-menu"> 
                            <li class="menu-title"> จัดการข้อมูล (Humanresort) </li>  
                            <li>
                                <a href="{{ route('dashboard') }}">
                                    <i class="fe-airplay"></i> 
                                    <span> แดชบอร์ด </span> 
                                </a>
                            </li>
                            <li>
                                <a href="javascript: void(0);">
                                    <i class="fe-user"></i> 
                                    <span> ข้อมูลพนักงาน </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false"> 
                                    <li> <a href="{{ route('employees.list') }}"> ข้อมูลพนักงาน </a></li>
                                    <li> <a href="{{ route('departments.list') }}"> ข้อมูลแผนก </a></li> 
                                    <li> <a href="{{ route('sub.departments.list') }}"> ข้อมูลแผนกย่อย </a></li> 
                                    <li> <a href="{{ route('positions.list') }}"> ข้อมูลตำแหน่ง </a></li> 
                                    <li> <a href="{{ route('branches.list') }}"> ข้อมูลสาขา </a></li> 
                                </ul>
                            </li> 
                            <li>
                                <a href="javascript: void(0);">
                                    <i class="fe-file-text"></i>
                                    <span> แบบประเมินผลออนไลน์ </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li> <a href="{{ route('assessmentform.list') }}"> จัดการฟอร์มการประเมิน </a></li>
                                    <li> <a href="{{ route('assessment.list') }}"> จัดการรูปแบบการประเมิน </a></li> 
                                </ul>
                            </li>  
                            <li>
                                <a href="javascript: void(0);">
                                    <i class="fe-user-plus"></i>
                                    <span> การสมัครงาน </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li> <a href="#"> แบบฟอร์มการสมัครงาน </a></li>
                                    <li> <a href="#"> รายการผู้สมัครงาน </a></li>
                                    <li> <a href="#"> ดูผลการประเมินผู้สมัครงาน </a></li> 
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);">
                                    <i class="fe-book"></i>
                                    <span> การลางาน / ลาหยุด </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li> <a href="#"> แบบฟอร์มการสมัครงาน </a></li>
                                    <li> <a href="#"> รายการผู้สมัครงาน </a></li>
                                    <li> <a href="#"> ดูผลการประเมินผู้สมัครงาน </a></li> 
                                </ul>
                            </li> 
                            <hr>
                            <li>
                                <a href="javascript: void(0);">
                                    <i class="fe-users"></i>
                                    <span> จัดการสิทธิ์ผู้ใช้งาน </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li> <a href="{{ route('request.access') }}"> ผู้เข้าใช้งานระบบ </a></li>
                                    <li> <a href="{{ route('roles.list') }}"> กำหนดบทบาทผู้ใช้งาน </a></li> 
                                    <li> <a href="{{ route('rolessystems.list') }}"> บทบาทการใช้งาน </a></li>
                                </ul>
                            </li>  
                        </ul> 
                    </div> 
                    <div class="clearfix"></div> 
                </div> 
            </div> 

            <div class="content-page"> 
                @yield('content')   
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                2021 - {{date('Y')}} &copy; Farm Chokchai | ระบบจัดการข้อมูลฝ่ายทรัพยากรมนุษย์ (Humanresort)
                            </div>
                        </div>
                    </div>
                </footer> 
            </div> 
        </div>  
        <script src="{{ asset('admin/js/vendor.min.js') }}"></script> 
        <script src="{{ asset('admin/js/app.min.js') }}"></script> 
        <script> 
            $(document).on('click', '.notify-view', function(event) { 
                var id=$(this)[0].dataset.id;
                $.post("{{ route('ajax.notifyview') }}", {
                _token: "{{ csrf_token() }}",  
                id: id,  
                })
                .done(function(data, status, error){   
                if(error.status==200){  
                    if(data!=null){ 
                        location.href = data;
                    } 
                }
                })
                .fail(function(xhr, status, error) { 
                    alert('An error occurred, please try again.'); 
                    location.reload();
                });  
            });
        </script> 
        @yield('script')
    </body>
</html>