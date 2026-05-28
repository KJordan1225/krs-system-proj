<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Meeting::withCount('tasks')
            ->latest('scheduled_at')
            ->paginate(10);

        $summary = [
            'total_meetings' => Meeting::count(),
            'scheduled' => Meeting::where('status', 'Scheduled')->count(),
            'completed' => Meeting::where('status', 'Completed')->count(),
            'recurring' => Meeting::where('is_recurring', true)->count(),
        ];

        return view('meetings.index', compact('meetings', 'summary'));
    }

    public function create()
    {
        return view('meetings.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validatedData($request);

        DB::transaction(function () use ($validated, $request) {
            $meeting = Meeting::create($validated);

            $this->syncTasks($meeting, $request);
        });

        return redirect()
            ->route('meetings.index')
            ->with('success', 'Meeting created successfully.');
    }

    public function show(Meeting $meeting)
    {
        $meeting->load('tasks');

        return view('meetings.show', compact('meeting'));
    }

    public function edit(Meeting $meeting)
    {
        $meeting->load('tasks');

        return view('meetings.edit', compact('meeting'));
    }

    public function update(Request $request, Meeting $meeting)
    {
        $validated = $this->validatedData($request);

        DB::transaction(function () use ($meeting, $validated, $request) {
            $meeting->update($validated);

            $meeting->tasks()->delete();

            $this->syncTasks($meeting, $request);
        });

        return redirect()
            ->route('meetings.index')
            ->with('success', 'Meeting updated successfully.');
    }

    public function destroy(Meeting $meeting)
    {
        $meeting->delete();

        return redirect()
            ->route('meetings.index')
            ->with('success', 'Meeting deleted successfully.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'meeting_type' => ['required', 'string', 'max:100'],
            'scheduled_at' => ['required', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'agenda' => ['nullable', 'string'],
            'minutes' => ['nullable', 'string'],
            'motions' => ['nullable', 'string'],
            'voting_outcome' => ['nullable', 'string', 'max:255'],
            'is_recurring' => ['nullable', 'boolean'],
            'recurrence_pattern' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'string', 'max:50'],
        ]);
    }

    private function syncTasks(Meeting $meeting, Request $request): void
    {
        $tasks = $request->input('tasks', []);

        foreach ($tasks as $task) {
            if (! empty($task['task_title'])) {
                $meeting->tasks()->create([
                    'task_title' => $task['task_title'],
                    'assigned_to' => $task['assigned_to'] ?? null,
                    'due_date' => $task['due_date'] ?? null,
                    'status' => $task['status'] ?? 'Open',
                ]);
            }
        }
    }
}
