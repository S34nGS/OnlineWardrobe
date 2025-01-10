<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;  // Import the Category model

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Inserting categories using the Category model
        Category::create(['name' => 'Shirts']);
        Category::create(['name' => 'Broeken']);
        Category::create(['name' => 'Schoenen']);
        Category::create(['name' => 'Jassen']);
        Category::create(['name' => 'Accessoires']);
    }
}
