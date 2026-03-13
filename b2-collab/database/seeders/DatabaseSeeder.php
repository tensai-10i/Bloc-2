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
        $this->call(RoleSeeder::class);

        // User::factory(10)->create();

        $superAdminRole = \App\Models\Role::where('name', 'super_admin')->first();
        $adminRole = \App\Models\Role::where('name', 'admin')->first();
        $moderatorRole = \App\Models\Role::where('name', 'moderator')->first();
        $userRole = \App\Models\Role::where('name', 'user')->first();

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'role_id' => $superAdminRole->id,
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role_id' => $adminRole->id,
        ]);

        User::factory()->create([
            'name' => 'Moderator',
            'email' => 'moderator@example.com',
            'role_id' => $moderatorRole->id,
        ]);

        User::factory()->create([
            'name' => 'Normal User',
            'email' => 'user@example.com',
            'role_id' => $userRole->id,
        ]);
    }
}
