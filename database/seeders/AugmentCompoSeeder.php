<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AugmentCompoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {

        $championIds = DB::table('augments')->pluck('id')->toArray();

        $synergiIds = DB::table('compositions')->pluck('id')->toArray();

        if (empty($championIds) || empty($synergiIds)) {

            throw new \Exception('No se encontraron campeones o sinergias para rellenar la tabla champion_synergy.');
        }

        $championSynergiData = [];
        foreach ($championIds as $championId) {
            foreach ($synergiIds as $synergiId) {

                if (rand(0, 1)) {
                    $championSynergiData[] = [
                        'augment_id' => $championId,
                        'composition_id' => $synergiId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        DB::table('augment_compo')->insert($championSynergiData);
    }
}
