<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'student_id',
        'bio',
        'avatar',
        'phone',
        'location',
    ];

    /**
     * One-to-One Relationship: Profile belongs to Student
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
