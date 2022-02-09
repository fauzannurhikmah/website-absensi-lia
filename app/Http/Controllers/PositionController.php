<?php

namespace App\Http\Controllers;

use App\Http\Requests\PositionRequest;
use App\Models\Position;

class PositionController extends Controller
{
    public function index()
    {
        $position = Position::latest('id')->paginate(10);
        if (request('search'))
            $position = Position::where('name', 'LIKE', '%' . request('search'))->paginate(10);
        return view('position.index', compact('position'));
    }

    public function store(PositionRequest $request)
    {
        Position::create(['position' => $request->position, 'department' => $request->department]);
        return back()->with('success', 'New position added successfully');
    }

    public function update(PositionRequest $request, Position $position)
    {
        $position->update(['position' => $request->position, 'department' => $request->department]);
        return back()->with('success', 'The position updated successfully');
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return back()->with('success', 'The position deleted successfully');
    }
}
