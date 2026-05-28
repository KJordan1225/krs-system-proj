<?php

namespace App\Services;

use App\Models\DuesPayment;
use App\Models\DuesPeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DuesPaymentService
{
    public function create(array $data): DuesPayment
    {
        return DB::transaction(function () use ($data) {
            $period = DuesPeriod::findOrFail($data['dues_period_id']);

            $this->preventDuplicatePayment($data);

            $lateFee = $this->calculateLateFee($period, $data['paid_on'] ?? null);

            return DuesPayment::create([
                ...$data,
                'amount_due' => $data['amount_due'] ?? $period->standard_amount,
                'late_fee' => $lateFee,
            ]);
        });
    }

    public function update(DuesPayment $payment, array $data): DuesPayment
    {
        return DB::transaction(function () use ($payment, $data) {
            $period = DuesPeriod::findOrFail($data['dues_period_id']);

            $lateFee = $this->calculateLateFee($period, $data['paid_on'] ?? null);

            $payment->update([
                ...$data,
                'amount_due' => $data['amount_due'] ?? $period->standard_amount,
                'late_fee' => $lateFee,
            ]);

            return $payment;
        });
    }

    private function preventDuplicatePayment(array $data): void
    {
        if (empty($data['reference_number'])) {
            return;
        }

        $exists = DuesPayment::where('dues_period_id', $data['dues_period_id'])
            ->where('member_email', $data['member_email'] ?? null)
            ->where('reference_number', $data['reference_number'])
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'reference_number' => 'Duplicate payment reference found for this member and dues period.',
            ]);
        }
    }

    private function calculateLateFee(DuesPeriod $period, ?string $paidOn): float
    {
        if (! $period->late_fee_after || ! $paidOn) {
            return 0;
        }

        return $paidOn > $period->late_fee_after->format('Y-m-d')
            ? (float) $period->late_fee_amount
            : 0;
    }
}
