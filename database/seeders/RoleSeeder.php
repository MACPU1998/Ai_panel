<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'super-admin', 'guard_name' => 'admin', 'primary' => true],
            ['name' => 'admin', 'guard_name' => 'admin', 'primary' => true],

        ];
        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['name' => $role['name'], 'guard_name' => $role['guard_name']],
                ['primary' => $role['primary']]
            );
        }
    }
}
