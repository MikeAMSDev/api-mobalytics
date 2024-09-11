<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class CompositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        DB::table('compositions')->insert([

            [
                'name' => 'Noxus Empire',
                'description' => 'New Comp',
                'playing_style' => 'fast 8',
                'tier' => 'S',
                'difficulty' => 'Easy',
                'type' => 'private',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Noxus Empire 2',
                'description' => 'New Comp 2',
                'playing_style' => 'fast 8',
                'tier' => 'S',
                'difficulty' => 'Easy',
                'type' => 'publish',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Noxus Empire 3',
                'description' => 'New Comp 3',
                'playing_style' => 'fast 8',
                'tier' => 'S',
                'difficulty' => 'Easy',
                'type' => 'meta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);   

    }
}
