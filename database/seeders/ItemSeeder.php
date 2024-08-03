<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recipeIds = DB::table('recipes')->pluck('id');

        DB::table('items')->insert([
            [
                'name' => 'Legendary Sword',
                'description' => 'A powerful sword with legendary status.',
                'tier' => 'S',
                'object_img' => 'legendary_sword.png',
                'recipes_id' => $recipeIds->random(),
                'type_object' => 'Weapon',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mystic Shield',
                'description' => 'A shield imbued with mystical energies.',
                'tier' => 'A',
                'object_img' => 'mystic_shield.png',
                'recipes_id' => $recipeIds->random(),
                'type_object' => 'Armor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Healing Potion',
                'description' => 'A potion that restores health over time.',
                'tier' => 'B',
                'object_img' => 'healing_potion.png',
                'recipes_id' => $recipeIds->random(),
                'type_object' => 'Consumable',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Enchanted Boots',
                'description' => 'Boots with enchanting properties that increase speed.',
                'tier' => 'A',
                'object_img' => 'enchanted_boots.png',
                'recipes_id' => $recipeIds->random(),
                'type_object' => 'Armor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dragon Amulet',
                'description' => 'An amulet that grants the wearer dragon-like abilities.',
                'tier' => 'S',
                'object_img' => 'dragon_amulet.png',
                'recipes_id' => $recipeIds->random(),
                'type_object' => 'Accessory',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
