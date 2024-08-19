<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChampionItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $championIds = DB::table('champions')->pluck('id')->toArray();

        $itemIds = DB::table('items')->pluck('id')->toArray();

        if (empty($championIds) || empty($itemIds)) {
            throw new \Exception('No se encontraron campeones o items para rellenar la tabla champion_item.');
        }

        $championItemData = [];
        foreach ($championIds as $championId) {

            $randomItemIds = array_rand(array_flip($itemIds), rand(1, 3));
            foreach ((array)$randomItemIds as $itemId) {
                $championItemData[] = [
                    'champion_id' => $championId,
                    'item_id' => $itemId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('champion_item')->insert($championItemData);
    }
}
