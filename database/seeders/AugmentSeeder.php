<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;


class AugmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $tierIds = DB::table('tiers')->pluck('id')->toArray();
        
        DB::table('augments')->insert([
            [
                'name' => 'Augment Tier 1 - A',
                'description' => 'Description for Augment Tier 1 - A',
                'augment_img' => 'augment_tier_1_a.png',
                'tier' => $faker->randomElement($tierIds),
                'set_version' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Augment Tier 1 - B',
                'description' => 'Description for Augment Tier 1 - B',
                'augment_img' => 'augment_tier_1_b.png',
                'tier' => $faker->randomElement($tierIds),
                'set_version' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Augment Tier 2 - A',
                'description' => 'Description for Augment Tier 2 - A',
                'augment_img' => 'augment_tier_2_a.png',
                'tier' => $faker->randomElement($tierIds),
                'set_version' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Augment Tier 2 - B',
                'description' => 'Description for Augment Tier 2 - B',
                'augment_img' => 'augment_tier_2_b.png',
                'tier' => $faker->randomElement($tierIds),
                'set_version' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Augment Tier 3 - A',
                'description' => 'Description for Augment Tier 3 - A',
                'augment_img' => 'augment_tier_3_a.png',
                'tier' => $faker->randomElement($tierIds),
                'set_version' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Augment Tier 3 - B',
                'description' => 'Description for Augment Tier 3 - B',
                'augment_img' => 'augment_tier_3_b.png',
                'tier' => $faker->randomElement($tierIds),
                'set_version' => '6',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}