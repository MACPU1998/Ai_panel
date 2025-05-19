<?php

namespace Database\Seeders;

use App\DataProviders\CountryDataProvider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (CountryDataProvider::data() as $country) {
            DB::table('countries')->insert([
                'id' => $country['id'],
                'name' => ucfirst($country['name']),
                'status' => 'active',
            ]);
        }
    }
}
