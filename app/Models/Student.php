<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Student extends Model
{
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'address',
        'contact_number',
        'degree_id',
        'user_account_id'
    ];

    /**
     * Relationships
     */
    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    /**
     * One-to-One Relationship: Student has one Profile
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Many-to-Many Relationship: Student belongs to many Courses
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id');
    }

    /**
     * Relationship: Student belongs to a User (via user_account_id)
     * This retrieves the User record that matches this student's user_account_id
     */
    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            UserAccount::class,
            'id',              // Foreign key on user_accounts table
            'user_account_id', // Foreign key on users table
            'user_account_id', // Local key on students table
            'id'               // Local key on user_accounts table
        );
    }

    /**
     * Accessors - Get full name
     */
    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }

    /**
     * Scopes - Query scopes for filtering
     */
    public function scopeByDegree($query, $degreeId)
    {
        return $query->where('degree_id', $degreeId);
    }

    public function scopeSearchByEmail($query, $email)
    {
        return $query->where('email', 'like', "%{$email}%");
    }

    public function scopeSearchByName($query, $name)
    {
        return $query->where('first_name', 'like', "%{$name}%")
                    ->orWhere('last_name', 'like', "%{$name}%");
    }

    /**
     * Boot method for model events
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($student) {
            Log::info('Student created in model', ['student_id' => $student->id, 'email' => $student->email]);
        });

        static::updated(function ($student) {
            Log::info('Student updated in model', ['student_id' => $student->id, 'email' => $student->email]);
        });

        static::deleted(function ($student) {
            Log::info('Student deleted in model', ['student_id' => $student->id, 'email' => $student->email]);
        });
    }

    public function userAccount()
    {
        return $this->belongsTo(UserAccount::class, 'user_account_id');
    }
}
