<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'user',
                'level' => 1,
            ],
            [
                'name' => 'moderator',
                'level' => 2,
            ],
            [
                'name' => 'admin',
                'level' => 3,
            ],
            [
                'name' => 'super_admin',
                'level' => 4,
            ],
        ];

        foreach ($roles as $role) {
            \App\Models\Role::create($role);
        }
    }
}
