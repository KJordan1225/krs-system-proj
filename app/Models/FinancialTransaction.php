<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialTransaction extends Model
{
    protected $fillable = [
        'type',
        'category',
        'title',
        'description',
        'amount',
        'transaction_date',
        'payment_method',
        'reference_number',
        'status',
        'recorded_by',
        'finalized_at',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'finalized_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function getIsFinalizedAttribute(): bool
    {
        return $this->status === 'finalized';
    }
}
