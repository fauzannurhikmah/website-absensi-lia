<?php

namespace App\Http\Controllers;

use App\Models\{Position, Presence, User};
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = User::all()->count();
        $position = Position::all()->count();
        $attendance = Presence::where('date', date('y-m-d'))->get()->count();
        return view('dashboard', compact('user', 'position', 'attendance'));
    }
}
