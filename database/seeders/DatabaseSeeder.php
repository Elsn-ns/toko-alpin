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
        $this->call(CategorySeeder::class);

        // Admin
        User::factory()->create([
            'name' => 'Isnani',
            'email' => 'Isnani@gmail.com',
            'role' => 'admin',
            'password' => bcrypt('kadaingat'),
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
