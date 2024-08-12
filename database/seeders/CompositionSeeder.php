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
    public function run()
    {
        $faker = Factory::create();

        $tierIds = DB::table('tiers')->pluck('id')->toArray();

        $difficultyIds = DB::table('difficulties')->pluck('id')->toArray();

        $data = [];

        for ($i = 0; $i < 10; $i++) {
            $prio_carrusel = [];
            $num_items = rand(3, 10);
            for ($j = 0; $j < $num_items; $j++) {
                $prio_carrusel[] = $faker->word;
            }

            $prio_carrusel_json = json_encode($prio_carrusel);

            $data[] = [
                'name' => $faker->word,
                'sinergy' => rand(1, 5),
                'description' => $faker->sentence,
                'tier' => $faker->randomElement($tierIds),
                'difficulty' => $faker->randomElement($difficultyIds),
                'prio_carrusel' => $prio_carrusel_json,
                'playing_style' => $faker->word,
                'augments_id' => rand(1, 5),
                'champ_compo' => $faker->word,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('compositions')->insert($data);
    }
}
