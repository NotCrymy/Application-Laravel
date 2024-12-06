<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use app\Models\Cuve;

class MoutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'volume' => $this->faker->randomFloat(2, 10, 100),
            'type' => $this->faker->randomElement(['Chardonnay', 'Pinot Noir', 'Meunier']),
            'origine' => $this->faker->address,
            'cuve_id' => Cuve::factory(),
        ];
    }
}