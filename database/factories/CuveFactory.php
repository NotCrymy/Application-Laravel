<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CuveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nom' => 'Cuve ' . $this->faker->unique()->word,
            'volume_max' => $this->faker->numberBetween(500, 5000), // Volume aléatoire en litres
        ];
    }
}