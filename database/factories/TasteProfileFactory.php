<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TasteProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Sweet', 'Savory', 'Sour', 'Bitter', 'Umami', 'Salty']),
        ];
    }
}
