<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Technology'],
            ['name' => 'Health & Wellness'],
            ['name' => 'Education'],
            ['name' => 'Sports & Fitness'],
            ['name' => 'Food & Beverage'],
            ['name' => 'Fashion'],
            ['name' => 'Travel & Tourism'],
            ['name' => 'Entertainment'],
            ['name' => 'Business'],
            ['name' => 'Automotive'],
            ['name' => 'Real Estate'],
            ['name' => 'Finance'],
            ['name' => 'Arts & Culture'],
            ['name' => 'Gaming'],
            ['name' => 'Beauty & Skincare'],
        ];

        DB::table('categories')->insert($categories);
    }
}