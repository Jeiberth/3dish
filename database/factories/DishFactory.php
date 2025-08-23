<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DishFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 5, 50),
            'calories' => $this->faker->numberBetween(100, 1000),
            'spicy' => $this->faker->randomElement(['Not Spicy', 'Medium', 'Extra Hot']),
            'size' => $this->faker->randomElement(['Small', 'Medium', 'Large']),
            'image' => $this->faker->imageUrl(),
            'imageAR' => $this->faker->imageUrl(),
        ];
    }
}
