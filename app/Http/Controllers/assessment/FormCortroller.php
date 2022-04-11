<?php

namespace App\Http\Controllers\assessment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;  
use App\Models\assessmentForm;
use App\Models\assessmentFormDetail;

class FormCortroller extends Controller
{
    public function assessmentformlist()
    {
        $data=array(); 
        return view('admin.assessment.form_list', compact('data'));
    }

    public function assessmentformadd()
    {
        $data=array(); 
        return view('admin.assessment.form_add', compact('data'));
    }

    public function assessmentformedit($get_id)
    {
        $data=array( 
            "assessmentForm_find" => assessmentForm::find($get_id),
        );  
        return view('admin.assessment.form_edit', compact('data'));
    } 

    // ==========FUNCTION========== //
    public function Query_Datatable($keywrod, $status)
    {   
        $keywrod_sql=""; $status_sql="";
        if(isset($keywrod)){
            $keywrod_sql=" and assessment_forms.name LIKE '%".$keywrod."%'"; 
        }

        if(isset($status)){  
            $status_sql=" and assessment_forms.deleted_at = ".$status.""; 
        }

        $data = DB::select('select * 
        from `assessment_forms` 
        where assessment_forms.id != "" 
        '.$keywrod_sql.' '.$status_sql.'
        order by assessment_forms.id asc'); 

        return $data;
    }

    public function datatableAssessmentform(Request $request)
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
            ->addColumn('title', function($row){    
                return '<a href="'.route('assessmentform.edit', $row->id).'">'.$row->title.'</a>';
            })   
            ->addColumn('deleted_at', function($row){  
                $deleted_at='<span class="badge badge-success"> เปิดการแสดงผล </span>';
                if($row->deleted_at==1){
                    $deleted_at='<span class="badge badge-danger"> ปิดการแสดงผล </span>';
                }  
                return $deleted_at;
            })  
            ->addColumn('bntManger', function($row){      
                $html='<a href="'.route('assessmentform.edit', $row->id).'" class="btn btn-xs btn-icon waves-effect btn-secondary ml-1"> <i class="mdi mdi-pencil"></i> </a>';
                if(session('session_close')){
                    if(session('session_close')=="Y"){
                        $html.='<button type="button" class="btn btn-xs btn-icon waves-effect waves-light btn-danger ml-1" id="close" data-id="'.$row->id.'"> <i class="mdi mdi-delete"></i> </button>';
                    }
                }  
                return $html;
            })  
            ->rawColumns(['id','title','deleted_at','bntManger'])
            ->make(true);
        } 
    }

    public function closeAssessmentform(Request $request)
    {
        if(isset($request)){
            $data=DB::table('assessment_forms')
            ->where('assessment_forms.id', $request->id)  
            ->delete();

            $data=DB::table('assessment_form_details')
            ->where('assessment_form_details.forms_id', $request->id)  
            ->delete();
        }  
        return $data;
    }
 
    public function saveAssessmentform(Request $request)
    {  
        if(isset($request)){
            $validatedData = $request->validate(
                [  
                    'title' => ['required', 'string', 'max:255'],
                    'sub_title' => ['required', 'string', 'max:255'],
                    'sum_average' => ['required'], 
                    'status' => ['required'], 

                    "array"    => "required|array",
                    "array.*"  => "required",
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
                "title"         => $request->title,
                "sub_title"     => $request->sub_title,
                "sum_average"   => $request->sum_average,

                'deleted_at' => $request->status, 
                $dataType  => new \DateTime(),  
            );

            if($request->statusData=="C"){
                $GetId=DB::table('assessment_forms')->insertGetId($data);  
            } else if($request->statusData=="U"){
                $GetId=$request->id;
                DB::table('assessment_forms')
                ->where('assessment_forms.id', $GetId)
                ->update($data);
            } 

            if(isset($request->array)){
                if(count($request->array)>0){
                    foreach($request->array as $key=>$row){
                        $type=(isset($row['average']))? 1 : 2 ;
                        $data_de=array(
                            "forms_id" => $GetId,
                            "name"     => $row['name'],
                            "average"  => (isset($row['average']))? $row['average'] : 0 , 
                            "type"     => $type, 
                           
                            $dataType  => new \DateTime(),  
                        );
                        if($request->statusData=="C"){
                            DB::table('assessment_form_details')->insert($data_de);   
                        } else if($request->statusData=="U"){
                            if($row['id']==0){
                                DB::table('assessment_form_details')->insert($data_de);  
                            } else {
                                DB::table('assessment_form_details')
                                ->where('assessment_form_details.id', $row['id'])
                                ->update($data_de);
                            }  
                        } 
                    }
                }
            } 

            if($request->statusData=="C"){
                return redirect()->route('assessmentform.add')->with('success', $msg);
            } else if($request->statusData=="U"){
                return redirect()->route('assessmentform.edit', [$GetId])->with('success', $msg);
            } 
        }
    }

    public function Query_Datatable_Detail($id)
    {    
        $data = DB::select('select * 
        from `assessment_form_details` 
        where assessment_form_details.forms_id = '.$id.' 
        order by assessment_form_details.id asc'); 

        return $data;
    }

    public function datatableAssessmentformDetail(Request $request)
    { 
        if($request->ajax()) {     
            // ===================QUERY-DATATABLE======================= //
                $data=$this->Query_Datatable_Detail($request->id);
            // ===================QUERY-DATATABLE======================= // 
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('buttonMg', function($row){    
                return '<input type="hidden" name="array['.$row->id.'][id]" value="'.$row->id.'"><button type="button" class="btn btn-icon waves-effect waves-light btn-danger delete-row" data-id="'.$row->id.'"> <i class="fas fa-times"></i> </button>';
            })  
            ->addColumn('name', function($row){    
                return '<input id="name" type="text" class="form-control" name="array['.$row->id.'][name]" value="'.$row->name.'" required="" autocomplete="name" autofocus="" placeholder="หัวข้อ">';
            })  
            ->addColumn('average', function($row){  
                if($row->type==1){
                    $average='<input id="average" type="number" class="form-control average" name="array['.$row->id.'][average]" value="'.$row->average.'" required="" autocomplete="average" autofocus="" placeholder="คะแนน">';
                } else if($row->type==2){
                    $average='<div class="text-area"> Text area </div>';
                }   
                return $average;
            }) 
            ->rawColumns(['buttonMg', 'name', 'average'])
            ->make(true);
        } 
    }

    public function closeAssessmentformDetail(Request $request)
    {
        if(isset($request)){
            $data=DB::table('assessment_form_details')
            ->where('assessment_form_details.id', $request->id)  
            ->delete();
        }  
        return $data;
    }
}
