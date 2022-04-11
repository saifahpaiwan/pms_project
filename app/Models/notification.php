<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'users_id',
        'message', 
        'message_type',
        'route',
        'status',
        'deleted_at',
    ];
}
