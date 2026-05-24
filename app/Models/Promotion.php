<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'discount_percentage',
        'start_date',
        'end_date',
        'is_active',
        'banner_color',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the active promotion
     */
    public static function getActive()
    {
        return static::where('is_active', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now())
                    ->first();
    }

    /**
     * Get days remaining until end date
     */
    public function daysRemaining()
    {
        return $this->end_date->diffInDays(now());
    }

    /**
     * Get hours remaining until end date
     */
    public function hoursRemaining()
    {
        return $this->end_date->diffInHours(now());
    }

    /**
     * Check if promotion is ending soon (less than 24 hours)
     */
    public function isEndingSoon()
    {
        return $this->hoursRemaining() < 24;
    }
}
