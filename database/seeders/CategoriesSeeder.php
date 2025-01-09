<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Shirts'],
            ['name' => 'Broeken'],
            ['name' => 'Schoenen'],
            ['name' => 'Jassen'],
            ['name' => 'Accessoires'],
        ]);
    }
}
