<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'specialization',
        'experience_years',
        'office_location',
        'contact_number',
    ];

    /**
     * Relationship: Teacher belongs to a User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Teacher has many Courses
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    /**
     * Accessor: Get full name
     */
    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }
}
