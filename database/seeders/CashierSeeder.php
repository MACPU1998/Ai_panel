<?php

namespace Database\Seeders;

use App\Models\User;
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
            'guard_name' => 'user',
        ], [
            'primary' => false,
            'status' => 1,
        ]);

        $this->command->info('✅ نقش صندوقدار (cashier) ایجاد/تأیید شد.');

        $user = User::firstOrCreate(
            ['email' => 'cashier@email.com'],
            [
                'first_name' => 'صندوقدار',
                'last_name' => 'نمونه',
                'phone' => '09100000001',
                'password' => bcrypt('cashier123'),
            ]
        );

        $user->syncRoles([$role->name]);

        $this->command->info('✅ کاربر صندوقدار (cashier@email.com) ایجاد/تأیید شد و نقش اختصاص داده شد.');
    }
}
