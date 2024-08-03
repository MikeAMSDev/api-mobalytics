<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SynergySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            [
                'name' => 'Synergy One',
                'description' => 'Description for Synergy One',
                'icon_synergy' => 'icon1.png',
                'synergy_img' => 'synergi1.png',
                'synergy_activation' => json_encode([
                    ['1' => 'Activation One'],
                    ['2' => 'Activation Two'],
                ]),
                'set_version' => rand(1, 12),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Synergy Two',
                'description' => 'Description for Synergy Two',
                'icon_synergy' => 'icon2.png',
                'synergy_img' => 'synergi2.png',
                'synergy_activation' => json_encode([
                    ['3' => 'Activation Three'],
                    ['4' => 'Activation Four'],
                ]),
                'set_version' => rand(1, 12),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Synergy Three',
                'description' => 'Description for Synergy Three',
                'icon_synergy' => 'icon2.png',
                'synergy_img' => 'synergi2.png',
                'synergy_activation' => json_encode([
                    ['3' => 'Activation Three'],
                    ['4' => 'Activation Four'],
                ]),
                'set_version' => rand(1, 12),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Synergy Four',
                'description' => 'Description for Synergy Four',
                'icon_synergy' => 'icon2.png',
                'synergy_img' => 'synergi2.png',
                'synergy_activation' => json_encode([
                    ['3' => 'Activation Three'],
                    ['4' => 'Activation Four'],
                    ['5' => 'Activation Five'],
                    ['8' => 'Activation Eigth'],
                ]),
                'set_version' => rand(1, 12),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Synergy Five',
                'description' => 'Description for Synergy Five',
                'icon_synergy' => 'icon2.png',
                'synergy_img' => 'synergi2.png',
                'synergy_activation' => json_encode([
                    ['3' => 'Activation Three'],
                ]),
                'set_version' => rand(1, 12),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Synergy Six',
                'description' => 'Description for Synergy Six',
                'icon_synergy' => 'icon2.png',
                'synergy_img' => 'synergi2.png',
                'synergy_activation' => json_encode([
                    ['3' => 'Activation Three'],
                    ['4' => 'Activation Four'],
                    ['8' => 'Activation Eight'],
                ]),
                'set_version' => rand(1, 12),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ];

        DB::table('synergies')->insert($data);
    }
}