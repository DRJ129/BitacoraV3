<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crea o actualiza un usuario admin con email conocido.
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'lastname' => 'User',
                'email' => 'admin@example.com',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
