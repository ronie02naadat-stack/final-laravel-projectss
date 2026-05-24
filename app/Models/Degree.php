<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Degree extends Model
{
    protected $fillable = [
        'degree_title',
        'degree_code',
        'description',
    ];

    /**
     * Relationships
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Courses belonging to this degree
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Scopes - Query scopes for filtering
     */
    public function scopeSearchByTitle($query, $title)
    {
        return $query->where('degree_title', 'like', "%{$title}%");
    }

    /**
     * Boot method for model events
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($degree) {
            Log::info('Degree created in model', ['degree_id' => $degree->id, 'title' => $degree->degree_title]);
        });

        static::updated(function ($degree) {
            Log::info('Degree updated in model', ['degree_id' => $degree->id, 'title' => $degree->degree_title]);
        });

        static::deleted(function ($degree) {
            Log::info('Degree deleted in model', ['degree_id' => $degree->id, 'title' => $degree->degree_title]);
        });
    }
}
