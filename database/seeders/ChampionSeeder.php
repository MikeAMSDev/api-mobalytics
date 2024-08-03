<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChampionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('champions')->insert([
            [
                'name' => 'Champion A',
                'description' => 'A powerful champion with great abilities.',
                'cost' => '1',
                'tier' => 'Tier 1',
                'champion_img' => 'champion_a.png',
                'set_version' => 1,
                'stats' => json_encode([
                    'health' => '1000 / 1800 / 3240',
                    'damage' => '80 / 120 / 180',
                    'dps' => '64 / 96 / 144',
                    'mr' => 30,
                    'armor' => 50,
                    'speed' => 0.75,
                    'mana' => '30 / 80',
                    'range' => 3,
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Champion B',
                'description' => 'A skilled champion with diverse abilities.',
                'cost' => '2',
                'tier' => 'Tier 2',
                'champion_img' => 'champion_b.png',
                'set_version' => 2,
                'stats' => json_encode([
                    'health' => '1200 / 2000 / 3500',
                    'damage' => '100 / 150 / 210',
                    'dps' => '80 / 110 / 160',
                    'mr' => 25,
                    'armor' => 45,
                    'speed' => 0.85,
                    'mana' => '40 / 90',
                    'range' => 4,
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Champion C',
                'description' => 'An agile champion with quick reflexes.',
                'cost' => '3',
                'tier' => 'Tier 3',
                'champion_img' => 'champion_c.png',
                'set_version' => 3,
                'stats' => json_encode([
                    'health' => '900 / 1700 / 3100',
                    'damage' => '90 / 140 / 200',
                    'dps' => '70 / 100 / 150',
                    'mr' => 35,
                    'armor' => 55,
                    'speed' => 0.95,
                    'mana' => '50 / 100',
                    'range' => 2,
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
