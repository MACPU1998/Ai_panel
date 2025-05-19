<?php

namespace Database\Seeders;

use App\DataProviders\StateDataProvider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (StateDataProvider::data() as $state) {
            DB::table('states')->insert([
                'id' => $state['id'],
                'country_id' => $state['country_id'],
                'name' => ucfirst($state['name']),
                'status' => 'active',
            ]);
        }
    }
}
