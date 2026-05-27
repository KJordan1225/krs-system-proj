<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'membership_status',
        'officer_position',
        'committee',
        'role_tracking',
        'joined_at',
        'membership_history',
        'notes',
    ];

    protected $casts = [
        'joined_at' => 'date',
    ];

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
