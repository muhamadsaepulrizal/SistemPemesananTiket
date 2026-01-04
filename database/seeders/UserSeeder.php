<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        // Buat Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@tiket.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Buat User Contoh
        User::create([
            'name' => 'User Demo',
            'email' => 'user@tiket.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);
    }
}
