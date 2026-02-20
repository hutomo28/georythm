<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database with test users.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@georythm.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Officer',
            'email' => 'officer@georythm.com',
            'password' => Hash::make('password'),
            'role' => 'officer',
        ]);

        User::create([
            'name' => 'Customer',
            'email' => 'customer@georythm.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
    }
}
