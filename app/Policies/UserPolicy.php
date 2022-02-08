<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function view(User $user, User $model)
    {
        $role = $user->role->where('name', 'admin')->first()->id ?? 0;
        return 1 === $role;
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, User $model)
    {
        //
    }

    public function delete(User $user, User $model)
    {
        //
    }
}
