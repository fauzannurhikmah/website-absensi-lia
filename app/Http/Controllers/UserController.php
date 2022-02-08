<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\{Position, Role, User};
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::orderBy('name')->paginate(10);
        if (request('search'))
            $user = User::where('name', 'LIKE', '%' . request('search'))->paginate(10);
        return view('user.index', compact('user'));
    }
    public function create()
    {
        $position = Position::orderBy('name', 'asc')->get();
        return view('user.create', compact('position'));
    }
    public function store(UserRequest $request)
    {
        $user = User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'position_id' => $request->position
        ]);

        if ($request->role === "on") {
            $role = Role::where('name', 'admin')->first();
            $user->role()->attach($role);
        } else {
            $role = Role::where('name', 'employee')->first();
            $user->role()->attach($role);
        }

        return back()->with('success', 'New user added successfully');
    }

    public function edit(User $user)
    {
        $position = Position::orderBy('name', 'asc')->get();
        return view('user.edit', compact('user', 'position'));
    }
    public function update(UserRequest $request, User $user)
    {
        $user->update([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'position_id' => $request->position
        ]);

        if ($request->role === "on") {
            $role = Role::where('name', 'admin')->first();
            $user->role()->sync($role);
        } else {
            $role = Role::where('name', 'employee')->first();
            $user->role()->sync($role);
        }

        return back()->with('success', 'The user update successfully');
    }
    public function destroy(User $user)
    {
        $user->role()->detach();
        $user->delete();
    }
}
