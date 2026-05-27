@extends('layouts.app')

@section('title', 'View Financial Transaction')

@section('content')
<div class="container py-4">

    <div class="card border-0 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background:#4b0082;">
            <h5 class="mb-0">{{ $finance->title }}</h5>

            @if(!$finance->is_finalized)
                <a href="{{ route('finances.edit', $finance) }}" class="btn btn-warning btn-sm fw-bold">
                    Edit Transaction
                </a>
            @else
                <span class="badge bg-success">Finalized / Locked</span>
            @endif
        </div>

        <div class="card-body">
            <div class="row g-4">

                <div class="col-md-6">
                    <h6 class="text-muted">Transaction Details</h6>
                    <p><strong>Type:</strong> {{ ucfirst($finance->type) }}</p>
                    <p><strong>Category:</strong> {{ $finance->category }}</p>
                    <p><strong>Amount:</strong> ${{ number_format($finance->amount, 2) }}</p>
                    <p><strong>Date:</strong> {{ $finance->transaction_date->format('M d, Y') }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($finance->status) }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Audit Information</h6>
                    <p><strong>Recorded By:</strong> {{ $finance->recorded_by ?? 'N/A' }}</p>
                    <p><strong>Payment Method:</strong> {{ $finance->payment_method ?? 'N/A' }}</p>
                    <p><strong>Reference Number:</strong> {{ $finance->reference_number ?? 'N/A' }}</p>
                    <p><strong>Finalized At:</strong> {{ $finance->finalized_at?->format('M d, Y g:i A') ?? 'Not finalized' }}</p>
                    <p><strong>Created:</strong> {{ $finance->created_at->format('M d, Y g:i A') }}</p>
                </div>

                <div class="col-12">
                    <h6 class="text-muted">Description</h6>
                    <p>{{ $finance->description ?? 'No description entered.' }}</p>
                </div>

            </div>
        </div>

        <div class="card-footer bg-white d-flex justify-content-between">
            <a href="{{ route('finances.index') }}" class="btn btn-secondary">
                Back
            </a>

            @if(!$finance->is_finalized)
                <form action="{{ route('finances.destroy', $finance) }}" method="POST"
                      onsubmit="return confirm('Delete this draft transaction?');">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">
                        Delete Transaction
                    </button>
                </form>
            @endif
        </div>
    </div>

</div>
@endsection
