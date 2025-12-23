<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role' => UserRole::ADMIN,
        ]);

        User::factory()->create([
            'name' => 'Normal Customer',
            'email' => 'testuser@gmail.com',
        ]);
    }
}
