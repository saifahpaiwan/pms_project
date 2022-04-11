<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;  
use App\Models\roles_system;

class RolessystemsCortroller extends Controller
{
    public function rolessystemslist()
    {
        $data=array(); 
        return view('admin.permissions.rolessystems.rolsystem_list', compact('data'));
    }

    public function rolessystemsadd()
    {
        $data=array(); 
        return view('admin.permissions.rolessystems.rolsystem_add', compact('data'));
    }

    public function rolessystemsedit($get_id)
    {
        $data=array( 
            "rolessystems_find" => roles_system::find($get_id),
        );  
        return view('admin.permissions.rolessystems.rolsystem_edit', compact('data'));
    } 

    // ==========FUNCTION========== //
    public function Query_Datatable($keywrod, $status)
    {   
        $keywrod_sql=""; $status_sql="";
        if(isset($keywrod)){
            $keywrod_sql=" and roles_systems.name LIKE '%".$keywrod."%'"; 
        }

        if(isset($status)){  
            $status_sql=" and roles_systems.deleted_at = ".$status.""; 
        }

        $data = DB::select('select * 
        from `roles_systems` 
        where roles_systems.id != "" 
        '.$keywrod_sql.' '.$status_sql.'
        order by roles_systems.id asc'); 

        return $data;
    }

    public function datatableRolessystems(Request $request)
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
                return '<a href="'.route('rolessystems.edit', $row->id).'">'.$row->name.'</a>';
            })   
            ->addColumn('module', function($row){   
                return '<span class="badge badge-dark w-100"><i class="fe-folder"></i> '.$row->module.'</span>';
            })
            ->addColumn('deleted_at', function($row){  
                $deleted_at='<span class="badge badge-success"> เปิดการแสดงผล </span>';
                if($row->deleted_at==1){
                    $deleted_at='<span class="badge badge-danger"> ปิดการแสดงผล </span>';
                }  
                return $deleted_at;
            })  
            ->addColumn('bntManger', function($row){      
                $html='<a href="'.route('rolessystems.edit', $row->id).'" class="btn btn-xs btn-icon waves-effect btn-secondary ml-1"> <i class="mdi mdi-pencil"></i> </a>';
                if(session('session_close')){
                    if(session('session_close')=="Y"){
                        $html.='<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger ml-1" id="close" data-id="'.$row->id.'"> <i class="mdi mdi-delete"></i> </button>';
                    }
                }  
                return $html;
            })  
            ->rawColumns(['id','name', 'module', 'deleted_at','bntManger'])
            ->make(true);
        } 
    }

    public function closeRolessystems(Request $request)
    {
        if(isset($request)){
            $data=DB::table('roles_systems')
            ->where('roles_systems.id', $request->id)  
            ->delete();
        }  
        return $data;
    }

    public function saveRolessystems(Request $request)
    {
        if(isset($request)){
            $validatedData = $request->validate(
                [  
                    'name' => ['required', 'string', 'max:255'],
                    'module' => ['required', 'string', 'max:255'], 
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
                'module'  => $request->module, 

                'deleted_at' => $request->status, 
                $dataType    => new \DateTime(),  
            );

            if($request->statusData=="C"){
                DB::table('roles_systems')->insert($data); 
                return redirect()->route('rolessystems.add')->with('success', $msg);  
            } else if($request->statusData=="U"){
                DB::table('roles_systems')
                ->where('roles_systems.id', $request->id)
                ->update($data);  
                return redirect()->route('rolessystems.edit', [$request->id])->with('success', $msg); 
            } 
        } 
    }
}
