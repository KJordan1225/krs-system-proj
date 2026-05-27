@extends('layouts.app')

@section('title', 'Financial Management')

@section('content')
<style>
    .finance-hero {
        background: linear-gradient(135deg, #4b0082, #2d004d);
        color: #fff;
        border-radius: 1rem;
    }

    .text-gold {
        color: #d4af37;
    }

    .btn-purple {
        background: #4b0082;
        border-color: #4b0082;
        color: #fff;
    }

    .btn-purple:hover {
        background: #3a0066;
        border-color: #3a0066;
        color: #fff;
    }

    .badge-purple {
        background: #4b0082;
    }
</style>

<div class="container-fluid py-4">

    <div class="finance-hero p-4 mb-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-1">Financial Management Module</h1>
                <p class="mb-0 text-gold">
                    Ledger-style tracking for income, expenses, budgets, reports, and audit-style records.
                </p>
            </div>

            <a href="{{ route('finances.create') }}" class="btn btn-warning fw-bold">
                Add Transaction
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Income</h6>
                    <h3 class="text-success">${{ number_format($incomeTotal, 2) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Expenses</h6>
                    <h3 class="text-danger">${{ number_format($expenseTotal, 2) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Current Balance</h6>
                    <h3 class="text-gold">${{ number_format($balance, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Transaction Ledger</h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->transaction_date->format('M d, Y') }}</td>
                                <td>{{ $transaction->title }}</td>
                                <td>{{ ucfirst($transaction->type) }}</td>
                                <td>{{ $transaction->category }}</td>
                                <td>${{ number_format($transaction->amount, 2) }}</td>
                                <td>
                                    <span class="badge {{ $transaction->status === 'finalized' ? 'bg-success' : 'badge-purple' }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('finances.show', $transaction) }}" class="btn btn-sm btn-outline-secondary">
                                        View
                                    </a>

                                    @if(!$transaction->is_finalized)
                                        <a href="{{ route('finances.edit', $transaction) }}" class="btn btn-sm btn-purple">
                                            Edit
                                        </a>

                                        <form action="{{ route('finances.destroy', $transaction) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Delete this draft transaction?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                Delete
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small">Locked</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    No financial transactions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection