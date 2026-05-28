@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="org-page-title">Meeting Attendance</h1>
            <p class="text-muted mb-0">
                Track check-ins, absences, excused absences, and member participation.
            </p>
        </div>

        <a href="{{ route('meeting-attendance.create') }}" class="btn btn-org-gold">
            Add Attendance
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
                <span>Total Records</span>
                <h3>{{ $summary['total_records'] }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="org-summary-card">
                <span>Present</span>
                <h3>{{ $summary['present'] }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="org-summary-card">
                <span>Absent</span>
                <h3>{{ $summary['absent'] }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="org-summary-card">
                <span>Excused</span>
                <h3>{{ $summary['excused'] }}</h3>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header org-card-header">
            Attendance Records
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Meeting</th>
                        <th>Member</th>
                        <th>Status</th>
                        <th>Checked In</th>
                        <th>Excused</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($attendances as $attendance)
                        <tr>
                            <td>
                                <strong>{{ $attendance->meeting?->title }}</strong><br>
                                <small class="text-muted">
                                    {{ $attendance->meeting?->scheduled_at?->format('M d, Y g:i A') }}
                                </small>
                            </td>

                            <td>
                                {{ $attendance->member?->first_name }}
                                {{ $attendance->member?->last_name }}
                            </td>

                            <td>
                                @if($attendance->status === 'Present')
                                    <span class="badge bg-success">Present</span>
                                @elseif($attendance->status === 'Late')
                                    <span class="badge bg-warning text-dark">Late</span>
                                @elseif($attendance->status === 'Excused')
                                    <span class="badge bg-info text-dark">Excused</span>
                                @else
                                    <span class="badge bg-danger">Absent</span>
                                @endif
                            </td>

                            <td>
                                {{ $attendance->checked_in_at?->format('M d, Y g:i A') ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $attendance->is_excused ? 'Yes' : 'No' }}
                            </td>

                            <td class="text-end">
                                <a href="{{ route('meeting-attendance.show', $attendance) }}" class="btn btn-sm btn-outline-secondary">
                                    View
                                </a>

                                <a href="{{ route('meeting-attendance.edit', $attendance) }}" class="btn btn-sm btn-outline-primary">
                                    Edit
                                </a>

                                <form action="{{ route('meeting-attendance.destroy', $attendance) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete this attendance record?');">
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
                            <td colspan="6" class="text-center text-muted py-4">
                                No attendance records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $attendances->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
