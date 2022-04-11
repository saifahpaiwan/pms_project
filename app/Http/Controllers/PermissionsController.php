<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth;
use DataTables;  
use Hash;
use Session;
use App\Models\User;
use App\Models\permission;
use App\Models\role; 

class PermissionsController extends Controller
{
    public function Query_permission()
    {
        $data=permission::whereNotIn('level', [1])->get(); 
        return $data;
    }

    public function requestAccess()
    { 
        $data=array(
            "Query_permission" => $this->Query_permission(),
        );   
        return view('admin.permissions.requestAccess', compact('data'));
    }

    public function permissionsadd()
    { 
        $data=array(
            "Query_permission" => $this->Query_permission(),
        );   
        return view('admin.permissions.permis_add', compact('data'));
    }

    public function permissionsedit($get_id)
    {  
        $data=array(
            "Query_permission" => $this->Query_permission(),
            "users_find" => User::find($get_id),
        );   
        return view('admin.permissions.permis_edit', compact('data'));
    } 

    public function roleslist()
    { 
        $data=array(
            "Query_permission" => $this->Query_permission(),
        );   
        return view('admin.permissions.roles_list', compact('data'));
    } 

    public function rolesadd()
    { 
        $data=array(  
            "Query_permission" => $this->Query_permission(),
        );   
        return view('admin.permissions.roles_add', compact('data'));
    } 

    public function rolesedit($get_id)
    {  
        $data=array(
            "Query_permission" => $this->Query_permission(),
            "permission_find" => permission::find($get_id), 
        );   
        return view('admin.permissions.roles_edit', compact('data'));
    } 
    
