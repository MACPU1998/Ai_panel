<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $role = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'admin']);

        $admin = Admin::firstOrCreate(
            [
                'email' => 'admin@email.com',
                'password' => bcrypt('admin123'),
            ]
        );
        $admin->assignRole($role);
    }
}
