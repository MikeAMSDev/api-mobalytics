<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DifficultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $difficulty = [
            ['name' => 'Easy'],
            ['name' => 'Medium'],
            ['name' => 'Hard'],
        ];

        DB::table('difficulties')->insert($difficulty);
    }
}
