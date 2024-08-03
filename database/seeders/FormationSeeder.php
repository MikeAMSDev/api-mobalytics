<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($row = 1; $row <= 4; $row++) {
            for ($col = 1; $col <= 7; $col++) {

                DB::table('formations')->insert([
                    'slot_table' => json_encode([$row, $col]),
                    'champion_id' => rand(1, 3),
                    'compo_id' => rand(1, 5),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
