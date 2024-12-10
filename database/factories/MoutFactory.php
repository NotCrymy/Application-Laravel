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
        // Liste des origines françaises
        $originesFrancaises = [
            'Bordeaux', 'Bourgogne', 'Champagne', 'Alsace', 'Provence', 
            'Loire', 'Languedoc', 'Jura', 'Roussillon', 'Côtes-du-Rhône'
        ];

        // Liste des types de moûts
        $typesDeMouts = [
            'Chardonnay', 'Merlot', 'Pinot Noir', 'Syrah', 'Cabernet Sauvignon',
            'Sauvignon Blanc', 'Grenache', 'Malbec', 'Gamay', 'Viognier'
        ];

        return [
            'type' => $this->faker->randomElement($typesDeMouts),
            'origine' => $this->faker->randomElement($originesFrancaises),
            'volume' => $this->faker->numberBetween(50, 500), // Volume en litres
            'cuve_id' => Cuve::factory(),
        ];
    }
}