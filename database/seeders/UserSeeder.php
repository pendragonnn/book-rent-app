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
        User::updateOrInsert(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role_id' => 1,
                'email_verified_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Member
        User::updateOrInsert(
            ['email' => 'member@example.com'],
            [
                'name' => 'Member',
                'password' => Hash::make('member123'),
                'role_id' => 2,
                'email_verified_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}

