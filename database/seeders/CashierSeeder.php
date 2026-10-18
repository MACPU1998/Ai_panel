<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CashierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::firstOrCreate([
            'name' => 'cashier',
            'guard_name' => 'admin',
        ], [
            'primary' => false,
            'status' => 1,
        ]);

        $this->command->info('✅ نقش صندوقدار (cashier) ایجاد/تأیید شد.');

        $admin = Admin::firstOrCreate(
            ['email' => 'cashier@email.com'],
            [
                'first_name' => 'صندوقدار',
                'last_name' => 'نمونه',
                'phone' => '09100000001',
                'password' => bcrypt('cashier123'),
            ]
        );

        $admin->syncRoles([$role->name]);

        $this->command->info('✅ ادمین صندوقدار (cashier@email.com) ایجاد/تأیید شد و نقش اختصاص داده شد.');
    }
}
