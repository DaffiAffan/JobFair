<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('kodeunit'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User One',
                'email' => 'user1@gmail.com',
                'password' => Hash::make('semangat45'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User Two',
                'email' => 'user2@gmail.com',
                'password' => Hash::make('semangat17'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ASTACALA',
                'email' => 'astacala@gmail.com',
                'password' => Hash::make('astacala'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
