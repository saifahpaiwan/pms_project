<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB; 
use Carbon\Carbon; 
use App\Models\User; 
use Mail; 
use Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showForgetPasswordForm()
    {
        return view('auth.forgetPassword');
    }

    public function email_temp()
    {
        return view('auth.email_temp');
    }
    

    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
          ]);

        Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        }); 
        return back()->with('success', 'เราได้ทำการส่งอีเมลลิงค์รีเซ็ตรหัสผ่านไปยังคุณแล้ว !');
    }

    public function showResetPasswordForm($token) { 
        return view('auth.forgetPasswordLink', ['token' => $token]);
    }

    public function submitResetPasswordForm(Request $request)
    {
    $request->validate([
        'email' => 'required|email|exists:users',
        'password' => 'required|string|min:6|confirmed',
        'password_confirmation' => 'required'
    ]);

    $updatePassword=DB::table('password_resets')
    ->where([
    'email' => $request->email, 
    'token' => $request->token
    ])->first();

    if(!$updatePassword){
        return back()->withInput()->with('error', 'รหัสโทเค็นไม่ถูกต้อง!');
    }

    $user=User::where('email', $request->email)
    ->update(['password' => Hash::make($request->password)]);
    DB::table('password_resets')->where(['email'=> $request->email])->delete();
    return redirect()->route('login')->with('success', 'รหัสผ่านของคุณถูกเปลี่ยนแล้ว กรุณาล็อกอินเพื่อเข้าสู่ระบบ !'); 
    }
}
