<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserCompoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $userIds = DB::table('users')->pluck('id')->toArray();

        $compositionIds = DB::table('compositions')->pluck('id')->toArray();

        if (empty($userIds) || empty($compositionIds)) {

            throw new \Exception('No se encontraron usuarios o composiciones para rellenar la tabla user_compo.');
        }

        $userCompoData = [];
        foreach ($userIds as $userId) {
            foreach ($compositionIds as $compositionId) {
                $userCompoData[] = [
                    'user_id' => $userId,
                    'composition_id' => $compositionId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('user_compo')->insert($userCompoData);
    }
}