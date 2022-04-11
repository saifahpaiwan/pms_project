<?php

namespace App\Http\Controllers\assessment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;  

use App\Models\employee;
use App\Models\assessmentForm;
use App\Models\assessment_group;
use App\Models\assessment; 

class ManageassessedCortroller extends Controller
{

    
    public function assessmentlist()
    {
        $data=array(
            "Query_employee" => employee::all()->where('deleted_at', 0), 
            "Query_assessmentForms" => assessmentForm::all()->where('deleted_at', 0), 
        ); 
        return view('admin.assessment.mgassess_list', compact('data'));
    }

    public function assessmentadd()
    {
        $data=array(
            "Query_employee" => employee::all()->where('deleted_at', 0), 
            "Query_assessmentForms" => assessmentForm::all()->where('deleted_at', 0), 
        ); 
        return view('admin.assessment.mgassess_add', compact('data'));
    }

    public function assessmentedit($get_id)
    {
        $data=array(
            "assessment_find"  => assessment::find($get_id), 
            "Query_employee" => employee::all()->where('deleted_at', 0), 
            "Query_assessmentForms" => assessmentForm::all()->where('deleted_at', 0), 
        );  
        return view('admin.assessment.mgassess_edit', compact('data'));
    } 

    public function assessmentgroupview($get_id)
    {
        $first=DB::table('assessments')
        ->select('assessments.*', 'employees.id as employees_id', 'employees.name as employees_name', 'assessments.users_id as users_id', 'levels.name as levels_name',
        'assessments.status as assessments_status')  
        ->leftJoin('employees', 'assessments.employees_id', '=', 'employees.id')
        ->leftJoin('levels', 'assessments.level_id', '=', 'levels.number')
        ->where('assessments.deleted_at', 0)
        ->where('assessments.id', $get_id)->where('assessments.tems_status', 'N')->first(); 
        $data=array(
            "assessmentGroup_first" => $first, 
        );  
        return view('admin.assessment.mgassess_group_view', compact('data'));
    } 

    public function assessmentempview($id1, $id2)
    {
        $data=array(); 
        return view('admin.assessment.mgassess_emp_view', compact('data'));
    } 
    
    public function saveAssessmentTems(Request $request)
    { 
        if(isset($request)){
            if($request->l1_tems_id==0){ 
                $dataType="created_at";
                $tems_status="Y";
            }else{ 
                $dataType="updated_at";
                $tems_status="N";
            }
             
            $data=array(
                "level_id"      => 2,
                "name"          => $request->l1_name,
                "detail"        => $request->l1_detail,
                "users_id"      => Auth::user()->id,
                "employees_id"  => $request->l1_employees_id, 
                "email"         => $request->l1_email,
                "tems_status"   => $tems_status, 
                "password"      => $request->l1_password,

                $dataType => new \DateTime(),  
            ); 
            if($request->l1_tems_id==0){
                $Getid=DB::table('assessments')->insertGetId($data);  
            } else {
                $Getid=$request->l1_tems_id;
                DB::table('assessments')
                ->where('assessments.id', $request->l1_tems_id)
                ->update($data);   
            } 
        }   
        return $Getid;
    }

    public function saveAssessmentGroupTems(Request $request)
    { 
        if(isset($request)){
            if(isset($request->arrayGroup)){
                if(count($request->arrayGroup)>0){ 
                    foreach($request->arrayGroup as $row){
                        if($row['id']==0){
                            $dataType="created_at";
                            $tems_status="Y";
                        }else{
                            $dataType="updated_at";
                            $tems_status="N";
                        }
                        $data=array(
                            "assessment_id" => $request->l1_tems_id,
                            "level_id"      => 3,
                            "name"          => $row['name'],
                            "detail"        => $row['detail'],
                            "employees_id"  => $row['employees'], 
                            "email"         => $row['email'], 
                            "tems_status"   => $tems_status, 
                            
                            "password"      => $row['password'], 
                            $dataType => new \DateTime(),
                        );
                        if($row['id']==0){
                            $Getid=DB::table('assessment_groups')->insertGetId($data);  
                        } else {
                            $Getid=$row['id'];
                            DB::table('assessment_groups')
                            ->where('assessment_groups.id', $row['id'])
                            ->update($data);   
                        } 
                    }
                }
            }
        }    
        return $Getid;
    }

