<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use DataTables;  
use App\Models\position;
use App\Models\department;
use App\Models\sub_department;


class PositionsController extends Controller
{
    public function positionslist()
    {
        $data=array(
            "Query_department" => department::all()->where('deleted_at', 0), 
        ); 
        return view('admin.positions.posit_list', compact('data'));
    }

    public function positionsadd()
    {
        $data=array(
            "Query_department" => department::all()->where('deleted_at', 0), 
        ); 
        return view('admin.positions.posit_add', compact('data'));
    }

    public function positionsedit($get_id)
    {
        $data=array( 
            "Query_department" => department::all()->where('deleted_at', 0), 
            "position_find" => position::find($get_id),
        );  
        return view('admin.positions.posit_edit', compact('data'));
    } 

    // ==========FUNCTION========== //
    public function Query_Datatable($keywrod, $status)
    {   
        $keywrod_sql=""; $status_sql="";
        if(isset($keywrod)){
            $keywrod_sql=" and positions.name LIKE '%".$keywrod."%'"; 
        }

        if(isset($status)){  
            $status_sql=" and positions.deleted_at = ".$status.""; 
        }

        $data = DB::select('select positions.id as id, positions.name as name, 
        positions.deleted_at as deleted_at, departments.name as departments_name,
        sub_departments.name as sub_departments_name
        from `positions` 
        LEFT JOIN departments ON positions.departments_id = departments.id
        LEFT JOIN sub_departments ON positions.sub_departments_id = sub_departments.id
        where positions.id != "" 
        '.$keywrod_sql.' '.$status_sql.'
        order by positions.id DESC'); 

        return $data;
    }

    public function datatablePositions(Request $request)
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
                return $row->name;
            })  
            ->addColumn('departments_name', function($row){    
                return $row->departments_name;
            })  
            ->addColumn('sub_departments_name', function($row){    
                return $row->sub_departments_name;
            })   
            ->addColumn('deleted_at', function($row){  
                $deleted_at='<span class="badge badge-success"> เปิดการแสดงผล </span>';
                if($row->deleted_at==1){
                    $deleted_at='<span class="badge badge-danger"> ปิดการแสดงผล </span>';
                }  
                return $deleted_at;
            })  
            ->addColumn('bntManger', function($row){      
                $html='<a href="'.route('positions.edit', $row->id).'" class="btn btn-xs btn-icon waves-effect btn-secondary ml-1"> <i class="mdi mdi-pencil"></i> </a>';
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

    public function closePositions(Request $request)
    {
        if(isset($request)){
            $data=DB::table('positions')
            ->where('positions.id', $request->id)  
            ->delete();
        }  
        return $data;
    }

    public function savePositions(Request $request)
    {
        if(isset($request)){
            $validatedData = $request->validate(
                [  
                    'name' => ['required', 'string', 'max:255'],
                    'departments_id' => ['required'], 
                    'sub_departments_id' => ['required'], 
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
                'sub_departments_id'  => $request->sub_departments_id,
                'deleted_at' => $request->status, 
                $dataType    => new \DateTime(),  
            );

            if($request->statusData=="C"){
                DB::table('positions')->insert($data);  
                return redirect()->route('positions.add')->with('success', $msg); 
            } else if($request->statusData=="U"){
                DB::table('positions')
                ->where('positions.id', $request->id)
                ->update($data);  
                return redirect()->route('positions.edit', [$request->id])->with('success', $msg); 
            }   
        } 
    }
}
