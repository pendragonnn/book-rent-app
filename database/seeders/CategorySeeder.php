<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Fiction', 'Science', 'History', 'Technology', 'Children'];

        foreach ($categories as $name) {
            Category::updateOrInsert(['name' => $name]);
        }
    }
}

