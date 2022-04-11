<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class roles_system extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 
        'name',
        'module', 
        'deleted_at',
    ];
}
