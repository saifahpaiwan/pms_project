<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;  
use App\Models\branch;

class BranchesController extends Controller
{
    public function brancheslist()
    {
        $data=array(); 
        return view('admin.branches.bran_list', compact('data'));
    }

    public function branchesadd()
    {
        $data=array(); 
        return view('admin.branches.bran_add', compact('data'));
    }

    public function branchesedit($get_id)
    {
        $data=array( 
            "branch_find" => branch::find($get_id),
        );  
        return view('admin.branches.bran_edit', compact('data'));
    } 

    // ==========FUNCTION========== //
    public function Query_Datatable($keywrod, $status)
    {   
        $keywrod_sql=""; $status_sql="";
        if(isset($keywrod)){
            $keywrod_sql=" and branches.name LIKE '%".$keywrod."%'"; 
        }

        if(isset($status)){  
            $status_sql=" and branches.deleted_at = ".$status.""; 
        }

        $data = DB::select('select * 
        from `branches` 
        where branches.id != "" 
        '.$keywrod_sql.' '.$status_sql.'
        order by branches.id asc'); 

        return $data;
    }

    public function datatableBranches(Request $request)
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
                return '<a href="'.route('branches.edit', $row->id).'">'.$row->name.'</a>';
            })   
            ->addColumn('deleted_at', function($row){  
                $deleted_at='<span class="badge badge-success"> เปิดการแสดงผล </span>';
                if($row->deleted_at==1){
                    $deleted_at='<span class="badge badge-danger"> ปิดการแสดงผล </span>';
                }  
                return $deleted_at;
            })  
            ->addColumn('bntManger', function($row){      
                $html='<a href="'.route('branches.edit', $row->id).'" class="btn btn-xs btn-icon waves-effect btn-secondary ml-1"> <i class="mdi mdi-pencil"></i> </a>';
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

    public function closeBranches(Request $request)
    {
        if(isset($request)){
            $data=DB::table('branches')
            ->where('branches.id', $request->id)  
            ->delete();
        }  
        return $data;
    }

    public function saveBranches(Request $request)
    {
        if(isset($request)){
            $validatedData = $request->validate(
                [  
                    'name' => ['required', 'string', 'max:255'],
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
                'deleted_at' => $request->status, 
                $dataType    => new \DateTime(),  
            );

            if($request->statusData=="C"){
                DB::table('branches')->insert($data); 
                return redirect()->route('branches.add')->with('success', $msg);  
            } else if($request->statusData=="U"){
                DB::table('branches')
                ->where('branches.id', $request->id)
                ->update($data);  
                return redirect()->route('branches.edit', [$request->id])->with('success', $msg); 
            } 
        } 
    }
}
