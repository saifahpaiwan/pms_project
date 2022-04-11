<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assessment_group extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'assessment_id',
        'employees_id',
        'level_id',
        'name',
        'detail',
        'status',
        'tems_status',
        'email',
        'send_mail',
        'password', 
        'deleted_at',
    ];
}
