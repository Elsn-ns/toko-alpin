<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::factory()->create([
            'name' => 'Admin Toko',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
        ]);

        // Staff
        User::factory()->create([
            'name' => 'Staff Toko',
            'email' => 'staff@gmail.com',
            'role' => 'staff',
        ]);

        // Test Customer
        User::factory()->create([
            'name' => 'Test Customer',
            'email' => 'test@gmail.com',
            'role' => 'customer',
        ]);
    }
}
