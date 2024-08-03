<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRoleId = DB::table('roles')->where('name', 'user')->value('id');
        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id');

        DB::table('users')->insert([
            [
                'name' => 'Paco',
                'email' => 'admin@example.com',
                'roles_id' => $adminRoleId,
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Joao',
                'email' => 'user@example.com',
                'roles_id' => $userRoleId,
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}