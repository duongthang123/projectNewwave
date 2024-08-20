<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($student) {
            if ($student->avatar) {
                Storage::delete('public/uploads/users/' . $student->avatar);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class)->withPivot('score')->withTimestamps();
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function getAvatarUrlAttribute()
    {
        $path = 'storage/uploads/users/';
        if($this->avatar) {
            return asset($path . $this->avatar);
        }
        return asset($path . 'default-user.jpg');
    }
}
