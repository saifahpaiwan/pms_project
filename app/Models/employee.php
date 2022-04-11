<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'departments_id',
        'sub_departments_id',
        'position_id',
        'branche_id',
        'level_id',
        'title_id',

        'employee_code',
        'name',
        'deleted_at',
    ];
}