    // ==========FUNCTION========== //
    public function Query_Datatable_Roles($id)
    {      
        if(!empty($id)){   
            $data = DB::select('select roles.id as id, permissions.id as permissions_id,
            roles_systems.id as roles_systems_id, roles_systems.name as name, roles_systems.module as module,
            roles.view as view_r, roles.add as add_r, roles.edit as edit_r, roles.delete as delete_r, roles.export as export_r
             
            from `roles` 
            LEFT JOIN permissions ON roles.permission_id = permissions.id
            LEFT JOIN roles_systems ON roles.roles_systems_id = roles_systems.id  
            where permissions.id = '.$id.'
            order by roles_systems.id asc');   
        } else {
            $data = DB::select('select *
            from `roles_systems`   
            order by roles_systems.id asc');  
        } 
        
        return $data;
    }

    public function datatableRoles(Request $request)
    { 
        if($request->ajax()) {     
            // ===================QUERY-DATATABLE======================= //
                $data=$this->Query_Datatable_Roles($request->id);
            // ===================QUERY-DATATABLE======================= // 
            return Datatables::of($data)
            ->addIndexColumn() 
            ->addColumn('name', function($row){    
                return '<input type="hidden" name="array['.$row->id.'][roles_id]" value="'.$row->id.'"><input type="text" class="form-control form-control-sm" name="array['.$row->id.'][roles_name]" placeholder="โปรดระบุข้อมูล..." required value="'.$row->name.'" disabled>';
            })
            ->addColumn('detail', function($row){    
                return '<input type="text" class="form-control form-control-sm" name="array['.$row->id.'][roles_detail]" placeholder="โปรดระบุข้อมูล..." required value="'.$row->module.'" disabled>';
            }) 
            ->addColumn('view', function($row){    
                $checked="";
                if(isset($row->view_r)){
                    if($row->view_r=="Y"){$checked="checked";}
                } 
                return '<div class="custom-control custom-checkbox text-center"> <input '.$checked.' type="checkbox" class="custom-control-input" id="view'.$row->id.'" name="array['.$row->id.'][roles_view]" value="Y">  <label class="custom-control-label" for="view'.$row->id.'"></label> </div>';
            }) 
            ->addColumn('add', function($row){    
                $checked="";
                if(isset($row->add_r)){
                    if($row->add_r=="Y"){$checked="checked";}
                }
                return '<div class="custom-control custom-checkbox text-center"> <input '.$checked.' type="checkbox" class="custom-control-input" id="add'.$row->id.'" name="array['.$row->id.'][roles_add]" value="Y">  <label class="custom-control-label" for="add'.$row->id.'"></label> </div>';
            }) 
            ->addColumn('edit', function($row){    
                $checked="";
                if(isset($row->edit_r)){
                    if($row->edit_r=="Y"){$checked="checked";}
                }
                return '<div class="custom-control custom-checkbox text-center"> <input '.$checked.' type="checkbox" class="custom-control-input" id="edit'.$row->id.'" name="array['.$row->id.'][roles_edit]" value="Y">  <label class="custom-control-label" for="edit'.$row->id.'"></label> </div>';
            })
            ->addColumn('delete', function($row){    
                $checked="";
                if(isset($row->delete_r)){
                    if($row->delete_r=="Y"){$checked="checked";}
                }
                return '<div class="custom-control custom-checkbox text-center"> <input '.$checked.' type="checkbox" class="custom-control-input" id="delete'.$row->id.'" name="array['.$row->id.'][roles_delete]" value="Y">  <label class="custom-control-label" for="delete'.$row->id.'"></label> </div>';
            }) 
            ->addColumn('export', function($row){    
                $checked="";
                if(isset($row->export_r)){
                    if($row->export_r=="Y"){$checked="checked";}
                }
                return '<div class="custom-control custom-checkbox text-center"> <input '.$checked.' type="checkbox" class="custom-control-input" id="export'.$row->id.'" name="array['.$row->id.'][roles_export]" value="Y">  <label class="custom-control-label" for="export'.$row->id.'"></label> </div>';
            })  
            ->rawColumns(['name','detail','view', 'add', 'edit', 'delete', 'export'])
            ->make(true);
        } 
    }
    
    public function Query_Datatable_Permiss($keywrod, $status)
    {   
        $keywrod_sql=""; $status_sql="";
        if(isset($keywrod)){
            $keywrod_sql=" and permissions.name LIKE '%".$keywrod."%'"; 
        }

        if(isset($status)){  
            $status_sql=" and permissions.deleted_at = ".$status.""; 
        }

        $data = DB::select('select * 
        from `permissions` 
        where permissions.id != "" 
        '.$keywrod_sql.' '.$status_sql.'
        order by permissions.id asc'); 

        return $data;
    }

    public function datatablePermissions(Request $request)
    { 
        if($request->ajax()) {     
            // ===================QUERY-DATATABLE======================= //
                $data=$this->Query_Datatable_Permiss($request->keywrod, $request->status);
            // ===================QUERY-DATATABLE======================= // 
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('id', function($row){    
                return $row->id;
            }) 
            ->addColumn('name', function($row){   
                $name=$row->name; 
                if($row->id!=1){
                    $name='<a href="'.route('roles.edit', $row->id).'">'.$row->name.'</a>';
                }
                return $name;
            })   
            ->addColumn('deleted_at', function($row){  
                $deleted_at='<span class="badge badge-success"> เปิดการแสดงผล </span>';
                if($row->deleted_at==1){
                    $deleted_at='<span class="badge badge-danger"> ปิดการแสดงผล </span>';
                }  
                return $deleted_at;
            })  
            ->addColumn('bntManger', function($row){    
                $html='<span class="badge badge-primary w-100">Owner</span>'; 
                if($row->id!=1){
                    $html='<a href="'.route('roles.edit', $row->id).'" class="btn btn-xs btn-icon waves-effect btn-secondary"> <i class="mdi mdi-pencil"></i> </a>';
                    if(session('session_close')){
                        if(session('session_close')=="Y"){
                            $html.='<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger ml-1" id="close" data-id="'.$row->id.'"> <i class="mdi mdi-delete"></i> </button>';
                        }
                    }  
                }   
                return $html;
            })  
            ->rawColumns(['id','name','deleted_at','bntManger'])
            ->make(true);
        } 
    }
    
    public function Query_Datatable_Users($keywrod, $permission, $status)
    {   
        $keywrod_sql=""; $permission_sql=""; $status_sql="";
        if(isset($keywrod)){
            $keywrod_sql=" and users.name LIKE '%".$keywrod."%' or permissions.name LIKE '%".$keywrod."%'"; 
        }

        if(isset($status)){  
            $status_sql=" and users.deleted_at = ".$status.""; 
        }
        
        if(isset($permission)){  
            $permission_sql=" and permissions.id = ".$permission.""; 
        }

        $data = DB::select('select users.id as id, users.name as name, users.email as email, permissions.name permissions_name,
        users.deleted_at as deleted_at, users.permission_id as permission_id

        from `users` 
        LEFT JOIN permissions ON users.permission_id = permissions.id
        where users.deleted_at in (0,1,2,3) 
        '.$keywrod_sql.' '.$permission_sql.' '.$status_sql.'
        order by users.id asc'); 

        return $data;
    }

    
    public function datatableRequestAccess(Request $request)
    { 
        if($request->ajax()) {     
            // ===================QUERY-DATATABLE======================= //
                $data=$this->Query_Datatable_Users($request->keywrod, $request->permission, $request->status);
            // ===================QUERY-DATATABLE======================= // 
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('id', function($row){    
                return $row->id;
            }) 
            ->addColumn('name', function($row){    
                $img='<img src="'.asset('images/icon/no-users.jpg').'" alt="contact-img" title="contact-img" class="rounded-circle avatar-sm mr-2">';
                $tag=$img.$row->name;
                if($row->permission_id!=1){
                    $tag='<a href="'.route('permissions.edit', [$row->id]).'">'.$img.$row->name.'</a>';
                }
                return $tag; 
            })  
            ->addColumn('email', function($row){    
                return $row->email;
            })   
            ->addColumn('permissions_name', function($row){    
                return $row->permissions_name;
            })   
            ->addColumn('status', function($row){  
                $status="";  
                if($row->deleted_at==0){
                    $status='<span class="badge badge-success"> ผู้เข้าใช้งานระบบ </span>';  
                } else if($row->deleted_at==1){
                    $status='<span class="badge badge-danger"> ปิดการแสดงผล </span>';  
                } else if($row->deleted_at==2){
                    $status='<span class="badge badge-danger"> ยกเลิกข้อมูล </span>';  
                } else if($row->deleted_at==3){
                    $status='<span class="badge badge-primary"> ขอเข้าใช้งานระบบ </span>';  
                }
                return $status;
            })  
            ->addColumn('bntManger', function($row){    
                $html='<span class="badge badge-primary w-100">Owner</span>'; 
                if($row->permission_id!=1){
                    $html='<a href="'.route('permissions.edit', $row->id).'" class="btn btn-xs btn-icon waves-effect btn-secondary"> <i class="mdi mdi-pencil"></i> จัดการสิทธ์ </a>';
                    if(session('session_close')){
                        if(session('session_close')=="Y"){
                            $html.='<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger ml-1" id="close" data-id="'.$row->id.'"> <i class="mdi mdi-delete"></i> </button>';
                        }
                    }  
                }  
                return $html;
            })  
            ->rawColumns(['id','name', 'email', 'status', 'permissions_name', 'bntManger'])
            ->make(true);
        } 
    }

    public function savePermissions(Request $request)
    {
        if(isset($request)){  
            if($request->statusData=="C"){ 
                $validatedData = $request->validate(
                    [  
                        'usersname' => ['required', 'string', 'max:255'],
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],  
                        'permission' => ['required'], 
                        'password' => ['required', 'string', 'min:8', 'same:passwordConfirm'],
                        'passwordConfirm' => 'required'
                        
                    ] 
                );  

                $msg="Save data successfully."; 
                $data=array(
                    'name'  => $request->usersname, 
                    'email' => $request->email, 
                    'permission_id'  => $request->permission, 
                    'password'  => Hash::make($request->password), 
    
                    'deleted_at' => $request->status, 
                    'created_at'    => new \DateTime(),  
                );  
            } else if($request->statusData=="U"){   
                $msg="Update data successfully.";
                if(!empty($request->old_password)){
                    $validatedData = $request->validate(
                        [  
                            'usersname' => ['required', 'string', 'max:255'], 
                            'permission' => ['required'],
                            'old_password' => [ 'string', 'min:8'], 
                            'new_password' => [ 'string', 'min:8', 'same:passwordConfirm'], 
                        ] 
                    ); 
                    $userPassword=User::find($request->id); 
                    if (!Hash::check($request->old_password, $userPassword->password)) {
                        return back()->withErrors(['old_password'=>'รหัสผ่านไม่ตรงกัน !']); 
                    }  
                    $data=array(
                        'name'  => $request->usersname,  
                        'permission_id'  => $request->permission, 
                        'password'  => Hash::make($request->new_password), 
        
                        'deleted_at' => $request->status, 
                        'updated_at'    => new \DateTime(),  
                    );
                } else {
                    $validatedData = $request->validate(
                        [  
                            'usersname' => ['required', 'string', 'max:255'], 
                            'permission' => ['required'], 
                        ] 
                    ); 
                    $data=array(
                        'name'  => $request->usersname,  
                        'permission_id'  => $request->permission,  

                        'deleted_at' => $request->status, 
                        'updated_at'    => new \DateTime(),  
                    );
                }
            } 

            if($request->statusData=="C"){
                DB::table('users')->insert($data); 
                return redirect()->route('permissions.add')->with('success', $msg);  
            } else if($request->statusData=="U"){
                DB::table('users')
                ->where('users.id', $request->id)
                ->update($data);  
                return redirect()->route('permissions.edit', [$request->id])->with('success', $msg); 
            } 
        } 
    }

    public function closePermissions(Request $request)
    {
        if(isset($request)){
            $data=DB::table('users')
            ->where('users.id', $request->id)  
            ->delete();
        }  
        return $data;
    }

    public function saveRoles(Request $request)
    {    
        if(isset($request)){ 
            $validatedData = $request->validate(
                [  
                    'name' => ['required', 'string', 'max:255'],
                    'detail' => ['required', 'string', 'max:255'],

                    "array"    => "required|array",
                    "array.*"  => "required",
                ] 
            );  

            if($request->statusData=="C"){
                $data=array(
                    "name"      => $request->name,
                    "detail"    => $request->detail,
                    "level"     => 3,
    
                    'created_at'    => new \DateTime(),
                ); 
                $last_id=DB::table('permissions')->insertGetId($data); 
                if(!empty($last_id)){
                    if(count($request->array)>0){
                        foreach($request->array as $row){
                            $data_roles=array(
                                "permission_id" => $last_id,
                                "roles_systems_id"  => $row['roles_id'],  

                                "view"    => (isset($row['roles_view']))? "Y" : "N", 
                                "add"     => (isset($row['roles_add']))? "Y" : "N", 
                                "edit"    => (isset($row['roles_edit']))? "Y" : "N", 
                                "delete"  => (isset($row['roles_delete']))? "Y" : "N", 
                                "export"  => (isset($row['roles_export']))? "Y" : "N", 
                                
                                'created_at'    => new \DateTime(),
                            );
                            DB::table('roles')->insert($data_roles); 
                        }
                    }
                    $msg="Save data successfully."; 
                }
                return redirect()->route('roles.add')->with('success', $msg);  
            } else if($request->statusData=="U"){
                $data=array(
                    "name"      => $request->name,
                    "detail"    => $request->detail,
                    "level"     => 3,
    
                    'updated_at'    => new \DateTime(),
                ); 
                DB::table('permissions')
                ->where('permissions.id', $request->id)
                ->update($data);  
                $last_id=$request->id;
                if(!empty($last_id)){
                    if(count($request->array)>0){
                        foreach($request->array as $row){
                            if($row['roles_id']==0){
                                $date_at="created_at";
                            }else{
                                $date_at="updated_at";
                            }
                            $data_roles=array(  
                                "view"    => (isset($row['roles_view']))? "Y" : "N", 
                                "add"     => (isset($row['roles_add']))? "Y" : "N", 
                                "edit"    => (isset($row['roles_edit']))? "Y" : "N", 
                                "delete"  => (isset($row['roles_delete']))? "Y" : "N", 
                                "export"  => (isset($row['roles_export']))? "Y" : "N", 
                                
                                $date_at  => new \DateTime(),
                            ); 
                            if($row['roles_id']==0){
                                DB::table('roles')->insert($data_roles);
                            } else {
                                DB::table('roles')
                                ->where('roles.id', $row['roles_id'])
                                ->update($data_roles);  
                            }
                        }
                    }
                    $msg="Update data successfully."; 
                } 
                return redirect()->route('roles.edit', [$request->id])->with('success', $msg); 
            } 
        }
    } 

    public function closeRoles(Request $request)
    {
        if(isset($request)){
            $data=DB::table('permissions')
            ->where('permissions.id', $request->id)  
            ->delete();

            $data=DB::table('roles')
            ->where('roles.permission_id', $request->id)  
            ->delete();
        }  
        return $data;
    }
}
