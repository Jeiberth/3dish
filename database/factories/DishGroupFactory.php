<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DishGroupFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'order_number' => $this->faker->numberBetween(1, 100),
            'name' => $this->faker->word(),
        ];
    }
}
