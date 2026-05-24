<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course_name',
        'description',
        'code',
        'teacher_id',
        'degree_id',
    ];

    /**
     * Belongs to Teacher (User)
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Belongs to Degree
     */
    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    /**
     * Many-to-Many Relationship: Course belongs to many Students
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_student', 'course_id', 'student_id');
    }
}
