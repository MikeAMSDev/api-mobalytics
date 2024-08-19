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
                'prio_carrusel' => json_encode(['B.F. Sword', 'Chain Vest', 'Giants Belt', 'Negatron Cloak', 'Recurve Bow']),
                'playing_style' => 'fast 8',
                'tier' => 'S',
                'difficulty' => 'Easy',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);   

    }
}
