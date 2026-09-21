<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PropertyStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('property_statuses')->insert([
            [
                'description' => 'Available',
            ],
            [
                'description' => 'Reserved',
            ],
            [
                'description' => 'Sold',
            ],
            [
                'description' => 'Rented',
            ],
            [
                'description' => 'Under Maintenance',
            ],
            [
                'description' => 'Inactive',
            ],
        ]);
    }
}
