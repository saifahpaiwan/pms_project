<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Auth;
use Hash;

class ProfileController extends Controller
{
    public function profile()
    { 
        $data=array(
            "users_find" => Auth::user(),
        );   
        return view('admin.profile', compact('data'));
    }

    public function saveprofile(Request $request)
    { 
        $user=Auth::user();
        $userPassword=$user->password;  
        if($request->changepassCheck){ 
            $request->validate([
                'usersname' => ['required', 'string', 'max:255'], 
                'old_password' => ['required', 'string', 'min:8'], 
                'new_password' => ['required', 'string', 'min:8', 'same:passwordConfirm'],
                'passwordConfirm' => 'required'
            ]);
            
            if (!Hash::check($request->old_password, $userPassword)) {
                return back()->withErrors(['old_password'=>'รหัสผ่านไม่ตรงกัน !']); 
            }
            
            $data=array(
                'name'      => $request->usersname, 
                'password'  => Hash::make($request->new_password),
                'deleted_at'     => $request->status,

                'updated_at'  => new \DateTime(),  
            );  
        } else {
            $request->validate([
                'usersname' => ['required', 'string', 'max:255'],  
            ]);

            $data=array(
                'name'      => $request->usersname, 
                'deleted_at'     => $request->status,

                'updated_at'  => new \DateTime(),  
            );  
        }   
        DB::table('users')->where('users.id', $user->id)->update($data);  
        return redirect()->route('profile')->with('success', 'Update data successfully.');   
    }
}
 