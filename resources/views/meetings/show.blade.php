@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="org-page-title">Meeting Details</h1>

        <a href="{{ route('meetings.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header org-card-header">
            {{ $meeting->title }}
        </div>

        <div class="card-body">
            <dl class="row">
                <dt class="col-md-4">Meeting Type</dt>
                <dd class="col-md-8">{{ $meeting->meeting_type }}</dd>

                <dt class="col-md-4">Scheduled At</dt>
                <dd class="col-md-8">{{ $meeting->scheduled_at->format('M d, Y g:i A') }}</dd>

                <dt class="col-md-4">Location</dt>
                <dd class="col-md-8">{{ $meeting->location ?? 'N/A' }}</dd>

                <dt class="col-md-4">Status</dt>
                <dd class="col-md-8">{{ $meeting->status }}</dd>

                <dt class="col-md-4">Recurring</dt>
                <dd class="col-md-8">
                    {{ $meeting->is_recurring ? 'Yes' : 'No' }}
                    @if($meeting->is_recurring)
                        — {{ $meeting->recurrence_pattern }}
                    @endif
                </dd>

                <dt class="col-md-4">Agenda</dt>
                <dd class="col-md-8">{{ $meeting->agenda ?? 'N/A' }}</dd>

                <dt class="col-md-4">Minutes</dt>
                <dd class="col-md-8">{{ $meeting->minutes ?? 'N/A' }}</dd>

                <dt class="col-md-4">Motions</dt>
                <dd class="col-md-8">{{ $meeting->motions ?? 'N/A' }}</dd>

                <dt class="col-md-4">Voting Outcome</dt>
                <dd class="col-md-8">{{ $meeting->voting_outcome ?? 'N/A' }}</dd>
            </dl>

            <h5 class="mt-4">Follow-Up Tasks</h5>

            <table class="table table-bordered align-middle mt-2">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Assigned To</th>
                        <th>Due Date</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($meeting->tasks as $task)
                        <tr>
                            <td>{{ $task->task_title }}</td>
                            <td>{{ $task->assigned_to ?? 'N/A' }}</td>
                            <td>{{ $task->due_date?->format('M d, Y') ?? 'N/A' }}</td>
                            <td>{{ $task->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No follow-up tasks assigned.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('meetings.edit', $meeting) }}" class="btn btn-org-gold">
                Edit Meeting
            </a>

            <form action="{{ route('meetings.destroy', $meeting) }}"
                  method="POST"
                  onsubmit="return confirm('Delete this meeting record?');">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-outline-danger">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
