<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 
        'permission_id',
        'roles_systems_id',
        "view"  ,  
        "add"   , 
        "edit"  , 
        "delete", 
        "export", 
        'deleted_at',
    ];
}
