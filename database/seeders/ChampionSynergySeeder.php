<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChampionSynergySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {

        $championIds = DB::table('champions')->pluck('id')->toArray();

        $synergiIds = DB::table('synergies')->pluck('id')->toArray();

        if (empty($championIds) || empty($synergiIds)) {

            throw new \Exception('No se encontraron campeones o sinergias para rellenar la tabla champion_synergy.');
        }

        $championSynergiData = [];
        foreach ($championIds as $championId) {
            foreach ($synergiIds as $synergiId) {

                if (rand(0, 1)) {
                    $championSynergiData[] = [
                        'champion_id' => $championId,
                        'synergy_id' => $synergiId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        DB::table('champion_synergy')->insert($championSynergiData);
    }
}
