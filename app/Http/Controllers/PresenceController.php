<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceExport;
use App\Http\Requests\PresenceRequest;
use App\Models\{Presence, User};
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class PresenceController extends Controller
{
    public function index()
    {
        if (auth()->user()->role[0]->pivot['role_id'] == 1) {
            $attendance = Presence::latest('id')->where('date', date('y-m-d'))->with('user')->paginate(10);
            if (request('filter'))
                $attendance = Presence::latest('id')->where('date', request('filter'))->with('user')->paginate(10);
        } else {
            $attendance = Presence::latest('id')->where('user_id', auth()->id())->whereMonth('date', date('m'))->with('user')->paginate(10);
            if (request('filter'))
                $attendance = Presence::latest('id')->where('date', request('filter'))->Where('user_id', auth()->id())->with('user')->get();
        }

        $user = User::orderBy('name', 'asc')->select(['id', 'name', 'position_id', 'nik'])->with('position')->get();
        return view('presence.index', compact('attendance', 'user'));
    }

    public function store(PresenceRequest $request)
    {
        $attendance = Presence::where('user_id', $request->name)->where('date', $request->date)->first();;
        if ($attendance) {
            return back()->with('failed', 'Punten teu kenging dua kali');
        } else {
            Presence::create(['user_id' => $request->name, 'timeIn' => Carbon::now('GMT+7')->format('H:i:s'), 'date' => $request->date]);
            return back()->with('success', 'The attendance added successfully');
        }
    }

    public function destroy(Presence $presence)
    {
        $presence->delete();
        return back()->with('success', 'The attendance deleted successfully');
    }

    public function exportFile()
    {
        $attendance = Presence::where('date', request('date'))->get();
        if ($attendance->count() == 0)
            return back()->with('failed', 'Export data for date ' . request('date') . ' is empty');
        if ($attendance->count() > 0)
            return Excel::download(new AttendanceExport(request('date')), 'Attendance List - ' . request('date') . '.xlsx');
    }
}
