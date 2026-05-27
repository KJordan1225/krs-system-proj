@extends('layouts.app')

@section('title', 'View Member')

@section('content')
<div class="container py-4">

    <div class="card border-0 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background:#4b0082;">
            <h5 class="mb-0">{{ $member->full_name }}</h5>

            <a href="{{ route('members.edit', $member) }}" class="btn btn-warning btn-sm fw-bold">
                Edit Member
            </a>
        </div>

        <div class="card-body">
            <div class="row g-4">

                <div class="col-md-6">
                    <h6 class="text-muted">Contact Information</h6>
                    <p><strong>Email:</strong> {{ $member->email }}</p>
                    <p><strong>Phone:</strong> {{ $member->phone ?? 'N/A' }}</p>
                    <p><strong>Address:</strong> {{ $member->address ?? 'N/A' }}</p>
                    <p><strong>City:</strong> {{ $member->city ?? 'N/A' }}</p>
                    <p><strong>State:</strong> {{ $member->state ?? 'N/A' }}</p>
                    <p><strong>ZIP:</strong> {{ $member->zip_code ?? 'N/A' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Membership Information</h6>
                    <p><strong>Status:</strong> {{ ucfirst($member->membership_status) }}</p>
                    <p><strong>Officer Position:</strong> {{ $member->officer_position ?? 'N/A' }}</p>
                    <p><strong>Committee:</strong> {{ $member->committee ?? 'N/A' }}</p>
                    <p><strong>Role Tracking:</strong> {{ $member->role_tracking ?? 'N/A' }}</p>
                    <p><strong>Joined:</strong> {{ $member->joined_at?->format('M d, Y') ?? 'N/A' }}</p>
                </div>

                <div class="col-12">
                    <h6 class="text-muted">Membership History</h6>
                    <p>{{ $member->membership_history ?? 'No history entered.' }}</p>
                </div>

                <div class="col-12">
                    <h6 class="text-muted">Notes</h6>
                    <p>{{ $member->notes ?? 'No notes entered.' }}</p>
                </div>

            </div>
        </div>

        <div class="card-footer bg-white d-flex justify-content-between">
            <a href="{{ route('members.index') }}" class="btn btn-secondary">
                Back
            </a>

            <form action="{{ route('members.destroy', $member) }}" method="POST"
                  onsubmit="return confirm('Delete this member?');">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger">
                    Delete Member
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
