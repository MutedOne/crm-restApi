<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\Contact;
use App\Models\ContactType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PropertyOwner>
 */
class PropertyOwnerFactory extends Factory
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
            'contact_id' => Contact::inRandomOrder()->value('id'),
            'type_id' => ContactType::inRandomOrder()->value('id'),
        ];
    }
}
