<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;  
use Illuminate\Http\Request; 
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\permission;
use App\Http\Controllers\NotificationCortroller;

class AuthenticationController extends Controller
{ 

    public function index()
    {
        return view('auth.login');
    }  

    public function register()
    { 
        $Qry=permission::whereNotIn('level', [1,2])->get();  
        $data=array(
            "Query_permission" => $Qry,
        );   
        return view('auth.register', compact('data'));
    }   

    public function logincheck(Request $request)
    { 
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if(auth()->user()->permission_id==0){
                return redirect()->route('login')->with('error', 'โปรดรอเจ้าหน้าที่ตรวจสอบข้อมูลการลงทะเบียนสักครู่ !');
            } else {
                return redirect()->intended('dashboard')->withSuccess('ยินดีต้อนรับเข้าสู่ระบบ By Farm chokchai.'); 
            } 
        } 
        return redirect()->route('login')->with('error', 'รายละเอียดการล็อกอินไม่ถูกต้อง โปรดลองใหม่อีกครั้ง !');
    }

    public function signOut() {
        Session::flush();
        Auth::logout(); 
        return redirect()->route('login');
    }

    public function registration(Request $request)
    {  
        $request->validate([
            'usersname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],  
            'permission' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => 'required'
        ]);
             
        $data=array(
            'name'           => $request->usersname, 
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'permission_id'  => $request->permission,
            
            'deleted_at'     => 3, 
            'created_at'     => new \DateTime(),  
        );
        $users_id=DB::table('users')->insertGetId($data); 

        if(!empty($users_id)){
            $NotificationCortroller=new NotificationCortroller; 
            $message="มีผู้ขอลงทะเบียนขอเข้าใช้งานระบบ name : ".$request->usersname;
            $message_type="1";
            $route="request-access";
            $NotificationCortroller->saveNotification($users_id, $message, $message_type, $route);
        } 

        return redirect()->route('register')->with('success', 'ลงทะเบียนสำเร็จเรียบร้อย โปรดรอเจ้าหน้าที่ตรวจสอบสักครู่...');
    } 
}
