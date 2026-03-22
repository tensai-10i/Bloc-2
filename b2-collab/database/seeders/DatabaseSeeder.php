<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // -------------------------
        // APPELS DES SEEDERS
        // -------------------------
        $this->call([
            TypeRessourceSeeder::class,
            CategorySeeder::class,
        ]);

        // -------------------------
        // ROLES
        // -------------------------
        foreach ([
                     ['name' => 'superadmin', 'description' => 'Superadministrateur'],
                     ['name' => 'admin', 'description' => 'Administrateur'],
                     ['name' => 'moderator', 'description' => 'Moderateur'],
                     ['name' => 'user', 'description' => 'Utilisateur'],
                 ] as $role) {
            DB::table('roles')->updateOrInsert(
                ['name' => $role['name']],
                [
                    'description' => $role['description'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // -------------------------
        // USERS
        // -------------------------
        $superadmin = User::query()->updateOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Superadmin',
                'password' => Hash::make('password'),
                'role' => 'superadmin',
            ]
        );

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $moderator = User::query()->updateOrCreate(
            ['email' => 'moderator@example.com'],
            [
                'name' => 'Moderator',
                'password' => Hash::make('password'),
                'role' => 'moderator',
            ]
        );

        $user = User::query()->updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );
    }
}
