<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Contact;
use App\Models\LeadStatus;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'assigned_agent_id' => User::inRandomOrder()->value('id'),
            'notes' => fake()->paragraph(),
            'contact_id' => Contact::inRandomOrder()->value('id'),
            'status_id' => LeadStatus::inRandomOrder()->value('id'),
            'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
            'updated_at' => fake()->dateTimeBetween('-6 months', 'now'),
            
        ];
    }
}
