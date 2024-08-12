<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $tierIds = DB::table('tiers')->pluck('id')->toArray();
        $recipeIds = DB::table('recipes')->pluck('id');

        DB::table('items')->insert([
            [
                'name' => 'Legendary Sword',
                'description' => 'A powerful sword with legendary status.',
                'tier' => $faker->randomElement($tierIds),
                'object_img' => 'legendary_sword.png',
                'recipes_id' => $recipeIds->random(),
                'type_object' => 'Basic',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mystic Shield',
                'description' => 'A shield imbued with mystical energies.',
                'tier' => $faker->randomElement($tierIds),
                'object_img' => 'mystic_shield.png',
                'recipes_id' => $recipeIds->random(),
                'type_object' => 'Combined',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Healing Potion',
                'description' => 'A potion that restores health over time.',
                'tier' => $faker->randomElement($tierIds),
                'object_img' => 'healing_potion.png',
                'recipes_id' => $recipeIds->random(),
                'type_object' => 'Non-crafteable',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Enchanted Boots',
                'description' => 'Boots with enchanting properties that increase speed.',
                'tier' => $faker->randomElement($tierIds),
                'object_img' => 'enchanted_boots.png',
                'recipes_id' => $recipeIds->random(),
                'type_object' => 'Basic',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dragon Amulet',
                'description' => 'An amulet that grants the wearer dragon-like abilities.',
                'tier' => $faker->randomElement($tierIds),
                'object_img' => 'dragon_amulet.png',
                'recipes_id' => $recipeIds->random(),
                'type_object' => 'Combined',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
