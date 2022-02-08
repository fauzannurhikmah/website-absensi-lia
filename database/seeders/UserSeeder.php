<?php

namespace Database\Seeders;

use App\Models\{Role, User};
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'nik' => '2378200812366232',
            'name' => 'Fauzan Nurhikmah',
            'email' => 'fauzannurhikmah@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $role = Role::where('name', 'admin')->first();
        $user->role()->attach($role);
    }
}
