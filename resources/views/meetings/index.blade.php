@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="org-page-title">Meeting Management</h1>
            <p class="text-muted mb-0">
                Schedule meetings, publish agendas, record minutes, track motions, and assign follow-up tasks.
            </p>
        </div>

        <a href="{{ route('meetings.create') }}" class="btn btn-org-gold">
            Schedule Meeting
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
                <span>Total Meetings</span>
                <h3>{{ $summary['total_meetings'] }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="org-summary-card">
                <span>Scheduled</span>
                <h3>{{ $summary['scheduled'] }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="org-summary-card">
                <span>Completed</span>
                <h3>{{ $summary['completed'] }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="org-summary-card">
                <span>Recurring</span>
                <h3>{{ $summary['recurring'] }}</h3>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header org-card-header">
            Meeting Records
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Meeting</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Tasks</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($meetings as $meeting)
                        <tr>
                            <td>
                                <strong>{{ $meeting->title }}</strong><br>
                                @if($meeting->is_recurring)
                                    <small class="text-muted">
                                        Recurs: {{ $meeting->recurrence_pattern }}
                                    </small>
                                @endif
                            </td>

                            <td>{{ $meeting->meeting_type }}</td>

                            <td>{{ $meeting->scheduled_at->format('M d, Y g:i A') }}</td>

                            <td>{{ $meeting->location ?? 'N/A' }}</td>

                            <td>
                                @if($meeting->status === 'Completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif($meeting->status === 'Cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                @else
                                    <span class="badge bg-warning text-dark">Scheduled</span>
                                @endif
                            </td>

                            <td>{{ $meeting->tasks_count }}</td>

                            <td class="text-end">
                                <a href="{{ route('meetings.show', $meeting) }}" class="btn btn-sm btn-outline-secondary">
                                    View
                                </a>

                                <a href="{{ route('meetings.edit', $meeting) }}" class="btn btn-sm btn-outline-primary">
                                    Edit
                                </a>

                                <form action="{{ route('meetings.destroy', $meeting) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete this meeting record?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No meetings found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $meetings->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
