<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;   
use App\Models\level;
use App\Models\branch; 
use App\Models\department; 
use App\Models\title; 
use App\Models\employee; 

class EmployeesController extends Controller
{
    public function employeeslist()
    {
        $data=array(
            "Query_level" => level::all()->where('deleted_at', 0),
            "Query_branch" => branch::all()->where('deleted_at', 0), 
            "Query_department" => department::all()->where('deleted_at', 0),  
        ); 
        return view('admin.employees.emp_list', compact('data'));
    }
    
    public function employeesadd()
    {
        $data=array(
            "Query_level" => level::all()->where('deleted_at', 0),
            "Query_branch" => branch::all()->where('deleted_at', 0), 
            "Query_department" => department::all()->where('deleted_at', 0), 
            "Query_title" => title::all()->where('deleted_at', 0), 
        ); 
        return view('admin.employees.emp_add', compact('data'));
    } 

    public function employeesedit($get_id)
    {
        $data=array(
            "Query_level" => level::all()->where('deleted_at', 0),
            "Query_branch" => branch::all()->where('deleted_at', 0), 
            "Query_department" => department::all()->where('deleted_at', 0), 
            "Query_title" => title::all()->where('deleted_at', 0), 
            "employee_find" => employee::find($get_id),
        ); 
        return view('admin.employees.emp_edit', compact('data'));
    }   

    public function employeesexport()
    {
        $data=array(
            "Query_export" => $this->Query_Datatable($_GET['keywrod'], $_GET['status'], $_GET['departments_id'], $_GET['sub_departments_id'], $_GET['positions_id'], $_GET['levels_id'], $_GET['branche_id']),
        ); 
        return view('admin.employees.emp_export', compact('data'));
    } 

