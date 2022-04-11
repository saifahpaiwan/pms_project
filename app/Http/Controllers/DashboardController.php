<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use App\Models\department;
use App\Models\sub_department;

class DashboardController extends Controller
{
    public function dashboard()
    {     
        $data=array(
            "count_employee"    => $this->count_employee(),
            "count_department"  => $this->count_department(),
        ); 
        return view('admin.dashboard', compact('data'));
    }  

    public function ajax_sub_departments(Request $request)
    {
        if(isset($request)){
            $data=sub_department::where('departments_id', $request->id)
            ->where('deleted_at', 0)
            ->get();
        } 
        return $data;
    }

    public function ajax_positions(Request $request)
    {
        if(isset($request)){
            $departments_sql="";
            if(!empty($request->departments_id)){
                $departments_sql=' and positions.departments_id = '.$request->departments_id;
            }

            $sub_departments_sql="";
            if(!empty($request->sub_id)){
                $sub_departments_sql=' and positions.sub_departments_id =  '.$request->sub_id;
            }

            $data = DB::select ('select * 
            from `positions`  
            where positions.deleted_at = 0 
            '.$departments_sql.'  '.$sub_departments_sql.'
            order by positions.id DESC');  
        } 
        return $data;
    }

    public function count_employee()
    {
        $data=DB::table('employees')       
        ->where('employees.deleted_at', '!=', 1)  
        ->count();  
        return $data;
    }

    public function count_department()
    {
        $data=DB::table('departments')       
        ->where('departments.deleted_at', '!=', 1)  
        ->count();  
        return $data;
    } 
}
