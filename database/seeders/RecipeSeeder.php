<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('recipes')->insert([
            [
                'name' => 'Spaghetti Carbonara',
                'description' => 'A classic Italian pasta dish made with eggs, cheese, pancetta, and pepper.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chicken Alfredo',
                'description' => 'Creamy pasta dish made with chicken, fettuccine, and Alfredo sauce.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Beef Stroganoff',
                'description' => 'A rich and creamy dish made with beef, mushrooms, onions, and sour cream.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vegetable Stir-Fry',
                'description' => 'A colorful and healthy mix of stir-fried vegetables with a savory sauce.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Caesar Salad',
                'description' => 'A crisp salad with romaine lettuce, croutons, Parmesan cheese, and Caesar dressing.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
