<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        DB::table('roles')->insert([
            ['name' => 'superadmin', 'description' => 'Superadministrateur', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'admin', 'description' => 'Administrateur', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'moderator', 'description' => 'Moderateur', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'user', 'description' => 'Utilisateur', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // User::factory(10)->create();

        // Superadmin
        User::factory()->create([
            'name' => 'Superadmin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'),
            'role' => 'superadmin',
        ]);

        // Admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Moderator
        User::factory()->create([
            'name' => 'Moderator',
            'email' => 'moderator@example.com',
            'password' => bcrypt('password'),
            'role' => 'moderator',
        ]);

        // Test User
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}
