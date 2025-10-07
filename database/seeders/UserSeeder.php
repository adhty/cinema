<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(5)->create(); // Kalau pakai factory

        // Atau manual:
        User::create([
            'name' => 'Test User',
            'email' => 'user@cinema.com',
            'password' => Hash::make('user123'),
            'is_admin' => false,
        ]);
    }
}
