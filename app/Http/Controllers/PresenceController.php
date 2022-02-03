<?php

namespace App\Http\Controllers;

use App\Http\Requests\PresenceRequest;
use App\Models\{Employee, Position, Presence};

class PresenceController extends Controller
{
    public function index()
    {
        $attendance = Presence::latest('id')->get();
        $employee = Employee::orderBy('name')->select(['id', 'name'])->get();
        $position = Position::orderBy('name')->select(['id', 'name'])->get();
        return view('presence.index', compact('attendance', 'employee', 'position'));
    }

    public function store(PresenceRequest $request)
    {
        Presence::create([
            'user_id' => auth()->id(),
            'employee_id' => $request->name,
            'position_id' => $request->position,
        ]);

        return back()->with('success', 'New attendance added succesfully');
    }

    public function update(PresenceRequest $request, Presence $presence)
    {
        //
    }
    public function destroy(Presence $presence)
    {
        //
    }
}
