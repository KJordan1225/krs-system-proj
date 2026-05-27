@extends('layouts.app')

@section('title', 'View Event')

@section('content')
<div class="container py-4">

    <div class="card border-0 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center text-white" style="background:#4b0082;">
            <h5 class="mb-0">{{ $event->title }}</h5>

            <a href="{{ route('events.edit', $event) }}" class="btn btn-warning btn-sm fw-bold">
                Edit Event
            </a>
        </div>

        <div class="card-body">
            <div class="row g-4">

                <div class="col-md-6">
                    <h6 class="text-muted">Event Details</h6>
                    <p><strong>Category:</strong> {{ $event->category ?? 'N/A' }}</p>
                    <p><strong>Type:</strong> {{ $event->event_type ?? 'N/A' }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($event->status) }}</p>
                    <p><strong>Visibility:</strong> {{ ucfirst($event->visibility) }}</p>
                    <p><strong>Location:</strong> {{ $event->location ?? 'N/A' }}</p>

                    @if($event->virtual_link)
                        <p>
                            <strong>Virtual Link:</strong>
                            <a href="{{ $event->virtual_link }}" target="_blank">
                                Open Link
                            </a>
                        </p>
                    @endif
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Schedule</h6>
                    <p><strong>Starts:</strong> {{ $event->starts_at->format('M d, Y g:i A') }}</p>
                    <p><strong>Ends:</strong> {{ $event->ends_at?->format('M d, Y g:i A') ?? 'N/A' }}</p>
                    <p><strong>Multi-Day:</strong> {{ $event->is_multi_day ? 'Yes' : 'No' }}</p>
                    <p><strong>Recurring:</strong> {{ $event->is_recurring ? 'Yes' : 'No' }}</p>
                    <p><strong>Capacity:</strong> {{ $event->capacity ?? 'N/A' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">People & Partners</h6>
                    <p><strong>Host Committee:</strong> {{ $event->host_committee ?? 'N/A' }}</p>
                    <p><strong>Assigned Officer:</strong> {{ $event->assigned_officer ?? 'N/A' }}</p>
                    <p><strong>Speaker:</strong> {{ $event->speaker ?? 'N/A' }}</p>
                    <p><strong>Sponsor:</strong> {{ $event->sponsor ?? 'N/A' }}</p>
                    <p><strong>Vendor:</strong> {{ $event->vendor ?? 'N/A' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Financials</h6>
                    <p><strong>Registration Fee:</strong> ${{ number_format($event->registration_fee, 2) }}</p>
                    <p><strong>Budget:</strong> ${{ number_format($event->budget, 2) }}</p>
                    <p><strong>Expenses:</strong> ${{ number_format($event->expenses, 2) }}</p>
                    <p><strong>Revenue:</strong> ${{ number_format($event->revenue, 2) }}</p>
                    <p><strong>Donations:</strong> ${{ number_format($event->donations, 2) }}</p>
                </div>

                <div class="col-12">
                    <h6 class="text-muted">Description</h6>
                    <p>{{ $event->description ?? 'No description entered.' }}</p>
                </div>

                <div class="col-12">
                    <h6 class="text-muted">Agenda</h6>
                    <p>{{ $event->agenda ?? 'No agenda entered.' }}</p>
                </div>

                <div class="col-12">
                    <h6 class="text-muted">Notes</h6>
                    <p>{{ $event->notes ?? 'No notes entered.' }}</p>
                </div>

            </div>
        </div>

        <div class="card-footer bg-white d-flex justify-content-between">
            <a href="{{ route('events.index') }}" class="btn btn-secondary">
                Back
            </a>

            <form action="{{ route('events.destroy', $event) }}" method="POST"
                  onsubmit="return confirm('Delete this event?');">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger">
                    Delete Event
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
