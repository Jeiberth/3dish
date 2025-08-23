<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProteinFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Chicken', 'Beef', 'Fish', 'Seafood', 'Tofu', 'Vegetables']),
        ];
    }
}
