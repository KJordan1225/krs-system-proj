@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="org-page-title">Edit Attendance Record</h1>

    <form action="{{ route('meeting-attendance.update', $meetingAttendance) }}" method="POST" class="card border-0 shadow-sm mt-3">
        @csrf
        @method('PUT')

        <div class="card-header org-card-header">
            Update Attendance
        </div>

        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Meeting</label>
                <select name="meeting_id" class="form-select" required>
                    @foreach($meetings as $meeting)
                        <option value="{{ $meeting->id }}" @selected(old('meeting_id', $meetingAttendance->meeting_id) == $meeting->id)>
                            {{ $meeting->title }} - {{ $meeting->scheduled_at->format('M d, Y') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Member</label>
                <select name="member_id" class="form-select" required>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" @selected(old('member_id', $meetingAttendance->member_id) == $member->id)>
                            {{ $member->first_name }} {{ $member->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="Present" @selected(old('status', $meetingAttendance->status) === 'Present')>Present</option>
                    <option value="Absent" @selected(old('status', $meetingAttendance->status) === 'Absent')>Absent</option>
                    <option value="Late" @selected(old('status', $meetingAttendance->status) === 'Late')>Late</option>
                    <option value="Excused" @selected(old('status', $meetingAttendance->status) === 'Excused')>Excused</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Checked In At</label>
                <input type="datetime-local"
                       name="checked_in_at"
                       class="form-control"
                       value="{{ old('checked_in_at', optional($meetingAttendance->checked_in_at)->format('Y-m-d\TH:i')) }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Excused Absence?</label>
                <select name="is_excused" class="form-select">
                    <option value="0" @selected(! old('is_excused', $meetingAttendance->is_excused))>No</option>
                    <option value="1" @selected(old('is_excused', $meetingAttendance->is_excused))>Yes</option>
                </select>
            </div>

            <div class="col-12">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="4">{{ old('notes', $meetingAttendance->notes) }}</textarea>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('meeting-attendance.index') }}" class="btn btn-secondary">
                Cancel
            </a>

            <button type="submit" class="btn btn-org-gold">
                Update Attendance
            </button>
        </div>
    </form>
</div>
@endsection
