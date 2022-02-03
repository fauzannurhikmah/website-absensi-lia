<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{

    public function run()
    {
        $roles = collect(['admin', 'employee']);
        $roles->each(function ($item) {
            Role::create(['name' => $item]);
        });
    }
}
