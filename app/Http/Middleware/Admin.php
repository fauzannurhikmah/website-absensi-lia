<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        $user = User::whereId(auth()->user()->id)->first();
        if ($user->role->where('name', 'admin')->first()) {
            return $next($request);
        }

        return redirect()->route('dashboard');
    }
}
