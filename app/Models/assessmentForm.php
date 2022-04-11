<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assessmentForm extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title',
        'sub_title',
        'sum_average', 
        'deleted_at',
    ];
}
