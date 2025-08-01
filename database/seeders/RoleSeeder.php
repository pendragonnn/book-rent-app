<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::updateOrInsert(['id' => 1], ['name' => 'admin']);
        Role::updateOrInsert(['id' => 2], ['name' => 'member']);
    }
}
