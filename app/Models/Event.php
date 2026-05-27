<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'category',
        'event_type',
        'description',
        'agenda',
        'location',
        'virtual_link',
        'starts_at',
        'ends_at',
        'is_multi_day',
        'is_recurring',
        'visibility',
        'status',
        'host_committee',
        'assigned_officer',
        'capacity',
        'registration_fee',
        'budget',
        'expenses',
        'revenue',
        'donations',
        'speaker',
        'sponsor',
        'vendor',
        'notes',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_multi_day' => 'boolean',
        'is_recurring' => 'boolean',
        'registration_fee' => 'decimal:2',
        'budget' => 'decimal:2',
        'expenses' => 'decimal:2',
        'revenue' => 'decimal:2',
        'donations' => 'decimal:2',
    ];
}
