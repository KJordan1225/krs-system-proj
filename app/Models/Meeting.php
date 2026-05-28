<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meeting extends Model
{
    protected $fillable = [
        'title',
        'meeting_type',
        'scheduled_at',
        'location',
        'agenda',
        'minutes',
        'motions',
        'voting_outcome',
        'is_recurring',
        'recurrence_pattern',
        'status',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'is_recurring' => 'boolean',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(MeetingTask::class);
    }

    public function attendances()
    {
        return $this->hasMany(\App\Models\MeetingAttendance::class);
    }
}
