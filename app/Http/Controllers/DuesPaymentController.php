<?php

namespace App\Http\Controllers;

use App\Models\DuesPayment;
use App\Models\DuesPeriod;
use App\Services\DuesPaymentService;
use Illuminate\Http\Request;

class DuesPaymentController extends Controller
{
    public function index()
    {
        $payments = DuesPayment::with('period')
            ->latest()
            ->paginate(10);

        $allPayments = DuesPayment::all();

        $summary = [
            'total_revenue' => $allPayments->sum('amount_paid'),
            'outstanding_balance' => $allPayments->sum(fn ($payment) => $payment->balance()),
            'paid_members' => $allPayments->filter(fn ($payment) => $payment->status() === 'Paid')->count(),
            'delinquent_members' => $allPayments->filter(fn ($payment) => $payment->status() === 'Outstanding')->count(),
        ];

        return view('dues.index', compact('payments', 'summary'));
    }

    public function create()
    {
        $periods = DuesPeriod::where('is_active', true)->orderBy('name')->get();

        return view('dues.create', compact('periods'));
    }

    public function store(Request $request, DuesPaymentService $service)
    {
        $service->create($this->validatedData($request));

        return redirect()
            ->route('dues.index')
            ->with('success', 'Dues payment recorded successfully.');
    }

    public function show(DuesPayment $due)
    {
        $due->load('period');

        return view('dues.show', compact('due'));
    }

    public function edit(DuesPayment $due)
    {
        $periods = DuesPeriod::where('is_active', true)->orderBy('name')->get();

        return view('dues.edit', compact('due', 'periods'));
    }

    public function update(Request $request, DuesPayment $due, DuesPaymentService $service)
    {
        $service->update($due, $this->validatedData($request));

        return redirect()
            ->route('dues.index')
            ->with('success', 'Dues payment updated successfully.');
    }

    public function destroy(DuesPayment $due)
    {
        $due->delete();

        return redirect()
            ->route('dues.index')
            ->with('success', 'Dues payment deleted successfully.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'dues_period_id' => ['required', 'exists:dues_periods,id'],
            'member_name' => ['required', 'string', 'max:255'],
            'member_email' => ['nullable', 'email', 'max:255'],
            'amount_due' => ['nullable', 'numeric', 'min:0'],
            'amount_paid' => ['required', 'numeric', 'min:0'],
            'paid_on' => ['nullable', 'date'],
            'payment_method' => ['nullable', 'string', 'max:100'],
            'reference_number' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
