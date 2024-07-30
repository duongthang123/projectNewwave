<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_code',
        'avatar',
        'phone',
        'address',
        'status',
        'gender',
        'birthday',
        'department_id',
    ];
}
