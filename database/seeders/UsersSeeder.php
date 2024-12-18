<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'name' => 'Admin User',
                'active' => true,
                'created_at' => now(),
            ],
            [
                'email' => 'user1@example.com',
                'password' => Hash::make('password123'),
                'name' => 'User One',
                'active' => true,
                'created_at' => now(),
            ],
            [
                'email' => 'user2@example.com',
                'password' => Hash::make('password123'),
                'name' => 'User Two',
                'active' => false,
                'created_at' => now(),
            ],
        ]);
    }
}
