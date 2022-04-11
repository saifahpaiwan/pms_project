<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sub_department extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'departments_id', 
        'name',
        'deleted_at',
    ];
}
