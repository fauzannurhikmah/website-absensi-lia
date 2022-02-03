<?php

namespace App\Http\Controllers;

use App\Models\{AttendanceStatus, Presence};
use Illuminate\Http\Request;

class AttendanceStatusController extends Controller
{

    public function store(Request $request)
    {
        $attendance = Presence::where('employee_id', $request->name)->first();
        $request->validate(['name' => 'required|exists:employees,id', 'date' => 'required|date']);
        foreach ($attendance->attendance as $value) {
            $attendanceDay = $value->date->format('d');
            if ($attendanceDay != date('d', strtotime($request->date))) {
                AttendanceStatus::create(['presence_id' => $attendance->id, 'date' => $request->date]);
                return back()->with('success', 'The attendance added successfully');
            } else {
                return back()->with('failed', 'Punten teu kenging dua kali');
            }
        }
    }
}
