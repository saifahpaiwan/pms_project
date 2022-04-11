<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  

class is_permissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()){
            if(auth()->user()->deleted_at==0 && auth()->user()->permission_id!=0){
                $data=DB::table('users')->select('roles.roles_systems_id as roles_systems_id', 'roles_systems.module as module',
                'roles.view as view', 'roles.add as add', 'roles.edit as edit', 'roles.delete as delete', 'roles.export as export')
                ->leftJoin('permissions', 'users.permission_id', '=', 'permissions.id')
                ->leftJoin('roles', 'permissions.id', '=', 'roles.permission_id') 
                ->leftJoin('roles_systems', 'roles.roles_systems_id', '=', 'roles_systems.id') 
                ->where('users.id', auth()->user()->id)  
                ->get();  

                $request_path=$request->path();
                $explode_module=explode("-", $request_path);  
                
                if(isset($data)){
                    foreach($data as $row){  
                        if(in_array($row->module, $explode_module)){  
                            if(isset($explode_module[1])){   
                                session()->get('session_close');
                                session()->put('session_close', $row->delete);  
                                if($row->view=="N"){
                                    abort(403);
                                }  
                                if(strstr($explode_module[1], "add") && $row->add=="N"){
                                    abort(403);
                                }
                                if(strstr($explode_module[1], "edit") && $row->edit=="N"){
                                    abort(403);
                                }  
                                if(strstr($explode_module[1], "export") && $row->export=="N"){
                                    abort(403);
                                }
                            }
                            return $next($request);
                        }  
                    }
                }  
            } 
        }  
    }
}
