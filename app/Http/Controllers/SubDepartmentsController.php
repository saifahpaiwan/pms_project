<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use DataTables;   
use App\Models\department;
use App\Models\sub_department;

class SubDepartmentsController extends Controller
{
    public function subDepartmentslist()
    {
        $data=array(
            "Query_department" => department::all()->where('deleted_at', 0)->where('deleted_at', 0), 
        ); 
        return view('admin.subDepartments.subdep_list', compact('data'));
    }

    public function subDepartmentsadd()
    {
        $data=array(
            "Query_department" => department::all()->where('deleted_at', 0), 
        ); 
        return view('admin.subDepartments.subdep_add', compact('data'));
    }

    public function subDepartmentsedit($get_id)
    {
        $data=array( 
            "Query_department" => department::all()->where('deleted_at', 0), 
            "sub_department_find" => sub_department::find($get_id),
        );  
        return view('admin.subDepartments.subdep_edit', compact('data'));
    } 

    // ==========FUNCTION========== //
    public function Query_Datatable($keywrod, $status)
    {   
        $keywrod_sql=""; $status_sql="";
        if(isset($keywrod)){
            $keywrod_sql=" and sub_departments.name LIKE '%".$keywrod."%'"; 
        }

        if(isset($status)){  
            $status_sql=" and sub_departments.deleted_at = ".$status.""; 
        }

        $data = DB::select('select sub_departments.id as id, sub_departments.name as name, 
        sub_departments.deleted_at as deleted_at, departments.name as departments_name 
        from `sub_departments` 
        LEFT JOIN departments ON sub_departments.departments_id = departments.id 
        where sub_departments.id != "" 
        '.$keywrod_sql.' '.$status_sql.'
        order by sub_departments.id DESC'); 

        return $data;
    }

    public function datatablesubDepartments(Request $request)
    { 
        if($request->ajax()) {     
            // ===================QUERY-DATATABLE======================= //
                $data=$this->Query_Datatable($request->keywrod, $request->status);
            // ===================QUERY-DATATABLE======================= // 
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('id', function($row){    
                return $row->id;
            }) 
            ->addColumn('name', function($row){    
                return '<a href="'.route('sub.departments.edit', $row->id).'">'.$row->name.'</a>';
            })  
            ->addColumn('departments_name', function($row){    
                return $row->departments_name;
            })    
            ->addColumn('deleted_at', function($row){  
                $deleted_at='<span class="badge badge-success"> เปิดการแสดงผล </span>';
                if($row->deleted_at==1){
                    $deleted_at='<span class="badge badge-danger"> ปิดการแสดงผล </span>';
                }  
                return $deleted_at;
            })  
            ->addColumn('bntManger', function($row){      
                $html='<a href="'.route('sub.departments.edit', $row->id).'" class="btn btn-xs btn-icon waves-effect btn-secondary ml-1"> <i class="mdi mdi-pencil"></i> </a>'; 
                if(session('session_close')){
                    if(session('session_close')=="Y"){
                        $html.='<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger ml-1" id="close" data-id="'.$row->id.'"> <i class="mdi mdi-delete"></i> </button>';
                    }
                }  
                return $html;
            })  
            ->rawColumns(['id','name','deleted_at','bntManger'])
            ->make(true);
        } 
    }

    public function closesubDepartments(Request $request)
    {
        if(isset($request)){
            $data=DB::table('sub_departments')
            ->where('sub_departments.id', $request->id)  
            ->delete();
        }  
        return $data;
    }

    public function savesubDepartments(Request $request)
    {
        if(isset($request)){
            $validatedData = $request->validate(
                [  
                    'name' => ['required', 'string', 'max:255'],
                    'departments_id' => ['required'],  
                    'status' => ['required'], 
                ] 
            );  

            if($request->statusData=="C"){
                $dataType="created_at";
                $msg="Save data successfully."; 
            } else if($request->statusData=="U"){
                $dataType="updated_at";
                $msg="Update data successfully."; 
            }

            $data=array(
                'name'  => $request->name,
                'departments_id'  => $request->departments_id, 
                'deleted_at' => $request->status, 
                $dataType    => new \DateTime(),  
            );

            if($request->statusData=="C"){
                DB::table('sub_departments')->insert($data);  
                return redirect()->route('sub.departments.add')->with('success', $msg); 
            } else if($request->statusData=="U"){
                DB::table('sub_departments')
                ->where('sub_departments.id', $request->id)
                ->update($data);  
                return redirect()->route('sub.departments.edit', [$request->id])->with('success', $msg); 
            }   
        } 
    }
}
