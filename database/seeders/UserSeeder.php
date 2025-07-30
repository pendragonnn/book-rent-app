<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'), 
            'role_id' => 1, 
        ]);

        // Member
        User::create([
            'name' => 'Member',
            'email' => 'member@example.com',
            'password' => Hash::make('member123'),
            'role_id' => 2,
        ]);
    }
}