    public function saveAssessment(Request $request)
    { 
        if(isset($request)){ 
            if(isset($request->arrayEmp)){
                if(count($request->arrayEmp)){
                    foreach($request->arrayEmp as $row){
                        if($row['id']==0){ 
                            $dataType="created_at";
                        }else{ 
                            $dataType="updated_at";
                        }
                        $data=array(
                            "assessment_id"         => $request->l1_tems_id,
                            "assessment_group_id"   => $row['assessment_groups'],
                            "assessment_from_id"    => $row['assessment_from'],
                            "level_id"              => 4,
                            "employees_id"          => $row['employees'],
                            "note"                  => $row['note'],
                            
                            $dataType               => new \DateTime(),
                        );
                        if($row['id']==0){
                            $Getid=DB::table('assessment_emps')->insertGetId($data);  
                            DB::table('assessments')->where('assessments.id', $request->l1_tems_id)->update(array("tems_status" => "N"));   
                            DB::table('assessment_groups')->where('assessment_groups.assessment_id', $request->l1_tems_id)->update(array("tems_status" => "N"));   
                        } else {
                            $Getid=$row['id'];
                            DB::table('assessment_emps')
                            ->where('assessment_emps.id', $row['id'])
                            ->update($data);   
                            DB::table('assessments')->where('assessments.id', $request->l1_tems_id)->update(array("tems_status" => "N"));   
                            DB::table('assessment_groups')->where('assessment_groups.assessment_id', $request->l1_tems_id)->update(array("tems_status" => "N"));
                        } 
                    }
                }
            } 
        }
        $msg="จัดการรูปแบบการประเมินสำเร็จ Save data successfully.";
        return redirect()->route('assessment.add')->with('success', $msg);  
    }

    public function ajaxassessmentGroups(Request $request)
    {
        if(isset($request)){  
            $data=DB::table('assessment_groups')
            ->where('assessment_groups.assessment_id', $request->id)  
            ->where('assessment_groups.deleted_at', 0)->get();
            return $data;
        }
    }
    
