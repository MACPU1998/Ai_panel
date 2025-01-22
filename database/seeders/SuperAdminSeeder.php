<?php

namespace Database\Seeders;

use App\Models\admin\Admin;
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
            ['email' => 'admin@email.com'],
            [
                'first_name' => 'admin',
                'last_name' => 'admin',
                'phone' => '0123456789',
                'password' => bcrypt('admin123'),
            ]
        );

        // تخصیص نقش به کاربر
        $admin->assignRole($role);

    }
}
