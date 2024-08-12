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
                'champion_img' => 'champion_a.png',
                'champion_icon' => 'champions',
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
                'ability' => json_encode([
                    'name' => 'Learning to Fly',
                    'description' => 'Passive: Fly around and attack the nearest enemy. Active: Gain Attack Speed and replace Smolder\'s attacks with fireballs that deal physical damage for 6 seconds. Dragon Upgrade: Each fireball also heals 20 Health.',
                    'bonus_attack_speed' => '50% / 50% / 500%',
                    'damage_ad' => '185% / 190% / 888%',
                    'damage_ap' => '25% / 40% / 888%',
                    'dragon_upgrade_heal' => '20 / 30 / 200',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Champion B',
                'description' => 'A skilled champion with diverse abilities.',
                'cost' => '2',
                'champion_img' => 'champion_b.png',
                'champion_icon' => 'chasdasdu',
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
                'ability' => json_encode([
                    'name' => 'Learning to Fly',
                    'description' => 'Passive: Fly around and attack the nearest enemy. Active: Gain Attack Speed and replace Smolder\'s attacks with fireballs that deal physical damage for 6 seconds. Dragon Upgrade: Each fireball also heals 20 Health.',
                    'bonus_attack_speed' => '50% / 50% / 500%',
                    'damage_ad' => '185% / 190% / 888%',
                    'damage_ap' => '25% / 40% / 888%',
                    'dragon_upgrade_heal' => '20 / 30 / 200',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Champion C',
                'description' => 'An agile champion with quick reflexes.',
                'cost' => '3',
                'champion_img' => 'champion_c.png',
                'champion_icon' => 'asdgashgdh',
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
                'ability' => json_encode([
                    'name' => 'Learning to Fly',
                    'description' => 'Passive: Fly around and attack the nearest enemy. Active: Gain Attack Speed and replace Smolder\'s attacks with fireballs that deal physical damage for 6 seconds. Dragon Upgrade: Each fireball also heals 20 Health.',
                    'bonus_attack_speed' => '50% / 50% / 500%',
                    'damage_ad' => '185% / 190% / 888%',
                    'damage_ap' => '25% / 40% / 888%',
                    'dragon_upgrade_heal' => '20 / 30 / 200',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}