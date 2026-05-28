@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="org-page-title">Add Meeting Attendance</h1>

    <form action="{{ route('meeting-attendance.store') }}" method="POST" class="card border-0 shadow-sm mt-3">
        @csrf

        <div class="card-header org-card-header">
            Attendance Details
        </div>

        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Meeting</label>
                <select name="meeting_id" class="form-select" required>
                    <option value="">Select Meeting</option>
                    @foreach($meetings as $meeting)
                        <option value="{{ $meeting->id }}" @selected(old('meeting_id') == $meeting->id)>
                            {{ $meeting->title }} - {{ $meeting->scheduled_at->format('M d, Y') }}
                        </option>
                    @endforeach
                </select>
                @error('meeting_id')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Member</label>
                <select name="member_id" class="form-select" required>
                    <option value="">Select Member</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" @selected(old('member_id') == $member->id)>
                            {{ $member->first_name }} {{ $member->last_name }}
                        </option>
                    @endforeach
                </select>
                @error('member_id')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                    <option value="Late">Late</option>
                    <option value="Excused">Excused</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Checked In At</label>
                <input type="datetime-local" name="checked_in_at" class="form-control" value="{{ old('checked_in_at') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Excused Absence?</label>
                <select name="is_excused" class="form-select">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>

            <div class="col-12">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="4">{{ old('notes') }}</textarea>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('meeting-attendance.index') }}" class="btn btn-secondary">
                Cancel
            </a>

            <button type="submit" class="btn btn-org-gold">
                Save Attendance
            </button>
        </div>
    </form>
</div>
@endsection
