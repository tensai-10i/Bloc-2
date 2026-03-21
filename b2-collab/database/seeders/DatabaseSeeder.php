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
                    'updated_at' => now(),
                    'created_at' => now(),
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

        // -------------------------
        // RESSOURCES
        // -------------------------

        DB::table('ressources')->insert([
            [
                'title' => 'Gérer le stress au quotidien',
                'content' => 'Techniques simples pour réduire le stress : respiration, organisation et pauses.',
                'type' => 'article',
                'user_id' => $superadmin->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Exercices de respiration',
                'content' => '5 exercices efficaces pour calmer rapidement l’anxiété.',
                'type' => 'guide',
                'user_id' => $admin->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Comprendre ses émotions',
                'content' => 'Identifier et gérer ses émotions pour améliorer son bien-être.',
                'type' => 'article',
                'user_id' => $moderator->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Routine bien-être du matin',
                'content' => 'Créer une routine matinale efficace pour démarrer la journée.',
                'type' => 'guide',
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Podcast : lâcher prise',
                'content' => 'Un podcast pour apprendre à relativiser et lâcher prise.',
                'type' => 'podcast',
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Méditation guidée',
                'content' => 'Séance de méditation pour débutants.',
                'type' => 'video',
                'user_id' => $admin->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
