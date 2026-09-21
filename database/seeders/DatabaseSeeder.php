<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Contact;
use App\Models\Lead;
use App\Models\Property;
use App\Models\PropertyOwner;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       $this->call([
        UserRoleSeeder::class,
        UserStatusSeeder::class,
        PropertyTypeSeeder::class,
        LeadStatusSeeder::class,
        PropertyStatusSeeder::class,
        ListingTypeSeeder::class,
        ContactTypeSeeder::class,
        ContactSeeder::class,
    ]);
    
    User::factory()->count(50)->create();
    Property::factory()->count(50)->create();
    Lead::factory()->count(50)->create();
    PropertyOwner::factory()->count(20)->create();
    }
}
