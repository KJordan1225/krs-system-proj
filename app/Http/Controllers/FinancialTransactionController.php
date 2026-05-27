<?php

namespace App\Http\Controllers;

use App\Models\FinancialTransaction;
use Illuminate\Http\Request;

class FinancialTransactionController extends Controller
{
    public function index()
    {
        $transactions = FinancialTransaction::latest('transaction_date')->paginate(10);

        $incomeTotal = FinancialTransaction::where('type', 'income')->sum('amount');
        $expenseTotal = FinancialTransaction::where('type', 'expense')->sum('amount');
        $balance = $incomeTotal - $expenseTotal;

        return view('finances.index', compact(
            'transactions',
            'incomeTotal',
            'expenseTotal',
            'balance'
        ));
    }

    public function create()
    {
        return view('finances.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateTransaction($request);
        $data['recorded_by'] = auth()->user()->name ?? 'System';

        if ($data['status'] === 'finalized') {
            $data['finalized_at'] = now();
        }

        FinancialTransaction::create($data);

        return redirect()
            ->route('finances.index')
            ->with('success', 'Financial transaction created successfully.');
    }

    public function show(FinancialTransaction $finance)
    {
        return view('finances.show', compact('finance'));
    }

    public function edit(FinancialTransaction $finance)
    {
        if ($finance->is_finalized) {
            return redirect()
                ->route('finances.show', $finance)
                ->with('error', 'Finalized financial records cannot be edited.');
        }

        return view('finances.edit', compact('finance'));
    }

    public function update(Request $request, FinancialTransaction $finance)
    {
        if ($finance->is_finalized) {
            return redirect()
                ->route('finances.show', $finance)
                ->with('error', 'Finalized financial records cannot be edited.');
        }

        $data = $this->validateTransaction($request);

        if ($data['status'] === 'finalized') {
            $data['finalized_at'] = now();
        }

        $finance->update($data);

        return redirect()
            ->route('finances.index')
            ->with('success', 'Financial transaction updated successfully.');
    }

    public function destroy(FinancialTransaction $finance)
    {
        if ($finance->is_finalized) {
            return redirect()
                ->route('finances.index')
                ->with('error', 'Finalized financial records cannot be deleted.');
        }

        $finance->delete();

        return redirect()
            ->route('finances.index')
            ->with('success', 'Financial transaction deleted successfully.');
    }

    private function validateTransaction(Request $request): array
    {
        return $request->validate([
            'type' => ['required', 'in:income,expense'],
            'category' => ['required', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'transaction_date' => ['required', 'date'],
            'payment_method' => ['nullable', 'string', 'max:100'],
            'reference_number' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:draft,finalized'],
        ]);
    }
}
