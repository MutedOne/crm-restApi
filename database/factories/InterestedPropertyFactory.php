<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Property;
use App\Models\Lead;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InterestedProperty>
 */
class InterestedPropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'property_id' => Property::inRandomOrder()->value('id'),
            'lead_id' => Lead::inRandomOrder()->value('id'),
        ];
    }
}
