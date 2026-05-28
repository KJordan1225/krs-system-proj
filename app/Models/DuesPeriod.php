<?php

namespace App\Models;

use App\Models\DuesPayment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DuesPeriod extends Model
{
    protected $fillable = [
        'name',
        'starts_on',
        'ends_on',
        'standard_amount',
        'late_fee_amount',
        'late_fee_after',
        'is_active',
    ];

    protected $casts = [
        'starts_on' => 'date',
        'ends_on' => 'date',
        'late_fee_after' => 'date',
        'standard_amount' => 'decimal:2',
        'late_fee_amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function payments(): HasMany
    {
        return $this->hasMany(DuesPayment::class);
    }
}
