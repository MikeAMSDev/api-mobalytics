<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use SynergyCompSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            ChampionSeeder::class,
            SynergySeeder::class,
            //SynergyCompoSeeder::class,
            //AugmentCompoSeeder::class,
            TierSeeder::class,
            DifficultySeeder::class,
            RecipeSeeder::class,
            ItemSeeder::class,
            AugmentSeeder::class,
            CompositionSeeder::class,
            ChampionSynergySeeder::class,
            ChampionItemSeeder::class,
            FormationSeeder::class,
            UserSeeder::class,
            UserCompoSeeder::class,
        ]);
    }
}
