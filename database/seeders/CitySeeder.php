<?php

namespace Database\Seeders;

use App\DataProviders\CityDataProvider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (CityDataProvider::data() as $city) {
            DB::table('cities')->insert([
                'id' => $city['id'],
                'state_id' => $city['state_id'],
                'name' => ucfirst($city['name']),
                'status' => 'active',
            ]);
        }
    }
}
