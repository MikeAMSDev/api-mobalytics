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

        DB::table('augment_comp')->insert([
            [
                'composition_id' => 2,
                'augment_id' => 2
            ],
            [
                'composition_id' => 2,
                'augment_id' => 1
            ],
            [
                'composition_id' => 2,
                'augment_id' => 5
            ],
            [
                'composition_id' => 2,
                'augment_id' => 57
            ],
        ]);
    }
}