    // ==========FUNCTION========== //
    public function Query_Datatable($keywrod, $status, $departments_id, $sub_departments_id, $positions_id, $levels_id, $branche_id)
    {   
        $keywrod_sql=""; $status_sql=""; $departments_id_sql=""; $sub_departments_id_sql=""; 
        $positions_id_sql="";  $levels_id_sql=""; $branche_id_sql="";
        if(isset($keywrod) && !empty($keywrod)){
            $keywrod_sql=" and employees.name LIKE '%".$keywrod."%'"; 
        }

        if(isset($status) && !empty($status)){  
            $status_sql=" and employees.deleted_at = ".$status.""; 
        }

        if(isset($departments_id) && !empty($departments_id)){  
            $departments_id_sql=" and employees.departments_id = ".$departments_id.""; 
        }

        if(isset($sub_departments_id) && !empty($sub_departments_id)){  
            $sub_departments_id_sql=" and employees.sub_departments_id = ".$sub_departments_id.""; 
        }

        if(isset($positions_id) && !empty($positions_id)){  
            $positions_id_sql=" and employees.position_id = ".$positions_id.""; 
        }

        if(isset($levels_id) && !empty($levels_id)){  
            $levels_id_sql=" and employees.level_id = ".$levels_id.""; 
        }

        if(isset($branche_id) && !empty($branche_id)){  
            $branche_id_sql=" and employees.branche_id = ".$branche_id.""; 
        }

        $data = DB::select('select employees.id as id, employees.employee_code as employees_code, employees.name as employees_name, employees.deleted_at as deleted_at,
        branches.name as branches_name, departments.name as departments_name, sub_departments.name as sub_departments_name, 
        positions.name as positions_name, levels.name as levels_name, titles.name as titles_name

        from `employees` 
        LEFT JOIN departments ON employees.departments_id = departments.id
        LEFT JOIN sub_departments ON employees.sub_departments_id = sub_departments.id
        LEFT JOIN branches ON employees.branche_id = branches.id
        LEFT JOIN positions ON employees.position_id = positions.id
        LEFT JOIN levels ON employees.level_id = levels.id
        LEFT JOIN titles ON employees.title_id = titles.id

        where employees.id != "" 
        '.$keywrod_sql.' '.$status_sql.' '.$departments_id_sql.' '.$sub_departments_id_sql.' 
        '.$positions_id_sql.'  '.$levels_id_sql.' '.$branche_id_sql.'
        order by employees.id asc');  
        return $data;
    }

    public function datatableEmployees(Request $request)
    { 
        if($request->ajax()) {     
            // ===================QUERY-DATATABLE======================= //
                $data=$this->Query_Datatable($request->keywrod, $request->status, $request->departments_id, $request->sub_departments_id, $request->positions_id, $request->levels_id, $request->branche_id);
            // ===================QUERY-DATATABLE======================= // 
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('employees_code', function($row){    
                return $row->employees_code;
            }) 
            ->addColumn('employees_name', function($row){    
                $img='<img src="'.asset('images/icon/no-users.jpg').'" alt="contact-img" title="contact-img" class="rounded-circle avatar-sm mr-2">';
                return '<a href="'.route('employees.edit', [$row->id]).'">'.$img.$row->titles_name." ".$row->employees_name.'</a>';
            }) 
            ->addColumn('branches_name', function($row){    
                return $row->branches_name;
            }) 
            ->addColumn('departments_name', function($row){    
                return $row->departments_name;
            }) 
            ->addColumn('sub_departments_name', function($row){    
                return $row->sub_departments_name;
            }) 
            ->addColumn('positions_name', function($row){    
                return $row->positions_name;
            })
            ->addColumn('levels_name', function($row){    
                return $row->levels_name;
            })  
            ->addColumn('deleted_at', function($row){  
                $deleted_at='<span class="badge badge-primary"> สถานะทำงานอยู่ </span>';
                if($row->deleted_at==1){
                    $deleted_at='<span class="badge badge-danger"> ปิดการแสดงผล </span>';
                } else if($row->deleted_at==2){
                    $deleted_at='<span class="badge badge-secondary"> พ้นสภาพพนักงาน </span>';
                }
                return $deleted_at;
            })  
            ->addColumn('bntManger', function($row){      
                $html='<a href="'.route('employees.edit', [$row->id]).'" class="btn btn-xs btn-icon waves-effect btn-secondary ml-1"> <i class="mdi mdi-pencil"></i> </a>';
                if(session('session_close')){
                    if(session('session_close')=="Y"){
                        $html.='<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger ml-1" id="close" data-id="'.$row->id.'"> <i class="mdi mdi-delete"></i> </button>';
                    }
                } 
                return $html;
            })  
            ->rawColumns(['employees_code','employees_name','branches_name','departments_name','sub_departments_name','positions_name','levels_name','deleted_at','bntManger'])
            ->make(true);
        } 
    }

    public function saveEmployees(Request $request)
    {
        $validatedData = $request->validate(
            [  
                'code' => ['required', 'string', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
                'branche_id' => ['required'],
                'departments_id' => ['required'], 
                'sub_departments_id' => ['required'], 
                'positions_id' => ['required'], 
                'levels_id' => ['required'],  
            ] 
        ); 

        if(isset($request)){  
            $msg="";
            if($request->statusData=="C"){
                $dataType="created_at";
                $msg="Save data successfully.";
            } else if($request->statusData=="U"){
                $dataType="updated_at";
                $msg="Update data successfully.";
            }

            $data=array(
                'employee_code' => $request->code, 
                'departments_id' => $request->departments_id, 
                'sub_departments_id' => $request->sub_departments_id, 
                'position_id' => $request->positions_id, 
                'branche_id' => $request->branche_id,
                'level_id' => $request->levels_id,
                'title_id' => $request->title_id, 

                'name'  => $request->name, 
                'deleted_at' => $request->status, 
                $dataType    => new \DateTime(),  
            );

            if($request->statusData=="C"){
                DB::table('employees')->insert($data); 
                return redirect()->route('employees.add')->with('success', $msg);  
            } else if($request->statusData=="U"){
                DB::table('employees')
                ->where('employees.id', $request->id)
                ->update($data);  
                return redirect()->route('employees.edit', [$request->id])->with('success', $msg); 
            } 
        } 
    }

    public function closeEmployees(Request $request)
    {    
        if(isset($request)){ 
            $data=DB::table('employees')
            ->where('employees.id', $request->id)  
            ->delete();
        }  
        return $data;
    } 

    public function closeEmployeesSocial(Request $request)
    { 
        if(isset($request)){
            $data=DB::table('social_logins')
            ->where('social_logins.id', $request->id)  
            ->delete();
        }  
        return $data;
    }  

    public function datatableEmployeesSocial(Request $request)
    { 
        if($request->ajax()) {     
            // ===================QUERY-DATATABLE======================= //
            $data = DB::select('select * 
            from `social_logins`  
            where social_logins.employees_id = 1 
            order by social_logins.id DESC');  
            // ===================QUERY-DATATABLE======================= // 
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('id', function($row){    
                return $row->id;
            }) 
            ->addColumn('username', function($row){    
                $picture_url=asset('images/icon/no-users.jpg');
                $handle = @get_headers($row->picture_url);  
                if($handle[0]!="HTTP/1.0 404 Not Found"){
                    $picture_url=$row->picture_url;
                }
                return '<img src="'.$picture_url.'" alt="contact-img" title="contact-img" class="rounded-circle avatar-sm mr-2">'.$row->username;
            }) 
            ->addColumn('social_token', function($row){    
                return $row->social_token;
            }) 
            ->addColumn('email', function($row){    
                return $row->email;
            }) 
            ->addColumn('social', function($row){  
                $social="";  
                if($row->social=="F"){
                    $social='<i class="mdi mdi-facebook-box text-primary" style="font-size: 25px;"></i>';
                } else if($row->social=="G"){
                    $social='<i class="mdi mdi-google-plus text-danger" style="font-size: 25px;"></i>';
                } else if($row->social=="L"){
                    $social='<i class="fab fa-line text-success" style="font-size: 25px;"></i>';
                }
                return $social;
            })  
            ->addColumn('bntManger', function($row){       
                $html="";
                if(session('session_close')){
                    if(session('session_close')=="Y"){
                        $html='<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger ml-1" id="close-social" data-id="'.$row->id.'"> <i class="mdi mdi-delete"></i> </button>';
                    }
                }  
                return $html;
            })  
            ->rawColumns(['id', 'username', 'social_token', 'email', 'social', 'bntManger'])
            ->make(true);
        } 
    } 
}
