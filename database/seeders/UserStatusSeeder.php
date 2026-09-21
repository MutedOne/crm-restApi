<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('user_statuses')->insert([
            [
                'description' => 'Active',
            ],
            [
                'description' => 'Inactive',
            ],
            [
                'description' => 'Suspended',
            ],
            [
                'description' => 'Pending',
            ],
        ]);
    }
}
