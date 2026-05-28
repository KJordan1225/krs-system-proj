@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="org-page-title">Attendance Details</h1>

        <a href="{{ route('meeting-attendance.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header org-card-header">
            {{ $meetingAttendance->member?->first_name }} {{ $meetingAttendance->member?->last_name }}
        </div>

        <div class="card-body">
            <dl class="row">
                <dt class="col-md-4">Meeting</dt>
                <dd class="col-md-8">{{ $meetingAttendance->meeting?->title }}</dd>

                <dt class="col-md-4">Meeting Date</dt>
                <dd class="col-md-8">
                    {{ $meetingAttendance->meeting?->scheduled_at?->format('M d, Y g:i A') }}
                </dd>

                <dt class="col-md-4">Member</dt>
                <dd class="col-md-8">
                    {{ $meetingAttendance->member?->first_name }}
                    {{ $meetingAttendance->member?->last_name }}
                </dd>

                <dt class="col-md-4">Status</dt>
                <dd class="col-md-8">
                    {{ $meetingAttendance->status }}
                </dd>

                <dt class="col-md-4">Checked In At</dt>
                <dd class="col-md-8">
                    {{ $meetingAttendance->checked_in_at?->format('M d, Y g:i A') ?? 'N/A' }}
                </dd>

                <dt class="col-md-4">Excused Absence</dt>
                <dd class="col-md-8">
                    {{ $meetingAttendance->is_excused ? 'Yes' : 'No' }}
                </dd>

                <dt class="col-md-4">Notes</dt>
                <dd class="col-md-8">
                    {{ $meetingAttendance->notes ?? 'N/A' }}
                </dd>
            </dl>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('meeting-attendance.edit', $meetingAttendance) }}" class="btn btn-org-gold">
                Edit Attendance
            </a>

            <form action="{{ route('meeting-attendance.destroy', $meetingAttendance) }}"
                  method="POST"
                  onsubmit="return confirm('Delete this attendance record?');">
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
