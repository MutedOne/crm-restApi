<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       
        return [
            'name' => fake()->unique()->name(),
            'phone' => fake()->unique()->numerify('+9715########'),
            'email' => fake()->unique()->safeEmail(),
            'address' => fake()->address(),
            'notes' => fake()->paragraph(),
        ];
        
    }
}
