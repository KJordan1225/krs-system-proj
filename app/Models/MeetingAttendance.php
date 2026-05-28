<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeetingAttendance extends Model
{
    protected $fillable = [
        'meeting_id',
        'member_id',
        'status',
        'checked_in_at',
        'is_excused',
        'notes',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
        'is_excused' => 'boolean',
    ];

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
