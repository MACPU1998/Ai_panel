<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $role = Role::firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'admin',
        ]);

        $admin = Admin::withTrashed()->firstOrCreate(
            ['email' => 'admin@email.com'],
            [
                'first_name' => 'admin',
                'last_name' => 'admin',
                'phone' => '0123456789',
                'password' => bcrypt('admin123'),
            ]
        );

        if ($admin->trashed()) {
            $admin->restore();
        }

        $admin->syncRoles([$role]);
    }
}
