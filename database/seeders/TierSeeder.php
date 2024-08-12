<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiers = [
            ['name' => 'S'],
            ['name' => 'A'],
            ['name' => 'B'],
            ['name' => 'M'],
        ];

        DB::table('tiers')->insert($tiers);
    }
}