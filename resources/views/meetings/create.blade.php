@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="org-page-title">Schedule Meeting</h1>

    <form action="{{ route('meetings.store') }}" method="POST" class="card border-0 shadow-sm mt-3">
        @csrf

        <div class="card-header org-card-header">
            Meeting Details
        </div>

        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Meeting Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">Meeting Type</label>
                <select name="meeting_type" class="form-select" required>
                    <option value="General">General</option>
                    <option value="Executive">Executive</option>
                    <option value="Finance">Finance</option>
                    <option value="Committee">Committee</option>
                    <option value="Special">Special</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="Scheduled">Scheduled</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Scheduled Date & Time</label>
                <input type="datetime-local" name="scheduled_at" class="form-control" value="{{ old('scheduled_at') }}" required>
                @error('scheduled_at') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Recurring Meeting?</label>
                <select name="is_recurring" class="form-select">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Recurrence Pattern</label>
                <input type="text" name="recurrence_pattern" class="form-control" placeholder="Weekly, Monthly, Quarterly">
            </div>

            <div class="col-12">
                <label class="form-label">Agenda</label>
                <textarea name="agenda" class="form-control" rows="4">{{ old('agenda') }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label">Minutes</label>
                <textarea name="minutes" class="form-control" rows="5">{{ old('minutes') }}</textarea>
            </div>

            <div class="col-md-8">
                <label class="form-label">Motions</label>
                <textarea name="motions" class="form-control" rows="4">{{ old('motions') }}</textarea>
            </div>

            <div class="col-md-4">
                <label class="form-label">Voting Outcome</label>
                <input type="text" name="voting_outcome" class="form-control" placeholder="Passed, Failed, Tabled">
            </div>

            <div class="col-12">
                <h5 class="mt-3 text-purple">Follow-Up Tasks</h5>
            </div>

            @for($i = 0; $i < 3; $i++)
                <div class="col-md-5">
                    <label class="form-label">Task Title</label>
                    <input type="text" name="tasks[{{ $i }}][task_title]" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Assigned To</label>
                    <input type="text" name="tasks[{{ $i }}][assigned_to]" class="form-control">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Due Date</label>
                    <input type="date" name="tasks[{{ $i }}][due_date]" class="form-control">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="tasks[{{ $i }}][status]" class="form-select">
                        <option value="Open">Open</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>
            @endfor
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('meetings.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-org-gold">Save Meeting</button>
        </div>
    </form>
</div>
@endsection
