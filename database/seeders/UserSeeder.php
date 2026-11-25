<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@hertrip.com'],
            [
                'name' => 'Admin HerTrip',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'verification_status' => 'verified',
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@hertrip.com'],
            [
                'name' => 'Member HerTrip',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'verification_status' => 'verified',
            ]
        );
    }
}