<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
                [
                    'key' => 'هزینه ارسال',
                    'value' => '50000',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            [
                    'key' => 'مالیات',
                    'value' => '1',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate($setting);
        }

    }
}
