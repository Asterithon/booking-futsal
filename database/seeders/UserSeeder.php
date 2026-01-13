<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN DEFAULT
        User::updateOrCreate(
            ['email' => 'admin@futsal.test'],
            [
                'name' => 'Admin Futsal',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // CUSTOMER DEFAULT
        User::updateOrCreate(
            ['email' => 'user@futsal.test'],
            [
                'name' => 'Customer Futsal',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );
    }
}

