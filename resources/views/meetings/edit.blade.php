@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="org-page-title">Edit Meeting</h1>

    <form action="{{ route('meetings.update', $meeting) }}" method="POST" class="card border-0 shadow-sm mt-3">
        @csrf
        @method('PUT')

        <div class="card-header org-card-header">
            Update Meeting
        </div>

        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Meeting Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $meeting->title) }}" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Meeting Type</label>
                <input type="text" name="meeting_type" class="form-control" value="{{ old('meeting_type', $meeting->meeting_type) }}" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="Scheduled" @selected(old('status', $meeting->status) === 'Scheduled')>Scheduled</option>
                    <option value="Completed" @selected(old('status', $meeting->status) === 'Completed')>Completed</option>
                    <option value="Cancelled" @selected(old('status', $meeting->status) === 'Cancelled')>Cancelled</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Scheduled Date & Time</label>
                <input type="datetime-local"
                       name="scheduled_at"
                       class="form-control"
                       value="{{ old('scheduled_at', $meeting->scheduled_at->format('Y-m-d\TH:i')) }}"
                       required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location', $meeting->location) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Recurring Meeting?</label>
                <select name="is_recurring" class="form-select">
                    <option value="0" @selected(! $meeting->is_recurring)>No</option>
                    <option value="1" @selected($meeting->is_recurring)>Yes</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Recurrence Pattern</label>
                <input type="text" name="recurrence_pattern" class="form-control" value="{{ old('recurrence_pattern', $meeting->recurrence_pattern) }}">
            </div>

            <div class="col-12">
                <label class="form-label">Agenda</label>
                <textarea name="agenda" class="form-control" rows="4">{{ old('agenda', $meeting->agenda) }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label">Minutes</label>
                <textarea name="minutes" class="form-control" rows="5">{{ old('minutes', $meeting->minutes) }}</textarea>
            </div>

            <div class="col-md-8">
                <label class="form-label">Motions</label>
                <textarea name="motions" class="form-control" rows="4">{{ old('motions', $meeting->motions) }}</textarea>
            </div>

            <div class="col-md-4">
                <label class="form-label">Voting Outcome</label>
                <input type="text" name="voting_outcome" class="form-control" value="{{ old('voting_outcome', $meeting->voting_outcome) }}">
            </div>

            <div class="col-12">
                <h5 class="mt-3">Follow-Up Tasks</h5>
                <p class="text-muted small">Updating will replace the existing task list.</p>
            </div>

            @for($i = 0; $i < 3; $i++)
                @php
                    $task = $meeting->tasks[$i] ?? null;
                @endphp

                <div class="col-md-5">
                    <label class="form-label">Task Title</label>
                    <input type="text" name="tasks[{{ $i }}][task_title]" class="form-control" value="{{ old("tasks.$i.task_title", $task->task_title ?? '') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Assigned To</label>
                    <input type="text" name="tasks[{{ $i }}][assigned_to]" class="form-control" value="{{ old("tasks.$i.assigned_to", $task->assigned_to ?? '') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Due Date</label>
                    <input type="date" name="tasks[{{ $i }}][due_date]" class="form-control" value="{{ old("tasks.$i.due_date", optional($task?->due_date)->format('Y-m-d')) }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="tasks[{{ $i }}][status]" class="form-select">
                        <option value="Open" @selected(($task->status ?? '') === 'Open')>Open</option>
                        <option value="In Progress" @selected(($task->status ?? '') === 'In Progress')>In Progress</option>
                        <option value="Completed" @selected(($task->status ?? '') === 'Completed')>Completed</option>
                    </select>
                </div>
            @endfor
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('meetings.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-org-gold">Update Meeting</button>
        </div>
    </form>
</div>
@endsection
