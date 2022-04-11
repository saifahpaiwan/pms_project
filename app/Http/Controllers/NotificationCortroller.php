<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;   
use App\Models\notification; 

class NotificationCortroller extends Controller
{
    public function saveNotification($users_id, $message, $message_type, $route)
    {
        if(isset($users_id)){ 
            $data=array(
                'users_id'  => $users_id, 
                'message'   => $message, 
                'message_type'  => $message_type, 
                'route'         => $route, 
                'status'        => 0,  
 
                'created_at'    => new \DateTime(),  
            ); 
            return DB::table('notifications')->insert($data);
        } 
    }

    public function ajaxNotifyview(Request $request)
    {
        $route=null;
        if(isset($request)){
            $data=array('status' => 1, 'updated_at' => new \DateTime());
            DB::table('notifications')
            ->where('notifications.id', $request->id)
            ->update($data);  
            $data=notification::find($request->id);
            $route=url($data->route);
        }
        return $route;
    }
}
