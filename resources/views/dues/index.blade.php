@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="org-page-title">Dues Management</h1>

            <p class="text-muted mb-0">
                Track member dues, payment history, late fees, balances, and financial summaries.
            </p>
        </div>

        <a href="{{ route('dues.create') }}" class="btn btn-org-gold">
            Add Dues Payment
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="org-summary-card">
                <span>Total Revenue</span>

                <h3>
                    ${{ number_format($summary['total_revenue'], 2) }}
                </h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="org-summary-card">
                <span>Outstanding Balance</span>

                <h3>
                    ${{ number_format($summary['outstanding_balance'], 2) }}
                </h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="org-summary-card">
                <span>Paid Members</span>

                <h3>
                    {{ $summary['paid_members'] }}
                </h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="org-summary-card">
                <span>Delinquent Members</span>

                <h3>
                    {{ $summary['delinquent_members'] }}
                </h3>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header org-card-header">
            Payment History
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Period</th>
                        <th>Total Due</th>
                        <th>Paid</th>
                        <th>Balance</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>
                                <strong>
                                    {{ $payment->member_name }}
                                </strong>

                                <br>

                                <small class="text-muted">
                                    {{ $payment->member_email ?? 'No email' }}
                                </small>
                            </td>

                            <td>
                                {{ $payment->period?->name }}
                            </td>

                            <td>
                                ${{ number_format($payment->totalDue(), 2) }}
                            </td>

                            <td>
                                ${{ number_format($payment->amount_paid, 2) }}
                            </td>

                            <td>
                                ${{ number_format($payment->balance(), 2) }}
                            </td>

                            <td>
                                @if($payment->status() === 'Paid')
                                    <span class="badge bg-success">
                                        Paid
                                    </span>
                                @elseif($payment->status() === 'Partial')
                                    <span class="badge bg-warning text-dark">
                                        Partial
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        Outstanding
                                    </span>
                                @endif
                            </td>

                            <td class="text-end">
                                <a href="{{ route('dues.show', $payment) }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    View
                                </a>

                                <a href="{{ route('dues.edit', $payment) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Edit
                                </a>

                                <form action="{{ route('dues.destroy', $payment) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete this dues payment?');">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7"
                                class="text-center text-muted py-4">
                                No dues payments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection