<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InterestedPropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('interested_properties')->insert([
            [
                'property_id' => 1,
                'lead_id' => 1,
            ],
            [
                'property_id' => 2,
                'lead_id' => 1,
            ],
            [
                'property_id' => 3,
                'lead_id' => 2,
            ],
            [
                'property_id' => 5,
                'lead_id' => 3,
            ],
            [
                'property_id' => 7,
                'lead_id' => 4,
            ],
            [
                'property_id' => 8,
                'lead_id' => 5,
            ],
        ]);
    }
}
