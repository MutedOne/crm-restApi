<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ListingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('listing_types')->insert([
            [
                'description' => 'For Sale',
            ],
            [
                'description' => 'For Rent',
            ],
            [
                'description' => 'Lease',
            ],
            [
                'description' => 'Off Plan',
            ],
            [
                'description' => 'Auction',
            ],
        ]);
    }
}
