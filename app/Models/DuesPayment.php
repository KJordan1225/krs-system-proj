<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DuesPayment extends Model
{
    protected $fillable = [
        'dues_period_id',
        'member_name',
        'member_email',
        'amount_due',
        'late_fee',
        'amount_paid',
        'paid_on',
        'payment_method',
        'reference_number',
        'notes',
    ];

    protected $casts = [
        'amount_due' => 'decimal:2',
        'late_fee' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'paid_on' => 'date',
    ];

    public function period(): BelongsTo
    {
        return $this->belongsTo(DuesPeriod::class, 'dues_period_id');
    }

    public function totalDue(): float
    {
        return (float) $this->amount_due + (float) $this->late_fee;
    }

    public function balance(): float
    {
        return max($this->totalDue() - (float) $this->amount_paid, 0);
    }

    public function status(): string
    {
        if ((float) $this->amount_paid >= $this->totalDue()) {
            return 'Paid';
        }

        if ((float) $this->amount_paid > 0) {
            return 'Partial';
        }

        return 'Outstanding';
    }
}
