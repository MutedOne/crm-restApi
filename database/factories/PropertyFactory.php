<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ListingType;
use App\Models\Property;
use App\Models\PropertyStatus;
use App\Models\PropertyType;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type_id' => PropertyType::inRandomOrder()->value('id'),
            'listing_id' => ListingType::inRandomOrder()->value('id'),
            'price' => fake()->randomFloat(2, 100000, 10000000),
            'address' => fake()->address(),
            'status_id' => PropertyStatus::inRandomOrder()->value('id'),
            'assigned_agent_id' => User::inRandomOrder()->value('id'),
            'description' => fake()->paragraph(),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'name' => fake()->unique()->words(3, true),
        ];
    }
}
