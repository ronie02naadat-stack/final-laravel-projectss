<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $table = 'maintenances';

    protected $fillable = [
        'is_active',
        'title',
        'message',
        'scheduled_start',
        'scheduled_end',
        'description',
        'status',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'scheduled_start' => 'datetime',
        'scheduled_end' => 'datetime',
    ];

    /**
     * Get the currently active maintenance record
     * Checks both is_active flag and scheduled_end date
     * Only shows maintenance in local environment
     */
    public static function getActive()
    {
        // Disable maintenance mode in production
        if (app()->environment('production')) {
            return null;
        }
        
        $maintenance = static::where('is_active', true)->first();
        
        // If maintenance exists but scheduled_end has passed, deactivate it
        if ($maintenance && $maintenance->scheduled_end && now() > $maintenance->scheduled_end) {
            $maintenance->deactivate();
            return null;
        }
        
        return $maintenance;
    }

    /**
     * Activate this maintenance record
     */
    public function activate()
    {
        $this->update([
            'is_active' => true,
            'status' => 'ongoing',
        ]);
        return $this;
    }

    /**
     * Deactivate this maintenance record
     */
    public function deactivate()
    {
        $this->update([
            'is_active' => false,
            'status' => 'completed',
        ]);
        return $this;
    }
}
