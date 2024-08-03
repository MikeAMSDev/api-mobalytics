<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            AugmentSeeder::class,
            RecipeSeeder::class,
            ItemSeeder::class,
            ChampionSeeder::class,
            SynergySeeder::class,
            CompositionSeeder::class,
            FormationSeeder::class,
            UserCompoSeeder::class,
            ChampionSynergySeeder::class,
            ChampionItemSeeder::class,
        ]);
    }
}
