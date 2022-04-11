<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assessmentFormDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'average',
        'type', 
        'deleted_at',
    ];
}
