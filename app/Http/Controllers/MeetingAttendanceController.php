<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Member;
use App\Models\MeetingAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MeetingAttendanceController extends Controller
{
    public function index()
    {
        $attendances = MeetingAttendance::with(['meeting', 'member'])
            ->latest()
            ->paginate(10);

        $totalRecords = MeetingAttendance::count();

        $summary = [
            'total_records' => $totalRecords,
            'present' => MeetingAttendance::where('status', 'Present')->count(),
            'absent' => MeetingAttendance::where('status', 'Absent')->count(),
            'excused' => MeetingAttendance::where('is_excused', true)->count(),
        ];

        return view('meeting-attendance.index', compact('attendances', 'summary'));
    }

    public function create()
    {
        $meetings = Meeting::orderByDesc('scheduled_at')->get();
        $members = Member::orderBy('last_name')->orderBy('first_name')->get();

        return view('meeting-attendance.create', compact('meetings', 'members'));
    }

    public function store(Request $request)
    {
        $validated = $this->validatedData($request);

        DB::transaction(function () use ($validated) {
            MeetingAttendance::create($validated);
        });

        return redirect()
            ->route('meeting-attendance.index')
            ->with('success', 'Attendance record created successfully.');
    }

    public function show(MeetingAttendance $meetingAttendance)
    {
        $meetingAttendance->load(['meeting', 'member']);

        return view('meeting-attendance.show', compact('meetingAttendance'));
    }

    public function edit(MeetingAttendance $meetingAttendance)
    {
        $meetings = Meeting::orderByDesc('scheduled_at')->get();
        $members = Member::orderBy('last_name')->orderBy('first_name')->get();

        return view('meeting-attendance.edit', compact('meetingAttendance', 'meetings', 'members'));
    }

    public function update(Request $request, MeetingAttendance $meetingAttendance)
    {
        $validated = $this->validatedData($request, $meetingAttendance->id);

        DB::transaction(function () use ($meetingAttendance, $validated) {
            $meetingAttendance->update($validated);
        });

        return redirect()
            ->route('meeting-attendance.index')
            ->with('success', 'Attendance record updated successfully.');
    }

    public function destroy(MeetingAttendance $meetingAttendance)
    {
        $meetingAttendance->delete();

        return redirect()
            ->route('meeting-attendance.index')
            ->with('success', 'Attendance record deleted successfully.');
    }

    private function validatedData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'meeting_id' => ['required', 'exists:meetings,id'],
            'member_id' => ['required', 'exists:members,id'],
            'status' => ['required', 'string', 'in:Present,Absent,Late,Excused'],
            'checked_in_at' => ['nullable', 'date'],
            'is_excused' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