    // ========================DATATABLE assessments========================== //
    public function Query_Datatable_Assessments($keywrod, $status, $employees_id, $date)
    {    
        $keywrod_sql=""; $status_sql=""; $employees_id_sql=""; $date_sql="";
        if(isset($keywrod)){
            $keywrod_sql=" and assessments.name LIKE '%".$keywrod."%'"; 
        }

        if(isset($status)){  
            $status_sql=" and assessments.status = ".$status.""; 
        }

        if(isset($employees_id)){  
            $employees_id_sql=" and assessments.employees_id = ".$employees_id.""; 
        }

        if(isset($date)){  
            $date_sql=" and assessments.created_at BETWEEN '".$date." 00:00:00' AND '".$date." 23:59:59'"; 
        }
 
        $data = DB::select('select assessments.id as id, assessments.name as name, 
        employees.name as employees_name, assessments.status as status, assessments.created_at as created_at

        from `assessments`  
        LEFT JOIN employees ON assessments.employees_id = employees.id 
        where assessments.tems_status = "N"
        '.$keywrod_sql.' '.$status_sql.' '.$employees_id_sql.' '.$date_sql.'
        order by assessments.id DESC'); 

        return $data;
    }
 
    public function datatableAssessment(Request $request)
    { 
        if($request->ajax()) {     
            // ===================QUERY-DATATABLE======================= // 
                $data=$this->Query_Datatable_Assessments($request->keywrod, $request->status, $request->employees_id, $request->date); 
            // ===================QUERY-DATATABLE======================= // 
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('id', function($row){    
                return $row->id;
            }) 
            ->addColumn('name', function($row){    
                return '<a href="'.route('assessment.group.view', [$row->id]).'">'.$row->name.'</a>';
            }) 
            ->addColumn('employees', function($row){    
                return $row->employees_name;
            }) 
            ->addColumn('created_at', function($row){    
                return date("m/d/Y", strtotime($row->created_at));
            }) 
            ->addColumn('status', function($row){   
                $status='';
                if($row->status==1){
                    $status='<span class="badge badge-warning"> รอการประเมินผล </span>';
                } else  if($row->status==2){
                    $status='<span class="badge badge-warning"> รอการตรวจสอบ </span>';
                } else  if($row->status==3){
                    $status='<span class="badge badge-success"> การประเมินผลสำเร็จ </span>';
                } else  if($row->status==4){
                    $status='<span class="badge badge-secondary"> ส่งกลับแก้ไข </span>';
                }
                return $status;
            })
            ->addColumn('buttonMg', function($row){   
                $button="";  
                $button.='<a href="'.route('assessment.group.view', [$row->id]).'" class="btn btn-dark waves-effect waves-light btn-sm ml-1"><i class="fe-search"></i> ดูผลการประเมิน</a>'; 
                $button.='<a href="'.route('assessment.edit', [$row->id]).'" class="btn btn-dark waves-effect waves-light btn-sm ml-1"><i class="fe-edit"></i> แก้ไข </a>'; 
                return $button;
            }) 
            ->rawColumns(['id', 'name', 'employees', 'created_at', 'status', 'buttonMg'])
            ->make(true);
        }  
    }

    // ========================DATATABLE GROUP========================== //
    public function Query_Datatable_Group($id)
    {    
        $data = DB::select('select assessment_groups.assessment_id as id, assessment_groups.id as group_id, assessment_groups.name as name,
        assessment_groups.detail as detail, assessment_groups.password as password, 
        employees.name as employees_name, employees.id as employees_id, assessment_groups.status as status, assessment_groups.send_mail as send_mail,
        assessments.users_id as users_id

        from `assessment_groups` 

        LEFT JOIN employees ON assessment_groups.employees_id = employees.id
        LEFT JOIN assessments ON assessment_groups.assessment_id = assessments.id
        where assessment_groups.assessment_id = '.$id.' 
        order by assessment_groups.id asc'); 

        return $data;
    }
 
    public function datatableAssessmentgroup(Request $request)
    { 
        if($request->ajax()) {     
            // ===================QUERY-DATATABLE======================= //
                $data=$this->Query_Datatable_Group($request->id);
            // ===================QUERY-DATATABLE======================= // 
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('id', function($row){    
                return $row->group_id;
            }) 
            ->addColumn('name', function($row){    
                return $row->name;
            }) 
            ->addColumn('employees', function($row){    
                return $row->employees_name;
            })  
            ->addColumn('status', function($row){   
                $status='';
                if($row->status==1){
                    $status='<span class="badge badge-warning"> รอการประเมินผล </span>';
                } else  if($row->status==2){
                    $status='<span class="badge badge-success"> การประเมินผลสำเร็จ </span>';
                } else  if($row->status==3){
                    $status='<span class="badge badge-secondary"> ส่งกลับแก้ไข </span>';
                }
                return $status;
            })
            ->addColumn('buttonMg', function($row){    
                $button="";  
                $button.='<a href="'.route('assessment.emp.view', [$row->id, $row->group_id]).'" class="btn btn-dark waves-effect waves-light btn-sm ml-1"><i class="fe-search"></i> ดูผลประเมินกลุ่ม</a>';
                if($row->users_id==Auth::user()->id){
                    $send_mail='<i class="fe-mail"></i> ส่ง email';
                    if($row->send_mail=="Y"){
                        $send_mail='<i class="fe-mail"></i> ส่ง email อีกครั้ง';
                    }
                    $button.='<button type="button" class="btn btn-googleplus waves-effect waves-light btn-sm ml-1" style="min-width: 126.25px;" id="email" data-type="G" data-userid="'.$row->group_id.'">'.$send_mail.'</button>';
                }
                return $button;
            }) 
            ->rawColumns(['id', 'name', 'employees', 'status', 'buttonMg'])
            ->make(true);
        }  
    }

    public function datatableAssessmentgroupEdit(Request $request)
    { 
        if($request->ajax()) {     
            // ===================QUERY-DATATABLE======================= //
                $data=$this->Query_Datatable_Group($request->id);
            // ===================QUERY-DATATABLE======================= //  
             
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('buttonMg', function($row){  
                $buttonMg='<button type="button" class="btn btn-icon waves-effect waves-light btn-danger delete-row" data-id="'.$row->group_id.'"> <i class="fas fa-times"></i> </button>';
                $buttonMg.='<input type="hidden" class="l_group" name="arrayGroup['.$row->group_id.'][id]" value="'.$row->group_id.'">';
                $buttonMg.='<input type="hidden" name="arrayGroup['.$row->group_id.'][name]" value="'.$row->name.'">';
                $buttonMg.='<input type="hidden" name="arrayGroup['.$row->group_id.'][detail]" value="'.$row->detail.'">';
                $buttonMg.='<input type="hidden" name="arrayGroup['.$row->group_id.'][employees]" value="'.$row->employees_id.'">';
                $buttonMg.='<input type="hidden" name="arrayGroup['.$row->group_id.'][email]" value="'.$row->send_mail.'">';
                $buttonMg.='<input type="hidden" name="arrayGroup['.$row->group_id.'][password]" value="'.$row->password.'">';   
                return $buttonMg;
            })  
            ->addColumn('name', function($row){  
                return $row->name;
            })
            ->addColumn('employees', function($row){  
                return $row->employees_name;
            })
            ->rawColumns(['buttonMg', 'name', 'employees'])
            ->make(true);
        }  
    } 

    // ========================DATATABLE Emp========================== //
    public function Query_Datatable_Emp($id1, $id2)
    {    
        $group_id="";
        if(isset($id2)){
            $group_id=" and assessment_emps.assessment_group_id = ".$id2;
        }
        
        $data = DB::select('select assessment_emps.id as id, assessment_emps.note as note, 
        employees.name as employees_name, employees.employee_code as employee_code, assessment_emps.status as status,
        departments.name as departments_name, sub_departments.name as sub_departments_name, 
        positions.name as positions_name,  titles.name as titles_name, branches.name as branches_name,

        assessment_emps.assessment_from_id as assessment_from_id, assessment_emps.employees_id as employees_id, 
        assessment_emps.assessment_group_id as group_id, assessment_forms.title as assessment_forms_name

        from `assessment_emps` 

        LEFT JOIN employees ON assessment_emps.employees_id = employees.id
        LEFT JOIN departments ON employees.departments_id = departments.id
        LEFT JOIN sub_departments ON employees.sub_departments_id = sub_departments.id
        LEFT JOIN positions ON employees.position_id = positions.id
        LEFT JOIN titles ON employees.title_id = titles.id
        LEFT JOIN branches ON employees.branche_id = branches.id
        LEFT JOIN assessment_forms ON assessment_emps.assessment_from_id = assessment_forms.id

        where assessment_emps.assessment_id = '.$id1.'  
        '.$group_id.'
        order by assessment_emps.id asc'); 

        return $data;
    }
 
    public function datatableAssessmentemp(Request $request)
    { 
        if($request->ajax()) {     
            // ===================QUERY-DATATABLE======================= //
                $data=$this->Query_Datatable_Emp($request->id1, $request->id2);
            // ===================QUERY-DATATABLE======================= // 
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('employee_code', function($row){    
                return $row->employee_code;
            }) 
            ->addColumn('employees_name', function($row){    
                return '<a href="javascript: void(0);" id="bnt-assessment-forms" data-empid="'.$row->employees_id.'" data-fromid="'.$row->assessment_from_id.'">'.$row->titles_name." ".$row->employees_name.' <i class="fe-edit-1"></i></a>';
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
            ->addColumn('branches_name', function($row){    
                return $row->branches_name;
            }) 
            ->addColumn('status', function($row){   
                $status='';
                if($row->status==1){
                    $status='<span class="badge badge-warning"> รอการประเมินผล </span>';
                } else  if($row->status==2){
                    $status='<span class="badge badge-success"> การประเมินผลสำเร็จ </span>';
                } else  if($row->status==3){
                    $status='<span class="badge badge-secondary"> ส่งกลับแก้ไข </span>';
                }
                return $status;
            })
            ->addColumn('buttonMg', function($row){   
                $button="";
                $button.='<button type="button" class="btn btn-primary waves-effect waves-light btn-sm" id="bnt-assessment-forms" data-id="'.$row->id.'"><i class="fe-edit-1"></i> การประเมิน </button>'; 
                return $button;
            }) 
            ->rawColumns(['employee_code', 'employees_name', 'departments_name', 'sub_departments_name', 'positions_name', 'branches_name', 'status', 'buttonMg'])
            ->make(true);
        }  
    }

    public function datatableAssessmentempEdit(Request $request)
    { 
        if($request->ajax()) {     
            // ===================QUERY-DATATABLE======================= //
                $data=$this->Query_Datatable_Emp($request->id1, $request->id2);
            // ===================QUERY-DATATABLE======================= // 
             
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('buttonMg', function($row){    
                $buttonMg='<button type="button" class="btn btn-icon waves-effect waves-light btn-danger delete-row-emp" data-id="'.$row->id.'"> <i class="fas fa-times"></i> </button>';
                $buttonMg.='<input type="hidden" class="l_emp" name="arrayEmp['.$row->id.'][id]" value="'.$row->id.'">';
                $buttonMg.='<input type="hidden" name="arrayEmp['.$row->id.'][note]" value="'.$row->note.'">'; 
                $buttonMg.='<input type="hidden" name="arrayEmp['.$row->id.'][employees]" value="'.$row->employees_id.'">'; 
                $buttonMg.='<input type="hidden" name="arrayEmp['.$row->id.'][assessment_from]" value="'.$row->assessment_from_id.'">'; 
                $buttonMg.='<input type="hidden" name="arrayEmp['.$row->id.'][assessment_groups]" value="'.$row->group_id.'">'; 
                return $buttonMg;
            }) 
            ->addColumn('employees', function($row){    
                return $row->employees_name;
            }) 
            ->addColumn('assessment_from', function($row){    
                return $row->assessment_forms_name;
            }) 
             
            ->rawColumns(['buttonMg', 'employees', 'assessment_from'])
            ->make(true);
        }  
    } 

    public function ajaxAssessmentForms(Request $request)
    {
        if(isset($request)){   
            $employee=DB::table('employees')->where('id', intval($request->emp_id))->first(); 
            $Query_forms=DB::table('assessment_forms')
            ->select('assessment_forms.id as id', 'assessment_forms.title as title', 'assessment_forms.sub_title as sub_title', 'assessment_forms.sum_average as sum_average',
            'assessment_form_details.id as question_id', 'assessment_form_details.name as question_name', 'assessment_form_details.average as question_average', 'assessment_form_details.type as question_type')  
            ->leftJoin('assessment_form_details', 'assessment_forms.id', '=', 'assessment_form_details.forms_id') 
            ->where('assessment_forms.deleted_at', 0)
            ->where('assessment_form_details.deleted_at', 0)
            ->where('assessment_forms.id', $request->from_id) 
            ->get(); 

            $items=[];
            if(count($Query_forms)>0){
                foreach($Query_forms as $row){
                    $items[$row->id]['id'] =  $row->id;
                    $items[$row->id]['title'] =  $row->title;
                    $items[$row->id]['sub_title'] =  $row->sub_title;
                    $items[$row->id]['sum_average'] =  $row->sum_average; 
                    $items[$row->id]['question'][$row->question_id]['id'] =  $row->question_id;
                    $items[$row->id]['question'][$row->question_id]['name'] =  $row->question_name;
                    $items[$row->id]['question'][$row->question_id]['type'] =  $row->question_type;
                    $items[$row->id]['question'][$row->question_id]['average'] =  $row->question_average;
                }
            } 
             
            $html="";
            if(count($items)>0){
                foreach($items as $row1){
                    $html.='<div class="modal-header bg-primary" style="border-bottom: 0;border-radius: 0;">';
                    $html.='    <div class="modal-title" id="myModalLabel">';
                    $html.='    <div style="color: #fff; font-weight: 500;">แบบฟอร์มการประเมิน : '.$row1['title'].'</div>';
                    $html.='    <div style="color: #fff; font-weight: 300;font-size: 11px;">'.$row1['sub_title'].'</div>';
                    $html.='    <div style="color: #fff; font-weight: 300;font-size: 11px;"> ผู้ถูกประเมิน : '.$employee->name.' </div>';
                    $html.='    </div>';
                    $html.='</div>';
                    $html.='<div class="modal-body">';
                    $index=1;
                    foreach($row1['question'] as $row2){
                        if($row2['type']==1){
                            $html.='<div class="row mb-3" style="border-bottom: 2px solid #177ccc; padding-bottom: 0.25rem;">';
                            $html.='    <div class="col-md-10">';
                            $html.='        <div class="box-question">';
                            $html.='            <span class="box-verse"> '.$index.' </span>';
                            $html.='            '.$row2['name'];
                            $html.='        </div>';
                            $html.='    </div>';
                            $html.='   <div class="col-md-2 pl-0">';
                            $html.='        <div class="box-answer">';
                            $html.='            <input type="number" id="score" name="score" class="form-control" required>';
                            $html.='            <div class="text-center mt-1"> ให้คะแนน </div>';
                            $html.='        </div>';
                            $html.='    </div>';
                            $html.='</div>';
                        } else if($row2['type']==2){
                            $html.='<div class="row mb-3" style="border-bottom: 2px solid #177ccc; padding-bottom: 0.25rem;">';
                            $html.='    <div class="col-md-12">';
                            $html.='        <div class="box-question">';
                            $html.='            <span class="box-verse"> '.$index.' </span>';
                            $html.='            '.$row2['name'];
                            $html.='        </div>';
                            $html.='    </div>';
                            $html.='    <div class="col-md-12">';
                            $html.='        <div class="box-answer pt-2 pb-2">';
                            $html.='            <textarea class="form-control" rows="3" id="note" id="note"></textarea>'; 
                            $html.='        </div>';
                            $html.='    </div>';
                            $html.='</div>'; 
                        }
                        $index++;
                    }
                    $html.='</div>';
                }
            }
            $html.='<div class="modal-footer">';
            $html.='    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">ยกเลิก</button>';
            $html.='    <button type="button" class="btn btn-primary waves-effect waves-light"> ยืนยันการประเมินผล </button>';
            $html.='</div>';

            $data=array( 
                "html_from" => $html,
            ); 
            return $data;
        }
    }

    public function closeAsssessmentgroup(Request $request)
    { 
        if(isset($request)){
            DB::table('assessment_groups')
            ->where('assessment_groups.assessment_id', $request->assessment_id)  
            ->where('assessment_groups.id', $request->id)  
            ->delete();

            DB::table('assessment_emps')
            ->where('assessment_emps.assessment_id', $request->assessment_id)  
            ->where('assessment_emps.assessment_group_id', $request->id)  
            ->delete();
        }

        return true;
    }

    public function closeAsssessmentemp(Request $request)
    { 
        if(isset($request)){ 
            DB::table('assessment_emps')
            ->where('assessment_emps.assessment_id', $request->assessment_id)  
            ->where('assessment_emps.id', $request->id)  
            ->delete();
        }

        return true;
    }

    public function closeAsssessment(Request $request)
    { 
        if(isset($request)){ 
            DB::table('assessment_groups')
            ->where('assessment_groups.assessment_id', $request->id)  
            ->delete();

            DB::table('assessment_emps')
            ->where('assessment_emps.assessment_id', $request->id)   
            ->delete();

            DB::table('assessments')
            ->where('assessments.id', $request->id)  
            ->delete();
        }

        return true;
    } 

    public function changestatusAssessment(Request $request)
    { 
        if(isset($request) && in_array($request->status, [1,2])){ 
            if($request->status==1){
                $status=2;
            } else if($request->status==2){
                $status=3;       
            }
            return DB::table('assessments')->where('assessments.id', $request->id)->update(array("status" => $status));   
        }  
    } 

    public function emailAssessment(Request $request)
    {  
        if(isset($request)){
            if($request->type=="M"){
                return DB::table('assessments')->where('assessments.employees_id', $request->employees_id)->where('assessments.id', $request->id)->update(array("send_mail" => "Y"));   
            } else if($request->type=="G"){  
                return DB::table('assessment_groups')->where('assessment_groups.id', $request->employees_id)->update(array("send_mail" => "Y"));      
            } 
        } 
    }
}
