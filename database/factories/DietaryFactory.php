<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DietaryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Vegan', 'Vegetarian', 'Pescatarian', 'Halal', 'Kosher', 'Gluten-Free', 'Dairy-Free']),
        ];
    }
}
