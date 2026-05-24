<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'slug',
    ];

    /**
     * One-to-Many Relationship: Post belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
