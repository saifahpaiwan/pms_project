<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class social_login extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'employees_id',
        'social_token',
        'picture_url',
        'username',
        'email',
        'social', 
        'deleted_at',
    ];
}
