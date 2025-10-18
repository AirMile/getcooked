<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Miles',
            'email' => 'zeilstramiles@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        // Create test users with default 'user' role
        User::factory()->count(5)->create();
    }
}
