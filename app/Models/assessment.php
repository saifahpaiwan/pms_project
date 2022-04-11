<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assessment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name', 
        'detail', 
        'users_id', 
        'employees_id', 
        'status', 
        'tems_status',
        'email',
        'send_mail', 
        'password', 
        'deleted_at',
    ];
}
